<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Admin\Repositories\SubscriptionRepo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\SubscriptionRequest;
use App\Models\Log\Log;
use App\Models\Market\Payment;
use App\Models\Market\Plan;
use App\Models\Market\Subscription;
use App\Models\Market\SubscriptionAt;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function GuzzleHttp\Promise\all;

class SubscriptionController extends Controller
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
    public function index(SubscriptionRepo $repo, Request $request)
    {
        $subscriptions =  $repo->activeSub(request('status'))->searchEmail(request('email'))->paginateParents(20);

        $subscriptions->appends(request()->query());
        return view('admin.market.subscription.index', compact('subscriptions'));
    }
    public function create()
    {

        $plans = Plan::where('status', 1)->get();
        return view('admin.market.subscription.create', compact('plans'));
    }
    public function store(SubscriptionRequest $request)
    {
        $inputs = $request->all();
        //findUser
        $user = User::where('mobile', $inputs['user'])->orWhere('email', $inputs['user'])->first();

        if (!$user) {
            return redirect()->route('admin.market.subscription.create')->with('swal-error', 'کاربر یافت  نشد');
        }

        $plan = Plan::where('id', $inputs['plan_id'])->first();
        $inputs['user_id'] = $user->id;
        $inputs['order_final_amount'] = $inputs['price'] == null ? $plan->price : $inputs['price'];
        $inputs['price'] = $plan->price;
        $inputs['expirydate'] = Carbon::now()->addDay($plan->subscription_day);
        $inputs['plan_object'] = $plan;
        $inputs['payment_status'] = 1;
        $inputs['status'] = 1;

        $userExpire = Subscription::where(['user_id' => $user->id, 'status' => 1])->latest()->first();
        if (empty($userExpire->expirydate) || $userExpire->expirydate <= Carbon::now()) {
            DB::transaction(function () use ($inputs, $user) {
                $subscription =  Subscription::create($inputs);
                $payment = Payment::create([
                    'amount' => $inputs['order_final_amount'],
                    'user_id' => $user->id,
                    'gateway' => Auth::user()->full_name . ' پرداخت شده از طرف سایت',
                    'status' => 1,
                    'paymentable_id' => $subscription->id,
                    'paymentable_type' => 'App\Models\Market\Subscription',
                    'pay_for' => 2,
                    'description' => $inputs['description']
                ]);
                $subscription->update([
                    'payment_id' => $payment->id,
                    'payment_object' => $payment
                ]);
            });
        } else {
            return redirect()->route('admin.market.subscription.create')->with('swal-error', 'کاربر اشتراک فعال دارد!');
        }
        return redirect()->route('admin.market.subscription.index')->with('swal-success', 'اشتراک با موفقیت ایجاد شد');
    }

    public function destroy(Subscription $subscription, Request $request)
    {
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'حذف اشتراک  برای کاربر :  ' . $subscription->user->email . 'پلن کاربر ' . $subscription->plan->name,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        $subscription->delete();

        return redirect()->route('admin.market.subscription.index')->with('swal-success', 'اشتراک باموفقیت حذف  شد');
    }
    public function status(Subscription $subscription)
    {

        $subscription->status = $subscription->status == 0 ? 1 : 0;
        $result = $subscription->save();
        if ($result) {
            if ($subscription->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
    public function details(Subscription $subscription)
    {
        return view('admin.market.subscription.details', compact('subscription'));
    }
}
