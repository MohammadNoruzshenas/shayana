@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.market.order.index') }}">سفارشات</a></li>
@endsection
@section('content')


    <div class="table__box">
        <table class="table">

            <thead role="rowgroup">
            <tr role="row" class="title-row">
                <th>شناسه</th>
                <th>کد سفارش</th>
                <th>نام و  نام خانوادگی</th>
                <th>مجموع مبلغ سفارش (بدون تخفیف)</th>
                <th>مجموع تمامی مبلغ تخفیفات </th>
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

                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->full_name ?? '-' }}</td>
                    <td>{{ priceFormat($order->order_final_amount) ?? '-'  }} تومان</td>
                    <td>{{ priceFormat($order->order_discount_amount) ?? '-' }} تومان</td>
                    <td>{{ priceFormat($order->order_total_products_discount_amount) ?? '-' }} تومان</td>
                    <td>{{ priceFormat($order->order_final_amount -  $order->order_discount_amount) ?? '-' }} تومان</td>
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
</div>
@endsection
@section('script')
@include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
