<?php

namespace App\Http\Controllers\Customer\Content;

use App\Http\Controllers\Controller;
use App\Models\Content\Ads;
use App\Models\Content\Comment;
use App\Models\Content\Podcast;
use App\Models\Content\PodcastCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PodcastController extends Controller
{
    public function index(Request $request, PodcastCategory $podcastCategory = null)
    {
        $categories = PodcastCategory::where('status', 1)->get();
        $ads = Ads::where('status', 1)->where('enddate_at', '>', now())->where('start_at', '<', now())->first();

        //category selection
        if ($podcastCategory) {
            $podcastCategory = $podcastCategory->podcasts();
        } else {
            $podcastCategory = new Podcast();
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
            $query = $podcastCategory->where('title', 'LIKE', "%" . $request->search . "%")->where(['confirmation_status' => 1, 'status' => 1]);
        } else {
            $query = $podcastCategory->where(['confirmation_status' => 1, 'status' => 1]);
        }
        $query = $query->where('published_at', '<', now());
        if (isset($vip)) {

            $query = $query->where('is_vip', $vip);
        }
        $podcasts = $query->orderBy('created_at', 'DESC')->paginate(Cache::get('templateSetting')['number_post_page']);
        $podcasts->appends($request->query());
        return view('customer.content.podcast.podcasts', compact('podcasts', 'categories', 'ads'));
    }
    public function singlePodcast(Podcast $podcast)
    {
        if (Auth::check() && Auth::user()->is_admin == 1 || $podcast->confirmation_status == 1 && $podcast->status == 1 && $podcast->published_at < now()) {
            $relatedPodcasts = Podcast::where(['confirmation_status' => 1, 'status' => 1])->where('published_at', '<', now())->with('category')->whereHas('category', function ($q) use ($podcast) {
                $q->where('id', $podcast->category->id);
            })->latest()->take(6)->get()->except($podcast->id);
            $ads = Ads::where('status', 1)->where('enddate_at', '>', now())->where('start_at', '<', now())->first();
            return view('customer.content.podcast.singlePodcast', compact('podcast', 'relatedPodcasts', 'ads'));
        }
        abort(404);
    }
    public function addComment(Podcast $podcast, Request $request)
    {
        $request->validate([
           'body' => 'required|max:2000|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,!\s]+$/u',
            'replay' => 'nullable|numeric|exists:comments,id'
        ]);

        $inputs['body'] = str_replace(PHP_EOL, '<br/>', $request->body);
        $inputs['author_id'] = Auth::user()->id;
        $inputs['commentable_id'] = $podcast->id;
        $inputs['commentable_type'] = Podcast::class;
        $inputs['parent_id'] = $request->replay;
        $inputs['approved'] = Cache::get('settings')['comment_default_approved'] == 0 ? 0 : 1;
        if (Auth::user()->is_admin == 1) {
            $inputs['approved'] = 1;
        }
        Comment::create($inputs);
        return back()->with('swal-success', 'کامنت با موفقیت ثبت شد');
    }
}
