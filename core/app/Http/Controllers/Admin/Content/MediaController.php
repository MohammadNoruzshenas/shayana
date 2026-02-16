<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\MediaRequest;
use App\Http\Services\File\FileService;
use App\Models\Content\Media;
use App\Models\Market\Course;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Illuminate\Support\Str;


class MediaController extends Controller
{

    public function index()
    {
        if (auth()->user()->can('manage_uploader')) {
            $medias = Media::where('parent_id', null)->orderBy('created_at', 'desc')->paginate(20);
        } else {
            $medias = Media::where(['user_id' => auth()->user()->id, 'parent_id' => null])->orderBy('created_at', 'desc')->paginate(20);
        }
        return view('admin.content.media.index', compact('medias'));
    }
    public function details(Media $media)
    {
        if (auth()->user()->can('manage_uploader') || $media->user_id == auth()->user()->id) {
            $medias = $media->children()->paginate(20);
            return view('admin.content.media.details', compact('medias', 'media'));
        }
        abort(403);
    }

    public function create()
    {
        if (auth()->user()->can('manage_uploader')) {
            $courses = Course::where('confirmation_status', 1)->get();
        } else {
            $courses = Course::where(['confirmation_status' => 1, 'teacher_id' => auth()->user()->id])->get();
        }
        return view('admin.content.media.create', compact('courses'));
    }
    public function store(MediaRequest $request)
    {
        $inputs = $request->all();
        if (!auth()->user()->can('manage_uploader')) {
            if ($inputs['is_private'] == 1) {
                $disk = cache('settings')['defult_uploader_private'];
            } else {
                $disk = cache('settings')['defult_uploader_public'];
            }
        } else {
            $disk = $inputs['disk'];
        }
        if ($inputs['is_private'] != 1) {
            $disk = 'public';
        }
        $inputs['storage_space'] = $disk;
        $inputs['media'] = null;
        $inputs['user_id'] = Auth::user()->id;
        Media::create($inputs);
        return redirect()->route('admin.content.media.index')->with('swal-success', 'پرونده با موفقیت انجام شد');
    }

    public function upload(Media $media)
    {

        return view('admin.content.media.uploader', compact('media'));
    }


    public function chunkUpload(Request $request, Media $media)
    {

        $upload_access_file_format = explode(',', Cache::get('settings')->upload_file_format);
        if (!in_array($request->file->getClientOriginalExtension(), $upload_access_file_format)) {
            return response()->json([
                'message' => $upload_access_file_format,
                'status' => false
            ]);
        }


        // create the file receiver
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

        // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            return 'Dont Upload';
        }
        // receive the file
        $save = $receiver->receive();
        if ($save->isFinished()) {
            if ($media->storage_space == 's3') {
                return $this->saveFileToS3($save->getFile(), $media);
            }
            return $this->saveFile($save->getFile(), $media);
        }
        $handler = $save->handler();
        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true,
        ]);
    }

    protected function saveFileToS3($file, Media $media)
    {
        $fileName = $this->createFilename($file);
        // $disk = Storage::disk('s3');
        // It's better to use streaming Streaming (laravel 5.4+)
        //   $disk->putFile($media->title, $file, $fileName);

        $result = Storage::disk('s3')->putFile($media->title, $file);
        // for older laravel
        // $disk->put($fileName, file_get_contents($file), 'public');
        $mime = str_replace('/', '-', $file->getMimeType());

        // We need to delete the file when uploaded to s3
        unlink($file->getPathname());
        Media::create([
            'user_id' => auth()->user()->id,
            'media' =>  $result,
            'parent_id' => $media->id ?? null,
            'title' => $fileName,
            'is_private' => $media->is_private,
            'storage_space' => $media->storage_space
        ]);
        return response()->json([
            'path' => $result,
            'name' => $result,
            'mime_type' => $mime
        ]);
    }

    protected function saveFile(UploadedFile $file, Media $media)
    {
        $fileName = $this->createFilename($file);
        // Group files by mime type
        $mime = str_replace('/', '-', $file->getMimeType());
        // Group files by the date (week
        //$dateFolder = date("Y-m-d");

        // Build the file path


        if ($media->is_private == 1) {
            $filePath = "uploader" . DIRECTORY_SEPARATOR . $media->title;
            $finalPath = storage_path("app" . DIRECTORY_SEPARATOR . $filePath);
        } else {
            $filePath = "uploader" . DIRECTORY_SEPARATOR . $media->title;
            $finalPath = public_path($filePath);
        }
        // move the file name
        $file->move($finalPath, $fileName);
        Media::create([
            'user_id' => auth()->user()->id,
            'media' => $filePath . DIRECTORY_SEPARATOR . $fileName,
            'parent_id' => $media->id ?? null,
            'title' => $fileName,
            'is_private' => $media->is_private,
            'storage_space' => $media->storage_space
        ]);
        return response()->json([
            'path' => $filePath,
            'name' => $fileName,
            'mime_type' => $mime
        ]);
    }

    /**
     * Create unique filename for uploaded file
     * @param UploadedFile $file
     * @return string
     */
    protected function createFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace("." . $extension, "", $file->getClientOriginalName()); // Filename without extension
        $filename .= "_" . rand(1, 1000) . "." . $extension;
        return $filename;
    }

    public  function uploadCkeditorImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $request->file('upload')->move(public_path('images/general'), $fileName);
            $url = asset('images/general/' . $fileName);
            return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
        }
    }
    public function destroyMultiple(Request $request)
    {
        if (!auth()->user()->can('manage_uploader')) {
            abort(403);
        }
        $ids = explode(',', $request->ids);
        foreach ($ids as $id) {
            $media = Media::findOrFail($id);
            if ($media->is_private == 1) {
                if ($media->parent_id) {
                    Storage::disk($media->storage_space)->delete($media->media);
                } else {
                    foreach ($media->children()->get() as $item) {
                        Storage::disk($media->storage_space)->delete($item->media);
                    }
                }
            } else {
                if ($media->parent_id) {
                    if (file_exists($media->media)) {
                        unlink($media->media);
                    }
                } else {
                    foreach ($media->children()->get() as $item) {
                        if (file_exists($item->media)) {
                            unlink($item->media);
                        }
                    }
                }
            }
            $media->delete();
        }
        return redirect()->back()->with('swal-success', ' موفقیت حذف شد');
    }
    public function destory(Media $media)
    {
        if (!auth()->user()->can('manage_uploader')) {
            abort(403);
        }
        if ($media->is_private == 1) {
            if ($media->parent_id) {
                Storage::disk($media->storage_space)->delete($media->media);
            } else {
                foreach ($media->children()->get() as $item) {
                    Storage::disk($media->storage_space)->delete($item->media);
                }
            }
        } else {
            if ($media->parent_id) {
                if (file_exists($media->media)) {
                    unlink($media->media);
                }
            } else {
                foreach ($media->children()->get() as $item) {
                    if (file_exists($item->media)) {
                        unlink($item->media);
                    }
                }
            }
        }
        $media->delete();
        return redirect()->back()->with('swal-success', '  موفقیت حذف شد');
    }
}
