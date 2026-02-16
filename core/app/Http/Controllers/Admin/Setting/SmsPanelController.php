<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\SmsPanel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SmsPanelController extends Controller
{
    public function index()
    {
        $smsPanels = SmsPanel::all();
        return view('admin.setting.smsPanel.index',compact('smsPanels'));
    }
    public function edit(SmsPanel $smsPanel)
    {
        return view('admin.setting.smsPanel.edit',compact('smsPanel'));
    }
    public function update(SmsPanel $smsPanel,Request $request)
    {
        $smsPanel->update([
            'number' => $request->number,
            'username' => $request->username,
            'password' => $request->password,
        ]);
        return redirect()->route('admin.setting.smsPanel.index')->with('swal-success','پنل اس ام اس با موفقیت ویرایش شد');
    }
    public function active(SmsPanel $smsPanel)
    {
        foreach(SmsPanel::where('status',1)->get() as $item)
        {
            $item->status = 0;
            $item->save();
        }
        $smsPanel->status = 1;
        $smsPanel->save();
        Cache::clear();
        return redirect()->route('admin.setting.smsPanel.index')->with('swal-success','پنل اس ام اس با موفقیت ویرایش شد');
    }

}
