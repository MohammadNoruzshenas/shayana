@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.market.wallet.index') }}">کیف پول </a></li>
@endsection
@section('content')

        <div class="tab__box" style="padding-right: 15px;padding-top: 10px">
            <p>کاربر : {{$wallet->user->email }} -- {{$wallet->user->full_name }}</p>
            <p class="{{$wallet->type == 1 ? 'text-success' : 'text-danger'}} ">مبلغ : {{priceFormat($wallet->price)}} تومان</p>
            <p>توضیحات   : {!! $wallet->description ?? 'بدون توضیحات' !!}</p>
            <p>زمان   : {{ jalaliDate($wallet->created_at,'Y/m/d H:s')}}</p>
            <br>
    </div>
@endsection
