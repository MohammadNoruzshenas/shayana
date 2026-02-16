<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Admin\Repositories\OrderFilterRepo;
use App\Http\Controllers\Controller;
use App\Models\Market\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
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
    public function index(OrderFilterRepo $repo)
    {
        $orders = $repo->searchEmail(request('email'))->payment_status(request('payment_status'))->amount(request('amount'))->paginateParents(20);
        $orders->appends(request()->query());

        return view('admin.market.order.index',compact('orders'));
    }

    public function orderUser(User $user)
    {
        $orders = Order::where('user_id',$user->id)->get();
        return view('admin.market.order.order-user',compact('orders'));
    }
    public function details(Order $order)
    {
        return view('admin.market.order.details',compact('order'));
    }
}
