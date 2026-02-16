<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\PodcastCategoryRequest;
use App\Models\Content\PodcastCategory;
use Illuminate\Http\Request;

class PodcastCategoryController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if(!$user->can('show_categoryPodcast'))
        {
            abort(403);
        }
        $podcastCategories = PodcastCategory::paginate(20);
        return view('admin.content.podcast.category.index', compact('podcastCategories'));
    }
    public function store(PodcastCategoryRequest $request)
    {

        $user = auth()->user();
        if(!$user->can('create_categoryPodcast'))
        {
            abort(403);
        }

        $inputs = $request->all();
         PodcastCategory::create($inputs);
        return redirect()->route('admin.content.podcastCategory.index')->with('swal-success', 'دسته بندی  جدید شما با موفقیت ثبت شد');
    }
    public function edit(PodcastCategory $podcastCategory)
    {
        $user = auth()->user();
        if(!$user->can('edit_categoryPodcast'))
        {
            abort(403);
        }
        $postCategories = PodcastCategory::all()->except($podcastCategory->id);
        return view('admin.content.podcast.category.edit', compact('podcastCategory', 'postCategories'));
    }
    public function update(PodcastCategoryRequest $request, PodcastCategory $podcastCategory)
    {
        $user = auth()->user();
        if(!$user->can('edit_categoryPodcast'))
        {
            abort(403);
        }
        $podcastCategory->update($request->all());
        return redirect()->route('admin.content.podcastCategory.index')->with('swal-success', 'دسته بندی با موفقیت ویرایش  شد');
    }
    public function destory(PodcastCategory $podcastCategory)
    {

        $user = auth()->user();
        if(!$user->can('delete_categoryPodcast'))
        {
            abort(403);
        }
        $podcastCategory->delete();
        return redirect()->route('admin.content.podcastCategory.index')->with('swal-success', 'دسته بندی با موفقیت حذف  شد');
    }

    public function status(PodcastCategory $podcastCategory)
    {
        $user = auth()->user();
        if(!$user->can('edit_categoryPodcast'))
        {
            abort(403);
        }
        $podcastCategory->status = $podcastCategory->status == 0 ? 1 : 0;
        $result = $podcastCategory->save();
        if ($result) {
            if ($podcastCategory->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
