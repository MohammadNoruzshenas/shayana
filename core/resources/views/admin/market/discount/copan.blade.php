@extends('admin.layouts.master')
@section('head-tag')
    <title>کوپن تخفیف</title>
@endsection
@section('breadcrumb')
    <li><a href="{{ route('admin.market.discount.copan') }}">کوپن تخفیف</a></li>
@endsection
@section('content')
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item" href="{{ route('admin.market.discount.copan.create') }}">افزودن کوپن تخفیف</a>
                <a class="tab__item @if(request('sort') == null) is-active @endif" href="{{ route('admin.market.discount.copan') }}">لیست کوپن ها</a>
                <a class="tab__item @if(request('sort') == 1) is-active @endif" href="?sort=1">کوپن های  تاریخ دار</a>

            </div>
        </div>
        <div class="row no-gutters  ">
            <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">
                <p class="box__title">تخفیف ها</p>
                <div class="table__box">
                    <div class="table-box">
                        <table class="table">
                            <thead role="rowgroup">
                                <tr role="row" class="title-row">
                                    <th>#</th>
                                    <th>کد تخفیف</th>
                                    <th>نوع تخفیف</th>
                                    <th>میزان تخفیف </th>

                                    {{-- <th>سقف تخفیف</th> --}}
                                    <th>وضعیت</th>
                                    <th>شروع</th>
                                    <th>پایان</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($copans as $copan)
                                    <tr role="row" class="">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $copan->code }}</td>
                                        <th>{{ $copan->type_value }}</th>
                                        <th>{{ $copan->amount}}%</th>


                                        {{-- <td><a href="">{{ $copan->discount_ceiling }}</td> --}}
                                        <td>

                                            <label>
                                                <input id="{{ $copan->id }}" onchange="changeStatus({{ $copan->id }})"
                                                    data-url="{{ route('admin.market.discount.copan.status', $copan) }}"
                                                    type="checkbox" @if ($copan->status === 1) checked @endif>
                                            </label>
                                        </td>
                                        <td>{{ jalaliDate($copan->start_date) ?? '-' }}</td>
                                        <td>{{ jalaliDate($copan->end_date) ?? '-' }}</td>
                                        <td>
                                            <form action="{{ route('admin.market.discount.copan.destroy', $copan) }}"
                                                method="POST">
                                                @method('delete')
                                                @csrf
                                                <button class="item-delete mlg-15 delete" title="حذف"><i class="fa fa-trash"></i></button>
                                                <a href="{{ route('admin.market.discount.copan.edit', $copan) }}"
                                                    class="item-edit " title="ویرایش"><i class="fa fa-edit"></i></a>
                                            </form>
                                        </td>
                                @endforeach

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
                <!-- paginate -->
                {{ $copans->links('admin.layouts.paginate') }}
                <!-- endpaginate -->
    </div>
@endsection
@section('script')
    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
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
                                title: ' تخفیف با موفقیت فعال شد',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        } else {
                            element.prop('checked', false);
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: ' تخفیف با موفقیت غیرفعال شد',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    } else {
                        element.prop('checked', elementValue);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
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
@endsection
