@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.setting.gateway.index') }}">تنظیمات درگاه پرداخت</a></li>
    <li><a href="#">ویراش درگاه ({{$gateway->name_en . ' | ' . $gateway->name_fa}})</a></li>

@endsection
@section('content')
<p class="box__title">ویراش درگاه ({{$gateway->name_en . ' | ' . $gateway->name_fa}})</p>
<div class="row no-gutters bg-white">
    <div class="col-12">
        <form action="{{ route('admin.setting.gateway.update',$gateway->id) }}"  method="post" class="padding-30">
            @csrf
            @method('put')
            <p>Token / Merchant id :</p>
            <input type="text" name="token" value="{{ old('token',$gateway->token) }}" class="text" placeholder="Token / merchant id / ....">
            @error('token')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror

            <button class="btn btn-brand">ذخیره</button>
        </form>
    </div>
</div>
</div>
</div>
@endsection
