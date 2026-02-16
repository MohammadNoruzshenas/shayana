<?php

namespace App\Http\Controllers\Customer\Content;

use App\Http\Controllers\Controller;
use App\Models\Content\Ads;
use App\Models\Content\Comment;
use App\Models\Content\Post;
use App\Models\Content\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class BlogController extends Controller
{
    public function index(Request $request, postCategory $postCategory = null)
    {

        $categories = PostCategory::where('status', 1)->get();
        $ads = Ads::where('status', 1)->where('enddate_at', '>', now())->where('start_at', '<', now())->first();

        //category selection
        if ($postCategory) {
            $postCategory = $postCategory->posts();
        } else {
            $postCategory = new Post();
        }
        switch ($request->vip) {
            case 1:
                $vip = 0;
                break;
            case 2:
                $vip = 1;
                break;
            default:
                $vip = null;
        }
        if ($request->search) {
            $query = $postCategory->where('title', 'LIKE', "%" . $request->search . "%")->where(['confirmation_status' => 1, 'status' => 1]);
        } else {
            $query = $postCategory->where(['confirmation_status' => 1, 'status' => 1]);
        }
        if (isset($vip)) {

            $query = $query->where('is_vip', $vip);
        }
        $query = $query->where('published_at', '<', now());
        $posts = $query->orderBy('created_at','DESC')->paginate(Cache::get('templateSetting')['number_post_page']);
        $posts->appends($request->query());
        return view('customer.content.blog.blogs', compact('categories', 'posts', 'ads'));
    }

    public function post(Post $post)
    {
        if (Auth::check() && Auth::user()->is_admin == 1 || $post->confirmation_status == 1 && $post->status == 1 && $post->published_at < now()) {
            $relatedPosts = Post::where(['confirmation_status' => 1, 'status' => 1])->where('published_at', '<', now())->with('category')->whereHas('category', function ($q) use ($post) {
                $q->where('id', $post->category->id);
            })->latest()->take(6)->get()->except($post->id);
            $ads = Ads::where('status', 1)->where('enddate_at', '>', now())->where('start_at', '<', now())->first();
            return view('customer.content.blog.singlePost', compact('post', 'relatedPosts', 'ads'));
        }
        abort(404);
    }
    public function addComment(Post $post, Request $request)
    {
        $request->validate([
            'body' => 'required|max:2000|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,!\s]+$/u',
            'replay' => 'nullable|numeric|exists:comments,id'
        ]);

        $inputs['body'] = str_replace(PHP_EOL, '<br/>', $request->body);
        $inputs['author_id'] = Auth::user()->id;
        $inputs['commentable_id'] = $post->id;
        $inputs['commentable_type'] = Post::class;
        $inputs['parent_id'] = $request->replay;
        $inputs['approved'] = Cache::get('settings')['comment_default_approved'] == 0 ? 0 : 1;
        if( Auth::user()->is_admin == 1)
        {
            $inputs['approved'] = 1;
        }
        Comment::create($inputs);
        return back()->with('swal-success', 'کامنت با موفقیت ثبت شد');
    }
}
