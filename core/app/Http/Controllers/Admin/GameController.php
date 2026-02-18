<?php

namespace App\Http\Controllers\Admin;

use App\Models\Game;
use App\Models\Market\Course;
use App\Http\Controllers\Controller;
use App\Models\Market\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::with('course', 'mainSeason', 'subSeason')->latest()->get();
        return view('admin.game.index', compact('games'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'course_id' => 'required|exists:courses,id',
            'main_season_id' => 'required|exists:seasons,id',
            'sub_season_id' => 'required|exists:seasons,id'
        ]);

        // Upload image if provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('games', 'public');
            $validated['image'] = $imagePath;
        }

        Game::create($validated);

        return redirect()->route('admin.game.index')->with('swal-success', 'بازی با موفقیت ثبت شد');
    }

    public function edit(Game $game)
    {
        $courses = Course::where('status', 1)->orderBy('title')->get();
        return view('admin.game.edit', compact('game', 'courses'));
    }

    public function update(Request $request, Game $game)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'course_id' => 'required|exists:courses,id',
            'main_season_id' => 'required|exists:seasons,id',
            'sub_season_id' => 'required|exists:seasons,id'
        ]);

        if ($request->hasFile('image')) {
            if ($game->image) {
                Storage::disk('public')->delete($game->image);
            }
            $imagePath = $request->file('image')->store('games', 'public');
            $validated['image'] = $imagePath;
        }

        $game->update($validated);

        return redirect()->route('admin.game.index')->with('swal-success', 'بازی با موفقیت ویرایش شد');
    }

    public function destroy(Game $game)
    {
        if ($game->image) {
            Storage::disk('public')->delete($game->image);
        }
        $game->delete();
        return redirect()->route('admin.game.index')->with('swal-success', 'بازی با موفقیت حذف شد');
    }

    public function getCourses()
    {
        $courses = Course::where('status', 1)
            ->select('id', 'title')
            ->orderBy('title')
            ->get();
        return response()->json($courses);
    }

    public function getSeasonsByCourse(Request $request)
    {
        $courseId = $request->get('course_id');
        if (!$courseId) {
            return response()->json([]);
        }
        $seasons = Season::where('course_id', $courseId)
            ->whereNull('parent_id') // Main seasons only
            ->where('confirmation_status', 1)
            ->select('id', 'title', 'number')
            ->orderBy('number')
            ->get();
        return response()->json($seasons);
    }

    public function getSubSeasonsByMainSeason(Request $request)
    {
        $mainSeasonId = $request->get('main_season_id');
        $subSeasons = Season::where('parent_id', $mainSeasonId)
            ->where('confirmation_status', 1)
            ->select('id', 'title', 'number')
            ->orderBy('number')
            ->get();
        return response()->json($subSeasons);
    }

    /**
     * Get games by course, main season and sub season (for schedule page)
     */
    public function getGamesBySubSeason(Request $request)
    {
        $courseId = $request->get('course_id');
        $mainSeasonId = $request->get('main_season_id');
        $subSeasonId = $request->get('sub_season_id');

        if (!$courseId || !$mainSeasonId || !$subSeasonId) {
            return response()->json([]);
        }

        $games = Game::where('course_id', $courseId)
            ->where('main_season_id', $mainSeasonId)
            ->where('sub_season_id', $subSeasonId)
            ->select('id', 'title')
            ->orderBy('title')
            ->get();

        return response()->json($games);
    }
}
