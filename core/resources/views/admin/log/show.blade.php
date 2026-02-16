@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.log.index') }}">لاگ ها</a></li>
@endsection
@section('content')
<a href="{{ route('admin.log.index') }} " class="item-reject mlg-15 btn all-confirm-btn font-size-13 mb-5"
type="submit">برگشت </a>
<br>

        <div class="tab__box" style="padding-right: 15px;padding-top: 10px">
            <p>کاربر : {{$log->user->email }} -- {{$log->user->full_name }}</p>
            <p>توضیحات   : {!! $log->description ?? 'بدون توضیحات' !!}</p>
            <p>ای پی   : {{ $log->ip}} </p>
            <p>مشخصات تکمیلی  : {{ $log->os}}</p>

            <p>زمان   : {{ jalaliDate($log->created_at,'Y/m/d h:s')}}</p>



            <br>


    </div>
@endsection
@section('script')
    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection
