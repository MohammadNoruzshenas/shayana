<?php

namespace App\Http\Controllers\Customer\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Profile\ProfileUserRequest;
use App\Http\Requests\Customer\Profile\TicketRequest;
use App\Http\Services\File\FileService;
use App\Http\Services\Image\ImageService;
use App\Http\Services\Payment\PaymentService;
use App\Models\Log\Log;
use App\Models\Market\CartItem;
use App\Models\Market\Copan;
use App\Models\Market\Course;
use App\Models\Market\Installment;
use App\Models\Market\OrderItem;
use App\Models\Market\Payment;
use App\Models\Market\Plan;
use App\Models\Market\Subscription;
use App\Models\Market\WeeklySchedule;
use App\Models\Notify\Notification;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketFile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function index(Request $request)
    {
        $plans = Plan::where('status', 1)->get();
        $orders = OrderItem::where(['user_id' => auth()->user()->id, 'status' => 1])->get();
        $ids = [];
        foreach ($orders as $order) {
            array_push($ids, $order->course_id);
        }
        $course = Course::where('confirmation_status', 1)->count();
        $cartItems = CartItem::where('user_id', Auth::user()->id)->count();
        $subscription =  Subscription::where(['user_id' =>  Auth::user()->id, 'status' => 1])->where('expirydate', '>', now())->first();
        $notifactions = Notification::Where(['course_id' => null, 'status' => 1])->orWhereIn('course_id', $ids)->where('status', 1)->get();
        $payments = Payment::where(['user_id' => auth()->user()->id])->latest()->paginate(30);
        $installments = Installment::where('user_id', auth()->user()->id)->with('course')->orderBy('installment_date', 'asc')->get();
        
        // Get the 2 latest schedules for the user with the same week_start_date
        $latestScheduleDate = WeeklySchedule::where('user_id', auth()->user()->id)
            ->where('status', 1)
            ->latest('week_start_date')
            ->value('week_start_date');
            
        $schedules = collect();
        if ($latestScheduleDate) {
            $schedules = WeeklySchedule::with(['scheduleItems.lession.season.parent.course'])
                ->where('user_id', auth()->user()->id)
                ->where('status', 1)
                ->where('week_start_date', $latestScheduleDate)
                ->latest('created_at')
                ->take(2)
                ->get();
        }

        return view('customer.profile.index', compact('plans', 'orders', 'course', 'cartItems', 'subscription', 'notifactions', 'payments', 'installments', 'schedules'));
    }
    public function update(ProfileUserRequest $request, ImageService $imageService)
    {

        $user = Auth::user();
        $inputs = $request->all();
        if (isset($inputs['mobile'])) {
            if (preg_match('/^(\+98|98|0)9\d{9}$/', $inputs['mobile'])) {
                // all mobile numbers are in on format 9** *** ***
                $inputs['mobile'] = ltrim($inputs['mobile'], '0');
                $inputs['mobile'] = substr($inputs['mobile'], 0, 2) === '98' ? substr($inputs['mobile'], 2) : $inputs['mobile'];
                $inputs['mobile'] = str_replace('+98', '', $inputs['mobile']);

                $checkExistsMobile = User::where('mobile', $inputs['mobile'])->first();
                if (!empty($checkExistsMobile)) {
                    return redirect()->back()->with('swal-error', 'شماره موبایل قبلا ثبت شده است');
                }
            } else {
                return redirect()->back()->with('swal-error', 'شماره موبایل اشتباه است');
            }
        }
        //upload profile
        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'profile');
            $result = $imageService->save($request->file('image'));
            if ($result === false) {
                return redirect()->route('admin.user.user-information.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        }

        $user->update([
            'first_name' => $inputs['first_name'],
            'last_name' => $inputs['last_name'],
            'mobile' => $user->mobile ?? $inputs['mobile'],
            'password' =>   $inputs['password'] == null ? $user->password : Hash::make($inputs['password']),
            'email' =>  $user->email ?? $inputs['email'],
            'image' => $inputs['image'] ?? $user->image
        ]);
        return redirect()->back()->with('swal-success', 'مشخصات با موفقیت تغییر کرد');
    }

    public function createTicket(TicketRequest $request, FileService $fileService)
    {
        if (Cache::get('settings')['can_send_ticket'] != 1) {
            abort(403);
        }
        DB::transaction(function () use ($request, $fileService) {
            $inputs = $request->all();

            $ticket = Ticket::create([
                'subject' => $inputs['subject'],
                'description' => $inputs['description'],
                'user_id' => Auth::user()->id,
                'status' => 2
            ]);

            //ticket file
            if ($request->hasFile('file')) {
                $fileService->setExclusiveDirectory('files' . DIRECTORY_SEPARATOR . 'ticket-files');
                $fileService->setFileSize($request->file('file'));
                $fileSize = $fileService->getFileSize();
                $result = $fileService->moveToPublic($request->file('file'));
                // $result = $fileService->moveToStorage($request->file('file'));
                $fileFormat = $fileService->getFileFormat();
                $inputs['ticket_id'] = $ticket->id;
                $inputs['file_path'] = $result;
                $inputs['file_size'] = $fileSize;
                $inputs['file_type'] = $fileFormat;
                $inputs['user_id'] = auth()->user()->id;
                $file = TicketFile::create($inputs);
            }
        });

        return redirect()->back()->with('swal-success', 'تیکت با موفقیت ثبت شد');
    }
    public function showTicket(Ticket $ticket)
    {
        if (Auth::user()->id != $ticket->user_id) {
            abort(403);
        }
        return view('customer.profile.ticket', compact('ticket'));
    }
    public function answerTicket(Ticket $ticket, Request $request, FileService $fileService)
    {
        if (Auth::user()->id != $ticket->user_id) {
            abort(403);
        }
        $request->validate([
            'description' => 'required|min:2|max:1000|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'file' => 'nullable|mimes:png,jpg,pdf|max:800',
        ]);

        $inputs = $request->all();
        $inputs['subject'] = $ticket->subject;
        $inputs['description'] = $request->description;
        $inputs['seen'] = 1;
        $inputs['user_id'] = auth()->user()->id;
        $inputs['ticket_id'] = $ticket->id;
        DB::transaction(function () use ($inputs, $fileService, $request, $ticket) {
            $answerticket = Ticket::create($inputs);
            Ticket::whereId($ticket->id)->update(['status' => 2]);

            //ticket file
            if ($request->hasFile('file')) {
                $fileService->setExclusiveDirectory('files' . DIRECTORY_SEPARATOR . 'ticket-files');
                $fileService->setFileSize($request->file('file'));
                $fileSize = $fileService->getFileSize();
                $result = $fileService->moveToPublic($request->file('file'));
                // $result = $fileService->moveToStorage($request->file('file'));
                $fileFormat = $fileService->getFileFormat();
                $inputs['ticket_id'] = $answerticket->id;
                $inputs['file_path'] = $result;
                $inputs['file_size'] = $fileSize;
                $inputs['file_type'] = $fileFormat;
                $inputs['user_id'] = auth()->user()->id;
                $file = TicketFile::create($inputs);
            }
        });

        return redirect()->route('customer.profile.ticket.show', $ticket)->with('swal-success', 'پاسخ شما با موفقیت ثبت شد');
    }
    public function buySubscribe(Plan $plan, PaymentService $paymentService)
    {

        if (Auth::user()->hasActivceSubscribe()) {
            $subscription = Subscription::where(['user_id' => auth()->user()->id, 'status' => 1])->where('expirydate', '>', now())->first();
            Log::create([
                'user_id' => auth()->user()->id,
                'description' => 'کاربر اشتراک خود را پاک کرد' . '<br>' . 'پلن کاربر  : ' . $subscription->plan->name . '<br>' . 'تعداد روز های باقی مانده از پلن : ' . \Carbon\Carbon::today()->diffInDays($subscription->expirydate, false) . ' روز',
                'ip' => request()->ip(),
                'os' => request()->header('user-Agent')
            ]);
            $subscription->delete();
        }
        $copan = null;
        //IF use Copan can Use this Code
        // $copan = null;
        // $inputs['copan'] = 'noroz';
        // if ($inputs['copan']) {
        //     $copan = Copan::where([['code', $inputs['copan']], ['status', 1], ['end_date', '>', now()], ['start_date', '<', now()]])->first();
        //     if ($copan != null) {
        //         if ($copan->user_id != null) {
        //             $copan = Copan::where([['code', $copan], ['status', 1], ['end_date', '>', now()], ['start_date', '<', now()], ['user_id', auth()->user()->id]])->first();
        //             if ($copan == null) {
        //                 return redirect()->back()->withErrors(['copan' => ['کد تخفیف اشتباه وارد شده است']]);
        //             }
        //         }
        //     } else {
        //         return redirect()->back()->with('swal-error' ,'کد تخفیف اشتباه وارد شده است');
        //     }
        // }
        // if ($copan) {
        //     $order_final_amount = $plan->planFinalPrice()  - $plan->planFinalPrice() * ($copan->amount / 100);
        //     $order_copan_discount_amount = $plan->planFinalPrice() * ($copan->amount / 100);
        // } else {
        //     $order_final_amount = $plan->planFinalPrice();
        //     $order_copan_discount_amount = 0;
        // }
        //
        if ($copan) {
            $order_final_amount = $plan->planFinalPrice()  - $plan->planFinalPrice() * ($copan->amount / 100);
            $order_copan_discount_amount = $plan->planFinalPrice() * ($copan->amount / 100);
        } else {
            $order_final_amount = $plan->planFinalPrice();
            $order_copan_discount_amount = 0;
        }

        $subscription =  Subscription::create([
            'user_id' => Auth::user()->id,
            'plan_id' => $plan->id,
            'plan_object' => $plan,
            'expirydate' =>  Carbon::now()->addDay($plan->subscription_day),
            'status' => 0,
            'payment_id' => null,
            'payment_object' => null,
            'payment_status' => 0,
            'price' => $plan->price,
            'order_final_amount' => $order_final_amount,
            'order_discount_amount' => $plan->planDiscount(),
            'common_discount_object' => $plan->activeCommonDiscount(),
            'copan_id' =>  $copan->id ?? null,
            'copan_object' => $copan ?? null,
            'order_copan_discount_amount' => $order_copan_discount_amount
        ]);
        $payment = Payment::create([
            'amount' => $order_final_amount,
            'user_id' => Auth::user()->id,
            'status' => 0,
            'paymentable_id' => $subscription->id,
            'paymentable_type' => 'App\Models\Market\Subscription',
            'description' => 'خرید اشتراک ' . $plan->name,
            'pay_for' => 2
        ]);

        if ($order_final_amount <= 0) {
            $subscription->update(['status' => 1, 'payment_id' => $payment->id, 'payment_object' =>  $payment, 'payment_status' => 1]);
            $payment->update(['status' => 1]);
            return redirect()->route('customer.profile')->with('swal-success', 'اشتراک شما با موفقیت فعال شد');
        }
        $subscription->update(['payment_id' => $payment->id, 'payment_object' =>  $payment]);
        $callbackRoute = 'customer.profile.payment-call-back';
        $paymentService->payment($plan->price, $subscription, $payment, $callbackRoute);
    }
    public function paymentCallback(Subscription $subscription, Payment $payment, PaymentService $paymentService)
    {
        $amount = $payment->amount;
        $result = $paymentService->verify($amount, $payment);
        if ($result['success']) {
            $subscription->update(['status' => 1,'payment_status' => 1]);
            $payment->update(['status' => 1]);
            return redirect()->route('customer.profile')->with('swal-success', 'اشتراک شما با موفقیت فعال شد');
        } else {
            return redirect()->route('customer.profile')->with('swal-error', 'سفارش شما با خطا مواجه شد');
        }
    }
}
