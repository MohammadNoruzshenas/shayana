<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\NotificationSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationSettingController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            if (!$this->user->can('manage_notification')) {
                abort(403);
            }
            return $next($request);
        });

    }
    public function index()
    {
        $notifications = NotificationSetting::all();
        return view('admin.setting.notification.index', compact('notifications'));
    }
    public function update(Request $request)
    {
        $inputs = $request->except('_token','_method');
        foreach($inputs as $key=>$input)
        {
            $notification = NotificationSetting::where('id',$key)->first();
            $notification->update([
                'status' => $input,
            ]);
        }
        return redirect()->back()->with('swal-success', 'تغییرات با موفقیت اعمال شد');
     }
}
