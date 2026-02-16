<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\SeasonRequest;
use App\Models\Log\Log;
use App\Models\Market\Course;
use App\Models\Market\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{

    public function store(SeasonRequest $request, Course $course)
    {
        $user = auth()->user();
        if ($user->can('manage_course') || $user->can('create_lession') && $course->teacher_id == $user->id) {
            $inputs = $request->all();
            $inputs['user_id'] = auth()->user()->id;
            $inputs['course_id'] = $course->id;
            $inputs['number'] =  $this->generateNumber($request->number, $course);
            $inputs['parent_id'] = $request->parent_id ?? null;
            Season::create($inputs);
            return redirect()->route('admin.market.course.details', $course->id)->with('swal-success', 'سرفصل با موفقیت ایجاد شد');
        }
        abort(403);
    }
    public function edit(Course $course, season $season)
    {
        $user = auth()->user();
        if ($user->can('manage_course') || $user->can('edit_lession') && $course->teacher_id == $user->id) {
            return view('admin.market.course.season.edit', compact('season', 'course'));
        }
        abort(403);
    }
    public  function update(SeasonRequest $request, Course $course, Season $season)
    {
        $user = auth()->user();

        if ($user->can('manage_course') || $user->can('edit_lession') && $course->teacher_id == $user->id) {

            $inputs = $request->all();
            $season->update($inputs);
            return redirect()->route('admin.market.course.details', $course->id)->with('swal-success', 'سرفصل با موفقیت ویرایش شد');
        }
        abort(403);
    }
    public function destroy(Course $course, Season $season)
    {
        $user = auth()->user();

        if ($user->can('manage_course') || $user->can('delete_lession') && $course->teacher_id == $user->id) {
            $season->delete();
            return redirect()->route('admin.market.course.details', $course->id)->with('swal-success', 'سرفصل با موفقیت پاک شد');
        }
        abort(403);
    }
    public function accept(Course $course, Season $season)
    {
        $user = auth()->user();

        if ($user->can('manage_course') || $user->can('own_course') && $course->teacher_id == $user->id) {
            $season->update(['confirmation_status' => 1]);
            return redirect()->back()->with('swal-success', 'سرفصل با موفقیت تایید شد');
        }
        abort(403);
    }
    public function reject(Course $course, Season $season)
    {
        $user = auth()->user();

        if ($user->can('manage_course') || $user->can('own_course') && $course->teacher_id == $user->id) {
            $season->update(['confirmation_status' => 0]);
            return redirect()->back()->with('swal-success', 'سرفصل با موفقیت رد شد');
        }
        abort(403);
    }
    public function generateNumber($number, $course): int
    {
        if (is_null($number)) {
            $number = $course->season()->orderBy('number', 'desc')->firstOrNew([])->number ?: 0;
            $number++;
        }
        return $number;
    }
    public function reorder(Request $request, Course $course)
    {

        $seasons = $course->season()->get();

        foreach ($seasons as $season) {
            foreach ($request->order as $order) {
                if ($order['id'] == $season->id) {
                    $season->update(['number' => $order['position']]);
                }
            }
        }
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'ویرایش ترتیب سرفصل  دوره ' . $course->title . ' توسط کاربر: ' . Auth::user()->email,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);

        return response(['message' => 'Update Successfully','status' => 200], 200);
    }
}
