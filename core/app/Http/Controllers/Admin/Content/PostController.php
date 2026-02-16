<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Admin\Repositories\PostFilterRepo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\PostRequest;
use App\Http\Services\Image\ImageService;
use App\Models\Content\Post;
use App\Models\Content\PostCategory;
use App\Models\Log\Log;
use App\Models\User;
use Illuminate\Http\Request;


class PostController extends Controller
{
    public function index(PostFilterRepo $repo)
    {
        $user = auth()->user();
        if ($user->can('manage_post')) {
            $posts = $repo->title(request('title'))->confirmation_status(request('confirmation_status'))->email(request('email'))->paginateParents(20);
        } else {
            $posts = $repo->title(request('title'))->confirmation_status(request('confirmation_status'))->email(request('email'))->getPostByAuthorId($user)->paginateParents(20);
        }
        $posts->appends(request()->query());
        return view('admin.content.post.index', compact('posts'));
    }
    public function create()
    {
        $user = auth()->user();
        if (!$user->can('create_post')) {
            abort(403);
        }
        $users = User::where('is_admin', 1)->get();
        $categories = PostCategory::all();
        return view('admin.content.post.create', compact('users', 'categories'));
    }


    public function store(PostRequest $request, ImageService $imageService)
    {
        $user = auth()->user();

        if (!$user->can('create_post')) {
            abort(403);
        }
        $inputs = $request->all();
        if (!$user->can('manage_post')) {
            $inputs['author_id'] = $user->id;
            $inputs['status'] = 1;
        }

        //date fixed
        $realTimestampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post');
            $result = $imageService->save($request->file('image'));
            if ($result === false) {
                return redirect()->route('admin.content.post.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        }
        $post = Post::create($inputs);
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'افزودن مقاله با عنوان : ' . $post->title,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->route('admin.content.post.index')->with('swal-success', 'پست  جدید شما با موفقیت ثبت شد');
    }
    public function edit(Post $post)
    {
        $user = auth()->user();

        if ($user->can('manage_post') || $user->can('edit_post') && $post->author_id == $user->id) {
            $users = User::where('is_admin', 1)->get();
            $categories = PostCategory::all();
            return view('admin.content.post.edit', compact('users', 'categories', 'post'));
        }
        abort(403);
    }
    public function update(PostRequest $request, ImageService $imageService, Post $post)
    {
        $user = auth()->user();
        if ($user->can('manage_post') || $user->can('edit_post') && $post->author_id == $user->id) {
            $inputs = $request->all();
            if (!$user->can('manage_post')) {
                $inputs['author_id'] = $user->id;
                $inputs['status'] = 1;
            }
            //date fixed
            $realTimestampStart = substr($request->published_at, 0, 10);
            $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
            if ($request->hasFile('image')) {
                if (!empty($request->image)) {
                    $imageService->deleteImage($post->image);
                }
                $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post');
                $result = $imageService->save($request->file('image'));
                if ($result === false) {
                    return redirect()->route('admin.content.post.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
                }
                $inputs['image'] = $result;
            } else {
                if (isset($inputs['currentImage']) && !empty($post->image)) {
                    $image = $post->image;
                    $image['currentImage'] = $inputs['currentImage'];
                    $inputs['image'] = $image;
                }
            }
            Log::create([
                'user_id' => auth()->user()->id,
                'description' => 'ویرایش مقاله با عنوان ' . $post->title . ' عنوان جدید : ' . $inputs['title'],
                'ip' => $request->ip(),
                'os' => $request->header('user-Agent')
            ]);
            $post->update($inputs);
            return redirect()->route('admin.content.post.index')->with('swal-success', 'مطلب با موفقیت به روز رسانی شد');
        }
        abort(403);
    }
    public function status(Post $post, Request $request)
    {
        $user = auth()->user();

        if (!$user->can('manage_post')) {
            abort(403);
        }
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'تغییر وضعیت نمایش  پست عنوان پست : ' . $post->title,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        $post->status = $post->status == 0 ? 1 : 0;
        $result = $post->save();
        if ($result) {
            if ($post->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function reject(Post $post, Request $request)
    {
        $user = auth()->user();

        if (!$user->can('manage_post')) {
            abort(403);
        }
        $post->confirmation_status = 0;
        $post->save();
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'رد مقاله |  عنوان مقاله : ' . $post->title,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->back()->with('swal-success', 'مقاله با موفقیت رد شد');
    }
    public function accept(Post $post, Request $request)
    {
        $user = auth()->user();

        if (!$user->can('manage_post')) {
            abort(403);
        }
        $post->confirmation_status = 1;
        $post->save();
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'تایید مقاله |  عنوان مقاله : ' . $post->title,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->back()->with('swal-success', 'مطلب با موفقیت تایید شد');
    }

    public function acceptAll(Request $request)
    {
        $user = auth()->user();

        if (!$user->can('manage_post')) {
            abort(403);
        }
        $post = Post::where('confirmation_status', 0)->OrWhere('confirmation_status', 2)->get();
        if (count($post) > 0) {
            Post::where('confirmation_status', 0)->OrWhere('confirmation_status', 2)->update(['confirmation_status' => 1]);
            return redirect()->route('admin.content.post.index')->with('swal-success', 'مقالات با موفقیت تایید شد');
        }
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'تایید همه مقالات',
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->route('admin.content.post.index')->with('swal-error', 'مقاله ای برای تایید وجود ندارد');
    }


    public function acceptMultiple(Request $request)
    {
        $user = auth()->user();

        if (!$user->can('manage_post')) {
            abort(403);
        }
        $ids = explode(',', $request->ids);
        if (is_array($ids)) {
            Post::query()->whereIn('id', $ids)->update(['confirmation_status' => 1]);
        }
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'تایید مقالات |  ایدی مقالات : ' . $request->ids,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->route('admin.content.post.index')->with('swal-success', 'مقالات با موفقیت تایید شد');
    }
    public function rejectMultiple(Request $request)
    {
        $user = auth()->user();

        if (!$user->can('manage_post')) {
            abort(403);
        }
        $ids = explode(',', $request->ids);
        if (is_array($ids)) {
            Post::query()->whereIn('id', $ids)->update(['confirmation_status' => 0]);
        }
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'رد مقالات |  ایدی مقالات : ' . $request->ids,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->route('admin.content.post.index')->with('swal-success', 'مقالات با موفقیت رد شد');
    }
    public function destroyMultiple(Request $request, ImageService $imageService)
    {
        $user = auth()->user();

        if (!$user->can('manage_post')) {
            abort(403);
        }
        $ids = explode(',', $request->ids);
        foreach ($ids as $id) {
            $post = Post::findOrFail($id);
            if ($post->image) {
                $imageService->deleteImage($post->image);
            }
            $post->delete();
        }
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'حذف برخی از مقالات |  با ایدی  : ' . $request->ids,
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->route('admin.content.post.index')->with('swal-success', 'مقالات با موفقیت حذف شد');
    }
    public function destory(Post $post, ImageService $imageService, Request $request)
    {
        $user = auth()->user();

        if ($user->can('manage_post') || $user->can('delete_post') && $post->author_id == $user->id) {
            // delete All Comment
            foreach ($post->comments()->get() as $comment) {
                $comment->forceDelete();
            }
            if ($post->image) {
                $imageService->deleteImage($post->image);
            }
            Log::create([
                'user_id' => auth()->user()->id,
                'description' => 'حذف مقاله |  عنوان  : ' . $post->title,
                'ip' => $request->ip(),
                'os' => $request->header('user-Agent')
            ]);
            $post->delete();
            return redirect()->route('admin.content.post.index')->with('swal-success', 'مقاله با موفقیت حذف شد');
        }
        abort(403);
    }
}
