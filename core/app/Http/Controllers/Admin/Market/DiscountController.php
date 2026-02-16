<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\AmazingSaleRequest;
use App\Http\Requests\Admin\Market\CommonDiscountRequest;
use App\Http\Requests\Admin\Market\CopanRequest;
use App\Models\Log\Log;
use App\Models\Market\AmazingSale;
use App\Models\Market\CommonDiscount;
use App\Models\Market\Copan;
use App\Models\Market\Course;
use App\Models\Market\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscountController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            if (!$this->user->can('manage_discount')) {
                abort(403);
            }
            return $next($request);
        });
    }
    public function copan()
    {
        $sort = request('sort');
        if (isset($sort)) {
            $copans = Copan::where('end_date', '>', now())->latest()->paginate(20);
        } else {
            $copans = Copan::latest()->paginate(20);
        }
        $copans->appends(request()->query());
        return view('admin.market.discount.copan', compact('copans'));
    }
    public function copanCreate()
    {

        return view('admin.market.discount.copan-create');
    }

    public function copanStore(CopanRequest $request)
    {
        $inputs = $request->all();

        if ($inputs['type'] == 1) {
            $user = User::where('mobile', $inputs['user'])->orWhere('email', $inputs['user'])->first();

            if (!$user) {
                return redirect()->route('admin.market.discount.copan.create')->with('swal-error', 'کاربر یافت  نشد');
            }
            $inputs['user_id'] = $user->id;
        } else {
            $inputs['user_id'] = null;
        }
        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampEnd);


        $copan = Copan::create($inputs);
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'کد تخفیف جدید اضافه کرد | کد تخفیف ایچاد شده : ' . $copan->code,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->route('admin.market.discount.copan')->with('swal-success', ' کد تخفیف جدید شما با موفقیت ثبت شد');
    }


    public function copanEdit(Copan $copan)
    {

        return view('admin.market.discount.copan-edit', compact('copan'));
    }

    public function copanUpdate(CopanRequest $request, Copan $copan)
    {
        $inputs = $request->all();
        if ($inputs['type'] == 1) {
            $user = User::where('mobile', $inputs['user'])->orWhere('email', $inputs['user'])->first();

            if (!$user) {
                return redirect()->route('admin.market.discount.copan.edit', $copan)->with('swal-error', 'کاربر یافت  نشد');
            }
            $inputs['user_id'] = $user->id;
        } else {
            $inputs['user_id'] = null;
        }
        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampEnd);

        $copan->update($inputs);
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => '  تخفیف را ویرایش کرد | کد تخفیف ویرایش شده : ' . $copan->code,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->route('admin.market.discount.copan')->with('swal-success', 'کد تخفیف  شما با موفقیت ویرایش شد');
    }


    public function copanDestroy(Copan $copan, Request $request)
    {
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => '  تخقیف را حذف کرد | عنوان تخفیف حذف شده : ' . $copan->code,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        $result = $copan->delete();
        return redirect()->route('admin.market.discount.copan')->with('swal-success', ' تخفیف  شما با موفقیت حذف شد');
    }
    public function copanStatus(copan $copan)
    {

        $copan->status = $copan->status == 0 ? 1 : 0;
        $result = $copan->save();
        if ($result) {
            if ($copan->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function commonDiscount()
    {
        $sort = request('sort');
        if (isset($sort)) {
            $commonDiscounts = CommonDiscount::where('end_date', '>', now())->paginate(20);
        } else {
            $commonDiscounts = CommonDiscount::latest()->paginate(20);
        }
        $commonDiscounts->appends(request()->query());

        return view('admin.market.discount.common', compact('commonDiscounts'));
    }

    public function commonDiscountCreate()
    {
        $courses = Course::where(['confirmation_status' => 1, ['types', 1]])->get();
        $plans = Plan::where('status', 1)->get();
        return view('admin.market.discount.common-create', compact('courses', 'plans'));
    }

    public function commonDiscountStore(CommonDiscountRequest $request)
    {
        $inputs = $request->all();

        switch ($inputs['type']) {
            case 0:
                $inputs['commonable_type'] = Course::class;
                $inputs['commonable_id'] = null;
                break;
            case 1:
                $inputs['commonable_type'] = Course::class;
                $inputs['commonable_id'] = $inputs['course_id'];
                break;
            case 2:
                $inputs['commonable_type'] = Plan::class;
                $inputs['commonable_id'] = null;

                break;
            case 3:
                $inputs['commonable_type'] = Plan::class;
                $inputs['commonable_id'] = $inputs['plan_id'];
                break;
            default:
                $inputs['commonable_type'] = null;
                $inputs['commonable_id'] = null;
                break;
        }

        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampEnd);
        $commonDiscount = CommonDiscount::create($inputs);
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => '  تخقیف عمومی اضافه کرد | عنوان تخفیف اضافه شده : ' . $commonDiscount->title,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->route('admin.market.discount.commonDiscount')->with('swal-success', ' تخفیف عمومی شما با موفقیت ثبت شد');
    }


    public function commonDiscountEdit(CommonDiscount $commonDiscount)
    {
        $courses = Course::where(['confirmation_status' => 1, ['types', 1]])->get();
        $plans = Plan::where('status', 1)->get();
        return view('admin.market.discount.common-edit', compact('commonDiscount', 'courses', 'plans'));
    }

    public function commonDiscountUpdate(CommonDiscountRequest $request, CommonDiscount $commonDiscount)
    {
        $inputs = $request->all();

        switch ($inputs['type']) {
            case 0:
                $inputs['commonable_type'] = Course::class;
                $inputs['commonable_id'] = null;
                break;
            case 1:
                $inputs['commonable_type'] = Course::class;
                $inputs['commonable_id'] = $inputs['course_id'];
                break;
            case 2:
                $inputs['commonable_type'] = Plan::class;
                $inputs['commonable_id'] = null;

                break;
            case 3:
                $inputs['commonable_type'] = Plan::class;
                $inputs['commonable_id'] = $inputs['plan_id'];
                break;
            default:
                $inputs['commonable_type'] = null;
                $inputs['commonable_id'] = null;
                break;
        }

        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampEnd);
        $commonDiscount->update($inputs);
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => '  تخقیف عمومی را ویرایش کرد | عنوان تخفیف ویرایش شده : ' . $commonDiscount->title,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->route('admin.market.discount.commonDiscount')->with('swal-success', 'کد تخفیف جدید شما با موفقیت ویرایش شد');
    }

    public function commonDiscountDestroy(CommonDiscount $commonDiscount, Request $request)
    {
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => '  تخقیف عمومی را حذف کرد | عنوان تخفیف حذف شده : ' . $commonDiscount->title,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        $result = $commonDiscount->delete();
        return redirect()->route('admin.market.discount.commonDiscount')->with('swal-success', 'کد تخفیف  شما با موفقیت حذف شد');
    }
    public function commonDiscountStatus(CommonDiscount $commonDiscount)
    {
        $commonDiscount->status = $commonDiscount->status == 0 ? 1 : 0;
        $result = $commonDiscount->save();
        if ($result) {
            if ($commonDiscount->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
