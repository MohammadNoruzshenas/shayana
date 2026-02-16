<?php

namespace App\Http\Controllers\Admin\Repositories;

use App\Models\Market\Order;
use App\Models\Market\OrderItem;
use App\Models\Market\Payment;
use App\Models\Market\Settlement;
use App\Models\Market\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class DashboardFilterRepo
{

    public function getUserTotalBenefit($userId)
    {
        return OrderItem::whereIn(
            'payment_status',
            [1, 3]
        )->where('teacher_id', $userId)->sum('seller_share');
    }
    public function getUserTotalSiteShare($userId)
    {
        return OrderItem::whereIn(
            'payment_status',
            [1, 3]
        )->where('teacher_id', $userId)->sum('seller_site');
    }


    public function getUserSettlementDoing($userId)
    {
        return Settlement::where('status', 0)->where('user_id', $userId)->sum('amount');
    }
    public function getUserTotalSellByDay($userId, $date)
    {
        return OrderItem::whereIn('payment_status', [1, 3])->where('teacher_id', $userId)->whereDate("created_at", $date)->sum('seller_share');
    }
    public function getUserSellCountByDay($userId, $date)
    {
        return OrderItem::whereIn('payment_status', [1, 3])->where('teacher_id', $userId)->whereDate("created_at", $date)->count();
    }



    public function getLastNDaysPayments($days = null)
    {
        return Order::whereIn('payment_status', [1, 3])->where("created_at", ">=", now()->addDays($days));
    }
    public function getLastNDaysSuccessPayments($days = null)
    {
        return $this->getLastNDaysPayments($days);
    }

    public function getLastNDaysTotal($days = null)
    {
        //
        return $this->getLastNDaysSuccessPayments($days)->sum("order_final_amount");
    }

    public function getLastNDaysSiteBenefit($days = null)
    {
        return $this->getLastNDaysPayments($days)->sum("seller_site");
    }

    public function getLastNDaysSellerShare($days = null)
    {
        return Order::whereIn('payment_status', [1, 3])->sum('order_final_amount');
    }
    public function getTotalBenefit()
    {
        return Order::whereIn('payment_status', [1, 3])->sum('seller_site');
    }
    public function getTotalTeacherBenefit()
    {
        return Order::whereIn('payment_status', [1, 3])->sum('seller_share');
    }
    public function getTotalSell()
    {
        return Order::whereIn('payment_status', [1, 3])->sum('order_final_amount');
    }
    public function getDailySummary(Collection $dates, $teacherId = null)
    {
        $query = OrderItem::where("created_at", ">=", $dates->keys()->first())
            ->groupBy("date")
            ->orderBy("date");

        if (!is_null($teacherId))
            $query->where("teacher_id", $teacherId);

        return $query->get([
            DB::raw("DATE(created_at) as date"),
            DB::raw("SUM(seller_share + seller_site) as totalAmount"),
            DB::raw("SUM(seller_share) as totalSellerShare"),
            DB::raw("SUM(seller_site) as totalSiteShare"),
        ]);
    }
    public function getDays(Collection $dates)
    {
        $query = OrderItem::where("created_at", ">=", $dates->keys()->first())
            ->groupBy("date")
            ->orderBy("date");
        return $query->get([
            DB::raw("DATE(created_at) as date"),
            DB::raw("SUM(seller_share + seller_site) as totalAmount"),
            DB::raw("SUM(seller_share) as totalSellerShare"),
            DB::raw("SUM(seller_site) as totalSiteShare"),
        ]);
    }
    public function getTotalPaymentSettlement()
    {
        return Settlement::where('status', 1)->sum('amount');
    }
    public function getTotalOrderSuccessToday()
    {
        return Order::whereDate('updated_at', now())->whereIn('order_status', [1, 3])->count();
    }
    public function getTotalOrderSuccess()
    {
        return Order::whereIn('order_status', [1, 3])->count();
    }
    public function getTopSellCourses($marketing = true, $userId = null)
    {
        if ($marketing) {
            return OrderItem::select('course_id', DB::raw('COUNT(*) as TotalBuys'))->selectRaw('
      SUM(seller_share + seller_site) as price,
      SUM(seller_share) as seller_share
      ')->groupBy('course_id')->orderBy('price', 'DESC')->with('singleProduct')->take(10)->get();
        }

        return OrderItem::select('course_id', DB::raw('COUNT(*) as TotalBuys'))->selectRaw('
        SUM(seller_share + seller_site) as price,
        SUM(seller_share) as seller_share
        ')->where('teacher_id', $userId)->orderBy('price', 'DESC')->groupBy('course_id')->with('singleProduct')->take(10)->get();
    }
    public function getTopSellCoursesLastMonth($marketing = true, $userId = null)
    {
        if ($marketing) {
            return OrderItem::select('course_id', DB::raw('COUNT(*) as TotalBuys'))->selectRaw('
            SUM(seller_share + seller_site) as price,
            SUM(seller_share) as seller_share
            ')->where('created_at', '>=', now()->subMonth())->groupBy('course_id')->orderBy('price', 'DESC')->with('singleProduct')->take(10)->get();
        }
        return OrderItem::select('course_id', DB::raw('COUNT(*) as TotalBuys'))->selectRaw('
        SUM(seller_share + seller_site) as price,
        SUM(seller_share) as seller_share
        ')->where('teacher_id', $userId)->where('created_at', '>=', now()->subMonth())->groupBy('course_id')->orderBy('price', 'DESC')->with('singleProduct')->take(10)->get();
    }
    public function getDailySummaryCourse(Collection $dates, $courseId)
    {
        $query = OrderItem::where("created_at", ">=", $dates->keys()->first())
            ->where('course_id', $courseId)
            ->groupBy("date")
            ->orderBy("date");


        return $query->get([
            DB::raw("DATE(created_at) as date"),
            DB::raw("SUM(seller_share + seller_site) as totalAmount"),
            DB::raw("SUM(seller_share) as totalSellerShare"),
            DB::raw("SUM(seller_site) as totalSiteShare"),
            DB::raw("COUNT(*) as buys"),

        ]);
    }
    public function getCourseSell($days = null, $marketing = true, $userId = null)
    {
        if ($marketing) {
            if ($days) {
                return  OrderItem::where('created_at', '>=', now()->addDays($days))->count();
            }
            return  OrderItem::count();
        }
        if ($days) {
            return  OrderItem::where('teacher_id', $userId)->where('created_at', '>=', now()->addDays($days))->count();
        }
        return  OrderItem::where('teacher_id', $userId)->count();
    }
    public function benefitSellCourse($days = null, $benefit, $marketing = true, $userId = null)
    {
        if ($marketing) {
            if ($days) {
                return OrderItem::where('created_at', '>=', now()->addDays($days))->sum($benefit);
            }
            return OrderItem::sum('seller_share');
        }

        if ($days) {
            return OrderItem::where('teacher_id', $userId)->where('created_at', '>=', now()->addDays($days))->sum($benefit);
        }
        return OrderItem::where('teacher_id', $userId)->sum('seller_share');
    }
    public  function bestSellingTeachersMonth()
    {

        return OrderItem::select('teacher_id', DB::raw('COUNT(*) as TotalBuys'))->selectRaw('
        SUM(seller_share + seller_site) as price,
        SUM(seller_share) as seller_share
        ')->where('created_at', '>=', now()->subMonth())->groupBy('teacher_id')->orderBy('price', 'DESC')->with('user')->take(10)->get();
    }
    public  function  bestSellingTeachersTotal()
    {
        return OrderItem::select('teacher_id', DB::raw('COUNT(*) as TotalBuys'))->selectRaw('
        SUM(seller_share + seller_site) as price,
        SUM(seller_share) as seller_share
        ')->groupBy('teacher_id')->orderBy('price', 'DESC')->with('user')->take(10)->get();
    }
    public static function bestStudentsMonth()
    {
        return Order::select('user_id', DB::raw('COUNT(*) as TotalBuys'))
            ->selectRaw('SUM(order_final_amount) as total_price')
            ->where('created_at', '>=', now()->subMonth())
            ->where('order_status', 1)
            ->orWhere('order_status', 3)
            ->orderBy('total_price', 'DESC')
            ->groupBy('user_id')
            ->with('user')

            ->take(10)
            ->get();
    }
    public static function bestStudents()
    {
        return Order::select('user_id', DB::raw('COUNT(*) as TotalBuys'))
            ->selectRaw('SUM(order_final_amount) as total_price')
            ->where('order_status', 1)
            ->orWhere('order_status', 3)
            ->orderBy('total_price', 'DESC')
            ->groupBy('user_id')
            ->with('user')
            ->take(10)
            ->get();
    }
}
