<?php

namespace App\Http\Controllers\Admin\Market;

use App\Events\NewLession;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\LessionRequest;
use App\Http\Services\File\FileService;
use App\Models\Log\Log;
use App\Models\Market\Course;
use App\Models\Market\Lession;
use App\Models\Market\Season;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\ImageFile;

class LessionController extends Controller
{
    public function index(Course $course, Season $season)
    {
        $user = auth()->user();
        if ($user->can('show_lession') && $course->teacher_id == $user->id || $user->can('manage_course')) {

            return view('admin.market.course.lession.index', compact('season', 'course'));
        }
        abort(403);
    }
    public function create(Course $course, Season $season)
    {
        $user = auth()->user();
        if ($user->can('create_lession') && $course->teacher_id == $user->id || $user->can('manage_course')) {
            $seasons = season::where('course_id', $course->id)->where('confirmation_status', 1)->get();

            if ($seasons->count() <= 0) {
                return redirect()->back()->with('swal-error', 'لطفا ابتدا سرفصل اضافه نمایید');
            }
            return view('admin.market.course.lession.create', compact('course', 'seasons', 'season'));
        }
        abort(403);
    }
    public function store(LessionRequest $request, Course $course, Season $season = null)
    {

        $user = auth()->user();
        if ($user->can('create_lession') && $course->teacher_id == $user->id || $user->can('manage_course')) {
            $inputs = $request->all();
            $inputs['number'] = $this->generateNumber($request->number, $course);
            $inputs['link'] = !is_null($request->link) ? trim($request->link) : null;
            $inputs['file_link'] = !is_null($request->file_link) ? trim($request->file_link) : null;
            $inputs['course_id'] = $course->id;
            $inputs['user_id'] = auth()->user()->id;
            $lession = Lession::create($inputs);
            Log::create([
                'user_id' => auth()->user()->id,
                'description' => 'جلسه جدید با عنوان' . $lession->title . ' در دوره ی ' . $course->title . 'اضافه کرد',
                'ip' => $request->ip(),
                'os' => $request->header('user-Agent')
            ]);
            if ($season) {
                return redirect()->route('admin.market.course.season.lession.index', ['course' => $course, 'season' => $season])->with('swal-success', 'جلسه با موفقیت اپلود شد');
            }
            return redirect()->route('admin.market.course.details', $course)->with('swal-success', 'جلسه با موفقیت اپلود شد');
        }
        abort(403);
    }
    public function edit(Course $course, Lession $lession)
    {
        $user = auth()->user();
        if ($user->can('edit_lession') &&  $course->teacher_id == $user->id || $user->can('manage_course')) {
            $season = $lession->season_id;
            $seasons = season::where('course_id', $course->id)->get();
            return view('admin.market.course.lession.edit', compact('course', 'seasons', 'lession'));
        }
        abort(403);
    }
    public function update(LessionRequest $request, Course $course, Lession $lession, FileService $fileService)
    {
        $user = auth()->user();
        if ($user->can('edit_lession') && $course->teacher_id == $user->id || $user->can('manage_course')) {
            $inputs = $request->all();
            $inputs['link'] = !is_null($request->link) ? trim($request->link) : null;
            $inputs['file_link'] = !is_null($request->file_link) ? trim($request->file_link) : null;
            $inputs['course_id'] = $course->id;
            $inputs['user_id'] = auth()->user()->id;
            $lession->update($inputs);
            Log::create([
                'user_id' => auth()->user()->id,
                'description' => 'ویرایش جلسه با عنوان' . $lession->title . ' در دوره ی ' . $course->title,
                'ip' => $request->ip(),
                'os' => $request->header('user-Agent')
            ]);
            return redirect()->route('admin.market.course.season.lession.index', ['course' => $course->id,'season' => $lession->season_id])->with('swal-success', 'جلسه با موفقیت ویرایش شد');
        }
        abort(403);
    }
    public function destory(Course $course, Lession $lession, Request $request)
    {

        $user = auth()->user();
        if ($user->can('delete_lession') && $course->teacher_id == $user->id || $user->can('manage_course')) {

            if ($lession->media) {
                Storage::delete($lession->media);
            }
            Log::create([
                'user_id' => auth()->user()->id,
                'description' => 'حذف جلسه با عنوان' . $lession->title . ' در دوره ی ' . $course->title,
                'ip' => $request->ip(),
                'os' => $request->header('user-Agent')
            ]);
            $lession->delete();
            return redirect()->route('admin.market.course.season.lession.index',  ['course' => $course->id,'season' => $lession->season_id])->with('swal-success', 'جلسه با موفقیت حذف شد');
        }
        abort(403);
    }
    public function reject(Course $course, Lession $lession, Request $request)
    {
        $user = auth()->user();
        if ($user->can('manage_course') || $course->teacher_id == $user->id && $user->can('own_course')) {

            $lession->confirmation_status = 0;
            $lession->save();
            Log::create([
                'user_id' => auth()->user()->id,
                'description' => 'رد جلسه با عنوان' . $lession->title . ' در دوره ی ' . $course->title . 'اضافه کرد',
                'ip' => $request->ip(),
                'os' => $request->header('user-Agent')
            ]);
            return redirect()->back()->with('swal-success', 'جلسه با موفقیت رد شد');
        }
        abort(403);
    }
    public function accept(Course $course, Lession $lession, Request $request)
    {

        $user = auth()->user();
        if ($user->can('manage_course') || $course->teacher_id == $user->id && $user->can('own_course')) {

            $lession->confirmation_status = 1;
            $lession->save();
            Log::create([
                'user_id' => auth()->user()->id,
                'description' => 'تایید جلسه با عنوان' . $lession->title . ' در دوره ی ' . $course->title,
                'ip' => $request->ip(),
                'os' => $request->header('user-Agent')
            ]);
            event(new NewLession($lession));
            return redirect()->back()->with('swal-success', 'جلسه با موفقیت تایید شد');
        }
        abort(403);
    }
    public function acceptAll(Course $course, Request $request)
    {
        $user = auth()->user();

        if ($user->can('manage_course') || $course->teacher_id == $user->id && $user->can('own_course')) {
            $lession = Lession::where('course_id', $course->id)->get();
            Log::create([
                'user_id' => auth()->user()->id,
                'description' => 'تایید همه جلسات در دوره ' . $course->title,
                'ip' => $request->ip(),
                'os' => $request->header('user-Agent')
            ]);

            if (count($lession) > 0) {
                Lession::where('course_id', $course->id)->update(['confirmation_status' => 1]);
                return redirect()->route('admin.market.course.details', ['course' => $course->id])->with('swal-success', 'جلسات با موفقیت تایید شد');
            }
            return redirect()->route('admin.market.course.details', ['course' => $course->id])->with('swal-error', 'جلسه ای برای تایید وجود ندارد');
        }
        abort(403);
    }
    public function acceptMultiple(Course $course, Request $request,Season $season)
    {
        $user = auth()->user();
        if ($user->can('manage_course') || $course->teacher_id == $user->id && $user->can('own_course')) {

            $ids = explode(',', $request->ids);
            if (is_array($ids)) {
                Lession::query()->whereIn('id', $ids)->update(['confirmation_status' => 1]);
            }
            Log::create([
                'user_id' => auth()->user()->id,
                'description' => 'تایید برخی از جلسات با ایدی ' . $request->ids . ' در دوره ی ' . $course->title,
                'ip' => $request->ip(),
                'os' => $request->header('user-Agent')
            ]);
            return redirect()->route('admin.market.course.season.lession.index', ['course' => $course->id,'season' => $season])->with('swal-success', 'جلسات با موفقیت تایید شد');
        }
        abort(403);
    }
    public function rejectMultiple(Course $course, Request $request,Season $season)
    {
        $user = auth()->user();

        if ($user->can('manage_course') || $course->teacher_id == $user->id && $user->can('own_course')) {

            $ids = explode(',', $request->ids);
            if (is_array($ids)) {
                Lession::query()->whereIn('id', $ids)->update(['confirmation_status' => 0]);
            }
            Log::create([
                'user_id' => auth()->user()->id,
                'description' => 'رد برخی از جلسات با ایدی ' . $request->ids . ' در دوره ی ' . $course->title,
                'ip' => $request->ip(),
                'os' => $request->header('user-Agent')
            ]);
            return redirect()->route('admin.market.course.season.lession.index', ['course' => $course->id,'season' => $season])->with('swal-success', 'جلسات با موفقیت رد شد');
        }
        abort(403);
    }
    public function destroyMultiple(Course $course, Request $request,Season $season)
    {
        $user = auth()->user();

        if ($user->can('manage_course') || $course->teacher_id == $user->id && $user->can('own_course')) {

            $ids = explode(',', $request->ids);
            foreach ($ids as $id) {
                $lession = Lession::findOrFail($id);
                if ($lession->media) {
                    Storage::delete($lession->media);
                }
                $lession->delete();
            }
            Log::create([
                'user_id' => auth()->user()->id,
                'description' => 'حذف برخی از جلسات با ایدی ' . $request->ids . ' در دوره ی ' . $course->title,
                'ip' => $request->ip(),
                'os' => $request->header('user-Agent')
            ]);
            return redirect()->route('admin.market.course.season.lession.index', ['course' => $course->id,'season' => $season])->with('swal-success', 'جلسات با موفقیت حذف شد');
        }
        abort(403);
    }
    public function pending(Course $course, Lession $lession, Request $request)
    {
        $user = auth()->user();
        if ($user->can('manage_course') || $course->teacher_id == $user->id && $user->can('own_course')) {
            $lession->confirmation_status = 2;
            $lession->save();
            Log::create([
                'user_id' => auth()->user()->id,
                'description' => 'قفل جلسه با عنوان ' . $lession->title . ' در دوره ی ' . $course->title,
                'ip' => $request->ip(),
                'os' => $request->header('user-Agent')
            ]);
            return redirect()->back()->with('swal-success', 'جلسه با موفقیت قفل شد');
        }
        abort(403);
    }
    public function generateNumber($number, $course): int
    {
        if (is_null($number)) {
            $number = $course->lessons()->orderBy('number', 'desc')->firstOrNew([])->number ?: 0;
            $number++;
        }

        return $number;
    }

    public function reorder(Request $request, Course $course, Season $season)
    {
        $lessions = $season->lession;

        foreach ($lessions as $lession) {

            foreach ($request->order as $order) {

                if ($order['id'] == $lession->id) {

                    $lession->update(['number' => $order['position']]);
                }
            }
        }
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'ویرایش ترتیب جلسه  دوره ' . $course->title . ' توسط کاربر: ' . Auth::user()->email,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return response(['message' => 'Update Successfully','status' => 200], 200);
    }
}
