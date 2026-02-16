@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="#">اشتراک </a></li>
@endsection
@section('content')
    <div class="main-content padding-0 discounts">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item" href="{{ route('admin.market.subscription.create') }}">افزودن اشتراک </a>
                <a class="tab__item @if (request('status') == null) is-active @endif"
                    href="{{ route('admin.market.subscription.index') }}">همه</a>
                <a class="tab__item @if (request('status') == 1) is-active @endif" href="?status=1">فعال</a>
                <a class="tab__item @if (request('status') == 2) is-active @endif" href="?status=2">منقضی</a>
                <a class="tab__item @if (request('status') == 3) is-active @endif" href="?status=3">پرداخت نشده</a>



            </div>
        </div>

        <div class="bg-white padding-20">
            <div class="t-header-search">
                <form action="">
                    <div class="t-header-searchbox font-size-13">
                        <input type="text" class="text search-input__box font-size-13" placeholder="جستجوی در  ">
                        <div class="t-header-search-content ">

                            <input type="text" class="text" value="{{ request()->email }}" name="email"
                                placeholder="ایمیل کاربر">

                            <button type="submit" class="btn btn-webamooz_net">جستجو</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row no-gutters  ">
            <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">
                <p class="box__title">اشتراک ها</p>
                <div class="table__box">
                    <div class="table-box">
                        <table class="table">
                            <thead role="rowgroup">
                                <tr role="row" class="title-row">
                                    <th>#</th>
                                    <th>نام کاربر</th>
                                    <th>ایمیل </th>

                                    <th>پلن انتخاب شده</th>
                                    <th>زمانی باقی مانده اشتراک</th>
                                    <th>وضعیت</th>
                                    <th>زمان شروع </th>
                                    <th>مبلغ پرداخت </th>

                                    <th>وضعیت پرداخت </th>

                                    <th>عملیات </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscriptions as $subscription)
                                    <tr role="row" class="">
                                        <td><a href="">{{ $loop->iteration }}</a></td>
                                        <td><a
                                                href="{{ route('admin.user.user-information.index', $subscription->user) }}">{{ $subscription->user->full_name }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('admin.user.user-information.index', $subscription->user) }}">{{ $subscription->user->email }}</a>
                                        </td>

                                        @php
                                            $data = json_decode($subscription->plan_object);
                                        @endphp
                                        <th>{{ $data->name }}</th>
                                        <td>
                                            @if ($subscription->expirydate < now())
                                                0
                                            @else
                                                {{ \Carbon\Carbon::today()->diffInDays($subscription->expirydate, false) }}
                                            @endif
                                        </td>
                                        <td>
                                            <label>
                                                <input id="{{ $subscription->id }}"
                                                    onchange="changeStatus({{ $subscription->id }})"
                                                    data-url="{{ route('admin.market.subscription.status', $subscription->id) }}"
                                                    type="checkbox" @if ($subscription->status === 1) checked @endif>
                                            </label>
                                        </td>
                                        <td>{{ jalaliDate($subscription->created_at) }} </td>
                                        <td>
                                            @if ($subscription->payment_id != null)
                                                <a href="{{ route('admin.market.payment.detail', $subscription->payment_id) }}"
                                                    class="text-blue">{{ priceFormat($subscription->order_final_amount) }}
                                                    تومان </a>
                                            @endif
                                        </td>

                                        <td
                                            class="{{ $subscription->payment_status != 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $subscription->payment_status != 0 ? 'پرداخت شده' : 'پرداخت نشده' }} </td>

                                        <td>
                                            <form action="{{ route('admin.market.subscription.destroy', $subscription) }}"
                                                method="POST">
                                                @method('delete')
                                                @csrf

                                                <button class="item-delete mlg-15 delete" title="حذف">
                                                    <li class="fa fa-trash"></li>
                                                </button>
                                                <a href="{{ route('admin.market.subscription.details', $subscription) }}"
                                                    class="item-edit " title="eye"><i class="fa fa-eye"></i></a>

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
        {{ $subscriptions->links('admin.layouts.paginate') }}
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
                                title: ' اشتراک با موفقیت فعال شد',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        } else {
                            element.prop('checked', false);
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: ' اشتراک با موفقیت غیرفعال شد',
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
