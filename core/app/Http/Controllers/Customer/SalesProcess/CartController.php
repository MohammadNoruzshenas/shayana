<?php

namespace App\Http\Controllers\Customer\SalesProcess;

use App\Http\Controllers\Controller;
use App\Models\Market\CartItem;
use App\Models\Market\CommonDiscount;
use App\Models\Market\Copan;
use App\Models\Market\Course;
use App\Models\Market\Order;
use App\Models\Market\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{
    public function cart(Request $request)
    {

        if (Auth::check()) {
            $cartItems = CartItem::where('user_id', Auth::user()->id)->get();
            return view('customer.sales-process.cart', compact('cartItems'));
        } else {
            return redirect()->route('auth.customer.registerForm')->with('swal-error', 'لطفا ابتدا وارد شوید');
        }
    }


    public function copanDiscount(Request $request)
    {

        $request->validate(
            ['copan' => 'required']
        );

        $copan = Copan::where([['code', $request->copan], ['status', 1], ['end_date', '>', now()], ['start_date', '<', now()]])->first();

        if ($copan != null) {
            if ($copan->user_id != null) {
                $copan = Copan::where([['code', $request->copan], ['status', 1], ['end_date', '>', now()], ['start_date', '<', now()], ['user_id', auth()->user()->id]])->first();
                if ($copan == null) {
                    return redirect()->back()->withErrors(['copan' => ['کد تخفیف اشتباه وارد شده است']]);
                }
            }
            return Redirect::back()->with(['data' => $copan, 'copan' => 'تخفیف با موفقیت اعمال شد']);
        } else {
            return redirect()->back()->withErrors(['copan' => ['کد تخفیف اشتباه وارد شده است']]);
        }
    }
    public function addToCart(Course $course)
    {
        if (Auth::check()) {
            $cartItems = CartItem::where('course_id', $course->id)->where('user_id', auth()->user()->id)->first();
            if ($cartItems) {
                return back()->with('swal-error', 'شما قبلا این دوره رو به سبد خرید اضافه کردید');
            }
            if ($course->hasStudent() || Auth::user()->orderItems->where('course_id', $course->id)->first()) {
                return back()->with('swal-error', 'شما قبلا این دوره رو خریداری کردید در صورت بروز مشکل با مدیریت در ارتباط باشید');
            }
            if (!is_null($course->maximum_registration) && $course->maximum_registration < count($course->students)) {
                return back()->with('swal-error', 'ظرفیت دوره پر شده ');
            }
            if ($course->types == 0) {
               $order=  Order::create([
                    'user_id' => Auth::user()->id,
                    'order_final_amount' => 0,
                    'totalProductPrice' => 0,
                    'seller_share' => 0,
                    'seller_site' => 0,
                    'order_status' => 1,
                    'payment_status' => 1
                ]);
                $newItem =  OrderItem::create([
                    'order_id' => $order->id,
                    'course_id' => $course->id,
                    'teacher_id' => $course->teacher->id,
                    'user_id' => Auth::user()->id,
                    'payment_status' => 1,
                    'course' => $course,
                    'seller_share' => 0,
                    'seller_site' => 0,
                    'status' => 1
                ]);
                return back()->with('swal-success', 'دوره مورد نظر با موفقیت خریداری شد');
            }
            $inputs['user_id'] = auth()->user()->id;
            $inputs['course_id'] = $course->id;
            CartItem::create($inputs);
            return back()->with('swal-success', 'دوره مورد نظر با موفقیت به سبد خرید اضافه شد');
        } else {
            return redirect()->route('auth.customer.registerForm')->with('swal-error', 'لطفا ابتدا وارد شوید');
        }
    }

    public function removeFromCart(CartItem $cartItem)
    {
        if ($cartItem->user_id == Auth::user()->id) {
            $cartItem->delete();
        }
        return back()->with('swal-success', 'دوره مورد نظر با موفقیت از سبد خرید حذف شد');
    }
}
