@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.content.post.index') }}" title="">مقالات </a></li>
    <li><a href="{{ route('admin.content.comment.post.index') }}" title="">نظرات مقالات </a></li>
@endsection
@section('content')
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item is-active" href="{{ route('admin.content.comment.post.index') }}">تمام نظرات </a>
                <a class="tab__item" href="?approved=1">نظرات تایید شده
                </a>
                <a class="tab__item" href="?approved=2">نظرات رد شده
                </a>
                <a class="tab__item" href="?approved=0"> نظرات درحال
                    بررسی
                </a>

            </div>
        </div>


            <div class="table__box">
                <table class="table">

                    <thead role="rowgroup">
                        <tr role="row" class="title-row">
                            <th>شناسه</th>
                            <th>نظر</th>
                            <th>پاسخ به</th>
                            <th>کد کاربر</th>
                            <th>نویسنده نظر</th>
                            <th>کد پست</th>
                            <th>عنوان پست</th>
                            <th>وضعیت تایید</th>
                            {{-- <th>وضعیت کامنت</th> --}}
                            <th>عملیات</th>

                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($comments as $key => $comment)
                            <tr role="row">
                                <th>{{ $key + 1 }}</th>
                                <td>{{ Str::limit($comment->body, 10) }}</td>
                                <td>{{ $comment->parent_id ? Str::limit($comment->parent->body, 10) : '-' }}</td>
                                <td>{{ $comment->author_id }}</td>
                                <td><a href="{{route('admin.user.user-information.index',$comment->user)}}">{{ $comment->user->fullName }}</td></a>
                                <td>{{ $comment->commentable_id ?? '-'}}</td>
                                <td>{{ $comment->commentable->title ?? '-'}}</td>
                                <td class="@if($comment->approved == 1) text-success @elseif ($comment->approved == 2) text-danger @else text-warning @endif">{{ $comment->approvedValue }} </td>
                                {{-- <td>
                                    <label>
                                        <input id="{{ $comment->id }}" onchange="changeStatus({{ $comment->id }})"
                                            data-url="{{ route('admin.content.comment.status', $comment->id) }}"
                                            type="checkbox" @if ($comment->status === 1) checked @endif>
                                    </label>
                                </td> --}}
                                <td class="width-16-rem text-left">
                                    <a href="{{ route('admin.content.comment.show', $comment->id) }}"
                                        class="item-eye mlg-15"><i class="fa fa-eye"></i></a>
                                    @if ($comment->approved == 1)
                                        <a href="{{ route('admin.content.comment.approved', $comment->id) }} "class="item-reject mlg-15"
                                            type="submit"><i class="fa fa-xmark"></i></a>
                                    @else
                                        <a href="{{ route('admin.content.comment.approved', $comment->id) }}"
                                            class="item-confirm mlg-15" type="submit"><i class="fa fa-check"></i></a>
                                    @endif
                                </td>
                                </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">

        function changeStatus(id) {
            var element = $("#" + id)
            var url = element.attr('data-url')
            var elementValue = !element.prop('checked');

            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    if (response.status) {
                        if (response.checked) {
                            element.prop('checked', true);
                            successToast('نظر  با موفقیت فعال شد')
                        } else {
                            element.prop('checked', false);
                            successToast('نظر  با موفقیت غیر فعال شد')
                        }
                    } else {
                        element.prop('checked', elementValue);
                        errorToast('هنگام ویرایش مشکلی بوجود امده است')
                    }
                },
                error: function() {
                    element.prop('checked', elementValue);
                    errorToast('ارتباط برقرار نشد')
                }
            });

            function successToast(message) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: message,
                    showConfirmButton: false,
                    timer: 1500
                })
            }
            function errorToast(message) {

                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: message,
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        }
    </script>
@endsection
