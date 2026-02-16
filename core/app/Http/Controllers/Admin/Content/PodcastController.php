<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Admin\Repositories\PodcastFilterRepo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\PodcastRequest;
use App\Http\Services\Image\ImageService;
use App\Models\Content\Podcast;
use App\Models\Content\PodcastCategory;
use App\Models\Log\Log;
use App\Models\User;
use Illuminate\Http\Request;

class PodcastController extends Controller
{

    public function index(PodcastFilterRepo $repo)
    {
        $user = auth()->user();
        if ($user->can('manage_podcast')) {
            $podcasts = $repo->title(request('title'))->confirmation_status(request('confirmation_status'))->email(request('email'))->paginateParents(20);
        } else {
            $podcasts = $repo->title(request('title'))->confirmation_status(request('confirmation_status'))->email(request('email'))->getPodcastBypodcasterId($user)->paginateParents(20);
        }
        $podcasts->appends(request()->query());
        return view('admin.content.podcast.index', compact('podcasts'));
    }
    public function create()
    {
        $user = auth()->user();
        if (!$user->can('create_podcast')) {
            abort(403);
        }
        $users = User::where('is_admin', 1)->get();
        $categories = PodcastCategory::all();
        return view('admin.content.podcast.create', compact('users', 'categories'));
    }


    public function store(PodcastRequest $request, ImageService $imageService)
    {
        $user = auth()->user();

        if (!$user->can('create_podcast')) {
            abort(403);
        }
        $inputs = $request->all();
        if (!$user->can('manage_podcast')) {
            $inputs['podcaster_id'] = $user->id;
            $inputs['status'] = 1;
        }

        //date fixed
        $realTimestampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'podcast');
            $result = $imageService->save($request->file('image'));
            if ($result === false) {
                return redirect()->route('admin.content.podcast.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        }
        $podcast = Podcast::create($inputs);
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'افزودن پادکست با عنوان : ' . $podcast->title,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->route('admin.content.podcast.index')->with('swal-success', 'پادکست  جدید شما با موفقیت ثبت شد');
    }
    public function edit(Podcast $podcast)
    {
        $user = auth()->user();

        if ($user->can('manage_podcast') || $user->can('edit_podcast') && $podcast->podcaster_id == $user->id) {
            $users = User::where('is_admin', 1)->get();
            $categories = PodcastCategory::all();
            return view('admin.content.podcast.edit', compact('users', 'categories', 'podcast'));
        }
        abort(403);
    }
    public function update(PodcastRequest $request, ImageService $imageService, Podcast $podcast)
    {
        $user = auth()->user();
        if ($user->can('manage_podcast') || $user->can('edit_podcast') && $podcast->podcaster_id == $user->id) {
            $inputs = $request->all();
            if (!$user->can('manage_podcast')) {
                $inputs['podcaster_id'] = $user->id;
                $inputs['status'] = 1;
            }
            //date fixed
            $realTimestampStart = substr($request->published_at, 0, 10);
            $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
            if ($request->hasFile('image')) {
                if (!empty($request->image)) {
                    $imageService->deleteImage($podcast->image);
                }
                $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'podcast');
                $result = $imageService->save($request->file('image'));
                if ($result === false) {
                    return redirect()->route('admin.content.podcast.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
                }
                $inputs['image'] = $result;
            } else {
                if (isset($inputs['currentImage']) && !empty($podcast->image)) {
                    $image = $podcast->image;
                    $image['currentImage'] = $inputs['currentImage'];
                    $inputs['image'] = $image;
                }
            }
            Log::create([
                'user_id' => auth()->user()->id,
                'description' => 'ویرایش پادکست با عنوان ' . $podcast->title . ' عنوان جدید : ' . $inputs['title'],
                'ip' => $request->ip(),
                'os' => $request->header('user-Agent')
            ]);
            $podcast->update($inputs);
            return redirect()->route('admin.content.podcast.index')->with('swal-success', 'پادکست با موفقیت ویرایش شد');
        }
        abort(403);
    }
    public function status(Podcast $podcast, Request $request)
    {
        $user = auth()->user();

        if (!$user->can('manage_podcast')) {
            abort(403);
        }
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'تغییر وضعیت نمایش  پادکست عنوان پادکست : ' . $podcast->title,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        $podcast->status = $podcast->status == 0 ? 1 : 0;
        $result = $podcast->save();
        if ($result) {
            if ($podcast->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function reject(Podcast $podcast, Request $request)
    {
        $user = auth()->user();

        if (!$user->can('manage_podcast')) {
            abort(403);
        }
        $podcast->confirmation_status = 0;
        $podcast->save();
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'رد پادکست |  عنوان پادکست : ' . $podcast->title,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->back()->with('swal-success', 'پادکست با موفقیت رد شد');
    }
    public function accept(Podcast $podcast, Request $request)
    {
        $user = auth()->user();

        if (!$user->can('manage_podcast')) {
            abort(403);
        }
        $podcast->confirmation_status = 1;
        $podcast->save();
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'تایید پادکست |  عنوان پادکست : ' . $podcast->title,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->back()->with('swal-success', 'پادکست با موفقیت تایید شد');
    }

    public function acceptAll(Request $request)
    {
        $user = auth()->user();

        if (!$user->can('manage_podcast')) {
            abort(403);
        }
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'تایید همه پادکست ها',
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        $podcast = Podcast::where('confirmation_status',0)->OrWhere('confirmation_status',2)->get();
        if (count($podcast) > 0) {
            podcast::where('confirmation_status',0)->OrWhere('confirmation_status',2)->update(['confirmation_status' => 1]);
            return redirect()->route('admin.content.podcast.index')->with('swal-success', 'پادکست ها با موفقیت تایید شد');
        }

        return redirect()->route('admin.content.podcast.index')->with('swal-error', 'پادکست  برای تایید وجود ندارد');
    }


    public function acceptMultiple(Request $request)
    {
        $user = auth()->user();

        if (!$user->can('manage_podcast')) {
            abort(403);
        }
        $ids = explode(',', $request->ids);
        if (is_array($ids)) {
            Podcast::query()->whereIn('id', $ids)->update(['confirmation_status' => 1]);
        }
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'تایید پادکست ها |  ایدی پادکست ها : ' . $request->ids,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->route('admin.content.podcast.index')->with('swal-success', 'پادکست ها با موفقیت تایید شد');
    }
    public function rejectMultiple(Request $request)
    {
        $user = auth()->user();

        if (!$user->can('manage_podcast')) {
            abort(403);
        }
        $ids = explode(',', $request->ids);
        if (is_array($ids)) {
            podcast::query()->whereIn('id', $ids)->update(['confirmation_status' => 0]);
        }
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'رد پادکست ها |  ایدی پادکست ها : ' . $request->ids,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->route('admin.content.podcast.index')->with('swal-success', 'پادکست ها با موفقیت رد شد');
    }
    public function destroyMultiple(Request $request, ImageService $imageService)
    {
        $user = auth()->user();

        if (!$user->can('manage_podcast')) {
            abort(403);
        }
        $ids = explode(',', $request->ids);

        foreach ($ids as $id) {
            $podcast = Podcast::findOrFail($id);
            if ($podcast->image) {
                $imageService->deleteImage($podcast->image);
            }
            $podcast->delete();
        }
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'حذف برخی از پادکست ها |  با ایدی  : ' . $request->ids,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->route('admin.content.podcast.index')->with('swal-success', 'پادکست ها با موفقیت حذف شد');
    }
    public function destory(Podcast $podcast, ImageService $imageService, Request $request)
    {
        $user = auth()->user();

        if ($user->can('manage_podcast') || $user->can('edit_podcast') && $podcast->podcaster_id == $user->id) {
            // delete All Comment
            foreach ($podcast->comments()->get() as $comment) {
                $comment->forceDelete();
            }
            if ($podcast->image) {
                $imageService->deleteImage($podcast->image);
            }
            Log::create([
                'user_id' => auth()->user()->id,
                'description' => 'حذف پادکست |  عنوان  : ' . $podcast->title,
                'ip' => $request->ip(),
                'os' => $request->header('user-Agent')
            ]);
            $podcast->delete();
            return redirect()->route('admin.content.podcast.index')->with('swal-success', 'پادکست با موفقیت حذف شد');
        }
        abort(403);
    }
}
