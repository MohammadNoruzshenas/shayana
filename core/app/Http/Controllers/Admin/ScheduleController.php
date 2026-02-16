<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Market\Course;
use App\Models\Market\Lession;
use App\Models\Market\ScheduleItem;
use App\Models\Market\Season;
use App\Models\Market\WeeklySchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Market\UserLessionRead;
use App\Jobs\SendConfirmStudentJob;


class ScheduleController extends Controller
{
    /**
     * Display a listing of weekly schedules.
     */
    public function index(Request $request)
    {
        $schedules = WeeklySchedule::with(['user', 'scheduleItems'])
            ->when($request->filled('first_name'), function($query) use ($request) {
                $query->whereHas('user', function($q) use ($request) {
                    $q->where('first_name', 'like', '%' . $request->first_name . '%');
                });
            })
            ->when($request->filled('last_name'), function($query) use ($request) {
                $query->whereHas('user', function($q) use ($request) {
                    $q->where('last_name', 'like', '%' . $request->last_name . '%');
                });
            })
            ->when($request->filled('mobile'), function($query) use ($request) {
                $query->whereHas('user', function($q) use ($request) {
                    $q->where('mobile', 'like', '%' . $request->mobile . '%');
                });
            })
            ->when($request->filled('email'), function($query) use ($request) {
                $query->whereHas('user', function($q) use ($request) {
                    $q->where('email', 'like', '%' . $request->email . '%');
                });
            })
            ->when($request->filled('username'), function($query) use ($request) {
                $query->whereHas('user', function($q) use ($request) {
                    $q->where('username', 'like', '%' . $request->username . '%');
                });
            })
            ->latest()
            ->paginate(10);

        return view('admin.schedule.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new schedule.
     */
    public function create()
    {
        $users = User::get();
        $seasons = Season::with(['course.teacher', 'parent'])->get();
        
        return view('admin.schedule.create', compact('users', 'seasons'));
    }

    /**
     * Store a newly created schedule in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'week_start_date' => 'required',
            'title' => 'nullable|string|max:255',
            'schedule' => 'array',
            'schedule.*.*.main_season_id' => 'nullable|exists:seasons,id',
            'schedule.*.*.sub_season_id' => 'nullable|exists:seasons,id',
            'schedule.*.*.lession_id' => 'nullable|exists:lessions,id',
            'schedule.*.*.notes' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($request) {
            // Create weekly schedule
            $schedule = WeeklySchedule::create([
                'user_id' => $request->user_id,
                'week_start_date' => jalaliDateToMiladi(convertPersianToEnglish($request->week_start_date),"Y/m/d"),
                'title' => $request->title,
                'status' => 1,
            ]);

            // Create schedule items
            if ($request->has('schedule')) {
                foreach ($request->schedule as $dayIndex => $slots) {
                    foreach ($slots as $slotIndex => $slotData) {
                        // Allow creating schedule items with either lesson_id OR notes (or both)
                        if (!empty($slotData['lession_id']) || !empty($slotData['notes'])) {
                            ScheduleItem::create([
                                'weekly_schedule_id' => $schedule->id,
                                'day_of_week' => $dayIndex,
                                'time_slot' => $slotIndex,
                                'lession_id' => $slotData['lession_id'] ?? null,
                                'notes' => $slotData['notes'] ?? null,
                            ]);
                        }
                    }
                }
            }
        });

        return redirect()->route('admin.schedule.index')
            ->with('success', 'برنامه هفتگی با موفقیت ایجاد شد.');
    }

    /**
     * Display the specified schedule.
     */
    public function show($id)
    {
        $schedule = WeeklySchedule::with(['user', 'scheduleItems.lession.course'])
            ->findOrFail($id);

        return view('admin.schedule.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified schedule.
     */
    public function edit($id)
    {
        $schedule = WeeklySchedule::with(['scheduleItems.lession.season.parent.course.teacher'])
            ->findOrFail($id);
            $courses = Course::get();
        $users = User::where('status', 1)->get();
        $seasons = Season::where('status', 1)->with(['course.teacher', 'parent'])->get();

        return view('admin.schedule.edit', compact('schedule', 'users', 'seasons','courses'));
    }

    /**
     * Update the specified schedule in storage.
     */
    public function update(Request $request, $id)
    {
        $schedule = WeeklySchedule::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'week_start_date' => 'required',
            'title' => 'nullable|string|max:255',
            'status' => 'required|in:0,1',
            'schedule' => 'array',
            'schedule.*.*.main_season_id' => 'nullable|exists:seasons,id',
            'schedule.*.*.sub_season_id' => 'nullable|exists:seasons,id',
            'schedule.*.*.lession_id' => 'nullable|exists:lessions,id',
            'schedule.*.*.notes' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($request, $schedule) {
            // Update weekly schedule
            $schedule->update([
                'user_id' => $request->user_id,
                'week_start_date' => jalaliDateToMiladi(convertPersianToEnglish($request->week_start_date),"Y/m/d"),
                'title' => $request->title,
                'status' => $request->status,
            ]);

            // Delete existing schedule items
            $schedule->scheduleItems()->delete();

            // Create new schedule items
            if ($request->has('schedule')) {
                foreach ($request->schedule as $dayIndex => $slots) {
                    foreach ($slots as $slotIndex => $slotData) {
                        // Allow creating schedule items with either lesson_id OR notes (or both)
                        if (!empty($slotData['lession_id']) || !empty($slotData['notes'])) {
                            ScheduleItem::create([
                                'weekly_schedule_id' => $schedule->id,
                                'day_of_week' => $dayIndex,
                                'time_slot' => $slotIndex,
                                'lession_id' => $slotData['lession_id'] ?? null,
                                'notes' => $slotData['notes'] ?? null,
                            ]);
                        }
                    }
                }
            }
        });

        return redirect()->route('admin.schedule.index')
            ->with('success', 'برنامه هفتگی با موفقیت به‌روزرسانی شد.');
    }

    /**
     * Remove the specified schedule from storage.
     */
    public function destroy($id)
    {
        $schedule = WeeklySchedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('admin.schedule.index')
            ->with('success', 'برنامه هفتگی با موفقیت حذف شد.');
    }

    /**
     * Get schedule data for AJAX requests
     */
    public function getScheduleData($id)
    {
        $schedule = WeeklySchedule::with(['scheduleItems.lession'])
            ->findOrFail($id);

        $organizedSchedule = [];
        
        for ($day = 0; $day < 7; $day++) {
            for ($slot = 1; $slot <= 4; $slot++) {
                $item = $schedule->scheduleItems
                    ->where('day_of_week', $day)
                    ->where('time_slot', $slot)
                    ->first();
                
                $organizedSchedule[$day][$slot] = [
                    'lession_id' => $item ? $item->lession_id : null,
                    'notes' => $item ? $item->notes : null,
                    'lession_title' => $item && $item->lession ? $item->lession->title : null,
                ];
            }
        }

        return response()->json($organizedSchedule);
    }

    /**
     * Get main seasons for a specific course (AJAX) - parent_id is null
     */
    public function getSeasonsByCourse(Request $request)
    {
        $courseId = $request->get('course_id');
        
        if (!$courseId) {
            return response()->json([]);
        }
        
        $seasons = Season::where('course_id', $courseId)
            ->whereNull('parent_id') // Only main seasons
            //->where('status', 1)
            ->select('id', 'title', 'number')
            ->orderBy('number')
            ->get();
            
        return response()->json($seasons);
    }

    /**
     * Get sub-seasons for a specific main season (AJAX)
     */
    public function getSubSeasonsByMainSeason(Request $request)
    {
        $mainSeasonId = $request->get('main_season_id');
        
        if (!$mainSeasonId) {
            return response()->json([]);
        }
        
        $subSeasons = Season::where('parent_id', $mainSeasonId)
         //   ->where('status', 1)
            ->select('id', 'title', 'number')
            ->orderBy('number')
            ->get();
            
        return response()->json($subSeasons);
    }

    /**
     * Get lessons for a specific sub-season (AJAX)
     */
    public function getLessonsBySubSeason(Request $request)
    {
        $subSeasonId = $request->get('sub_season_id');
        $userId = $request->get('user_id');
        
        if (!$subSeasonId) {
            return response()->json([]);
        }
        
        $lessons = Lession::where('season_id', $subSeasonId)
           // ->where('status', 1)
            ->select('id', 'title', 'number')
            ->orderBy('number')
            ->get();
        $userReadeds = UserLessionRead::where('user_id',$userId)->pluck('lession_id')->toArray();
        
        // If user_id is provided, check which lessons exist in previous schedules
        $previousLessonIds = [];
        if ($userId) {
            $previousLessonIds = ScheduleItem::whereHas('weeklySchedule', function($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->whereNotNull('lession_id')
                ->pluck('lession_id')
                ->unique()
                ->toArray();
        }
        
        // Add the previous_schedule flag to each lesson
        $lessons = $lessons->map(function ($lesson) use ($previousLessonIds,$userReadeds) {
            $lesson->in_previous_schedule = in_array($lesson->id, $previousLessonIds);
            $lesson->is_read = in_array($lesson->id,$userReadeds);
            return $lesson;
        });
            
        return response()->json($lessons);
    }

    /**
     * Get lessons for a specific course (AJAX) - Updated for backward compatibility
     */
    public function getLessonsByCourse(Request $request)
    {
        $courseId = $request->get('course_id');
        
        if (!$courseId) {
            return response()->json([]);
        }
        
        // Get all lessons for a course through seasons
        $lessons = Lession::whereHas('season', function($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            //->where('status', 1)
            ->with('season')
            ->select('id', 'title', 'number', 'season_id')
            ->orderBy('number')
            ->get();
            
        return response()->json($lessons);
    }

    /**
     * Send SMS notification to parent about new schedule
     */
    public function sendScheduleSms(Request $request, $id)
    {
        $request->validate([
            'adjective' => 'required|string|max:50'
        ]);

        $schedule = WeeklySchedule::with('user')->findOrFail($id);
        $user = $schedule->user;

        // Check if user has mobile number
        if (!$user->mobile) {
            return response()->json([
                'success' => false,
                'message' => 'شماره موبایل کاربر ثبت نشده است.'
            ], 400);
        }

        // Build the SMS message using translation
        $parentName = $user->parent_name ?: '';
        $studentName = $user->first_name ?: 'فرزند شما';
        $adjective = $request->adjective;

        $message = __('sms.newSchedule', [
            'parentName' => $parentName,
            'studentName' => $studentName,
            'adjective' => $adjective
        ]);

        // Send SMS using the job
        SendConfirmStudentJob::dispatch([$user->mobile], [$message]);

        return response()->json([
            'success' => true,
            'message' => 'پیامک با موفقیت ارسال شد.'
        ]);
    }

    public function sendWarningSms(Request $request, $id)
    {
        $message = "والد گرامی،با توجه به اینکه نتوانستیم از طریق اپلیکیشن‌های بله یا روبیکا با شما در ارتباط باشیم، خواهشمندیم برای به‌روزرسانی برنامهٔ «کوچولو دلبندتون» در اسرع وقت با پشتیبانی تخصصی خود از طریق پیام رسان ها ارتباط حاصل فرمایید.";
        $schedule = WeeklySchedule::with('user')->findOrFail($id);
        $user = $schedule->user;

        // Send SMS using the job
        SendConfirmStudentJob::dispatch([$user->mobile], [$message]);
        return redirect()->route('admin.schedule.index')
            ->with('success', 'پیامک با موفقیت ارسال شد.');

    }
}
