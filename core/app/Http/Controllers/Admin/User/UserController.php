<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Admin\Repositories\UserFilterRepo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserRequest;
use App\Http\Services\Image\ImageService;
use App\Models\Log\Log;
use App\Models\User;
use App\Models\User\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index(UserFilterRepo $repo)
    {
        $loginwithUser = auth()->user();

        if (!$loginwithUser->can('show_user')) {
            abort(403);
        }
        $users = $repo->status(request('status'))->first_name(request('first_name'))->last_name(request('last_name'))->email(request('email'))->mobile(request('mobile'))->username(request('username'))->paginateParents(20);
        return view('admin.user.index', compact('users'));
    }
    public function create()
    {
        $loginwithUser = auth()->user();

        if (!$loginwithUser->can('create_user')) {
            abort(403);
        }
        
        $roles = Role::where('status', 1)->get();
        return view('admin.user.create', compact('roles'));
    }
    public function store(UserRequest $request)
    {
        $loginwithUser = auth()->user();

        if (!$loginwithUser->can('create_user')) {
            abort(403);
        }
        $inputs = $request->all();
        $inputs['password'] =  Hash::make($inputs['password']);
        
        // Convert Persian date to Georgian
        if (!empty($inputs['birth'])) {
            $inputs['birth'] = jalaliDateToMiladi(convertPersianToEnglish($inputs['birth']), "Y/m/d");
        }
        if (preg_match('/^(\+98|98|0|)9\d{9}$/', $inputs['mobile'])) {

            // all mobile numbers are in on format 9** *** ***
            $inputs['mobile'] = ltrim($inputs['mobile'], '0');
            $inputs['mobile'] = substr($inputs['mobile'], 0, 2) === '98' ? substr($inputs['mobile'], 2) : $inputs['mobile'];
            $inputs['mobile'] = str_replace('+98', '', $inputs['mobile']);
        } else {
            $errorText = 'شماره موبایل اشتباه است';
            return redirect()->route('admin.user.create')->withErrors(['mobile' => $errorText]);
        }
        $userCheckMobileExist = User::where('mobile', $inputs['mobile'])->first();
        if (!$userCheckMobileExist) {
            $user = User::create($inputs);
            $user->roles()->sync($request->roles);
            return redirect()->route('admin.user.index')->with('swal-success', 'کاربر با موفقیت ایجاد شد');
        }
        $errorText = 'شماره موبایل قبلا ثبت شده است';
        return redirect()->route('admin.user.create')->withErrors(['mobile' => $errorText]);
    }
    public function edit(User $user)
    {
        $loginwithUser = auth()->user();

        if (!$loginwithUser->can('edit_user')) {
            abort(403);
        }

        $roles = Role::where('status', 1)->get();
        return view('admin.user.edit', compact('user', 'roles'));
    }

    public  function update(UserRequest $request, User $user)
    {
        $loginwithUser = auth()->user();
        if (!$loginwithUser->can('edit_user')) {
            abort(403);
        }
        $inputs = $request->all();
        $inputs['password'] = $inputs['password'] == null ? $user->password : Hash::make($inputs['password']);
        
        // Convert Persian date to Georgian
        if (!empty($inputs['birth'])) {
            $inputs['birth'] = jalaliDateToMiladi(convertPersianToEnglish($inputs['birth']), "Y/m/d");
        }
        if (preg_match('/^(\+98|98|0|)9\d{9}$/', $inputs['mobile'])) {

            // all mobile numbers are in on format 9** *** ***
            $inputs['mobile'] = ltrim($inputs['mobile'], '0');
            $inputs['mobile'] = substr($inputs['mobile'], 0, 2) === '98' ? substr($inputs['mobile'], 2) : $inputs['mobile'];
            $inputs['mobile'] = str_replace('+98', '', $inputs['mobile']);
        } else {
            $errorText = 'شماره موبایل اشتباه است';
            return redirect()->route('admin.user.edit', $user)->withErrors(['mobile' => $errorText]);
        }
        $userCheckMobileExist = User::where('mobile', $inputs['mobile'])->first();
        if ($userCheckMobileExist && $userCheckMobileExist->id == $user->id || !$userCheckMobileExist) {
            $user->update($inputs);
            $user->roles()->sync($request->roles);
            Log::create([
                'user_id' => auth()->user()->id,
                'description' => 'کاربر با ایدی' . $user->id . 'را ویرایش کرد',
                'ip' => $request->ip(),
                'os' => $request->header('user-Agent')
            ]);

            return redirect()->route('admin.user.index')->with('swal-success', ' کاربر با موفقیت ویرایش  شد');
        }
        $errorText = 'شماره موبایل قبلا ثبت شده است';
        return redirect()->route('admin.user.edit', $user)->withErrors(['mobile' => $errorText]);
    }
    public function destroy(Request $request, User $user)
    {

        $loginwithUser = auth()->user();

        if (!$loginwithUser->can('delete_user')) {
            abort(403);
        }
        $user->delete();
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'کاربر با ایدی' . $user->id . 'را پاک کرد',
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->route('admin.user.index')->with('swal-success', ' کاربر با موفقیت حذف  شد');
    }
    public function information(User $user)
    {

        $loginwithUser = auth()->user();
        if ($loginwithUser->can('show_user') || $user->id == $loginwithUser->id) {
            return view('admin.user.user-information', compact('user'));
        }
        abort(403);
    }
    public function informationUpdate(User $user, UserRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();

        $inputs['password'] = $inputs['password'] == null ? $user->password : Hash::make($inputs['password']);
        
        // Convert Persian date to Georgian
        if (!empty($inputs['birth'])) {
            $inputs['birth'] = jalaliDateToMiladi(convertPersianToEnglish($inputs['birth']), "Y/m/d");
        }
        if (preg_match('/^(\+98|98|0|)9\d{9}$/', $inputs['mobile'])) {

            // all mobile numbers are in on format 9** *** ***
            $inputs['mobile'] = ltrim($inputs['mobile'], '0');
            $inputs['mobile'] = substr($inputs['mobile'], 0, 2) === '98' ? substr($inputs['mobile'], 2) : $inputs['mobile'];
            $inputs['mobile'] = str_replace('+98', '', $inputs['mobile']);
        } else {
            $errorText = 'شماره موبایل اشتباه است';
            return redirect()->route('admin.user.user-information.index', $user)->withErrors(['mobile' => $errorText]);
        }
        $userCheckMobileExist = User::where('mobile', $inputs['mobile'])->first();

        if ($userCheckMobileExist && $userCheckMobileExist->id == $user->id || !$userCheckMobileExist) {


            //upload profile
            if ($request->hasFile('image')) {
                $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'profile');
                $result = $imageService->save($request->file('image'));
                if ($result === false) {
                    return redirect()->route('admin.user.user-information.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
                }
                $inputs['image'] = $result;
            }
            //update user
            $user->update($inputs);
            return redirect()->route('admin.user.user-information.index', $user)->with('swal-success', 'اطلاعات با موفقیت به روزرسانی شد');
        }
        $errorText = 'شماره موبایل قبلا ثبت شده است';
        return redirect()->route('admin.user.user-information.index', $user)->withErrors(['mobile' => $errorText]);
    }
    public function accept(Request $request,User $user)
    {
        $user->update(['status' => 1]);
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'کاربر با ایدی' . $user->id . 'را تایید کرد',
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->route('admin.user.index')->with('swal-success', 'کاربر با موفقیت فعال شد');
    }
    public function reject(Request $request,User $user)
    {

        $user->update(['status' => 0]);
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'کاربر با ایدی' . $user->id . 'را رد کرد',
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->route('admin.user.index')->with('swal-success', 'کاربر با موفقیت غیرفعال  شد');
    }
}
