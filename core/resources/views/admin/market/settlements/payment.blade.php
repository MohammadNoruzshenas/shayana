@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.market.settlements.index') }}" >تسویه حساب</a></li>
@endsection
@section('content')
    <form action="{{ route('admin.market.settlements.payment.store',$settlement) }}" method="post" class="padding-30 bg-white font-size-14">
        @csrf
        @method('put')

        <div class="w-100 mlg-15">
            <p class="mb-5">نام صاحب حساب فرستنده</p>
            <input type="text" name="name" placeholder="نام صاحب حساب فرستنده " required onkeydown="submitReset()" class="text w-100"
                value="{{ old('name',auth()->user()->full_name) }}">
        </div>
        @error('from.name')
        <span class="alert_required text-error p-1 rounded" role="alert">
            <strong>
                {{ $message }}
            </strong>
        </span>
    @enderror
        <div class="w-100 mlg-15">
            <p class="mb-5">شماره کارت فرستنده</p>
            <input type="text" name="cart" placeholder="شماره کارت فرستنده" required onkeydown="submitReset()" class="text w-100"
            value="{{ old('cart',auth()->user()->cart) }}">
        </div>
        @error('from.cart')
        <span class="alert_required text-error p-1 rounded" role="alert">
            <strong>
                {{ $message }}
            </strong>
        </span>
    @enderror
        <div class="w-100 mlg-15">
            <p class="mb-5">نام شماره حساب گیرنده</p>
            <input type="text"  value="{{$settlement->to['name']}}" placeholder="{{$settlement->to['name']}}" class="text w-100" readonly>
        </div>
        @error('to.name')
        <span class="alert_required text-error p-1 rounded" role="alert">
            <strong>
                {{ $message }}
            </strong>
        </span>
    @enderror
        <div class="w-100 mlg-15">
            <p class="mb-5">شماره کارت </p>
            <input type="text" placeholder="{{$settlement->to['cart']}}" class="text w-100" readonly>
        </div>
        @error('to.cart')
        <span class="alert_required text-error p-1 rounded" role="alert">
            <strong>
                {{ $message }}
            </strong>
        </span>
    @enderror
        <div class="w-100 mlg-15">
            <p class="mb-5">مبلغ</p>
            <input type="text"  placeholder="{{ numberFormat($settlement->amount) }}" class="text w-100"
                readonly>
        </div>
        @error('amount')
        <span class="alert_required text-error p-1 rounded" role="alert">
            <strong>
                {{ $message }}
            </strong>
        </span>
    @enderror
    <p class="mb-5">توضیحات</p>
    <div class="w-100 mlg-15">
        <textarea  style="background-color: #222831" id="" readonly>{{ old('comments',$settlement->comments) }}</textarea>
     </div>
        <div class="row no-gutters border-2 margin-bottom-15 text-center ">
            <div class="w-50 padding-20 w-50">باقی مانده ی حساب :‌</div>
            <div class="bg-fafafa padding-20 w-50"> {{$remainingMoney}} تومان</div>
        </div>
        <button type="submit" id="SubmitButtonPay" onclick="ButtonDisableR()" class="btn all-confirm-btn">پرداخت</button>
    </form>
    </div>
    </div>
    </div>
@endsection
@section('script')
    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
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
