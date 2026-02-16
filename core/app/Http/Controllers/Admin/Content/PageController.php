<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\ContactUsRequest;
use App\Http\Requests\Admin\Content\PageRequest;
use App\Models\Content\ContactUs;
use App\Models\Content\Page;
use App\Models\Log\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            if (!$this->user->can('manage_pages')) {
                abort(403);
            }
            return $next($request);
        });
    }
    public function index()
    {
        $pages = Page::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.content.page.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.content.page.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        $inputs = $request->all();
        $page = Page::create($inputs);
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'افزودن صفحه |  عنوان  : ' . $page->title,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->route('admin.content.page.index')->with('swal-success', 'صفحه  جدید شما با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view('admin.content.page.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, Page $page)
    {
        $inputs = $request->all();
        // $inputs['slug'] = null;
        $page->update($inputs);
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'ویرایش صفحه |  عنوان  : ' . $page->title,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->route('admin.content.page.index')->with('swal-success', 'صفحه  شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page, Request $request)
    {
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'حذف صفحه |  عنوان  : ' . $page->title,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        $result = $page->delete();
        return redirect()->route('admin.content.page.index')->with('swal-success', 'صفحه  شما با موفقیت حذف شد');
    }


    public function status(Page $page, Request $request)
    {

        $page->status = $page->status == 0 ? 1 : 0;
        $result = $page->save();
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'تغییر وضعیت صفحه |  عنوان  : ' . $page->title,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        if ($result) {
            if ($page->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
    public function contactUs()
    {
        $contactUs = ContactUs::first();
        return view('admin.content.page.contactUs', compact('contactUs'));
    }
    public function contactUsUpdate(ContactUsRequest $request)
    {
        $contactUs = ContactUs::first();
        $contactUs->update($request->all());
        return redirect()->back()->with('swal-success', 'تماس با ما با موفقیت ویرایش شد');
    }
}
