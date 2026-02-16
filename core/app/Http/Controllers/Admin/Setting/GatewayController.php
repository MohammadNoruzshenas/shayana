<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Models\Log\Log;
use App\Models\Setting\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class GatewayController extends Controller
{
    public function index()
    {
        $gateways = Gateway::all();
        return view('admin.setting.gateway.index',compact('gateways'));
    }
    public function edit(Gateway $gateway)
    {
        return view('admin.setting.gateway.edit',compact('gateway'));
    }
    public function update(Gateway $gateway,Request $request)
    {
        $gateway->update([
            'token' => $request->token,
        ]);
        Log::create([
            'user_id' => auth()->user()->id,
            'description' =>  'درگاه پرداخت '.$gateway->name_en.'را ویرایش کرد' ,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        Cache::clear();

        return redirect()->route('admin.setting.gateway.index')->with('swal-success','درگاه با موفقیت ویرایش شد');
    }
    public function active(Gateway $gateway,Request $request)
    {
        foreach(Gateway::where('status',1)->get() as $item)
        {
            $item->status = 0;
            $item->save();
        }
        $gateway->status = 1;
        $gateway->save();
        Log::create([
            'user_id' => auth()->user()->id,
            'description' =>  'درگاه پرداخت '.$gateway->name_en.'را ویرایش کرد' ,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        Cache::clear();
        return redirect()->route('admin.setting.gateway.index')->with('swal-success','درگاه با موفقیت ویرایش شد');
    }
}
