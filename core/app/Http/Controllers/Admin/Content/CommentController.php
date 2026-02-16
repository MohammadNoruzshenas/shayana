<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Admin\Repositories\CommentFilterRepo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\CommentRequest;
use App\Models\Content\Comment;
use App\Models\Log\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            if (!$this->user->can('manage_comment')) {
                abort(403);
            }
            return $next($request);
        });

    }
    public function post(CommentFilterRepo $repo,Request $request)
    {
        $comments =  $repo->approved(request("confirmation_status"))->commentable_type('App\Models\Content\Post')->paginateParents(20);
        $comments->appends(request()->query());

        return view('admin.content.comment.index', compact('comments'));

    }
    public function podcast(CommentFilterRepo $repo,Request $request)
    {
        $comments =  $repo->approved(request("confirmation_status"))->commentable_type('App\Models\Content\Podcast')->paginateParents(20);
        $comments->appends(request()->query());

        return view('admin.content.comment.index', compact('comments'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        return view('admin.content.comment.show', compact('comment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function status(Comment $comment){

        $comment->status = $comment->status == 0 ? 1 : 0;
        $result = $comment->save();
        if($result){
                if($comment->status == 0){
                    return response()->json(['status' => true, 'checked' => false]);
                }
                else{
                    return response()->json(['status' => true, 'checked' => true]);
                }
        }
        else{
            return response()->json(['status' => false]);
        }

    }

    public function approved(Comment $comment){

        if($comment->approved == 0 || $comment->approved == 2)
        {
            $comment->approved = 1;
        }else{

            $comment->approved = 2;
        }

        $result = $comment->save();
        if($comment->commentable_type == 'App\Models\Content\Post')
        {
            $route = 'admin.content.comment.post.index';
        }else{
            $route = 'admin.content.comment.podcast.index';
        }
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'نظر با ایدی: '.$comment->id.'را تغییر وضعیت داد',
            'ip' => null,
            'os' => null
            ]);
        if($result){
            return redirect()->route($route)->with('swal-success', '  وضعیت نظر با موفقیت تغییر کرد');
        }
        else{
            return redirect()->route($route)->with('swal-error', '  وضعیت نظر با خطا مواجه شد');
        }

    }


    public function answer(CommentRequest $request, Comment $comment)
    {
            $inputs = $request->all();
            $inputs['author_id'] = Auth::user()->id;
            $inputs['parent_id'] = $comment->id;
            $inputs['commentable_id'] = $comment->commentable_id;
            $inputs['commentable_type'] = $comment->commentable_type;
            $inputs['approved'] = 1;
            $inputs['status'] = 1;
            $comment = Comment::create($inputs);
            if($comment->commentable_type == 'App\Models\Content\Post')
            {
                $route = 'admin.content.comment.post.index';
            }else{
                $route = 'admin.content.comment.podcast.index';
            }

            return redirect()->route($route)->with('swal-success', '  پاسخ شما با موفقیت ثبت شد');

    }
}
