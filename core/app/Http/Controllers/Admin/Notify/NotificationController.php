<?php

namespace App\Http\Controllers\Admin\Notify;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Notify\NotificationRequest;
use App\Models\Market\Course;
use App\Models\Notify\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
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
        $notifications = Notification::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.notify.notification.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::all();
        return view('admin.notify.notification.create',compact('courses'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotificationRequest $request)
    {
        $inputs = $request->all();
        if($inputs['type'] == 0)
        {
            $inputs['course_id'] = null;
        }
        $inputs['user_id'] = Auth::user()->id;
        $notification = Notification::create($inputs);
        return redirect()->route('admin.notify.notification.index')->with('swal-success', 'اعلان شما با موفقیت ثبت شد');
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
    public function edit(Notification $notification)
    {
        $courses = Course::all();

        return view('admin.notify.notification.edit', compact('notification','courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NotificationRequest $request, Notification $notification)
    {
        $inputs = $request->all();
        if($inputs['type'] == 0)
        {
            $inputs['course_id'] = null;
        }
        $inputs['user_id'] = Auth::user()->id;
        $notification->update($inputs);
        return redirect()->route('admin.notify.notification.index')->with('swal-success', 'اعلان شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        $result = $notification->delete();
        return redirect()->route('admin.notify.notification.index')->with('swal-success', 'پیامک شما با موفقیت حذف شد');
    }


    public function status(Notification $notification){

        $notification->status = $notification->status == 0 ? 1 : 0;
        $result = $notification->save();
        if($result){
                if($notification->status == 0){
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
}
