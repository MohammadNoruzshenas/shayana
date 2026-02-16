@extends('admin.layouts.master')
@section('breadcrumb')
<li><a href="{{ route('admin.market.settlements.index') }}" >تسویه حساب</a></li>
@endsection
@section('content')
    @if (cache('settings')['can_request_settlements'] == 1)

            <form action="{{ route('admin.market.settlements.store') }}" method="post"
                class="padding-30 bg-white font-size-14">
                @csrf
                <div class="w-100 mlg-15">
                    <input type="text" name="name" value="{{ old('name',auth()->user()->full_name) }}" placeholder="نام صاحب حساب" class="text w-100" required="required"
                        value="">
                </div>
                @error('name')
                <span class="alert_required text-error p-1 rounded" role="alert">
                    <strong>
                        {{ $message }}
                    </strong>
                </span>
            @enderror
                <div class="w-100 mlg-15">
                    <input type="text" name="cart" value="{{ old('cart',auth()->user()->cart) }}" placeholder="شماره کارت" class="text w-100" required="required"
                       >
                </div>
                @error('cart')
                <span class="alert_required text-error p-1 rounded" role="alert">
                    <strong>
                        {{ $message }}
                    </strong>
                </span>
            @enderror
            <div class="w-100 mlg-15">
                <input type="text" name="amount" value="{{old('amount',numberFormat(auth()->user()->balance))}}" placeholder="مبلغ به تومان" class="text w-100" >
            </div>
                @error('amount')
                <span class="alert_required text-error p-1 rounded" role="alert">
                    <strong>
                        {{ $message }}
                    </strong>
                </span>
            @enderror
            <div class="w-100 mlg-15">
               <textarea style="background-color: #222831" name="comments" id="" placeholder="توضیحات (اختیاری)" >{{ old('comments') }}</textarea>
            </div>
                @error('comments')
                <span class="alert_required text-error p-1 rounded" role="alert">
                    <strong>
                        {{ $message }}
                    </strong>
                </span>
            @enderror
                <div class="row no-gutters border-2 margin-bottom-15 text-center ">
                    <div class="w-50 padding-20 w-50">موجودی قابل برداشت :‌</div>
                    <div class="bg-fafafa padding-20 w-50"> {{ priceFormat(auth()->user()->balance) }} تومان</div>
                </div>
                <div class="row no-gutters border-2 text-center margin-bottom-15">
                    <div class="w-50 padding-20">حداکثر زمان واریز :‌</div>
                    <div class="w-50 bg-fafafa padding-20">{{ cache('settings')['settlement_pay_time']  }} روز</div>
                </div>
                <button type="submit" class="btn all-confirm-btn">درخواست تسویه</button>
            </form>
            @else
            <p>درخواست پرداخت موقتا  غیر فعال شده است</p>
    @endif

        </div>
    </div>
    </div>
@endsection
@section('script')
    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection
