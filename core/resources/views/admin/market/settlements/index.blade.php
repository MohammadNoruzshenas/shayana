@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="">تسویه حساب</a></li>
@endsection

@section('content')
    <div class="main-content">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item @if (request()->status == null) is-active @endif"
                    href="{{ route('admin.market.settlements.index') }}"> همه تسویه ها</a>
                <a class="tab__item @if (request()->status == 3) is-active @endif" href="?status=3">در حال بررسی</a>
                <a class="tab__item @if (request()->status == 1) is-active @endif" href="?status=1">واریز شده</a>
                <a class="tab__item @if (request()->status == 2) is-active @endif" href="?status=2">رد شده</a>
                <a class="tab__item" href="{{ route('admin.market.settlements.create') }}">درخواست تسویه جدید</a>
            </div>
        </div>
        <div class="bg-white padding-20">
            <div class="t-header-search">
                <form action="">
                    <div class="t-header-searchbox font-size-13">
                        <input type="text" class="text search-input__box font-size-13"
                            placeholder="جستجوی در  تسویه حساب ها">
                        <div class="t-header-search-content ">

                            <input type="text" class="text" name="email" value="{{ request('email') }}"
                                placeholder="ایمیل">
                            <input type="text" class="text" name="username" value="{{ request('username') }}"
                                placeholder="نام کاربری">
                            <input type="text" class="text" name="amount" value="{{ request('amount') }}"
                                placeholder="مبلغ">




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
                        <th>کاربر</th>
                        <th>صاحب حساب</th>
                        <th> شماره کارت</th>
                        <th>تاریخ درخواست واریز</th>
                        <th>تاریخ واریز شده</th>
                        <th>مبدا</th>

                        <th>مبلغ (تومان )</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($settlements as $settlement)
                        <tr role="row">
                            <td>{{ $loop->iteration }}</td>
                            <td ><a class="color-2b4a83"
                                    href="{{ route('admin.user.user-information.index', $settlement->user) }}">{{ $settlement->user->full_name ?? '-' }}</a>
                            </td>
                            <td>{{ $settlement->to['name'] ?? '-' }}</td>
                            <td>{{ Str::limit($settlement->to['cart'] ?? '-', 24) }}</td>
                            <td>{{ $settlement->created_at->diffForHumans() ?? '-' }}</td>

                            <td>
                                @if ($settlement->status == 1)
                                    {{ \Carbon\Carbon::parse($settlement->settled_at)->diffForHumans() }}
                                @else
                                    -
                                @endif
                            </td>
                            <td title="{{ $settlement->from['cart'] ?? '-' }}">{{ $settlement->from['name'] ?? '-' }}</td>

                            <td>{{ priceFormat($settlement->amount) ?? '-' }} تومان</td>
                            <td><span @if ($settlement->status == 0) class='text-warning' @endif
                                    @if ($settlement->status == 1) class='text-success' @endif
                                    @if ($settlement->status == 2) class='text-danger' @endif
                                    @if ($settlement->status == 3) class='text-warning' @endif>
                                    {{ $settlement->status_value }}
                                    </a>
                            </td>
                            <td>
                                @if ($settlement->status == 0)
                                    <a href="{{ route('admin.market.settlements.payment', $settlement) }}"
                                        class="btn all-confirm-btn">پرداخت</a>

                                    <a href="{{ route('admin.market.settlements.reject', $settlement) }}"
                                        class="btn d delete-btn">رد </a>
                                    <a href="{{ route('admin.market.settlements.cancelled', $settlement) }}"
                                        class="btn d btn-warning ">لغو </a>
                                @else
                                    -
                                @endif


                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <!-- paginate -->
    {{ $settlements->links('admin.layouts.paginate') }}
    <!-- endpaginate -->
    </div>
@endsection
@section('script')
    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection
