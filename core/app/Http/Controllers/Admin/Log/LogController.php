<?php

namespace App\Http\Controllers\Admin\Log;

use App\Http\Controllers\Admin\Repositories\LogFilterRepo;
use App\Http\Controllers\Controller;
use App\Models\Log\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            if (!$this->user->can('manage_logs')) {
                abort(403);
            }
            return $next($request);
        });


    }
    public function index(LogFilterRepo $repo,Request $request)
    {
        $logs = $repo->email($request->email)->paginateParents(20);
        $canDeleteLog =  Log::whereDate('created_at', '<=', Carbon::now()->subMonths(1))->count();
        return  view('admin.log.index',compact('logs','canDeleteLog'));
    }
    public function show(Log $log)
    {
        return view('admin.log.show',compact('log'));
    }
    public function destory()
    {
        $oneMonthAgo = Carbon::now()->subMonths(1);
        $logs = Log::whereDate('created_at', '<=', $oneMonthAgo)->get();
        foreach($logs as $log)
        {
            $log->forceDelete();
        }
        return back()->with('swal-success','لاگ ها با موفقیت پاک شدن');
    }
}
