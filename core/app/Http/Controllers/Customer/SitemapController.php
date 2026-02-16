<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Content\Page;
use App\Models\Content\Podcast;
use App\Models\Content\PodcastCategory;
use App\Models\Content\Post;
use App\Models\Content\PostCategory;
use App\Models\Market\Course;
use App\Models\Market\CourseCategory;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        return response()->view('sitemap.index')->header('Content-Type', 'text/xml');
    }
    public function courses()
    {
        $courses = Course::where('confirmation_status',1)->latest()->get();
        return response()->view('sitemap.courses', [ 'courses' => $courses ])->header('Content-Type', 'text/xml');
    }

    public function blogs()
    {
        $posts = Post::where('confirmation_status',1)->get();
        return response()->view('sitemap.blogs', [ 'posts' => $posts ])->header('Content-Type', 'text/xml');
    }
    public function courseCategories()
    {
        $courseCategory = CourseCategory::where('status',1)->get();
        return response()->view('sitemap.courseCategories', [ 'courseCategory' => $courseCategory ])->header('Content-Type', 'text/xml');
    }
    public function postCategories()
    {
        $postCategories = PostCategory::where('status',1)->all();
        return response()->view('sitemap.postCategories', [ 'postCategories' => $postCategories ])->header('Content-Type', 'text/xml');
    }
    public function page()
    {
        $pages = Page::where('status',1)->get();
        return response()->view('sitemap.page', [ 'pages' => $pages ])->header('Content-Type', 'text/xml');
    }
    public function podcastCategories()
    {
        $podcastCategories = PodcastCategory::where('status',1)->get();
        return response()->view('sitemap.podcastCategories', [ 'podcastCategories' => $podcastCategories ])->header('Content-Type', 'text/xml');
    }
    public function podcasts()
    {
        $podcasts = Podcast::where(['status' =>1,'confirmation_status' => 1])->get();
        return response()->view('sitemap.podcast', [ 'podcasts' => $podcasts ])->header('Content-Type', 'text/xml');
    }
}
