<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Content\Ads;
use App\Models\Content\Comment;
use App\Models\Content\Contact;
use App\Models\Content\ContactUs;
use App\Models\Content\Faq;
use App\Models\Content\Page;
use App\Models\Content\Podcast;
use App\Models\Content\Post;
use App\Models\Market\Course;
use App\Models\Market\CourseCategory;
use App\Models\Market\Lession;
use App\Models\Market\Plan;
use App\Models\Setting\FooterLink;
use App\Models\Setting\Setting;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $allTimeLession = Cache::remember('allTimeLession', 3600, function () {
            return Lession::where('confirmation_status', 1)->sum('time');
        });
        $allUsers = Cache::remember('allUsers', 3600, function () {
            return User::count();
        });
        $allCourse = Cache::remember('allCourse', 3600, function () {
            return Course::where('confirmation_status', 1)->where('published_at', '<', now())->count();
        });
        $allPostBlog = Cache::remember('allPostBlog', 3600, function () {
            return  Post::where('confirmation_status', 1)->count();
        });
        $sliders = Slider::where('status', 1)->latest()->take(2)->get();
        $lastCourses = Course::where('confirmation_status', 1)->where('id',21)->where('published_at', '<', now())->latest()->take(6)->get();
        $posts = Post::where(['confirmation_status' => 1, 'status' => 1])->where('published_at', '<', now())->latest()->take(6)->get();
        $vipPost = Post::where(['confirmation_status' => 1, 'status' => 1, 'is_vip' => 1])->where('published_at', '<', now())->latest()->take(6)->get();

        $faqs = Faq::where('status', 1)->latest()->take(6)->get();
        $categories = CourseCategory::where('status', 1)->latest()->take(4)->get();
        $popularCourses = Course::where('confirmation_status', 1)->where('published_at', '<', now())->orderBy('sold_number', 'DESC')->latest()->take(6)->get();
        $freeCourses = Course::where(['confirmation_status' => 1, 'types' => 0])->where('published_at', '<', now())->orderBy('sold_number', 'DESC')->latest()->take(6)->get();
        $plans = Plan::where('status', 1)->latest()->take(3)->get();
        $firstAds = Ads::where('position', 1)->where('status', 1)->where('enddate_at', '>', now())->where('start_at', '<', now())->first();
        $seccondAds = Ads::where('position', 2)->where('status', 1)->where('enddate_at', '>', now())->where('start_at', '<', now())->first();
        $comments = Comment::where(['commentable_type' => 'App\Models\Market\Course', 'view_in_home' => 1, 'approved' => 1])->inRandomOrder()
            ->limit(10)
            ->get();
        $lastPodcast = Podcast::where(['confirmation_status' => 1, 'status' => 1])->where('published_at', '<', now())->latest()->take(6)->get();

        return view('customer.home', compact('lastPodcast', 'sliders', 'lastCourses', 'posts', 'vipPost', 'faqs', 'categories', 'popularCourses', 'freeCourses', 'plans', 'firstAds', 'seccondAds', 'comments'));
    }

    public function teacher(User $user = null)
    {
        if (!$user || $user->is_admin != 1) {
            abort(404);
        }
        return view('customer.teacher', compact('user'));
    }
    public function page(Page $page)
    {

        if ($page->status == 0 && !auth()->user()->can('show_post')) {
            abort(403);
        }
        return view('customer.page', compact('page'));
    }
    public function contactUs()
    {
        $contactUs = ContactUs::first();
        return view('customer.ContactUs', compact('contactUs'));
    }
    public function contactStore(Request $request)
    {
        $contactUs = ContactUs::first();
        if ($contactUs->isActive_form != 1) {
            return redirect()->back()->with('swal-error', 'خطا');
        }
        $request->validate([
            //'title' => 'required|max:195|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'full_name' => 'required|max:195|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            //'email' => 'required|max:195|email',
            'phone' => 'required|max:195|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'description' => 'required|min:5|max:5000|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,!\s]+$/u'
        ]);
        $inputs = $request->all();
        if (preg_match('/^(\+98|98|0)9\d{9}$/', $inputs['phone'])) {
            // all mobile numbers are in on format 9** *** ***
            $inputs['phone'] = ltrim($inputs['phone'], '0');
            $inputs['phone'] = substr($inputs['phone'], 0, 2) === '98' ? substr($inputs['phone'], 2) : $inputs['phone'];
            $inputs['phone'] = str_replace('+98', '', $inputs['phone']);
        } else {
            $errorText = 'شماره موبایل اشتباه است';
            return redirect()->route('customer.contactUs')->withErrors(['phone' => $errorText]);
        }
        $contactUs = Contact::create([
            'title' => $inputs['title'] ?? '',
            'full_name' => $inputs['full_name'],
            'email' => $inputs['email'] ?? '',
            'phone' => $inputs['phone'],
            'description' => str_replace(PHP_EOL, '<br/>', $inputs['description'])
        ]);
        return redirect()->back()->with('swal-success', 'پیام شما با موفقیت ارسال شد');
    }

    public function rules()
    {
        $setting = Setting::first();
        return view('customer.rules', compact('setting'));
    }
}
