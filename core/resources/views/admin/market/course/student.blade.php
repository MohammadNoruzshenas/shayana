@extends('admin.layouts.master')
@section('head-tag')
<title>مشاهده افراد ثبت نام کرده</title>
@endsection
@section('breadcrumb')
<li><a href="{{ route('admin.market.course.index') }}">دوره ها</a></li>
<li><a >{{ $course->title }}</a></li>
<li><a href="#">مشاهده افراد ثبت نام کرده</a></li>


@endsection
@section('content')
<div class="main-content">

    <div class="table__box">
        <table class="table">

            <thead role="rowgroup">
            <tr role="row" class="title-row">
                    <th>#</th>
                    <th>نام </th>
                    <th>ایمیل</th>
                    <th>شماره موبایل</th>
                    <th>وضعیت دسترسی</th>


            </tr>
            </thead>

            <tbody>

                @foreach ($course->students as $user)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $user->fullName->title ?? '-' }}</td>
                    <td>{{ $user->email ?? '-' }}</td>
                    <td>{{ $user->mobile ?? '-' }}</td>
                    <td>
                        <label>
                            <input id="{{ $user->id }}"
                                onchange="changeStatus({{ $user->id }})"
                                data-url="{{ route('admin.market.course.AccessStudentToCourseSatus.status',['course' => $course->id,'user' => $user->id]) }}"
                                type="checkbox" @if ($user->orderItems->where('course_id',$course->id)->first()->status == 1) checked @endif>
                        </label>
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
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: ' تغییرات با موفقیت فعال شد',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        } else {
                            element.prop('checked', false);
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: ' تغییرات با موفقیت غیرفعال شد',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    } else {
                        element.prop('checked', elementValue);
                        Swal.fire({
                            position: 'error',
                            icon: 'success',
                            title: 'هنگان ویرایش مشکلی به وجود اومد!لطفا مجدد امتحان نمایید',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                },
                error: function() {
                    element.prop('checked', elementValue);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'ارتباط برقرار نشد',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            });
        }
    </script>
@endsection
