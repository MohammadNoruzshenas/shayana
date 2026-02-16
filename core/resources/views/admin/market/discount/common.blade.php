@extends('admin.layouts.master')
@section('breadcrumb')
<title>تخفیف عمومی</title>
    <li><a href="{{ route('admin.market.discount.commonDiscount') }}">تخفیف عمومی </a></li>
@endsection
@section('content')
    <div class="tab__box">
        <div class="tab__items">
            <a class="tab__item " href="{{ route('admin.market.discount.commonDiscount.create') }}">افزودن تخفیف
                عمومی</a>

            <a class="tab__item @if(request('sort') == null) is-active @endif" href="{{ route('admin.market.discount.commonDiscount') }}">لیست تخفیف عمومی</a>
            <a class="tab__item @if(request('sort') == 1) is-active @endif" href="?sort=1">تخفیف های تاریخ دار</a>

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

                                <th>عنوان</th>
                                <th>درصد تخفیف</th>
                                <th>تخفیف روی</th>
                                {{-- <th>سقف تخفیف</th>
                                <th> حداقل سفارش</th> --}}
                                <th>وضعیت</th>
                                <th>شروع</th>
                                <th>پایان</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($commonDiscounts as $commonDiscount)
                                <tr role="row" class="">
                                    <td><a href="">{{ $loop->iteration }}</a></td>
                                    <td><a href="">{{ $commonDiscount->title }}</a></td>
                                    <th>{{ $commonDiscount->percentage }}</th>
                                    <th>{{ $commonDiscount->common_discount_type_value }}</th>


                                    {{-- <td><a href="">{{ $commonDiscount->discount_ceiling }}</td>
                                    <td><a href="">{{ $commonDiscount->minimal_order_amount }}</td> --}}

                                    <td>

                                        <label>
                                            <input id="{{ $commonDiscount->id }}"
                                                onchange="changeStatus({{ $commonDiscount->id }})"
                                                data-url="{{ route('admin.market.discount.commonDiscount.status', $commonDiscount) }}"
                                                type="checkbox" @if ($commonDiscount->status === 1) checked @endif>
                                        </label>
                                    </td>
                                    <td>{{ jalaliDate($commonDiscount->start_date) ?? '-' }}</td>
                                    <td>{{ jalaliDate($commonDiscount->end_date) ?? '-' }}</td>
                                    <td>
                                        <form
                                            action="{{ route('admin.market.discount.commonDiscount.destroy', $commonDiscount) }}"
                                            method="POST">
                                            @method('delete')
                                            @csrf
                                            <button class="item-delete mlg-15 delete" title="حذف"><i class="fa fa-trash"></i></button>
                                            <a href="{{ route('admin.market.discount.commonDiscount.edit', $commonDiscount) }}"
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
        {{ $commonDiscounts->links('admin.layouts.paginate') }}
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
