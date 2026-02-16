@extends('admin.layouts.master')
@section('breadcrumb')
    <li>
        <a href="{{ route('admin.market.payment.index') }}">تراکنش ها</a>
    </li>
@endsection
@section('content')
    <a href="{{ route('admin.market.payment.index') }} " class="item-reject mlg-15 btn all-confirm-btn font-size-13 mb-5"
        type="submit">برگشت </a>
    <br>


    <div class="tab__box" style="padding-right: 15px;padding-top: 10px">
        <p>کاربر : {{ $payment->user->full_name }}</p>
        <p class="text-{{ $payment->status == 1 ? 'success' : 'danger' }}"> وضعیت : {{ $payment->status_value }}</p>

        <p>پرداخت بابت : @if ($payment->pay_for == 1)
                <td><a class="color-link"
                        href="{{ route('admin.market.order.details', $payment->paymentable_id ?? '-') }}">{{ $payment->pay_for_value . '-' . $payment->paymentable_id }}</a>
                </td>
            @elseif ($payment->pay_for == 2)
                <td><a class="color-link"
                        href="{{ route('admin.market.subscription.details', $payment->paymentable_id ?? '-') }}">{{ $payment->pay_for_value . '-' . $payment->paymentable_id }}</a>
                </td>
            @elseif ($payment->pay_for == 3)
                <td><a
                        href="{{ route('admin.content.ads.edit', $payment->paymentable_id ?? '-') }}">{{ $payment->pay_for_value . '-' . $payment->paymentable_id }}</a>
                </td>
            @else
                <td>-</td>
            @endif
        </p>

        <p>مبلغ : {{ priceFormat($payment->amount) }} تومان</p>
        <p>درگاه : {{ $payment->gateway }}</p>
        <p>کد تراکنش : {{ $payment->transaction_id }}</p>



        <p>توضیحات:</p>
        <span>{!! $payment->description ?? '-' !!}</span>
        <br>
        <br>


    </div>
@endsection
@section('script')
    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection
