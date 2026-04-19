<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParentTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ParentTrainingController extends Controller
{
    public function index()
    {
        $parentTrainings = ParentTraining::orderBy('created_at', 'desc')->get();
        return view('admin.parent-training.index', compact('parentTrainings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_path' => 'required|file|mimetypes:video/mp4,video/mpeg,video/quicktime|max:51200', // Max 50MB
        ]);

        $parentTraining = new ParentTraining();
        $parentTraining->title = $request->title;
        $parentTraining->description = $request->description;

        if ($request->hasFile('video_path')) {
            $path = $request->file('video_path')->store('parent-trainings/videos', 'public');
            $parentTraining->video_path = '/storage/' . $path;
        }

        $parentTraining->save();

        return redirect()->route('admin.parent-training.index')->with('swal-success', 'آموزش با موفقیت اضافه شد');
    }

    public function edit(ParentTraining $parentTraining)
    {
        return view('admin.parent-training.edit', compact('parentTraining'));
    }

    public function update(Request $request, ParentTraining $parentTraining)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_path' => 'nullable|file|mimetypes:video/mp4,video/mpeg,video/quicktime|max:51200',
        ]);

        $parentTraining->title = $request->title;
        $parentTraining->description = $request->description;

        if ($request->hasFile('video_path')) {
            if ($parentTraining->video_path) {
                $oldPath = str_replace('/storage/', '', $parentTraining->video_path);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('video_path')->store('parent-trainings/videos', 'public');
            $parentTraining->video_path = '/storage/' . $path;
        }

        $parentTraining->save();

        return redirect()->route('admin.parent-training.index')->with('swal-success', 'آموزش با موفقیت ویرایش شد');
    }

    public function destroy(ParentTraining $parentTraining)
    {
        if ($parentTraining->video_path) {
            $oldPath = str_replace('/storage/', '', $parentTraining->video_path);
            Storage::disk('public')->delete($oldPath);
        }
        $parentTraining->delete();
        return redirect()->route('admin.parent-training.index')->with('swal-success', 'آموزش با موفقیت حذف شد');
    }
}
