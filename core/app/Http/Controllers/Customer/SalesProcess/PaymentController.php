<?php

namespace App\Http\Controllers\Customer\SalesProcess;

use App\Events\BuyCourse;
use App\Events\NewLicenseSpotPlayer;
use App\Http\Controllers\Controller;
use App\Http\Services\Payment\PaymentService;
use App\Models\Market\CartItem;
use App\Models\Market\Copan;
use App\Models\Market\Order;
use App\Models\Market\OrderItem;
use App\Models\Market\Payment;
use App\Models\Market\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function payment(Request $request, PaymentService $paymentService)
    {
        if (cache('settings')['stop_selling'] == 1) {
            return redirect()->route('customer.home')->with('swal-error', 'امکان ثبت نام در دوره موقتا غیر فعال شده است');
        }
        $user = auth()->user();

        //calc price
        $cartItems = CartItem::where('user_id', $user->id)->get();
        $totalProductPrice = 0;
        $totalDiscount = 0;
        $totalFinalPrice = 0;
        $totalOrderCommonDiscountAmount = 0;
        foreach ($cartItems as $cartItem) {
            $totalProductPrice += $cartItem->cartItemProductPrice();
            $totalDiscount += $cartItem->cartItemProductDiscount();
            $totalFinalPrice += $cartItem->cartItemFinalPrice();
            $totalOrderCommonDiscountAmount += $cartItem->cartItemProductDiscount();
        }
        $inputs['user_id'] = $user->id;
        $inputs['order_final_amount'] = $totalFinalPrice;
        $inputs['order_discount_amount'] = $totalOrderCommonDiscountAmount;
        $inputs['order_common_discount_amount'] = $totalOrderCommonDiscountAmount;
        $inputs['order_total_products_discount_amount'] = $inputs['order_common_discount_amount'];
        $inputs['totalProductPrice'] = $totalProductPrice;
        $inputs['seller_share'] = 0;
        $inputs['seller_site'] = 0;

        $order = Order::updateOrCreate(
            ['user_id' => $user->id, 'order_status' => 0, 'copan_id' => null],
            $inputs
        );
        if ($request->copan) {
            $this->copanDiscount($request->copan);
        }
        $order = Order::where('user_id', Auth::user()->id)->where('order_status', 0)->latest()->first();

        $payment = Payment::create([
            'amount' => $order['order_final_amount'],
            'user_id' => $inputs['user_id'],
            'status' => 0,
            'paymentable_id' => $order->id,
            'paymentable_type' => 'App\Models\Market\Order',
            'description' => 'سبد خرید',
            'pay_for' => 1,
        ]);
        if ($order->order_final_amount <= 0) {
            return $this->CourseRegistration($order->order_final_amount, $payment, $order);
        }
        $callBackRoute =  'customer.sales-process.payment-call-back';
        $paymentService->payment((int)$order->order_final_amount * 10, $order, $payment, $callBackRoute);
    }


    public function copanDiscount($copan)
    {
        $copan = Copan::where([['code', $copan], ['status', 1], ['end_date', '>', now()], ['start_date', '<', now()]])->first();
        if ($copan != null) {
            if ($copan->user_id != null) {
                $copan = Copan::where([['code', $copan], ['status', 1], ['end_date', '>', now()], ['start_date', '<', now()], ['user_id', auth()->user()->id]])->first();
                if ($copan == null) {
                    return redirect()->back()->withErrors(['copan' => ['کد تخفیف اشتباه وارد شده است']]);
                }
            }

            $order = Order::where('user_id', Auth::user()->id)->where('order_status', 0)->where('copan_id', null)->first();
            $order_copan_discount_amount = $order->order_final_amount * ($copan->amount / 100);
            $order_total_products_discount_amount = $order->order_total_products_discount_amount + $order_copan_discount_amount;

            $order->order_final_amount = $order->order_final_amount - $order->order_final_amount * ($copan->amount / 100);


            $order->update(
                ['copan_id' => $copan->id, 'order_copan_discount_amount' => $order_copan_discount_amount, 'order_total_products_discount_amount' => $order_total_products_discount_amount]
            );
        } else {
            return redirect()->back()->withErrors(['copan' => ['کد تخفیف اشتباه وارد شده است']]);
        }
    }
    public function paymentCallback(Order $order, Payment $payment, PaymentService $paymentService, Request $request)
    {
        if ($order->order_status == 1) {

            return redirect()->route('customer.profile')->with('swal-error', 'پرداخت شما قبلا ثبت شده است');
        }

        $amount = $payment->amount;
        $result = $paymentService->verify((int)$amount * 10, $payment, $order);
        if ($result['success']) {
            return $this->CourseRegistration($amount, $payment, $order);
        } else {
            return redirect()->route('customer.profile')->with('swal-error', 'پرداخت شما با خطا مواجه شد');
        }
    }
    private function CourseRegistration($amount, $payment, Order $order)
    {
        $cartItems = CartItem::where('user_id', Auth::user()->id)->get();
        $totalProductPrice = 0;
        foreach ($cartItems as $cartItem) {
            $totalProductPrice += $cartItem->cartItemProductPrice();
        }
        if ($order->totalProductPrice != $totalProductPrice) {
            $payment->update(['status' => 1, 'description' => 'مبلغ پرداخت شده با مبلغ سبد خرید مطابقت ندارد']);
            return redirect()->route('customer.profile')->with('swal-error', 'ملبغ پرداخت شده با مبلغ سبد خرید مطابفت ندارد لطفا با مدیریت تماس بگیرید');
        }
        $totalSeller_share = 0;
        $totalSeller_site = 0;
        foreach ($cartItems as $cartItem) {

            // Calculate the percentage of period money for site and teacher
            $seller_share = ($cartItem->cartItemFinalPrice() / 100) * $cartItem->course->percent;
            $seller_site = $cartItem->cartItemFinalPrice() - $seller_share;
            if ($order->copan) {
                $seller_share = $seller_share - $seller_share * ($order->copan->amount / 100);
                $seller_site = $seller_site - $seller_site * ($order->copan->amount / 100);
            }
            //

            $totalSeller_share += $seller_share;
            $totalSeller_site += $seller_site;
            DB::transaction(function () use ($order, $cartItem, $seller_share, $seller_site, $payment) {
                $order->update(['status' => 1, 'payment_status' => 1, 'order_status' => 1]);
                $payment->update(['status' => 1]);
                $newItem =  OrderItem::create([
                    'order_id' => $order->id,
                    'course_id' => $cartItem->course_id,
                    'teacher_id' => $cartItem->course->teacher->id,
                    'user_id' => Auth::user()->id,
                    'payment_status' => 1,
                    'course' => $cartItem->course,
                    'seller_share' => $seller_share,
                    'seller_site' => $seller_site,
                    'status' => 1
                ]);
                if ($seller_share > 0) {
                    Wallet::create([
                        'price' => $seller_share,
                        'user_id' => $cartItem->course->teacher->id,
                        'type' => 1,
                        'description' => 'خرید دوره توسط دانشجو : ' . $order->user->email ?? $order->user->mobile
                    ]);
                }
                if ($cartItem->course->get_course_option == 1) {
                    event(new NewLicenseSpotPlayer($newItem, $cartItem->course, Auth::user()));
                }
                //find teacher and increase seller share
                $teacher = $cartItem->course->teacher->increment('balance', $seller_share);
                //
                $cartItem->course->increment('sold_number');
                event(new BuyCourse(Auth::user()->id, $cartItem->course));
                $cartItem->delete();
            });
        }
        $order->update(['seller_share' => $totalSeller_share, 'seller_site' => $totalSeller_site]);
        return redirect()->route('customer.profile')->with('swal-success', 'پرداخت با موفقیت انجام شد');
    }
}
