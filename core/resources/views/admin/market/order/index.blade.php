@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.market.order.index') }}">سفارشات</a></li>
@endsection
@section('content')
    <div class="tab__box">
        <div class="tab__items">
            <a class="tab__item @if(request('payment_status') == null) is-active @endif" href="{{ route('admin.market.order.index') }}">همه سفارشات</a>
            <a class="tab__item @if(request('payment_status') == 4) is-active @endif" href="?payment_status=4">سفارشات پرداخت نشده</a>
            <a class="tab__item @if(request('payment_status') == 1) is-active @endif" href="?payment_status=1">سفارشات پرداخت شده</a>
            {{-- <a class="tab__item @if(request('payment_status') == 2) is-active @endif" href="?payment_status=2"> برگشت داده  شده </a> --}}
            <a class="tab__item @if(request('payment_status') == 3) is-active @endif" href="?payment_status=3"> پرداخت شده توسط وبسایت</a>


        </div>
    </div>
    <div class="bg-white padding-20">
        <div class="t-header-search">
            <form action="">
                <div class="t-header-searchbox font-size-13">
                    <input type="text" class="text search-input__box font-size-13" placeholder="جستجوی در  سفارشات">
                    <div class="t-header-search-content ">
                        <input type="text"  class="text" name="email" value="{{ request('email') }}" placeholder="ایمیل">
                        <input type="text"  class="text" name="amount" value="{{ request('amount') }}" placeholder="مبلغ">

                        <button type="submit" class="btn btn-webamooz_net">جستجو</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="table__box">
        <table class="table">

            <thead role="rowgroup">
            <tr role="row" class="title-row">
                <th>شناسه</th>
                <th>کد سفارش</th>
                <th>نام و  نام خانوادگی</th>




                <th>مجموع مبلغ سفارش (بدون تخفیف)</th>
                <th>کوپن تخفیف</th>
                <th>مبلغ تخفیف کوپن</th>


                <th>مبلغ تخفیف عمومی</th>
                <th>مبلغ تخفیف همه دوره</th>
                <th>مبلغ نهایی</th>
                <th>درامد سایت</th>
                <th>درامد مدرس</th>
                <th>مشاهده جزئیات</th>
                <th>وضعیت پرداخت</th>
            </tr>
            </thead>

            <tbody>
                @foreach ($orders as $order)
                <tr>

                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $order->id }}</td>
                    <td><a class="text-blue" href="{{route('admin.user.user-information.index',$order->user)}}">{{ $order->user->full_name ?? '-' }}</a></td>




                    <td>{{ priceFormat($order->totalProductPrice) ?? '-'  }} تومان</td>
                    <td>{{$order->copan->code ?? '-'}}</td>
                    <td>{{ priceFormat($order->order_copan_discount_amount) ?? '-'  }} تومان</td>


                    <td>{{ priceFormat($order->order_common_discount_amount) ?? '-' }} تومان</td>
                    <td>{{ priceFormat($order->order_total_products_discount_amount) ?? '-' }} تومان</td>
                    <td>{{ priceFormat($order->order_final_amount) ?? '-' }} تومان</td>
                    <td>{{ priceFormat($order->seller_site) ?? '-' }} تومان</td>
                    <td>{{ priceFormat($order->seller_share) ?? '-' }} تومان</td>
                    <td><a href="{{ route('admin.market.order.details', $order->id) }}" class="dropdown-item text-right"><i class="fa fa-images"></i> مشاهده فاکتور</a></td>
                    <td
                    @if ($order->payment_status == 0) class='text-warning' @endif
                     @if ($order->payment_status == 1) class='text-success' @endif
                        @if ($order->payment_status == 2) class='text-danger' @endif
                        @if ($order->payment_status == 3) class='text-success' @endif>
                        {{ $order->payment_status_value }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
    <!-- paginate -->
    {{ $orders->links('admin.layouts.paginate') }}
    <!-- endpaginate -->
</div>
@endsection
@section('script')
@include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
