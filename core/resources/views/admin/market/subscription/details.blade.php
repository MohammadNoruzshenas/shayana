@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.market.subscription.index') }}">اشتراک ها</a></li>
    <li><a href="#">مشاهده سفارش</a></li>
    <li><a href="#">{{ $subscription->id }}</a></li>
@endsection
@section('content')
    <div class="main-content">

        <div class="table__box">
            <table class="table">

                <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th>#</th>
                        <th>نام و نام خانوادگی</th>
                        <th>نام پلن</th>
                        <th>مدت پلن</th>
                        <th>مبلغ پلن</th>
                        <th>مبلغ نهایی</th>
                        <th>مبلغ تخفیف</th>
                        <th>مدت پلن</th>

                        <th>تاریخ شروع</th>
                        <th>تاریخ پایان</th>


                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <th>{{ $subscription->id }}</th>
                        <td>{{ $subscription->user->full_name ?? '-' }}</td>

                        <td>{{ $subscription->plan->name ?? '-' }}</td>
                        <td>{{ $subscription->plan->subscription_day ?? '-' }}</td>

                        <td>{{  priceFormat($subscription->price)}} تومان</td>
                        <td>{{ priceFormat($subscription->order_final_amount) }} تومان</td>
                        <td>{{ $subscription->order_common_discount ?? '-' }}</td>
                        <td>{{ $subscription->plan->subscription_day ?? '-' }}</td>


                        <td>{{ jalaliDate($subscription->created_at) }}</td>
                        <td>{{ jalaliDate($subscription->expirydate) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>
@endsection
@section('script')
    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection
