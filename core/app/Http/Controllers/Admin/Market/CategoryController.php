<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\CourseCategoriesRequest;
use App\Models\Market\CourseCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        if (!$user->can('show_category')) {
            abort(403);
        }
        $courseCategories = CourseCategory::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.market.category.index', compact('courseCategories'));
    }
    public function store(CourseCategoriesRequest $request)
    {
        $user = auth()->user();
        if (!$user->can('create_category')) {
            abort(403);
        }
        $pattern = '/<svg\b[^>]* (viewBox=\"(\b[^"]*)\").*?>([\s\S]*?)<\/svg>/';
        $inputs = $request->all();

        if (!is_null($inputs['svg_code'])) {
            if (substr($inputs['svg_code'], 0, 4) != '<svg' || preg_match($pattern, $inputs['svg_code']) != 1) {
                return redirect()->back()->with('swal-error', 'کد اس وی جی اشتباه است');
            }
        }

        $courseCategory = CourseCategory::create($inputs);
        return redirect()->route('admin.market.category.index')->with('swal-success', 'دسته بندی  جدید شما با موفقیت ثبت شد');
    }
    public function edit(CourseCategory $courseCategory)
    {

        $user = auth()->user();
        if (!$user->can('edit_category')) {
            abort(403);
        }
        $courseCategories = CourseCategory::all()->except($courseCategory->id);
        return view('admin.market.category.edit', compact('courseCategory', 'courseCategories'));
    }
    public function update(CourseCategoriesRequest $request, CourseCategory $courseCategory)
    {
        $user = auth()->user();
        if (!$user->can('edit_category')) {
            abort(403);
        }

        $pattern = '/<svg\b[^>]* (viewBox=\"(\b[^"]*)\").*?>([\s\S]*?)<\/svg>/';
        $inputs = $request->all();

        if (!is_null($inputs['svg_code'])) {
            if (substr($inputs['svg_code'], 0, 4) != '<svg' || preg_match($pattern, $inputs['svg_code']) != 1) {
                return redirect()->back()->with('swal-error', 'کد اس وی جی اشتباه است');
            }
        }
        $courseCategory->update($request->all());
        return redirect()->route('admin.market.category.index')->with('swal-success', 'دسته بندی با موفقیت ویرایش  شد');
    }
    public function destory(CourseCategory $courseCategory)
    {

        $user = auth()->user();
        if (!$user->can('delete_category')) {
            abort(403);
        }
        $courseCategory->delete();
        return redirect()->route('admin.market.category.index')->with('swal-success', 'دسته بندی با موفقیت حذف  شد');
    }

    public function status(CourseCategory $courseCategory)
    {
        $user = auth()->user();
        if (!$user->can('edit_category')) {
            abort(403);
        }
        $courseCategory->status = $courseCategory->status == 0 ? 1 : 0;
        $result = $courseCategory->save();
        if ($result) {
            if ($courseCategory->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
