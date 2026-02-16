<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Admin\Repositories\DashboardFilterRepo;
use App\Http\Controllers\Controller;
use App\Models\Content\Comment;
use App\Models\Content\Podcast;
use App\Models\Content\Post;
use App\Models\Log\Log;
use App\Models\Market\Course;
use App\Models\Market\Lession;
use App\Models\Market\Order;
use App\Models\Market\Payment;
use App\Models\Market\Season;
use App\Models\Market\Settlement;
use App\Models\Market\Wallet;
use App\Models\Ticket\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(DashboardFilterRepo $repo, Request $request)
    {
        $balance = null;
        $fullName = null;

        if (!Auth::user()->can('manage_financial')) {
            $userId = auth()->user()->id;
        } else {
            $user = User::where(['is_admin' => 1, 'id' => $request->userId])->first();

            if ($user) {
                $balance = $user->balance;
                $fullName = $user->full_name . ' | ' . $user->email;
                $userId = $user->id;
            } else {
                $userId = auth()->user()->id;
            }
        }
        $totalBenefit = $repo->getUserTotalBenefit($userId);
        $totalSiteShare = $repo->getUserTotalSiteShare($userId);
        $settlementDoing = $repo->getUserSettlementDoing($userId);
        $todaySuccessPaymentsCount = $repo->getUserSellCountByDay($userId, now());
        $getSettlement = Settlement::where('user_id', $userId)->where('status', 1)->sum('amount');
        $dates = collect();
        foreach (range(-30, 0) as $i) {

            $dates->put(now()->addDays($i)->format("Y-m-d"), 0);
        }
        $summary =  $repo->getDailySummary($dates, $userId);
        $days =  $repo->getDays($dates);


        $usersCount = User::count();
        $ticketsCount = Ticket::count();
        $commentsCount = Comment::count();
        $ticketsWatingAnswerCount = Ticket::where('status', 2)->count();
        $commentsWatingApproved = Comment::where('approved', 0)->count();
        $posts = Post::count();
        $numberCourses = Course::count();
        $logs = Log::latest()->take(11)->get();
        $postPending = Post::where('confirmation_status', 2)->count();
        $coursePending = Post::where('confirmation_status', 2)->count();


        $courseSellToday = $repo->getCourseSell(-1, false, $userId);
        $courseSellMonth = $repo->getCourseSell(-30, false, $userId);
        $courseSellYear = $repo->getCourseSell(-365, false, $userId);
        $courseSellAll = $repo->getCourseSell(null, false, $userId);

        $benefitTeacherToday = $repo->benefitSellCourse(-1, 'seller_share', false, $userId);
        $benefitTeacherMonth = $repo->benefitSellCourse(-30, 'seller_share', false, $userId);
        $benefitTeacherYear = $repo->benefitSellCourse(-365, 'seller_share', false, $userId);
        $benefitTeacherAll = $repo->benefitSellCourse(null, 'seller_share', false, $userId);

        $benefitSiteToday = $repo->benefitSellCourse(-1, 'seller_site', false, $userId);
        $benefitSiteMonth = $repo->benefitSellCourse(-30, 'seller_site', false, $userId);
        $benefitSiteYear = $repo->benefitSellCourse(-365, 'seller_site', false, $userId);
        $benefitSiteAll = $repo->benefitSellCourse(null, 'seller_site', false, $userId);

        $topSellCoursesMonth = $repo->getTopSellCoursesLastMonth(false, $userId);
        $topSellCourses = $repo->getTopSellCourses(false, $userId);

        //EndServer Check

        return view('admin.index', compact(
            'topSellCoursesMonth',
            'topSellCourses',
            'courseSellToday',
            'courseSellMonth',
            'courseSellYear',
            'courseSellAll',
            'benefitTeacherToday',
            'benefitTeacherMonth',
            'benefitTeacherYear',
            'benefitTeacherAll',
            'benefitSiteToday',
            'benefitSiteMonth',
            'benefitSiteYear',
            'benefitSiteAll',
            'totalBenefit',
            'totalSiteShare',
            'settlementDoing',
            'todaySuccessPaymentsCount',
            'dates',
            'summary',
            'getSettlement',
            'days',
            'usersCount',
            'ticketsCount',
            'ticketsWatingAnswerCount',
            'commentsWatingApproved',
            'commentsCount',
            'posts',
            'logs',
            'numberCourses',
            'postPending',
            'coursePending',
            'balance',
            'fullName'
        ));
    }


    public function marketing(DashboardFilterRepo $repo)
    {

        $userId = auth()->user()->id;
        if (!Auth::user()->can('manage_financial')) {
            abort(403);
        }
        $totalPaymentSettlement = $repo->getTotalPaymentSettlement();

        $totalSell = $repo->getTotalSell();
        $totalSiteBenefit = $repo->getTotalBenefit();
        $totalTeacherBenefit = $repo->getTotalTeacherBenefit();

        $payments = Payment::orderBy('created_at', 'desc')->get();
        $dates = collect();
        foreach (range(-30, 0) as $i) {

            $dates->put(now()->addDays($i)->format("Y-m-d"), 0);
        }
        $summary =  $repo->getDailySummary($dates, $userId);
        $days =  $repo->getDays($dates);
        $totalPaymentSubs = Payment::where(['paymentable_type' => 'App\Models\Market\Subscription', 'status' => 1])->sum('amount');
        $totalPaymentAds =  Payment::where(['paymentable_type' => 'App\Models\Market\Ads', 'status' => 1])->sum('amount');
        $totalPaymentSubsInMonth = Payment::where(['paymentable_type' => 'App\Models\Market\Subscription', 'status' => 1])->where("created_at", ">=", now()->addDays(-30))->sum('amount');
        $totalPaymentAdsInMonth = Payment::where(['paymentable_type' => 'App\Models\Market\Ads', 'status' => 1])->where("created_at", ">=", now()->addDays(-30))->sum('amount');

        $totalOrderSuccessToday = $repo->getTotalOrderSuccessToday();
        $totalOrderSuccess = $repo->getTotalOrderSuccess();
        $bestSellingTeachersMonths =  $repo->bestSellingTeachersMonth();
        $bestSellingTeachersTotal =  $repo->bestSellingTeachersTotal();
        $topSellCourses = $repo->getTopSellCourses();
        $topSellCoursesMonth = $repo->getTopSellCoursesLastMonth();
        $bestStudentsMonth = $repo->bestStudentsMonth();
        $bestStudents = $repo->bestStudents();
        //EndServer Check
        $courseSellToday = $repo->getCourseSell(-1);
        $courseSellMonth = $repo->getCourseSell(-30);
        $courseSellYear = $repo->getCourseSell(-365);
        $courseSellAll = $repo->getCourseSell();


        $benefitTeacherToday = $repo->benefitSellCourse(-1, 'seller_share');
        $benefitTeacherMonth = $repo->benefitSellCourse(-30, 'seller_share');
        $benefitTeacherYear = $repo->benefitSellCourse(-365, 'seller_share');
        $benefitTeacherAll = $repo->benefitSellCourse(null, 'seller_share');
        $benefitSiteToday = $repo->benefitSellCourse(-1, 'seller_site');
        $benefitSiteMonth = $repo->benefitSellCourse(-30, 'seller_site');
        $benefitSiteYear = $repo->benefitSellCourse(-365, 'seller_site');
        $benefitSiteAll = $repo->benefitSellCourse(null, 'seller_site');

        $accountBlanace = User::where('is_admin', 1)->sum('balance');
        return view('admin.marketing', compact(
            'accountBlanace',
            'courseSellToday',
            'courseSellMonth',
            'courseSellYear',
            'courseSellAll',
            'benefitTeacherToday',
            'benefitTeacherMonth',
            'benefitTeacherYear',
            'benefitTeacherAll',
            'benefitSiteToday',
            'benefitSiteMonth',
            'benefitSiteYear',
            'benefitSiteAll',
            'totalSiteBenefit',
            'totalPaymentSettlement',
            'totalPaymentAds',
            'totalPaymentSubs',
            'totalPaymentSubsInMonth',
            'totalPaymentAdsInMonth',
            'dates',
            'summary',
            'days',
            'bestSellingTeachersMonths',
            'bestSellingTeachersTotal',
            'topSellCourses',
            'topSellCoursesMonth',
            'bestStudentsMonth',
            'bestStudents',
            'totalTeacherBenefit'
        ));
    }



    public function notify()
    {
        if(auth()->user()->can('manage_course') || auth()->user()->can('manage_podcast') || auth()->user()->can('manage_post'))
        {
            $courses = Course::where('confirmation_status', 0)->take(10)->get();
            $posts = Post::where('confirmation_status', 2)->take(10)->get();
            $seasons = Season::where('confirmation_status', 2)->take(10)->get();
            $lessions = Lession::where('confirmation_status', 2)->take(10)->get();
            $podcasts = Podcast::where('confirmation_status', 2)->take(10)->get();
            return view('admin.notify', compact('courses', 'seasons', 'lessions', 'podcasts', 'posts'));
        }
        abort(403);
    }
}
