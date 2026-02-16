<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\PostCategoriesRequest;
use App\Models\Content\PostCategory;
use Illuminate\Http\Request;

class PostCategoryController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if(!$user->can('show_categoryPost'))
        {
            abort(403);
        }
        $postCategories = PostCategory::paginate(20);
        return view('admin.content.category.index', compact('postCategories'));
    }
    public function store(PostCategoriesRequest $request)
    {

        $user = auth()->user();
        if(!$user->can('create_categoryPost'))
        {
            abort(403);
        }

        $inputs = $request->all();
        $postCategory = PostCategory::create($inputs);
        return redirect()->route('admin.content.category.index')->with('swal-success', 'دسته بندی  جدید شما با موفقیت ثبت شد');
    }
    public function edit(PostCategory $postCategory)
    {

        $user = auth()->user();
        if(!$user->can('edit_categoryPost'))
        {
            abort(403);
        }
        $postCategories = PostCategory::all()->except($postCategory->id);
        return view('admin.content.category.edit', compact('postCategory', 'postCategories'));
    }
    public function update(PostCategoriesRequest $request, PostCategory $postCategory)
    {
        $user = auth()->user();
        if(!$user->can('edit_categoryPost'))
        {
            abort(403);
        }
        $postCategory->update($request->all());
        return redirect()->route('admin.content.category.index')->with('swal-success', 'دسته بندی با موفقیت ویرایش  شد');
    }
    public function destory(PostCategory $postCategory)
    {

        $user = auth()->user();
        if(!$user->can('delete_categoryPost'))
        {
            abort(403);
        }
        $postCategory->delete();
        return redirect()->route('admin.content.category.index')->with('swal-success', 'دسته بندی با موفقیت حذف  شد');
    }

    public function status(PostCategory $postCategory)
    {
        $user = auth()->user();
        if(!$user->can('edit_categoryPost'))
        {
            abort(403);
        }
        $postCategory->status = $postCategory->status == 0 ? 1 : 0;
        $result = $postCategory->save();
        if ($result) {
            if ($postCategory->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
