<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\SettingRequest;
use App\Models\Log\Log;
use App\Models\Setting\SecureRecord;
use App\Models\Setting\Setting;
use Database\Seeders\SecureSeeder;
use Database\Seeders\SettingSeeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;



class SettingController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            if (!$this->user->can('manage_setting')) {
                abort(403);
            }
            return $next($request);
        });

    }
    public function index()
    {
        $setting = Setting::first();
        if($setting === null){
            $default = new SettingSeeder();
            $default->run();
            $setting = Setting::first();
        }
        return view('admin.setting.index',compact('setting'));
    }
    public function update(SettingRequest $request, Setting $setting)
    {

        $inputs = $request->all();
        $inputs['site_repair'] = (isset($inputs['site_repair']) && $inputs['site_repair'] == 'on') ? 1:0;
        $inputs['account_confirmation'] = (isset($inputs['account_confirmation']) && $inputs['account_confirmation'] == 'on') ? 1:0;
        $inputs['stop_selling'] = (isset($inputs['stop_selling']) && $inputs['stop_selling'] == 'on') ? 1:0;
        $inputs['can_register_user'] = (isset($inputs['can_register_user']) && $inputs['can_register_user'] == 'on') ? 1:0;
        $inputs['chat_online'] = (isset($inputs['chat_online']) && $inputs['chat_online'] == 'on') ? 1:0;
        $inputs['recaptcha'] = (isset($inputs['recaptcha']) && $inputs['recaptcha'] == 'on') ? 1:0;
        $inputs['can_send_ticket'] = (isset($inputs['can_send_ticket']) && $inputs['can_send_ticket'] == 'on') ? 1:0;
        $inputs['comment_default_approved'] = (isset($inputs['comment_default_approved']) && $inputs['comment_default_approved'] == 'on') ? 1:0;
        $inputs['commentable'] = (isset($inputs['commentable']) && $inputs['commentable'] == 'on') ? 1:0;
        $inputs['can_request_settlements'] = (isset($inputs['can_request_settlements']) && $inputs['can_request_settlements'] == 'on') ? 1:0;

        if($inputs['site_repair'] == 1 )
        {
            Artisan::call('down', [
                '--secret' => SecureRecord::first()['site_repair_key'],
            ]);
        }elseif($inputs['site_repair'] == 0)
        {
          Artisan::call('up');
        }
        $setting->update($inputs);
        Cache::clear();

        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'ویرایش تنظیمات وبسایت',
            'ip' =>$request->ip(),
            'os' => $request->header('user-Agent')
            ]);
        return redirect()->route('admin.setting.index')->with('swal-success', 'تنظیمات سایت  شما با موفقیت ویرایش شد');
    }


}
