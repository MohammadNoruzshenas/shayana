<?php

namespace App\Http\Controllers\Admin\Market;

use App\Events\BuyCourse;
use App\Events\NewLicenseSpotPlayer;
use App\Http\Controllers\Admin\Repositories\CourseRepo;
use App\Http\Controllers\Admin\Repositories\DashboardFilterRepo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\CourseRequest;
use App\Http\Services\Image\ImageService;
use App\Models\Content\Comment;
use App\Models\Log\Log;
use App\Models\Market\Course;
use App\Models\Market\CourseCategory;
use App\Models\Market\Installment;
use App\Models\Market\Lession;
use App\Models\Market\Order;
use App\Models\Market\OrderItem;
use App\Models\Market\Payment;
use App\Models\Market\Season;
use App\Models\Market\Wallet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


class CourseController extends Controller
{

    public function index(CourseRepo $repo)
    {
        // check can access to page
        $user = auth()->user();
        if ($user->can('manage_course')) {
            $courses =  $repo->confirmationStatus(request("confirmation_status"))->searchEmail(request('email'))->searchTitle(request("title"))->paginateParents(20);
        } else {
            $courses =  $repo->confirmationStatus(request("confirmation_status"))->searchTitle(request("title"))->getCoursesByTeacherId($user)->paginateParents(20);
        }
        $courses->appends(request()->query());
        return view('admin.market.course.index', compact('courses'));
    }

    public function create()
    {
        $user = auth()->user();
        if (!$user->can('create_course')) {
            abort(403);
        }
        $users = User::where('is_admin', 1)->get();
        $categories = CourseCategory::all();
        return view('admin.market.course.create', compact('users', 'categories'));
    }

    public function store(CourseRequest $request, ImageService $imageService)
    {
        $user = auth()->user();
        if (!$user->can('create_course')) {
            abort(403);
        }
        $inputs = $request->all();
        //fix date
        $realTimestampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        //
        if (!$user->can('manage_course')) {
            $inputs['teacher_id'] = auth()->user()->id;
            $inputs['priority'] = null;
        }
        $inputs['price'] = $inputs['types'] != 1 ? 0 : $inputs['price'];
        $inputs['percent'] = $inputs['percent'] == null ? 0 : $inputs['percent'];
        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'course');
            $result = $imageService->save($request->file('image'));
            if ($result === false) {
                return redirect()->route('admin.market.course.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        }
        $course = Course::create($inputs);
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'دوره اضافه کرد - عنوان دوره : ' . $course->title,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->route('admin.market.course.index')->with('swal-success', 'دوره  جدید شما با موفقیت ایجاد شد');
    }

    public function edit(Course $course)
    {
        $user = auth()->user();
        if ($user->can('manage_course') || $user->can('edit_course') && $user->id == $course->teacher_id) {
            $users = User::where('is_admin', 1)->get();
            $categories = CourseCategory::all();
            return view('admin.market.course.edit', compact('users', 'course', 'categories'));
        }
        abort(403);
    }
    public function update(CourseRequest $request, Course $course, ImageService $imageService)
    {
        $user = auth()->user();
        if ($user->can('manage_course') || $user->can('edit_course') && $user->id == $course->teacher_id) {
            $inputs = $request->all();
              //date fixed
              $realTimestampStart = substr($request->published_at, 0, 10);
              $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);

            if (!$user->can('manage_course')) {
                $inputs['teacher_id'] = auth()->user()->id;
                $inputs['priority'] = null;
            }
            $inputs['price'] = $inputs['types'] != 1 ? 0 : $inputs['price'];

            if ($request->hasFile('image')) {
                if (!empty($request->image)) {
                    $imageService->deleteImage($course->image);
                }
                $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'course');
                $result = $imageService->save($request->file('image'));
                if ($result === false) {
                    return redirect()->route('admin.market.course.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
                }
                $inputs['image'] = $result;
            } else {
                if (isset($inputs['currentImage']) && !empty($course->image)) {
                    $image = $course->image;
                    $image['currentImage'] = $inputs['currentImage'];
                    $inputs['image'] = $image;
                }
            }
            $course->update($inputs);
            Log::create([
                'user_id' => auth()->user()->id,
                'description' => 'دوره را ویرایش کرد - عنوان دوره : ' . $course->title,
                'ip' => $request->ip(),
                'os' => $request->header('user-Agent')
            ]);
            return redirect()->route('admin.market.course.index')->with('swal-success', 'دوره با موفقیت به روز رسانی شد');
        }
        abort(403);
    }

    public function destory(Course $course, ImageService $imageService, Request $request)
    {
        $user = auth()->user();
        if ($user->can('manage_course') || $user->can('delete_course') && $user->id == $course->teacher_id) {
            // delete All Comment
            foreach ($course->comments()->get() as $comment) {
                $comment->forceDelete();
            }
            if ($course->image) {
                $imageService->deleteImage($course->image);
            }
            Log::create([
                'user_id' => auth()->user()->id,
                'description' => 'دوره را حذف کرد - عنوان دوره : ' . $course->title,
                'ip' => $request->ip(),
                'os' => $request->header('user-Agent')
            ]);
            $course->delete();
            return redirect()->route('admin.market.course.index')->with('swal-success', 'دوره  حذف شد');
        }
        abort(403);
    }

    public function rejection(Course $course, Request $request)
    {
        $user = auth()->user();
        if ($user->can('manage_course') || $user->can('own_course') && $user->id == $course->teacher_id) {
            $course->confirmation_status = 2;
            $course->save();
            Log::create([
                'user_id' => auth()->user()->id,
                'description' => 'دوره را رد کرد - عنوان دوره : ' . $course->title,
                'ip' => $request->ip(),
                'os' => $request->header('user-Agent')
            ]);
            return redirect()->back()->with('swal-success', 'دوره با موفقیت رد شد');
        }
        abort(403);
    }
    public function confirmation(Course $course, Request $request)
    {
        $user = auth()->user();
        if ($user->can('manage_course') || $user->can('own_course') && $user->id == $course->teacher_id) {
            $course->confirmation_status = 1;
            $course->save();
            Log::create([
                'user_id' => auth()->user()->id,
                'description' => 'دوره را تایید کرد - عنوان دوره : ' . $course->title,
                'ip' => $request->ip(),
                'os' => $request->header('user-Agent')
            ]);

            return redirect()->back()->with('swal-success', 'دوره با موفقیت تایید شد');
        }
        abort(403);
    }
    public function lockCourse(Course $course, Request $request)
    {
        $user = auth()->user();
        if ($user->can('manage_course') || $user->can('own_course') && $user->id == $course->teacher_id) {
            $course->status = 0;
            $course->save();
            Log::create([
                'user_id' => auth()->user()->id,
                'description' => 'دوره را قفل کرد - عنوان دوره : ' . $course->title,
                'ip' => $request->ip(),
                'os' => $request->header('user-Agent')
            ]);
            return redirect()->route('admin.market.course.index')->with('swal-success', 'دوره با موفقیت قفل شد');
        }
        abort(403);
    }
    public function addStudent(Course $course, Request $request)
    {
        
        if (!auth()->user()->can('add_student_course') || $course->types == 2) {
            abort(403);
        }


        $request->validate([
            'user' => 'required',
            'price' => 'required|numeric',
            'support_price' => 'required|numeric',
            'description' => 'nullable|max:1024',
            'student_count' => 'required|numeric|min:1',
            'installment_count' => 'required|numeric|min:1',
            'payment_method' => 'required|string|in:installment,cash',
            'register_date' => 'required',
        ]);

        $inputs = $request->all();

        if (preg_match('/^(\+98|98|0|)9\d{9}$/', $inputs['user'])) {

            // all mobile numbers are in on format 9** *** ***
            $inputs['user'] = ltrim($inputs['user'], '0');
            $inputs['user'] = substr($inputs['user'], 0, 2) === '98' ? substr($inputs['user'], 2) : $inputs['user'];
            $inputs['user'] = str_replace('+98', '', $inputs['user']);
        }

        //findUser
        $user = User::where('mobile', $inputs['user'])->orWhere('email', $inputs['user'])->first();

        if (!$user) {
            return redirect()->route('admin.market.course.details', ['course' => $course->id])->with('swal-error', 'کاربر یافت  نشد');
        }
        //check is exits user this in course
        $isCourseUser = OrderItem::where(['user_id' => $user->id, 'course_id' => $course->id])->get();

        if (count($isCourseUser) >= 1) {
            return redirect()->route('admin.market.course.details', ['course' => $course->id])->with('swal-error', 'کاربر قبلا در این دوره ثبت نام کرده');
        }
        // Calculate the percentage of period money for site and teacher
        if ($request->wage[0] == 1) {
            $seller_share = ($inputs['price'] / 100) * $course->percent;
            $seller_site = $inputs['price'] - $seller_share;
        } else {
            $seller_site = $inputs['price'];
            $seller_share = 0;
        }

        //
        DB::transaction(function () use ($inputs, $course, $seller_share, $seller_site, $request, $user) {
            $newOrder = Order::create([
                'user_id' => $user->id,
                'order_final_amount' => $inputs['price'],
                'seller_share' => $seller_share,
                'seller_site' => $seller_site,
                'order_status' => 3,
                'payment_status' => 3,
            ]);

            $newItem = OrderItem::create([
                'order_id' => $newOrder->id,
                'course_id' => $course->id,
                'teacher_id' => $course->teacher_id,
                'user_id' => $user->id,
                'payment_status' => 3,
                'course' => $course,
                'seller_share' => $seller_share,
                'seller_site' => $seller_site,
                'status' => 1
            ]);

            //create installments
            if(($user->installments)->isEmpty()){
                $supportPrice= $inputs['support_price'];
                $finalAmount = $inputs['price'] + ($supportPrice * ($inputs['student_count'] - 1));

                $registerDateTimeStamp = substr($request->register_date, 0, 10);
                $registerDate = date("Y-m-d H:i:s", (int)$registerDateTimeStamp);
                $registerDate = Carbon::parse($registerDate)->setTime(0,0,0);

                if($request->pament_method == 'cash'){
                    Installment::create([
                        'order_id' => $newOrder->id,
                        'course_id' => $course->id,
                        'user_id' => $user->id,
                        'installment_date' => $registerDate,
                        'installment_amount' => $finalAmount,
                        'installment_passed_at' => now()
                    ]);
                }else{
                    foreach(range(1, $inputs['installment_count']) as $index) {
                        $newRegisterDate = $registerDate->copy();
                        $installmentPassedAt = null;
                        $addMonth = $index-1;
                        $installmentDate = $newRegisterDate->addMonths($addMonth);

                        if($index == 1 && array_key_exists('first_installment_paid', $inputs) && $inputs['first_installment_paid']){
                            $installmentPassedAt = now();

                        }
                        Installment::create([
                            'order_id' => $newOrder->id,
                            'course_id' => $course->id,
                            'user_id' => $user->id,
                            'installment_date' => $installmentDate,
                            'installment_amount' => $inputs['price']/$inputs['installment_count'],
                            'installment_passed_at' => $installmentPassedAt,
                        ]);
                    }

                    if ($inputs['student_count'] > 1) {
                        for($i=1; $i < $inputs['student_count']; $i++) {
                            Installment::create([
                                'order_id' => $newOrder->id,
                                'course_id' => $course->id,
                                'user_id' => $user->id,
                                'installment_date' => $installmentDate->addMonth(),
                                'installment_amount' => $supportPrice,
                                'installment_passed_at' => $installmentPassedAt,
                            ]);
                        }
                    }
                }

            }

            //end create installments



            if ($course->get_course_option == 1) {
                event(new NewLicenseSpotPlayer($newItem, $course, $user));
            }
            Payment::create([
                'amount' => $inputs['price'],
                'user_id' => $user->id,
                'gateway' => 'از طرف سایت',
                'transaction_id' => rand(111111, 999999),
                'status' => 1,
                'description' => 'پرداخت شده توسط کاربر '. auth()->user()->full_name . '<br>' .$inputs['description'],
                'paymentable_type' => 'App\Models\Market\Course',
                'paymentable_id' => $newOrder->id,
                'pay_for' => 1
            ]);
            if ($seller_share > 0) {
                Wallet::create([
                    'price' => $seller_share,
                    'user_id' => $course->teacher->id,
                    'type' => 1,
                    'description' => 'افزودن دانشجو توسط ادمین'
                ]);
            }
            $userInf = $user->email ?? $user->phone;
            Log::create([
                'user_id' => auth()->user()->id,
                'description' => ' کاربر : ' .  $userInf . ' را به دوره ' . $course->title . '  اضافه کرد <br> <p>سود مدرس : ' . priceFormat($seller_share)  . ' تومان </p><br><p>موجودی حساب قبلی :' . priceFormat($course->teacher->balance) . ' تومان',
                'ip' => $request->ip(),
                'os' => $request->header('user-Agent')
            ]);
            //find teacher and increase seller share
            $teacher = $course->teacher->increment('balance', $seller_share);
            //
            $course->increment('sold_number');
            //
            event(new BuyCourse($user->id, $course));
        });
        return redirect()->route('admin.market.course.details', ['course' => $course->id])->with('swal-success', 'دوره با موفقیت خریداری  شد');
    }
    public function showStudentsCourse(Course $course)
    {
        $user = auth()->user();
        if ($user->can('manage_course') || $course->teacher_id == $user->id) {
            return view('admin.market.course.student', compact('course'));
        }
        abort(403);
    }
    public function AccessStudentToCourseSatus(Course $course, User $user)
    {
        $orderItem = OrderItem::where(['course_id' => $course->id, 'user_id' => $user->id])->first();
        $orderItem->status = $orderItem->status == 0 ? 1 : 0;
        $result = $orderItem->save();
        if ($result) {
            if ($orderItem->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
    public function progressUpdate(Request $request, Course $course)
    {
        $user = auth()->user();
        if ($user->can('manage_course') || $user->can('own_course') && $course->teacher_id == $user->id || $user->can('create_lession') && $course->teacher_id == $user->id) {

            $request->validate([
                'progress' => 'required|numeric|max:100'
            ]);
            Log::create([
                'user_id' => auth()->user()->id,
                'description' => 'ویرایش درصد پیشرفت دوره ' . $course->title . ' از ' . $course->progress . '% به ' . $request->progress . '% توسط کاربر: ' . Auth::user()->email,
                'ip' => $request->ip(),
                'os' => $request->header('user-Agent')
            ]);
            $course->update(['progress' => $request->progress]);
            return response()->json(['message' => 'ok', 'status' => 'success'], 200);
        }
        return response()->json(['message' => 'fail', 'status' => 'fail'], 403);
    }
    public function statistics(Course $course, DashboardFilterRepo $repo)
    {
        $getSellLastMonth = OrderItem::select('course_id', DB::raw('COUNT(*)'))->selectRaw('
        SUM(seller_share + seller_site) as price
        ')->where('course_id', $course->id)->where('created_at', '>=', now()->subMonth())->groupBy('course_id')->first();
        $getSellTotal = OrderItem::select('course_id', DB::raw('COUNT(*)'))->selectRaw('
        SUM(seller_share + seller_site) as price
        ')->where('course_id', $course->id)->groupBy('course_id')->first();
        $lession = Lession::where('course_id', $course->id)->count();
        $comments = Comment::where(['commentable_id' => $course->id, 'commentable_type' => Course::class])->count();


        $dates = collect();
        foreach (range(-30, 0) as $i) {

            $dates->put(now()->addDays($i)->format("Y-m-d"), 0);
        }

        $days =  $repo->getDays($dates);

        $summaryCourse =  $repo->getDailySummaryCourse($dates, $course->id);


        return view('admin.market.course.statistics', compact('course', 'getSellLastMonth', 'getSellTotal', 'lession', 'comments', 'days', 'dates', 'summaryCourse'));
    }
    public function details(Course $course)
    {
        $user = auth()->user();
        if ($user->can('show_lession') && $course->teacher_id == $user->id ||  $user->can('manage_course')) {
            $seasons = $course->season()->orderBy('number','asc')->with('parent')->get();
            $lessions = Lession::where('course_id', $course->id)->get();
            // $users = DB::table('users')->whereNotIn('id', function ($q) use ($course) {
            //     $q->select('user_id')->from('order_items')->where(['course_id' => $course->id]);
            // })->get();
            return view('admin.market.course.details', compact('course', 'seasons', 'lessions',));
        }
        abort(403);
    }
}
