@extends('admin.layouts.master')
@section('breadcrumb')
<li><a href="{{ route('admin.market.order.index') }}">سفارشات</a></li>
<li><a href="#">مشاهده سفارش</a></li>
<li><a href="#">{{ $order->id }}</a></li>


@endsection
@section('content')
<div class="main-content">

    <div class="table__box">
        <table class="table">

            <thead role="rowgroup">
            <tr role="row" class="title-row">
                    <th>#</th>
                    <th>نام دوره</th>
                    <th>تصویر</th>
                    <th>مبلغ نهایی</th>
                    <th>سهم سایت</th>
                    <th>سهم مدرس</th>


            </tr>
            </thead>

            <tbody>

                @foreach ($order->orderItems as $item)

                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->singleProduct->title ?? '-' }}</td>
                    <td><img src="{{ asset($item->singleProduct->image)}}" width="100" height="50" alt=""></td>
                    <td>{{ priceFormat($item->seller_site + $item->seller_share) ?? '-'}} تومان </td>
                    <td>{{ priceFormat($item->seller_site) ?? '-'}} تومان</td>
                    <td>{{ priceFormat($item->seller_share) ?? '-'}} تومان</td>


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
