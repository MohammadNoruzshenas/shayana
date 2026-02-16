<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Admin\Repositories\DashboardFilterRepo;
use App\Http\Controllers\Admin\Repositories\PaymentFilterRepo;
use App\Http\Controllers\Controller;
use App\Models\Market\Order;
use App\Models\Market\Payment;
use App\Models\Market\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;

class PaymentController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            if (!$this->user->can('manage_financial')) {
                abort(403);
            }
            return $next($request);
        });

    }
    public function index(PaymentFilterRepo $paymentRepo)
    {
        $payments = $paymentRepo->searchTransaction(request('transaction'))->searchAfterDate(jalaliDateToMiladi(request('start_date')))->searchBeforeDate(jalaliDateToMiladi(request('end_date')))->amount(request('amount'))->email(request('email'))->payFor(request('pay_for'))->paginateParents(20);
        $payments->appends(request()->query());

        return view('admin.market.payment.index',compact('payments'));
    }
    public function detail(Payment $payment)
    {
        return view('admin.market.payment.detail',compact('payment'));
    }


}
