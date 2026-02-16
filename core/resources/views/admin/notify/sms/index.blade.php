@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="#"> اطلاعیه ها</a></li>
    <li><a href="{{ route('admin.notify.sms.index') }}"> اطلاعیه پیامکی</a></li>
@endsection
@section('content')
    <div class="tab__box">
        <div class="tab__items">
            <a class="tab__item is-active" href="{{ route('admin.notify.sms.create') }}">ایجاد اطلاعیه جدید</a>
        </div>
    </div>
    <div class="table__box">
        <table class="table">
            <thead role="rowgroup">
                <tr role="row" class="title-row">
                    <th>#</th>
                    <th>عنوان</th>
                    <th>دریافت کنندگان</th>

                    {{-- <th>تاریخ ارسال</th> --}}
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sms as $single_sms)
                    <tr role="row">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $single_sms->title ?? '-' }}</td>
                        <td>{{ $single_sms->course->title ?? 'همه' }}</td>

                        {{-- <td>{{ jalaliDate( $single_sms->published_at) ?? '-' }}</td> --}}
                        <td>

                            <label>
                                <input id="{{ $single_sms->id }}" onchange="changeStatus({{ $single_sms->id }})"
                                    data-url="{{ route('admin.notify.sms.status', $single_sms) }}" type="checkbox"
                                    @if ($single_sms->status === 1) checked @endif>
                            </label>
                        </td>
                        <td>
                            <form action="{{ route('admin.notify.sms.destroy', $single_sms) }}" method="post">
                                @csrf
                                @method('delete')
                                <a href="{{ route('admin.notify.sms.edit', $single_sms) }}"
                                    class="btn btn-warning">ویرایش</a>

                                <button class="btn d  delete-btn">حذف</button>
                                <a href="{{ route('admin.notify.sms.send-sms', $single_sms) }}"
                                    class="btn d all-confirm-btn">ارسال</a>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
    </div>
          <!-- paginate -->
  {{ $sms->links('admin.layouts.paginate') }}
  <!-- endpaginate -->
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
