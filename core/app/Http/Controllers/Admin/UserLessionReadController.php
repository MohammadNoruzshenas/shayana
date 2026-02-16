<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Market\Course;
use App\Models\Market\Season;
use App\Models\Market\Lession;
use App\Models\Market\UserLessionRead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserLessionReadController extends Controller
{
    /**
     * Display the user lesson read management page
     */
    public function index()
    {
        $users = User::select('id', 'first_name', 'last_name')
                    ->whereNotNull('first_name')
                    ->whereNotNull('last_name')
                    ->orderBy('first_name')
                    ->get()
                    ->map(function($user) {
                        $user->full_name = $user->first_name . ' ' . $user->last_name;
                        return $user;
                    });

        $courses = Course::where('status', 1)
                        //->where('confirmation_status', 1)
                        ->select('id', 'title')
                        ->orderBy('title')
                        ->get();

        return view('admin.user-lesson-read.index', compact('users', 'courses'));
    }

    /**
     * Get main seasons by course
     */
    public function getSeasonsByCourse(Request $request)
    {
        $courseId = $request->get('course_id');
        
        $seasons = Season::where('course_id', $courseId)
                        ->whereNull('parent_id') // Main seasons only
                        //->where('status', 1)
                        ->where('confirmation_status', 1)
                        ->select('id', 'title', 'number')
                        ->orderBy('number')
                        ->get();

        return response()->json($seasons);
    }

    /**
     * Get sub seasons by main season
     */
    public function getSubSeasonsByMainSeason(Request $request)
    {
        $mainSeasonId = $request->get('main_season_id');
        
        $subSeasons = Season::where('parent_id', $mainSeasonId)
                          // ->where('status', 1)
                           ->where('confirmation_status', 1)
                           ->select('id', 'title', 'number')
                           ->orderBy('number')
                           ->get();

        return response()->json($subSeasons);
    }

    /**
     * Get lessons by sub season with read status for selected user
     */
    public function getLessonsBySubSeason(Request $request)
    {
        $subSeasonId = $request->get('sub_season_id');
        $userId = $request->get('user_id');
        
        $lessons = Lession::where('season_id', $subSeasonId)
                        // ->where('status', 1)
                         ->where('confirmation_status', 1)
                         ->select('id', 'title', 'number')
                         ->orderBy('number')
                         ->get();

        // Add read status for each lesson if user is selected
        if ($userId) {
            $readLessons = UserLessionRead::where('user_id', $userId)
                                        ->whereIn('lession_id', $lessons->pluck('id'))
                                        ->pluck('lession_id')
                                        ->toArray();

            $lessons->each(function($lesson) use ($readLessons) {
                $lesson->is_read = in_array($lesson->id, $readLessons);
            });
        } else {
            $lessons->each(function($lesson) {
                $lesson->is_read = false;
            });
        }

        return response()->json($lessons);
    }

    /**
     * Save user lesson read status
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'sub_season_id' => 'required|exists:seasons,id',
            'lesson_ids' => 'array'
        ]);

        try {
            DB::beginTransaction();

            $userId = $request->user_id;
            $subSeasonId = $request->sub_season_id;
            $selectedLessonIds = $request->lesson_ids ?? [];

            // Get all lessons in this sub season
            $allLessonIds = Lession::where('season_id', $subSeasonId)
                                 // ->where('status', 1)
                                  ->where('confirmation_status', 1)
                                  ->pluck('id')
                                  ->toArray();

            // Remove all existing read records for this user and sub season
            UserLessionRead::where('user_id', $userId)
                          ->whereIn('lession_id', $allLessonIds)
                          ->delete();

            // Add read records for selected lessons
            foreach ($selectedLessonIds as $lessonId) {
                UserLessionRead::markAsRead($userId, $lessonId);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'وضعیت مطالعه دروس با موفقیت ذخیره شد.'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'خطا در ذخیره اطلاعات: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's reading statistics
     */
    public function getUserStats(Request $request)
    {
        $userId = $request->get('user_id');
        
        if (!$userId) {
            return response()->json([]);
        }

        $stats = [
            'total_read_lessons' => UserLessionRead::where('user_id', $userId)->count(),
            'courses_with_read_lessons' => UserLessionRead::where('user_id', $userId)
                                                         ->join('lessions', 'user_lession_reads.lession_id', '=', 'lessions.id')
                                                         ->distinct('lessions.course_id')
                                                         ->count('lessions.course_id'),
            'recent_reads' => UserLessionRead::where('user_id', $userId)
                                           ->with(['lession:id,title,course_id'])
                                           ->orderBy('read_at', 'desc')
                                           ->limit(5)
                                           ->get()
        ];

        return response()->json($stats);
    }
} 