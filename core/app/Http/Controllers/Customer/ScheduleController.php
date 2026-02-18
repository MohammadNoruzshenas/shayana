<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Market\WeeklySchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of all user schedules
     */
    public function index(Request $request)
    {
        $schedules = WeeklySchedule::with([
            'scheduleItems.lession.season.parent.course',
            'scheduleItems.game.mainSeason',
            'scheduleItems.game.subSeason'
        ])
            ->where('user_id', Auth::id())
            ->where('status', 1)
            ->orderBy('week_start_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.schedule.index', compact('schedules'));
    }

    /**
     * Display the specified schedule
     */
    public function show(WeeklySchedule $schedule)
    {
        // Check if the schedule belongs to the authenticated user
        if ($schedule->user_id !== Auth::id()) {
            abort(403, 'شما مجاز به مشاهده این برنامه نیستید.');
        }

        // Load relationships
        $schedule->load([
            'scheduleItems.lession.season.parent.course',
            'scheduleItems.game.mainSeason',
            'scheduleItems.game.subSeason'
        ]);

        return view('customer.schedule.show', compact('schedule'));
    }

    /**
     * Get schedules for a specific week (AJAX endpoint)
     */
    public function getWeekSchedule(Request $request)
    {
        $weekStartDate = $request->input('week_start_date');
        
        if (!$weekStartDate) {
            return response()->json(['error' => 'تاریخ شروع هفته الزامی است'], 400);
        }

        $schedules = WeeklySchedule::with([
            'scheduleItems.lession.season.parent.course',
            'scheduleItems.game.mainSeason',
            'scheduleItems.game.subSeason'
        ])
            ->where('user_id', Auth::id())
            ->where('status', 1)
            ->where('week_start_date', $weekStartDate)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'schedules' => $schedules,
            'count' => $schedules->count()
        ]);
    }
} 