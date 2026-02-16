<?php

namespace App\Http\Controllers\Customer\Market;

use App\Http\Controllers\Controller;
use App\Models\Content\Ads;
use App\Models\Content\Comment;
use App\Models\Content\Media;
use App\Models\Market\Course;
use App\Models\Market\CourseCategory;
use App\Models\Market\Lession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public  function index(Request $request, CourseCategory $courseCategory = null)
    {

        $ads = Ads::where('status', 1)->where('enddate_at', '>', now())->where('start_at', '<', now())->first();

        //  $courses = Course::where('confirmation_status', 1)->get();
        $categories = CourseCategory::where('status', 1)->get();
        //category selection
        if ($courseCategory) {
            $courseModel = $courseCategory->courses();
        } else {
            $courseModel = new Course();
        }
        //switch for set sort for filtering
        switch ($request->sort) {
            case "1":
                $column = "created_at";
                $direction = "DESC";
                break;
            case "2":
                $column = "price";
                $direction = "DESC";
                break;
            case "3":
                $column = "price";
                $direction = "ASC";
                break;
            case "4":
                $column = "views";
                $direction = "DESC";
                break;
            case "5":
                $column = "sold_number";
                $direction = "DESC";
                break;
            default:
                $column = "priority";
                $direction = "desc";
        }
        switch ($request->type) {
            case 3:
                $type = 0;
                break;
            case 1:
                $type = 1;
                break;
            case 2:
                $type = 2;
                break;
            default:
                $type = null;
        }
        if ($request->search) {
            $query = $courseModel->where('title', 'LIKE', "%" . $request->search . "%")->where('confirmation_status', 1)->orderBy($column, $direction);
        } else {
            $query = $courseModel->orderBy($column, $direction)->where('confirmation_status', 1);
        }
        $query =  $query->where('id',21)->where('published_at', '<', now());
        if (isset($type)) {
            $query = $query->where('types', $type);
        }

        $courses = $query->paginate(Cache::get('templateSetting')['number_course_page']);

        $courses->appends($request->query());
        return view('customer.market.courses', compact('courses', 'categories', 'ads'));
    }
    public function singleCourse(Course $course)
    {
        if (Auth::check() && Auth::user()->is_admin == 1 || $course->confirmation_status == 1 && $course->published_at < now()) {
            $ads = Ads::where('status', 1)->where('enddate_at', '>', now())->where('start_at', '<', now())->first();
            $relatedCourses = Course::where('confirmation_status', 1)->where('published_at', '<', now())->with('category')->whereHas('category', function ($q) use ($course) {
                $q->where('id', $course->category->id);
            })->latest()->take(6)->get()->except($course->id);
            $showOnlineVideo = $this->showOnlineVideo($course->video_link);
            return view('customer.market.singleCourse', compact('course', 'relatedCourses', 'ads', 'showOnlineVideo'));
        }
        abort(404);
    }
    public function showLession(Course $course, Lession $lession)
    {
        if ($course->hasStudent() || $lession->is_free == 0  && $course->confirmation_status == 1 || Auth::check() && Auth::user()->can('manage_course') == 1) {
            $linkOnlieVideo =  $this->showOnlineVideo($lession->link);
            $ads = Ads::where('status', 1)->where('enddate_at', '>', now())->where('start_at', '<', now())->first();
            $relatedCourses = Course::where('confirmation_status', 1)->with('category')->whereHas('category', function ($q) use ($course) {
                $q->where('id', $course->category->id);
            })->get()->except($course->id);
            return view('customer.market.singleLession', compact('course', 'relatedCourses', 'ads', 'linkOnlieVideo', 'lession'));
        }
        return redirect()->route('customer.course.singleCourse', $course)->with('swal-error', 'لطفا ابتدا دوره رو خریداری فرمایید');
    }

    public function addComment(Course $course, Request $request)
    {

        $request->validate([
            'body' => 'required|max:2000|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,!\s]+$/u',
            'replay' => 'nullable|numeric|exists:comments,id'
        ]);
        $inputs['body'] = str_replace(PHP_EOL, '<br/>', $request->body);
        $inputs['author_id'] = Auth::user()->id;
        $inputs['commentable_id'] = $course->id;
        $inputs['commentable_type'] = Course::class;
        $inputs['parent_id'] = $request->replay;
        $inputs['approved'] = Cache::get('settings')['comment_default_approved'] == 0 ? 0 : 1;
        if (Auth::user()->is_admin == 1) {
            $inputs['approved'] = 1;
        }
        $newComment = Comment::create($inputs);
        if (!$newComment) {
            return back()->with('swal-warning', 'خطا در ثبت نظر');
        }
        return back()->with('swal-success', 'کامنت با موفقیت ثبت شد');
    }
    public function addRate(Course $course, Request $request)
    {
        $request->validate([
            'rating' => 'numeric|min:1|max:5'
        ]);

        if (Auth::check() && $course->hasStudent()) {

            $user = Auth::user();
            $user->rate($course, $request->rating);
            return back()->with('swal-success', 'امتیاز با موفقیت ثبت شد');
        }
        return back()->with('swal-error', 'لطفا ابتدا محصول را خریداری نمایید');
    }
    public function download(Lession $lession, Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(404);
        }
        $media = Media::where('media', $lession->link)->first();
        if ($media) {
            if (Storage::disk($media->storage_space)->exists($lession->link)) {
                // while (ob_get_level() > 0) ob_get_flush();
                if ($media->storage_space == 's3') {
                    $temporarySignedUrl = Storage::disk($media->storage_space)->temporaryUrl($lession->link, now()->addDay());
                    return redirect()->to($temporarySignedUrl);
                } else {
                    return Storage::disk($media->storage_space)->download($lession->link);
                }
            }
            $link =  asset($lession->link);
            return redirect()->to($link);
        }
        abort(404);
    }
    public function fileDownload(Lession $lession, Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(404);
        }
        if ($lession->file_link == null) {
            abort(404);
        }

        $media = Media::where('media', $lession->file_link)->first();

        if ($media) {
            if (Storage::disk($media->storage_space)->exists($lession->file_link)) {
                // while (ob_get_level() > 0) ob_get_flush();
                if ($media->storage_space == 's3') {
                    $temporarySignedUrl = Storage::disk($media->storage_space)->temporaryUrl($lession->file_link, now()->addDay());
                    return redirect()->to($temporarySignedUrl);
                } else {
                    return Storage::disk($media->storage_space)->download($lession->file_link);
                }
            }
            $file_link =  asset($lession->file_link);
            return redirect()->to($file_link);
        }
        abort(404);
    }
    public function showOnlineVideo($link)
    {
        $media = Media::where('media', $link)->first();
        if ($media && !is_null($link)) {
            if (Storage::disk($media->storage_space)->exists($link)) {
                // while (ob_get_level() > 0) ob_get_flush();
                if ($media->storage_space == 's3') {
                    $temporarySignedUrl = Storage::disk($media->storage_space)->temporaryUrl($link, now()->addDay());
                    return $temporarySignedUrl;
                } else {
                    return null;
                }
            } else {
                return asset($link);
            }
        }
        return $link;
    }
    public function downloadLinks(Course $course)
    {
        if ($course->hasStudent()) {
            return implode("<br>", $course->downloadLinks());
        }
        abort(403);
    }

    public function downloadLessonVideo(Course $course, Lession $lession)
    {
        // Check if user has access to this lesson
        if (!($course->hasStudent() || $lession->is_free == 0) && !(Auth::check() && Auth::user()->can('manage_course'))) {
            abort(403, 'Access denied');
        }

        // Check if lesson has a video link
        if (is_null($lession->link)) {
            abort(404, 'Video not found');
        }

        // Check if the link is an external URL
        if (filter_var($lession->link, FILTER_VALIDATE_URL)) {
            $filename = $lession->title . '.mp4';
            
            // Get file size first
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $lession->link);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            
            $headResponse = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $contentLength = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
            curl_close($ch);
            
            if ($httpCode !== 200) {
                abort(404, 'Video file not accessible');
            }
            
            // Handle range requests for proper download progress
            $requestHeaders = function_exists('getallheaders') ? getallheaders() : [];
            if (!function_exists('getallheaders')) {
                foreach ($_SERVER as $key => $value) {
                    if (substr($key, 0, 5) === 'HTTP_') {
                        $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
                        $requestHeaders[$header] = $value;
                    }
                }
            }
            $range = isset($requestHeaders['Range']) ? $requestHeaders['Range'] : (isset($requestHeaders['range']) ? $requestHeaders['range'] : null);
            
            $start = 0;
            $end = $contentLength - 1;
            
            if ($range) {
                list($unit, $range) = explode('=', $range, 2);
                if ($unit === 'bytes') {
                    list($start, $end) = explode('-', $range);
                    $start = intval($start);
                    $end = $end ? intval($end) : $contentLength - 1;
                }
            }
            
            $length = $end - $start + 1;
            
            // Set appropriate headers
            $responseHeaders = [
                'Content-Type' => 'video/mp4',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Accept-Ranges' => 'bytes',
                'Content-Length' => $length,
                'Cache-Control' => 'no-cache',
            ];
            
            if ($range) {
                $responseHeaders['Content-Range'] = "bytes $start-$end/$contentLength";
                $responseHeaders['HTTP/1.1'] = '206 Partial Content';
            } else {
                $responseHeaders['Content-Length'] = $contentLength;
            }
            
            return response()->stream(function () use ($lession, $start, $end) {
                // Set memory limit and time limit
                ini_set('memory_limit', '512M');
                set_time_limit(0);
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $lession->link);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_TIMEOUT, 0); // No timeout for streaming
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30); // Connection timeout
                curl_setopt($ch, CURLOPT_RANGE, "$start-$end");
                curl_setopt($ch, CURLOPT_BUFFERSIZE, 128 * 1024); // 128KB buffer
                curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($ch, $data) {
                    // Check if connection is still alive
                    if (connection_aborted()) {
                        return -1; // Stop the transfer
                    }
                    
                    echo $data;
                    if (ob_get_level()) {
                        ob_flush();
                    }
                    flush();
                    return strlen($data);
                });
                
                $result = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $error = curl_error($ch);
                curl_close($ch);
                
                if ($result === false || $httpCode >= 400) {
                    throw new \Exception('Failed to download video: ' . $error);
                }
            }, $range ? 206 : 200, $responseHeaders);
        }

        $media = Media::where('media', $lession->link)->first();
        
        if ($media) {
            if (Storage::disk($media->storage_space)->exists($lession->link)) {
                if ($media->storage_space == 's3') {
                    $temporarySignedUrl = Storage::disk($media->storage_space)->temporaryUrl($lession->link, now()->addDay());
                    return redirect()->to($temporarySignedUrl);
                } else {
                    return Storage::disk($media->storage_space)->download($lession->link, $lession->title . '.mp4');
                }
            }
        }
        
        // Fallback for local files
        if ($lession->link && file_exists(public_path($lession->link))) {
            return response()->download(public_path($lession->link), $lession->title . '.mp4');
        }
        
        abort(404, 'Video file not found');
    }
}
