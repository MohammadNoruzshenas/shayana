<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\SliderRequest;
use App\Http\Services\Image\ImageService;
use App\Models\Log\Log;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SliderController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            if (!$this->user->can('manage_slider')) {
                abort(403);
            }
            return $next($request);
        });
    }
    public function index()
    {

        $sliders = slider::orderBy('created_at', 'desc')->paginate(20);

        return view('admin.content.slider.index', compact('sliders'));
    }
    public function create()
    {
        return view('admin.content.slider.create');
    }
    public function store(SliderRequest $request, ImageService $imageService)
    {

        $inputs = $request->all();
        if ($request->hasFile('banner')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'slider');
            $result = $imageService->save($request->file('banner'));
            if ($result === false) {
                return redirect()->route('admin.content.slider.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['banner'] = $result;
        }
        $inputs['user_id'] = Auth::user()->id;
        $slider = Slider::create($inputs);
        return redirect()->route('admin.content.slider.index')->with('swal-success', 'اسلایدر با موفقیت ایجاد شد');
    }
    public function edit(Slider $slider)
    {
        return view('admin.content.slider.edit', compact('slider'));
    }
    public function update(SliderRequest $request, Slider $slider, ImageService $imageService)
    {

        $inputs = $request->all();
        if ($request->hasFile('banner')) {
            if ($slider->banner) {
                $imageService->deleteImage($slider->banner);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'slider');
            $result = $imageService->save($request->file('banner'));
            if ($result === false) {
                return redirect()->route('admin.content.slider.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['banner'] = $result;
        }
        $inputs['user_id'] = Auth::user()->id;
        $slider->update($inputs);
        return redirect()->route('admin.content.slider.index')->with('swal-success', 'اسلایدر با موفقیت اپدیت شد');
    }
    public function destory(Slider $slider, ImageService $imageService, Request $request)
    {
        if ($slider->banner) {
            $imageService->deleteImage($slider->banner);
        }
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'حذف اسلایدر |  عنوان  : ' . $slider->title,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        $slider->delete();
        return redirect()->route('admin.content.slider.index')->with('swal-success', 'اسلایدر با موفقیت حذف شد');
    }
    public function status(Slider $slider, Request $request)
    {
        $user = auth()->user();
        if (!$user->can('edit_category')) {
            abort(403);
        }
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'تغییر وضعیت اسلایدر |  عنوان  : ' . $slider->title,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        $slider->status = $slider->status == 0 ? 1 : 0;
        $result = $slider->save();
        if ($result) {
            if ($slider->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
