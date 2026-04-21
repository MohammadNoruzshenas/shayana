<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParentTraining;
use App\Models\ParentTrainingChapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ParentTrainingController extends Controller
{
    // ============ Chapters Methods ============
    
    public function index()
    {
        $chapters = ParentTrainingChapter::orderBy('order')->with('trainings')->get();
        return view('admin.parent-training.index', compact('chapters'));
    }

    public function storeChapter(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $maxOrder = ParentTrainingChapter::max('order') ?? 0;
        
        ParentTrainingChapter::create([
            'title' => $request->title,
            'description' => $request->description,
            'order' => $maxOrder + 1,
        ]);

        return redirect()->route('admin.parent-training.index')->with('swal-success', 'فصل با موفقیت اضافه شد');
    }

    public function editChapter(ParentTrainingChapter $chapter)
    {
        return view('admin.parent-training.edit-chapter', compact('chapter'));
    }

    public function updateChapter(Request $request, ParentTrainingChapter $chapter)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $chapter->update($request->only(['title', 'description']));

        return redirect()->route('admin.parent-training.index')->with('swal-success', 'فصل با موفقیت ویرایش شد');
    }

    public function destroyChapter(ParentTrainingChapter $chapter)
    {
        $chapter->delete();
        return redirect()->route('admin.parent-training.index')->with('swal-success', 'فصل با موفقیت حذف شد');
    }

    // ============ Sections Methods ============

    public function storeSection(Request $request)
    {
        $request->validate([
            'season_id' => 'required|exists:parent_training_seasons,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_link' => 'nullable|string',
            'audio_link' => 'nullable|string',
        ]);

        $maxOrder = ParentTraining::where('season_id', $request->season_id)->max('order') ?? 0;

        ParentTraining::create([
            'season_id' => $request->season_id,
            'title' => $request->title,
            'description' => $request->description,
            'video_link' => $request->video_link,
            'audio_link' => $request->audio_link,
            'order' => $maxOrder + 1,
        ]);

        return redirect()->route('admin.parent-training.index')->with('swal-success', 'قسمت با موفقیت اضافه شد');
    }

    public function editSection(ParentTraining $parentTraining)
    {
        $chapters = ParentTrainingChapter::orderBy('order')->get();
        return view('admin.parent-training.edit-section', compact('parentTraining', 'chapters'));
    }

    public function updateSection(Request $request, ParentTraining $parentTraining)
    {
        $request->validate([
            'season_id' => 'required|exists:parent_training_seasons,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_link' => 'nullable|string',
            'audio_link' => 'nullable|string',
        ]);

        $parentTraining->update([
            'season_id' => $request->season_id,
            'title' => $request->title,
            'description' => $request->description,
            'video_link' => $request->video_link,
            'audio_link' => $request->audio_link,
        ]);

        return redirect()->route('admin.parent-training.index')->with('swal-success', 'قسمت با موفقیت ویرایش شد');
    }

    public function destroySection(ParentTraining $parentTraining)
    {
        $parentTraining->delete();
        return redirect()->route('admin.parent-training.index')->with('swal-success', 'قسمت با موفقیت حذف شد');
    }
}
