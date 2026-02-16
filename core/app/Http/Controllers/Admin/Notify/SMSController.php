<?php

namespace App\Http\Controllers\Admin\Notify;

use App\Models\Notify\SMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Notify\SMSRequest;
use App\Jobs\SendSmsToUsers;
use App\Models\Market\Course;
use App\Models\Setting\SmsPanel;
use Illuminate\Support\Facades\Auth;

class SMSController extends Controller
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sms = SMS::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.notify.sms.index', compact('sms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::all();
        return view('admin.notify.sms.create',compact('courses'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SMSRequest $request)
    {
        $inputs = $request->all();
        if($inputs['type'] == 0)
        {
            $inputs['course_id'] = null;
        }
        //date fixed
        // $realTimestampStart = substr($request->published_at, 0, 10);
        // $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $sms = SMS::create($inputs);
        return redirect()->route('admin.notify.sms.index')->with('swal-success', 'پیامک شما با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SMS $sms)
    {
        $courses = Course::all();
        return view('admin.notify.sms.edit', compact('sms','courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SMSRequest $request, SMS $sms)
    {
        $inputs = $request->all();
        if($inputs['type'] == 0)
        {
            $inputs['course_id'] = null;
        }
        //date fixed
        // $realTimestampStart = substr($request->published_at, 0, 10);
        // $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $sms->update($inputs);
        return redirect()->route('admin.notify.sms.index')->with('swal-success', 'پیامک شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SMS $sms)
    {
        $result = $sms->delete();
        return redirect()->route('admin.notify.sms.index')->with('swal-success', 'پیامک شما با موفقیت حذف شد');
    }


    public function status(SMS $sms){

        $sms->status = $sms->status == 0 ? 1 : 0;
        $result = $sms->save();
        if($result){
                if($sms->status == 0){
                    return response()->json(['status' => true, 'checked' => false]);
                }
                else{
                    return response()->json(['status' => true, 'checked' => true]);
                }
        }
        else{
            return response()->json(['status' => false]);
        }

    }


    public function sendSMS(SMS $sms)
    {
        $smsPanel = SmsPanel::where('status',1)->first();
        if (is_null($smsPanel) || $smsPanel->username == null || $smsPanel->password == null || $smsPanel->number == null) {
           return redirect()->back()->with('swal-error','پنل اس ام اسی یافت نشد');
        }
        if($sms->status == 1)
        {
        //SendSmsToUsers::dispatch($sms); //todo deactivate jobs
        return back()->with('swal-success', 'پیامک شما با موفقیت ارسال شد');
        }
        return back()->with('swal-error', 'وضعیت پیامک غیر فعال است');

    }
}
