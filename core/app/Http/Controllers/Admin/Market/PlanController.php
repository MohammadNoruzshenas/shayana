<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\PlanReqeust;
use App\Http\Requests\Admin\Market\PlanRequest;
use App\Models\Log\Log;
use App\Models\Market\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            if (!$this->user->can('manage_subscribe')) {
                abort(403);
            }
            return $next($request);
        });

    }
    public function index()
    {
        $plans = Plan::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.market.subscription.plan',compact('plans'));
    }
    public function create()
    {
        return view('admin.market.subscription.plan-create');
    }
    public function store(PlanRequest $request)
   {
         $inputs = $request->all();
         $plan = Plan::create($inputs);
         Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'افزودن پلن با عنوان '.$plan->name,
            'ip' =>$request->ip(),
            'os' => $request->header('user-Agent')
            ]);
        return redirect()->route('admin.market.subscription.plan')->with('swal-success', 'پلن با موفقیت ایجاد شد');

   }
   public function edit(Plan $plan)
   {

        return view('admin.market.subscription.plan-edit',compact('plan'));
   }
   public function update(PlanRequest $request,Plan $plan)
   {
         $inputs = $request->all();
         $plan->update($inputs);
         Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'ویرایش پلن با عنوان '.$plan->name,
            'ip' =>$request->ip(),
            'os' => $request->header('user-Agent')
            ]);
        return redirect()->route('admin.market.subscription.plan')->with('swal-success', 'پلن با ویرایش  شد');

   }
   public function destroy(Plan $plan,Request $request)
   {
    Log::create([
        'user_id' => auth()->user()->id,
        'description' => 'حذف پلن با عنوان '.$plan->name,
        'ip' =>$request->ip(),
        'os' => $request->header('user-Agent')
        ]);
         $plan->delete();
        return redirect()->route('admin.market.subscription.plan')->with('swal-success', 'پلن با حذف  شد');

   }
}
