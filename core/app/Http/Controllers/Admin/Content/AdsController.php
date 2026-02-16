<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\AdsRequest;
use App\Http\Services\File\FileService;
use App\Http\Services\Image\ImageService;
use App\Models\Content\Ads;
use App\Models\Log\Log;
use App\Models\Market\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if(!$user->can('show_ads'))
        {
            abort(403);
        }
        $adverts = Ads::orderBy('created_at', 'desc')->paginate(20);
       return view('admin.content.ads.index',compact('adverts'));
    }
    public function create()
    {
        $user = auth()->user();

        if(!$user->can('create_ads'))
        {
            abort(403);
        }
       return view('admin.content.ads.create');
    }
    public function store(AdsRequest $request,FileService $fileService)
    {
        $user = auth()->user();

        if(!$user->can('create_ads'))
        {
            abort(403);
        }
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->start_at, 0, 10);
        $inputs['start_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        //date fixed
        $realTimestampStart = substr($request->enddate_at, 0, 10);
        $inputs['enddate_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        //
        if($request->hasFile('banner')){
            $fileService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'ads');
            $result = $fileService->moveToPublic($request->file('banner'));
            if ($result === false) {
                return redirect()->route('admin.content.ads.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['banner'] = $result;
        }
        $inputs['user_id'] = Auth::user()->id;
        DB::transaction(function() use($inputs,$request){
            $ads = Ads::create($inputs);
            Payment::create([
                'amount' => $inputs['amount'],
                'user_id' => auth()->user()->id,
                'gateway' => ' پرداخت شده از طرف سایت' .' '. Auth::user()->full_name,
                'status' => 1,
                'paymentable_id' => $ads->id,
                'paymentable_type' => 'App\Models\Market\Ads',
                'description' => $inputs['description'],
                'pay_for' =>  3
            ]);
            Log::create([
                'user_id' => auth()->user()->id,
                'description' => 'تبلیغ ایجاد کرد با عنوان: '.$ads->title,
                'ip' =>$request->ip(),
                'os' => $request->header('user-Agent')
                ]);
        });
        return redirect()->route('admin.content.ads.index')->with('swal-success','تبلیغ با موفقیت ایجاد شد');
    }
    public function edit(Ads $ads)
    {
        $user = auth()->user();

        if(!$user->can('edit_ads'))
        {
            abort(403);
        }
       return view('admin.content.ads.edit',compact('ads'));
    }
    public function update(AdsRequest $request,Ads $ads,FileService $fileService)
    {
        $user = auth()->user();

        if(!$user->can('edit_ads'))
        {
            abort(403);
        }
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->start_at, 0, 10);
        $inputs['start_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        //date fixed
        $realTimestampStart = substr($request->enddate_at, 0, 10);
        $inputs['enddate_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        //
        if($request->hasFile('banner')){
            $fileService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'ads');
            $result = $fileService->moveToPublic($request->file('banner'));
            if ($result === false) {
                return redirect()->route('admin.content.ads.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['banner'] = $result;
        }

        DB::transaction(function() use($inputs,$ads,$request){
            $payment = Payment::where(['paymentable_id' => $ads->id,
            'paymentable_type' => 'App\Models\Market\Ads']);
            $payment->update([
                'amount' => $inputs['amount'],
                'user_id' => auth()->user()->id,
                'gateway' => ' پرداخت شده از طرف سایت ' .' '. Auth::user()->full_name,
                'status' => 1,
                'description' => $inputs['description'],
                'pay_for' =>  3
            ]);
            Log::create([
                'user_id' => auth()->user()->id,
                'description' => 'ویرایش تبلیغ با عنوان  :' . $ads->title.'را ویرایش کرد  '.'عنوان تبلیغ جدید '.$inputs['title'],
                'ip' => $request->ip(),
                'os' => $request->header('user-Agent')
                ]);
          $ads->update($inputs);
        });
        return redirect()->route('admin.content.ads.index')->with('swal-success','تبلیغ با موفقیت اپدیت شد');

    }
    public function destory(Ads $ads,FileService $fileService,Request $request)
    {
            $user = auth()->user();
        if(!$user->can('delete_ads'))
        {
            abort(403);
        }
        if ($ads->banner) {
            $fileService->deleteFile($ads->banner);
        }
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'حذف تبلیغ با عنوان'.$ads->title,
            'ip' =>$request->ip(),
            'os' => $request->header('user-Agent')
            ]);
        $ads->delete();
        return redirect()->route('admin.content.ads.index')->with('swal-success','تبلیغ با موفقیت حذف شد');

    }
}
