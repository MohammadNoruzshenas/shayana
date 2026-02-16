@extends('admin.layouts.master')
@section('breadcrumb')
    @php
        if ($comment->commentable_type == 'App\Models\Content\Post') {
            $route = 'admin.content.comment.post.index';
        } else {
            $route = 'admin.content.comment.podcast.index';
        }
    @endphp
    <li><a href="{{ route($route) }}">نظرات</a></li>
    <li><a href="#">نمایش نظر</a></li>
@endsection
@section('content')
    <section class="card mb-3">
        @if ($comment->approved == 1)
            <a href="{{ route('admin.content.comment.approved', $comment->id) }} "class="item-reject mlg-15 btn delete-btn font-size-13"
                type="submit">رد نظر</a>
        @else
            <a href="{{ route('admin.content.comment.approved', $comment->id) }}"
                class="item-confirm mlg-15 btn confirm-btn font-size-13" type="submit">تایید نظر</a>
        @endif
        <br>
        <br>
        <section class="card-header bg-white e bg-custom-yellow" style="padding: 20px 20px 0  0">
            {{ $comment->user->fullName ?? '-' }} - {{ $comment->user->id ?? '-' }}
        </section>

        <section class="bg-white "style="padding: 20px">
            <h5 class="card-title">عنوان پست  : {{ $comment->commentable->title ?? '-' }} <br>آیدی :
                {{ $comment->commentable->id ?? '-' }}</h5>
            @if ($comment->parent)
                کامنت قبلش : {{ $comment->parent->body }}
            @endif
            <hr>
            <p class="card-text">{{ $comment->body }}</p>

        </section>
    </section>
    @if ($comment->parent_id == null)
        <br>
        <section>
            <form action="{{ route('admin.content.comment.answer', $comment->id) }}" method="post">
                @csrf
                <section class="row">
                    <section class="col-12">
                        <div class="form-group">
                            <p for="" class="text-white mb-1">پاسخ ادمین</p>
                            ‍
                            <textarea class="form-control form-control-sm" placeholder="..." name="body" rows="4"></textarea>
                        </div>
                        @error('body')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </section>
                    <section class="col-12">
                        <button class="btn  all-confirm-btn btn-sm">ثبت</button>
                    </section>
                </section>
            </form>
        </section>
    @endif
@endsection
@section('script')
    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection
