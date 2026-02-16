@extends('admin.layouts.master')
@section('head-tag')
    <title>ایجاد کیف پول</title>
    <link rel="stylesheet" href="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection
@section('breadcrumb')
    <li><a href="{{ route('admin.market.wallet.index') }}"> کیف پول</a></li>
    <li><a href="{{ route('admin.market.wallet.create') }}"> عملیات</a></li>


    <br>
@endsection
@section('content')
    <p class="box__title">کیف پول </p>
    <div class="row no-gutters bg-white">
        <div class="col-12">
            <form action="{{ route('admin.market.wallet.store') }}" method="post" enctype="multipart/form-data"
                class="padding-30">
                @csrf
                <p class="mb-5 font-size-14">ایمیل : </p>
                <input type="text" value="{{ old('email') }}" required name="email" class="text"
                    placeholder="ایمیل ">
                @error('email')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <p class="mb-5 font-size-14">مبلغ : </p>
                <input type="text" value="{{ old('price') }}" required name="price" class="text"
                    placeholder="مبلغ ">
                @error('price')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <p class="mb-5 font-size-14">نوع عملیات : </p>
                <select name="type">
                    <option value="0" @if(old('type') == 0) selected @endif>برداشت</option>
                    <option value="1" @if(old('type') == 1) selected @endif>واریز</option>
                </select>
                @error('type')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror

                <br>
                <p class="mb-5 font-size-14">توضیحات  : </p>
                <textarea name="description" placeholder="توضیحات " class="text h">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <div style="margin:5px"></div>
                <button class="btn btn-brand mt-5" id="SubmitButtonPay" onclick="ButtonDisableR()">انجام عملیات</button>
            </form>
        </div>
    </div>
@endsection

@section('script')
<script>
    function ButtonDisableR() {
    setTimeout(() => {
        document.getElementById("SubmitButtonPay").setAttribute("disabled", "true");
    }, 1);
    }
    function submitReset(){
        document.getElementById("SubmitButtonPay").disabled = false;
    }


</script>
@endsection
