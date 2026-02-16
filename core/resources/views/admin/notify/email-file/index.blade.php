@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="#"> اطلاعیه ها</a></li>
    <li><a href="{{ route('admin.notify.email.index') }}"> اطلاعیه ایمیلی</a></li>
    <li><a href="#">{{ $email->subject }}</a></li>
    <li><a href="{{ route('admin.notify.email-file.index',$email) }}">پیوست فایل</a></li>

@endsection
@section('content')
<div class="tab__box">
    <div class="tab__items">

        <a class="tab__item " href="{{ route('admin.notify.email-file.create',$email) }}">ایجاد فایل جدید</a>
    </div>
</div>


        <div class="table__box">
            <table class="table">
                <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th>#</th>
                        <th>عنوان ایمیل</th>
                        <th>سایز فایل</th>
                        <th>نوع فایل</th>
                        <th>وضعیت</th>
                        <th>تنظیمات</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($email->files as $key => $file)

                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $email->subject }}</td>
                        <td>{{ $file->file_size }}</td>
                        <td>{{ $file->file_type }}</td>
                        <td>
                            <label>
                                <input id="{{ $file->id }}" onchange="changeStatus({{ $file->id }})" data-url="{{ route('admin.notify.email-file.status', $file->id) }}" type="checkbox" @if ($file->status === 1)
                                checked
                                @endif>
                            </label>
                        </td>


                        <td>
                            <form class="d-inline" action="{{ route('admin.notify.email-file.destroy', $file->id) }}" method="post">
                            <a href="{{ route('admin.notify.email-file.edit', $file->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i> ویرایش</a>
                                @csrf
                                {{ method_field('delete') }}
                            <button class="btn d  delete-btn" type="submit"><i class="fa fa-trash-alt"></i> حذف</button>
                        </form>                            </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
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
                                title: ' وضعیت با موفقیت فعال شد',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        } else {
                            element.prop('checked', false);
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: ' وضعیت با موفقیت غیرفعال شد',
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
                            })                    }
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
            function successToast(message) {

var successToastTag = '<section class="toast" data-delay="5000">\n' +
    '<section class="toast-body p-3 d-flex bg-success text-white">\n' +
    '<strong class="ml-auto">' + message + '</strong>\n' +
    '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
    '<span aria-hidden="true">&times;</span>\n' +
    '</button>\n' +
    '</section>\n' +
    '</section>';

$('.toast-wrapper').append(successToastTag);
$('.toast').toast('show').delay(5500).queue(function() {
    $(this).remove();
})
}

function errorToast(message) {

var errorToastTag = '<section class="toast" data-delay="5000">\n' +
    '<section class="toast-body py-3 d-flex bg-danger text-white">\n' +
    '<strong class="ml-auto">' + message + '</strong>\n' +
    '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
    '<span aria-hidden="true">&times;</span>\n' +
    '</button>\n' +
    '</section>\n' +
    '</section>';

$('.toast-wrapper').append(errorToastTag);
$('.toast').toast('show').delay(5500).queue(function() {
    $(this).remove();
})
}
}
</script>
    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete-btn'])
@endsection
