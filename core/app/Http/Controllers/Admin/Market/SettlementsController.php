<?php

namespace App\Http\Controllers\Admin\Market;

use App\Events\PaymentSettlements;
use App\Http\Controllers\Admin\Repositories\SettlementFilterRepo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\SettlementsRequest;
use App\Models\Log\Log;
use App\Models\Market\Settlement;
use App\Models\Market\Wallet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class SettlementsController extends Controller
{

    public function index(SettlementFilterRepo $repo)
    {
        $user = auth()->user();

        if (!$user->can('manage_financial')) {
            abort(403);
        }
        $settlements = $repo->status(request('status'))->searchEmail(request('email'))->amount(request('amount'))->username(request('username'))->email(request('email'))->paginateParents(20);
        $settlements->appends(request()->query());
        return view('admin.market.settlements.index', compact('settlements'));
    }

    public function create()
    {
        return view('admin.market.settlements.create');
    }
    public function store(SettlementsRequest $request)
    {
        $inputs = $request->all();
        if ($this->getLatestPendingSettlement()) {
            return redirect()->route('admin.index')->with('swal-error', 'شما یک درخواست تسویه در حال انتظار دارید و نمیتوانید درخواست جدیدی فعلا ثبت بکنید.');
        }
        if (Auth::user()->balance < Cache::get('settings')->minimum_deposit_request || Auth::user()->balance < $inputs['amount']) {
            return redirect()->route('admin.index')->with('swal-error', 'موجودی شما برای درخواست تسویه کم میباشد');
        }
        settlement::create([
            'user_id' => Auth::user()->id,
            "amount" => $inputs["amount"],
            "to" => [
                "cart" => $inputs["cart"],
                "name" => $inputs["name"],
            ],
            'comments' => $inputs['comments']
        ]);
        return redirect()->route('admin.index')->with('swal-success', 'درخواست شما با موفقیت ثبت شد');
    }
    //get last pending settlement
    public function getLatestPendingSettlement()
    {
        return Settlement::where("user_id", Auth::user()->id)->where("status", 0)->latest()->first();
    }
    public function reject(Settlement $settlement, Request $request)
    {
        $user = auth()->user();
        if (!$user->can('manage_financial')) {
            abort(403);
        }
        $settlement->update(['status' => 2]);
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'رد درخواست پرداخت برای کاربر :  ' . $settlement->user->email,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->route('admin.market.settlements.index')->with('swal-success', 'درخواست پرداخت با موفقیت رد شد');
    }
    public function cancelled(Settlement $settlement, Request $request)
    {
        $user = auth()->user();

        if (!$user->can('manage_financial')) {
            abort(403);
        }
        $settlement->update(['status' => 3]);
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'لغو درخواست پرداخت برای کاربر :  ' . $settlement->user->email,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->route('admin.market.settlements.index')->with('swal-success', 'درخواست پرداخت با موفقیت لغو شد');
    }
    public function returned(Settlement $settlement)
    {
        $user = auth()->user();

        if (!$user->can('manage_financial')) {
            abort(403);
        }
        $settlement->update(['status' => 4]);
        return redirect()->route('admin.market.settlements.index')->with('swal-success', 'درخواست پرداخت با موفقیت برگشت داده شد');
    }
    public function payment(Settlement $settlement)
    {
        $user = auth()->user();

        if (!$user->can('manage_financial')) {
            abort(403);
        }
        //Check that the request has not been previously paid or rejected or canceled
        if ($settlement->status == 1 || $settlement->status == 2 || $settlement->status == 3 || $settlement->status == 4) {
            return redirect()->route('admin.market.settlements.index')->with('swal-error', "این درخواست قبلا $settlement->status_value شده است");
        }
        $remainingMoney = $settlement->user->balance - $settlement->amount;
        return view('admin.market.settlements.payment', compact('settlement', 'remainingMoney'));
    }
    public function paymentStore(SettlementsRequest $request, Settlement $settlement)
    {
        $user = auth()->user();
        if (!$user->can('manage_financial')) {
            abort(403);
        }
        //Check that the request has not been previously paid or rejected or canceled
        if ($settlement->status == 1 || $settlement->status == 2 || $settlement->status == 3 || $settlement->status == 4) {
            return redirect()->route('admin.market.settlements.index')->with('swal-error', "این درخواست قبلا $settlement->status_value شده است");
        }
        $inputs = $request->all();
        $settlement->update(
            [
                "from" => [
                    "cart" => $inputs["cart"],
                    "name" => $inputs["name"],
                    "user" => Auth::user()->id,
                ],
                'status' => 1,
                'settled_at' => now(),
            ]
        );

        //find teacher and decrement balance
        $user = User::find($settlement->user->id);
        $user->decrement('balance', $settlement->amount);
        Wallet::create([
            'price' => $settlement->amount,
            'user_id' => $settlement->user->id,
            'type' => 0,
            'description' => 'برداشت بابت تسویه حساب مدرس به آیدی  : ' . $settlement->id
        ]);
        event(new PaymentSettlements($settlement));
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'پرداخت به کاربر :  ' . $user->email,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->route('admin.market.settlements.index')->with('swal-success', ' پرداخت با موفقیت انجام شد');
    }
}
