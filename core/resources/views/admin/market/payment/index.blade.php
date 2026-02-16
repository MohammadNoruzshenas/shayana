@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.market.payment.index') }}">تراکنش ها</a></li>
@endsection
@section('content')
    <div class="tab__box">
        <div class="tab__items">
            <a class="tab__item @if (request('pay_for') == null) is-active @endif"
                href="{{ route('admin.market.payment.index') }}">همه تراکنش ها</a>
            <a class="tab__item @if (request('pay_for') == 1) is-active @endif" href="?pay_for=1"> تراکنش های دوره ها</a>
            <a class="tab__item @if (request('pay_for') == 2) is-active @endif" href="?pay_for=2"> تراکنش های اشتراک
                ها</a>
            <a class="tab__item @if (request('pay_for') == 3) is-active @endif" href="?pay_for=3">تراکنش های تبلیغات</a>


        </div>
    </div>

    <div class="bg-white padding-20">
        <div class="t-header-search">
            <form action="">
                <div class="t-header-searchbox font-size-13">
                    <input type="text" class="text search-input__box font-size-13" placeholder="جستجوی تراکنش">
                    <div class="t-header-search-content ">
                        <input type="text" class="text" name="email" value="{{ request('email') }}"
                            placeholder="ایمیل">
                        <input type="text" class="text" name="amount" value="{{ request('amount') }}"
                            placeholder="مبلغ به تومان">
                        <input type="text" class="text" name="transaction" value="{{ request('transaction') }}"
                            placeholder="کد تراکنش">

                        {{-- <input type="text"  class="text" id="start_date" name="start_date" value="{{ request("start_date") }}" placeholder="از تاریخ : 1402/06/21">
                    <input type="text" class="text margin-bottom-20" name="end_date" value="{{ request("end_date") }}"  placeholder="تا تاریخ : 1402/10/21"> --}}
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
                    <th>#</th>
                    <th>نام و نام خانوادگی</th>
                    <th>مبلغ</th>
                    <th>تاریخ</th>
                    <th>کد تراکنش</th>
                    <th>بانک</th>
                    <th>پرداخت بابت </th>
                    <th>وضعیت پرداخت</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><a
                                href="{{ route('admin.user.user-information.index', $payment->user) }}">{{ $payment->user->full_name ?? '-' }}</a>
                        </td>
                        <td>{{ priceFormat($payment->amount) }} تومان</td>
                        <td>{{ jalaliDate($payment->created_at) }} </td>

                        <td>{{ $payment->transaction_id }} </td>
                        <td>{{ $payment->gateway }}</td>
                        @if ($payment->pay_for == 1)
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

                        <td class="text-{{ $payment->status == 1 ? 'success' : 'danger' }}">{{ $payment->status_value }}
                        </td>
                        <td><a href="{{ route('admin.market.payment.detail', $payment) }}"><button
                                    class="btn btn-info">جزییات</button></a></td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
    <!-- paginate -->
    {{ $payments->links('admin.layouts.paginate') }}
    <!-- endpaginate -->
    </div>
@endsection
@section('script')
    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection
