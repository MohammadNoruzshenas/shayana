<?php

namespace App\Http\Controllers\Auth\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Customer\Mobile\LoginRegisterRequest;
use App\Http\Requests\Auth\Customer\RegisterRequest;
use App\Http\Services\Message\MessageService;
use App\Http\Services\Message\SMS\SmsService;
use App\Jobs\SendEmailRegisterAccountToUsers;
use App\Jobs\SendEmailVerficationEmailUser;
use App\Jobs\SendForgetPasswordEmailUser;
use App\Models\Log\Log;
use App\Models\Otp;
use App\Models\Setting\NotificationSetting;
use App\Models\User;
use App\Models\User\password_reset_token;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Kavenegar\KavenegarApi;

class AuthController extends Controller
{
    public function registerForm()
    {

        if (Cache::get('settings')->can_register_user != 1) {
            return redirect()->route('customer.home')->with('swal-error', 'امکان ثبت نام موقتا غیر فعال شده است');
        }
        if (Cache::get('settings')->method_login_register == 2) {
            return redirect()->route('auth.customer.mobileForm');
        }
        return view('auth.registerForm');
    }
    public function register(RegisterRequest $request)
    {
        $inputs = $request->all();
        if (preg_match('/^(\+98|98|0)9\d{9}$/', $inputs['mobile'])) {
            // all mobile numbers are in on format 9** *** ***
            $inputs['mobile'] = ltrim($inputs['mobile'], '0');
            $inputs['mobile'] = substr($inputs['mobile'], 0, 2) === '98' ? substr($inputs['mobile'], 2) : $inputs['mobile'];
            $inputs['mobile'] = str_replace('+98', '', $inputs['mobile']);
        } else {
            $errorText = 'شماره موبایل اشتباه است';
            return redirect()->route('auth.customer.registerForm')->withErrors(['mobile' => $errorText]);
        }
        $user = User::where('mobile', $inputs['mobile'])->first();
        if ($user) {
            $errorText = 'شماره موبایل قبلا ثبت شده است';
            return redirect()->route('auth.customer.registerForm')->withErrors(['mobile' => $errorText]);
        }
        $active_key = Str::random(64);
        $user = User::create([
            'email' => $inputs['email'],
            'password' =>  Hash::make($inputs['password']),
            'active_key' => $active_key,
            'mobile' => $inputs['mobile']
        ]);
        $message = 'اکانت شما با موفقیت ساخته شد';
        if (Cache::get('settings')->account_confirmation == 1) {
            //SendEmailVerficationEmailUser::dispatch($inputs['email'], $active_key); //todo deactivate jobs
            $message = 'لینک فعال سازی اکانت کاربری برای شما ارسال شد';
            return redirect()->route('auth.customer.loginForm')->with('swal-success', $message);
        }
        $notificationSetting = NotificationSetting::where('name', 'account_register')->first();
        if ($notificationSetting->status == 1) {
            //SendEmailRegisterAccountToUsers::dispatch($inputs['email']); //todo deactivate jobs
        }

        Auth::login($user);
        if ($user->is_admin == 1) {
            Log::create([
                'user_id' => $user->id,
                'description' => 'به سایت لاگین کرد',
                'ip' => $request->ip(),
                'os' => $request->header('user-Agent')
            ]);
        }

        return redirect()->route('customer.profile')->with('swal-success', 'با موفقیت وارد شدید');
    }

    public function verficationEmail($key)
    {
        if (Cache::get('settings')->method_login_register == 2) {
            return redirect()->route('auth.customer.mobileForm');
        }
        $user = User::where([
            'active_key' => $key,
        ])->first();

        if ($user) {
            $user->update([
                'email_verified_at' => now(),
                'status' => 1,
                'active_key' => null
            ]);
            $message = 'اکانت کاربری شما با موفقیت تایید شد';
            $code =  'swal-success';
        } else {
            $message = 'لینک فعال سازی اشتباه است ';
            $code =  'swal-error';
        }
        return redirect()->route('auth.customer.loginForm')->with($code, $message);
    }
    public function loginForm()
    {

        if (Cache::get('settings')->method_login_register == 2) {
            return redirect()->route('auth.customer.mobileForm');
        }

        return view('auth.loginForm');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'g-recaptcha-response' => 'recaptcha'

        ]);
        $inputs = $request->all();
        $user = User::where([
            'email' => $inputs['email'],
        ])->first();
        if ($user && Hash::check($request->password, $user->password)) {

            if (Cache::get('settings')->account_confirmation == 1) {
                if (empty($user->email_verified_at)) {
                    $active_key = Str::random(64);
                    $user->update([
                        'active_key' => $active_key
                    ]);
                   // SendEmailVerficationEmailUser::dispatch($user->email, $active_key);//todo deactivate jobs
                    return redirect()->route('auth.customer.loginForm')->with('swal-success', 'لطفا ایمیل خود را تایید کنید لینک حاوی کد فعال سازی به ایمیل شما ارسال شد');
                }
            }
            Auth::login($user);
            Log::create([
                'user_id' => $user->id,
                'description' => 'به سایت لاگین کرد',
                'ip' => $request->ip(),
                'os' => $request->header('user-Agent')
            ]);
            if ($user->is_admin == 1) {
                return redirect()->route('admin.index')->with('swal-success', 'با موفقیت وارد شدید');
            }
            return redirect()->route('customer.profile')->with('swal-success', 'با موفقیت وارد شدید');
        } else {
            return redirect()->route('auth.customer.loginForm')->withErrors(['wrongPassOrEmail' => 'ایمیل یا پسورد اشتباه است']);
        }
    }

    public function forgetPasswordForm()
    {
        if (Cache::get('settings')->method_login_register == 2) {
            return redirect()->route('auth.customer.mobileForm');
        }

        return view('auth.forgetForm');
    }
    public function forgetPassword(Request $request)
    {
        if (Cache::get('settings')->method_login_register == 2) {
            return redirect()->route('auth.customer.mobileForm');
        }
        $request->validate([
            'email' => 'required|exists:users,email'
        ]);
        $inputs = $request->all();
        $token = Str::random(64);
        $resetPassword = password_reset_token::create([
            'email' => $inputs['email'],
            'token' =>  $token
        ]);
        //SendForgetPasswordEmailUser::dispatch($inputs['email'], $token); //todo deactivate jobs
        return redirect()->route('auth.customer.loginForm')->with('swal-success', 'لینک بازیابی رمز عبور برای شما ایمیل شد');
    }
    public function EmailResetPasswordForm($token)
    {
        if (Cache::get('settings')->method_login_register == 2) {
            return redirect()->route('auth.customer.mobileForm');
        }
        $token =  password_reset_token::where('token', $token)->where('created_at', '>', Carbon::now()->subMinute(10))->first();
        if (!$token) {
            return redirect()->route('auth.customer.loginForm')->with('swal-error', 'لینک بازیابی اشتباه است یا منقضی شده ');
        }
        return view('auth.emailResetPasswordForm', compact('token'));
    }
    public function EmailResetPassword(Request $request)
    {
        if (Cache::get('settings')->method_login_register == 2) {
            return redirect()->route('auth.customer.mobileForm');
        }
        $request->validate([
            'password' => ['required', 'max:195', 'confirmed', Password::min(8)],
        ]);
        $token =  password_reset_token::where('token', $request->token)->where('created_at', '>', Carbon::now()->subMinute(15))->first();
        if (!$token) {
            return redirect()->route('auth.customer.loginForm')->with('swal-error', 'لینک بازیابی اشتباه است یا منقضی شده ');
        }
        $user = User::where('email', $token->email)->first();
        $user->update(['password' =>  Hash::make($request->password)]);
        $user->save();
        return redirect()->route('auth.customer.loginForm')->with('swal-success', 'رمز عبور شما با موفقیت تغییر کرد');
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.customer.loginForm');
    }
    public function mobileForm()
    {
        if (Cache::get('settings')->method_login_register == 1) {
            return redirect()->route('auth.customer.loginForm');
        }
        return view('auth.mobileForm');
    }
    public function mobile(Request $request)
    {
        if (Cache::get('settings')->method_login_register == 1) {
            return redirect()->route('auth.customer.loginForm');
        }
        $request->validate([
            'mobile' => 'required|numeric',
        ]);
        $inputs = $request->all();
        //check id is mobile or not
        if (preg_match('/^(\+98|98|0)9\d{9}$/', $inputs['mobile'])) {
            $type = 0; // 0 => mobile;
            // all mobile numbers are in on format 9** *** ***
            $inputs['mobile'] = ltrim($inputs['mobile'], '0');
            $inputs['mobile'] = substr($inputs['mobile'], 0, 2) === '98' ? substr($inputs['mobile'], 2) : $inputs['mobile'];
            $inputs['mobile'] = str_replace('+98', '', $inputs['mobile']);

            $user = User::where('mobile', $inputs['mobile'])->first();
            if (empty($user)) {
                if (Cache::get('settings')->can_register_user != 1) {
                    return redirect()->route('customer.home')->with('swal-error', 'امکان ثبت نام موقتا غیر فعال شده است');
                }
                $newUser['mobile'] = $inputs['mobile'];
            }
        } else {
            $errorText = 'شماره موبایل اشتباه است';
            return redirect()->route('auth.customer.mobileForm')->withErrors(['mobile' => $errorText]);
        }

        if (empty($user)) {
            $newUser['password'] = Str::random(16);
            $newUser['activation'] = 1;
            $user = User::create($newUser);
        }

        //create otp code
        $otpCode = rand(111111, 999999);
        $token = Str::random(60);
        $otpInputs = [
            'token' => $token,
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'login_id' => $inputs['mobile'],
            'type' => $type,
        ];
        Otp::create($otpInputs);
        $title  = Cache::get('templateSetting')->title;
        //send sms
        $smsService = new SmsService();
        $smsService->setTo(['0' . $user->mobile]);
        $smsService->setText("{$title}\n  کد تایید : $otpCode");
        $smsService->setIsFlash(true);
        $messagesService = new MessageService($smsService);
        $messagesService->send();
        return redirect()->route('auth.customer.mobile-confirm-form', $token);
    }
    public function mobileConfirmForm($token)
    {

        if (Cache::get('settings')->method_login_register == 1) {
            return redirect()->route('auth.customer.loginForm');
        }
        $otp = Otp::where('token', $token)->first();
        if (empty($otp)) {
            return redirect()->route('auth.customer.mobileForm')->withErrors(['error' => 'آدرس وارد شده نامعتبر میباشد']);
        }
        return view('auth.mobile-confirm', compact('token', 'otp'));
    }

    public function mobileConfirm($token, Request $request)
    {

        if (Cache::get('settings')->method_login_register == 1) {
            return redirect()->route('auth.customer.loginForm');
        }
        $inputs = $request->all();
        $inputs['code'] = implode("", $inputs['code']);
        $otp = Otp::where('token', $token)->where('used', 0)->where('created_at', '>=', Carbon::now()->subMinute(5)->toDateTimeString())->first();
        if (empty($otp)) {
            return redirect()->route('auth.customer.mobile-confirm-form', $token)->withErrors(['error' => 'آدرس وارد شده نامعتبر میباشد']);
        }

        //if otp not match
        if ($otp->otp_code !== $inputs['code']) {
            return redirect()->route('auth.customer.mobile-confirm-form', $token)->withErrors(['error' => 'کد وارد شده صحیح نمیباشد']);
        }

        // if everything is ok :
        $otp->update(['used' => 1]);
        $user = $otp->user()->first();
        if ($otp->type == 0 && empty($user->mobile_verified_at)) {
            $user->update(['mobile_verified_at' => Carbon::now(), 'status' => 1]);
        }
        Auth::login($user);


        if ($user->is_admin == 1) {
            Log::create([
                'user_id' => $user->id,
                'description' => 'به سایت لاگین کرد',
                'ip' => $request->ip(),
                'os' => $request->header('user-Agent')
            ]);
            return redirect()->route('admin.index')->with('swal-success', 'با موفقیت وارد شدید');
        }
        return redirect()->route('customer.profile')->with('swal-success', 'با موفقیت وارد شدید');
    }


    public function loginResendOtp($token)
    {
        if (Cache::get('settings')->method_login_register == 1) {
            return redirect()->route('auth.customer.loginForm');
        }

        $otp = Otp::where('token', $token)->where('created_at', '<=', Carbon::now()->subMinutes(5)->toDateTimeString())->first();
        if (empty($otp)) {
            return redirect()->route('auth.customer.mobileForm', $token)->withErrors(['error' => 'ادرس وارد شده نامعتبر است']);
        }


        $user = $otp->user()->first();
        //create otp code
        $otpCode = rand(111111, 999999);
        $token = Str::random(60);
        $otpInputs = [
            'token' => $token,
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'login_id' => $otp->login_id,
            'type' => $otp->type,
        ];

        Otp::create($otpInputs);




        //send sms
        $title  = Cache::get('templateSetting')->title;
        //send sms
        $smsService = new SmsService();
        $smsService->setTo(['0' . $user->mobile]);
        $smsService->setText("{$title}\n  کد تایید : $otpCode");
        $smsService->setIsFlash(true);

        $messagesService = new MessageService($smsService);
        $messagesService->send();
        return redirect()->route('auth.customer.mobile-confirm-form', $token);
    }

    public function smsLoginForm()
    {
        return view('auth.smsLoginForm');
    }

    public function smsLogin(Request $request)
    {
        $request->validate([
            'mobile' => 'required|numeric',
        ]);
        
        $inputs = $request->all();
        
        // Check if mobile number is valid Iranian mobile
        if (preg_match('/^(\+98|98|0)9\d{9}$/', $inputs['mobile'])) {
            // Normalize mobile number to 9xxxxxxxxx format
            $inputs['mobile'] = ltrim($inputs['mobile'], '0');
            $inputs['mobile'] = substr($inputs['mobile'], 0, 2) === '98' ? substr($inputs['mobile'], 2) : $inputs['mobile'];
            $inputs['mobile'] = str_replace('+98', '', $inputs['mobile']);
        } else {
            $errorText = 'شماره موبایل اشتباه است';
            return redirect()->route('auth.customer.smsLoginForm')->withErrors(['mobile' => $errorText]);
        }

        // Check if user exists with this mobile number
        $user = User::where('mobile', $inputs['mobile'])->first();
        if (!$user) {
            $errorText = 'کاربری با این شماره موبایل یافت نشد. لطفا ابتدا ثبت نام کنید.';
            return redirect()->route('auth.customer.smsLoginForm')->withErrors(['mobile' => $errorText]);
        }

        // Generate OTP code
        $otpCode = rand(111111, 999999);
        $token = Str::random(60);

        $checkOtp = Otp::where('login_id',$inputs['mobile'])->where('created_at','>',now()->subMinutes(2))->first();
        if($checkOtp){
            $errorText = 'توکن از قبل برای شما ارسال شده است، بعد از 2 دقیفه میتواند درخواست کد ورود کنید';
            return redirect()->route('auth.customer.smsLoginForm')->withErrors(['mobile' => $errorText]);
        }
        $otpInputs = [
            'token' => $token,
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'login_id' => $inputs['mobile'],
            'type' => 0, // 0 => mobile
        ];
        
        Otp::create($otpInputs);
        
        // $title = Cache::get('templateSetting')->title;
        
        // // Send SMS using Kavenegar
        // $smsService = new SmsService();
        // $smsService->setTo(['0' . $user->mobile]);
        // $smsService->setText("{$title}\n  کد تایید : $otpCode");
        // $smsService->setIsFlash(true);
        
        // $messagesService = new MessageService($smsService);
        // $messagesService->send();
        $kavenagar = new KavenegarApi(\config('kavenegar.apikey'));
        $kavenagar->VerifyLookup($user->mobile, $otpCode, '', '', 'login');

        return redirect()->route('auth.customer.smsLoginConfirmForm', $token);
    }

    public function smsLoginConfirmForm($token)
    {
        $otp = Otp::where('token', $token)->first();
        if (empty($otp)) {
            return redirect()->route('auth.customer.smsLoginForm')->withErrors(['error' => 'آدرس وارد شده نامعتبر میباشد']);
        }
        return view('auth.smsLoginConfirm', compact('token', 'otp'));
    }

    public function smsLoginConfirm(Request $request, $token)
    {
        $inputs = $request->all();
        $inputs['code'] = implode("", $inputs['code']);
        $otp = Otp::where('token', $token)->where('used', 0)->where('created_at', '>=', Carbon::now()->subMinute(5)->toDateTimeString())->first();
        
        if (empty($otp)) {
            return redirect()->route('auth.customer.smsLoginConfirmForm', $token)->withErrors(['error' => 'آدرس وارد شده نامعتبر میباشد یا کد منقضی شده است']);
        }

        // If OTP doesn't match
        if ($otp->otp_code !== $inputs['code']) {
            return redirect()->route('auth.customer.smsLoginConfirmForm', $token)->withErrors(['error' => 'کد وارد شده صحیح نمیباشد']);
        }

        // If everything is ok
        $otp->update(['used' => 1]);
        $user = $otp->user()->first();
        
        Auth::login($user);
        
        Log::create([
            'user_id' => $user->id,
            'description' => 'به سایت لاگین کرد (ورود با پیامک)',
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);

        if ($user->is_admin == 1) {
            return redirect()->route('admin.index')->with('swal-success', 'با موفقیت وارد شدید');
        }
        return redirect()->route('customer.profile')->with('swal-success', 'با موفقیت وارد شدید');
    }

    public function smsLoginResendOtp($token)
    {
        $otp = Otp::where('token', $token)->where('created_at', '<=', Carbon::now()->subMinutes(2)->toDateTimeString())->first();
        if (empty($otp)) {
            $errorText = 'توکن از قبل برای شما ارسال شده است، بعد از 2 دقیفه میتواند درخواست کد ورود کنید';

            return redirect()->route('auth.customer.smsLoginForm')->withErrors(['error' => $errorText]);
        }

        

        $user = $otp->user()->first();
        
        // Generate new OTP code
        $otpCode = rand(111111, 999999);
        $newToken = Str::random(60);
        $otpInputs = [
            'token' => $newToken,
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'login_id' => $otp->login_id,
            'type' => $otp->type,
        ];

        Otp::create($otpInputs);

       // $title = Cache::get('templateSetting')->title;
        
        // Send SMS using service
        // $smsService = new SmsService();
        // $smsService->setTo(['0' . $user->mobile]);
        // $smsService->setText("{$title}\n  کد تایید : $otpCode");
        // $smsService->setIsFlash(true);

        // $messagesService = new MessageService($smsService);
        // $messagesService->send();

        $kavenagar = new KavenegarApi(config('kavenegar.apikey'));
        $kavenagar->VerifyLookup($user->mobile, $otpCode, '', '', 'login');
        
        return redirect()->route('auth.customer.smsLoginConfirmForm', $newToken);
    }

    public function smsForgetPasswordForm()
    {
        return view('auth.smsForgetPasswordForm');
    }

    public function smsForgetPassword(Request $request)
    {
        $request->validate([
            'mobile' => 'required|numeric',
        ]);
        
        $inputs = $request->all();
        
        // Check if mobile number is valid Iranian mobile
        if (preg_match('/^(\+98|98|0)9\d{9}$/', $inputs['mobile'])) {
            // Normalize mobile number to 9xxxxxxxxx format
            $inputs['mobile'] = ltrim($inputs['mobile'], '0');
            $inputs['mobile'] = substr($inputs['mobile'], 0, 2) === '98' ? substr($inputs['mobile'], 2) : $inputs['mobile'];
            $inputs['mobile'] = str_replace('+98', '', $inputs['mobile']);
        } else {
            $errorText = 'شماره موبایل اشتباه است';
            return redirect()->route('auth.customer.smsForgetPasswordForm')->withErrors(['mobile' => $errorText]);
        }

        // Check if user exists with this mobile number
        $user = User::where('mobile', $inputs['mobile'])->first();
        if (!$user) {
            $errorText = 'کاربری با این شماره موبایل یافت نشد.';
            return redirect()->route('auth.customer.smsForgetPasswordForm')->withErrors(['mobile' => $errorText]);
        }

        // Generate OTP code
        $otpCode = rand(111111, 999999);
        $token = Str::random(60);

        $checkOtp = Otp::where('login_id',$inputs['mobile'])->where('created_at','>',now()->subMinutes(2))->first();
        if($checkOtp){
            $errorText = 'توکن از قبل برای شما ارسال شده است، بعد از 2 دقیقه میتوانید درخواست کد جدید کنید';
            return redirect()->route('auth.customer.smsForgetPasswordForm')->withErrors(['mobile' => $errorText]);
        }
        $otpInputs = [
            'token' => $token,
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'login_id' => $inputs['mobile'],
            'type' => 1, // 1 => forget password
        ];
        
        Otp::create($otpInputs);
        
        // Send SMS using Kavenegar
        $kavenagar = new KavenegarApi(config('kavenegar.apikey'));
        $kavenagar->VerifyLookup($user->mobile, $otpCode, '', '', 'login');

        return redirect()->route('auth.customer.smsForgetPasswordConfirmForm', $token);
    }

    public function smsForgetPasswordConfirmForm($token)
    {
        $otp = Otp::where('token', $token)->first();
        if (empty($otp)) {
            return redirect()->route('auth.customer.smsForgetPasswordForm')->withErrors(['error' => 'آدرس وارد شده نامعتبر میباشد']);
        }
        return view('auth.smsForgetPasswordConfirm', compact('token', 'otp'));
    }

    public function smsForgetPasswordConfirm(Request $request, $token)
    {
        $inputs = $request->all();
        $inputs['code'] = implode("", $inputs['code']);
        $otp = Otp::where('token', $token)->where('used', 0)->where('created_at', '>=', Carbon::now()->subMinute(5)->toDateTimeString())->first();
        
        if (empty($otp)) {
            return redirect()->route('auth.customer.smsForgetPasswordConfirmForm', $token)->withErrors(['error' => 'آدرس وارد شده نامعتبر میباشد یا کد منقضی شده است']);
        }

        // If OTP doesn't match
        if ($otp->otp_code !== $inputs['code']) {
            return redirect()->route('auth.customer.smsForgetPasswordConfirmForm', $token)->withErrors(['error' => 'کد وارد شده صحیح نمیباشد']);
        }

        // If everything is ok, mark OTP as used and redirect to reset password form
        $otp->update(['used' => 1]);
        
        // // Generate a new token for password reset
        $resetToken = Str::random(60);
        
        // // Store the reset token with user info (we'll use the same OTP table with a different type)
         Otp::create([
             'token' => $resetToken,
             'user_id' => $otp->user_id,
             'otp_code' => 0, // No OTP needed for password reset
             'login_id' => $otp->login_id,
             'type' => 2, // 2 => password reset token
         ]);

        return redirect()->route('auth.customer.smsResetPasswordForm', $resetToken);
    }

    public function smsResetPasswordForm($token)
    {
        $resetData = Otp::where('token', $token)->where('type', 2)->where('created_at', '>=', Carbon::now()->subMinutes(15))->first();

        if (!$resetData) {

            return redirect()->route('auth.customer.smsForgetPasswordForm')->with('swal-error', 'لینک بازیابی اشتباه است یا منقضی شده است');
        }
        return view('auth.smsResetPasswordForm', compact('token'));
    }

    public function smsResetPassword(Request $request, $token)
    {
        $request->validate([
            'password' => ['required', 'max:195', 'confirmed', Password::min(8)],
        ]);
        
        $resetData = Otp::where('token', $token)->where('type', 2)->where('created_at', '>', Carbon::now()->subMinutes(15))->first();
        if (!$resetData) {
            return redirect()->route('auth.customer.smsForgetPasswordForm')->with('swal-error', 'لینک بازیابی اشتباه است یا منقضی شده است');
        }
        
        $user = User::find($resetData->user_id);
        $user->update(['password' => Hash::make($request->password)]);
        
        // Mark reset token as used
        $resetData->update(['used' => 1]);
        
        return redirect()->route('auth.customer.loginForm')->with('swal-success', 'رمز عبور شما با موفقیت تغییر کرد');
    }

    public function smsForgetPasswordResendOtp($token)
    {
        $otp = Otp::where('token', $token)->where('created_at', '<=', Carbon::now()->subMinutes(2)->toDateTimeString())->first();
        if (empty($otp)) {
            $errorText = 'توکن از قبل برای شما ارسال شده است، بعد از 2 دقیقه میتوانید درخواست کد جدید کنید';
            return redirect()->route('auth.customer.smsForgetPasswordForm')->withErrors(['error' => $errorText]);
        }

        $user = $otp->user()->first();
        
        // Generate new OTP code
        $otpCode = rand(111111, 999999);
        $newToken = Str::random(60);
        $otpInputs = [
            'token' => $newToken,
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'login_id' => $otp->login_id,
            'type' => 1, // 1 => forget password
        ];

        Otp::create($otpInputs);

        // Send SMS using Kavenegar
        $kavenagar = new KavenegarApi(config('kavenegar.apikey'));
        $kavenagar->VerifyLookup($user->mobile, $otpCode, '', '', 'forget-password');
        
        return redirect()->route('auth.customer.smsForgetPasswordConfirmForm', $newToken);
    }
}
