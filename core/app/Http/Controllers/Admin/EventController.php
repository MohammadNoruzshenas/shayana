<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = \App\Models\Event::orderBy('created_at', 'desc')->get();
        return view('admin.event.index', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file_path' => 'nullable|file|max:5120',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'link' => 'nullable|url',
            'publish_date' => 'nullable|date',
        ]);

        $event = new \App\Models\Event();
        $event->title = $request->title;
        $event->description = $request->description;
        $event->link = $request->link;
        
        if($request->publish_date) {
            $event->publish_date = \Carbon\Carbon::parse($request->publish_date);
        }

        if ($request->hasFile('file_path')) {
            $path = $request->file('file_path')->store('events', 'public');
            $event->file_path = '/storage/' . $path;
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events/images', 'public');
            $event->image = '/storage/' . $imagePath;
        }

        $event->save();

        return redirect()->route('admin.event.index')->with('swal-success', 'رویداد با موفقیت اضافه شد');
    }

    public function edit(\App\Models\Event $event)
    {
        return view('admin.event.edit', compact('event'));
    }

    public function update(Request $request, \App\Models\Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file_path' => 'nullable|file|max:5120',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'link' => 'nullable|url',
            'publish_date' => 'nullable|date',
        ]);

        $event->title = $request->title;
        $event->description = $request->description;
        $event->link = $request->link;

        if($request->publish_date) {
            $event->publish_date = \Carbon\Carbon::parse($request->publish_date);
        } else {
            $event->publish_date = null;
        }

        if ($request->hasFile('file_path')) {
            if ($event->file_path) {
                $oldPath = str_replace('/storage/', '', $event->file_path);
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('file_path')->store('events', 'public');
            $event->file_path = '/storage/' . $path;
        }

        if ($request->hasFile('image')) {
            if ($event->image) {
                $oldImagePath = str_replace('/storage/', '', $event->image);
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldImagePath);
            }
            $imagePath = $request->file('image')->store('events/images', 'public');
            $event->image = '/storage/' . $imagePath;
        }

        $event->save();

        return redirect()->route('admin.event.index')->with('swal-success', 'رویداد با موفقیت ویرایش شد');
    }

    public function destroy(\App\Models\Event $event)
    {
        if ($event->file_path) {
            $oldPath = str_replace('/storage/', '', $event->file_path);
            \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
        }
        $event->delete();
        return redirect()->route('admin.event.index')->with('swal-success', 'رویداد با موفقیت حذف شد');
    }
}
