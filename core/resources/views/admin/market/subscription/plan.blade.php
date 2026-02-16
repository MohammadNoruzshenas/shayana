@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="#">اشتراک </a></li>
    <li><a href="#">طرح های اشتراک </a></li>

@endsection
@section('content')
    <div class="main-content padding-0 discounts">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item is-active" href="{{ route('admin.market.subscription.plans.create') }}">افزودن پلن </a>
                <a class="tab__item " href="{{ route('admin.market.subscription.plan') }}">لیست پلن ها</a>

            </div>
        </div>
        <div class="row no-gutters  ">
            <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">
                <p class="box__title">پلن ها</p>
                <div class="table__box">
                    <div class="table-box">
                        <table class="table">
                            <thead role="rowgroup">
                                <tr role="row" class="title-row">
                                    <th>#</th>
                                    <th>نام پلن</th>
                                    <th> توضیحات</th>
                                    <th>قیمت </th>
                                    <th>تعداد روز</th>
                                    <th>تاریخ ساخت</th>
                                    <th>عملیات </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($plans as $plan)
                                    <tr role="row" class="">
                                        <td><a href="">{{ $loop->iteration }}</a></td>
                                        <td><a href="">{{ $plan->name }}</a></td>
                                        <th>{{ $plan->description }}</th>
                                        <td>{{ priceFormat($plan->price) ?? '-' }} تومان</td>
                                        <td>{{ $plan->subscription_day ?? '-' }}</td>
                                        <td>{{ jalaliDate($plan->created_at) ?? '-' }}</td>
                                        <td>
                                            <form action="{{ route('admin.market.subscription.plans.destroy', $plan) }}"
                                                method="POST">
                                                @method('delete')
                                                @csrf
                                                <button class="item-delete mlg-15 delete" title="حذف"><i class="fa fa-trash"></i></button>
                                                <a href="{{ route('admin.market.subscription.plans.edit', $plan) }}"
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
           {{ $plans->links('admin.layouts.paginate') }}
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
