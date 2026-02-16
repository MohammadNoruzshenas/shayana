@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="#">اطلاعات کاربری</a></li>
@endsection
@section('content')
<div class="main-content">
    <div class="user-info bg-white padding-30 font-size-13">
        <form action="{{ route('admin.user.user-information.update',$user) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="profile__info border cursor-pointer text-center">
                <div class="avatar__img"><img @if($user->image) src="{{ asset($user->image) }}"@endif class="avatar___img">
                    <input type="file" name="image" accept="image/*" class="hidden avatar-img__input">
                    <div class="v-dialog__container" style="display: block;"></div>
                    <div class="box__camera default__avatar"></div>
                </div>
                <span class="profile__name">{{ $user->full_name }}</span>
            </div>
            @error('image')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror
       <div class="row" style="justify-content: space-between; margin:0px;">
       <div class="col-49">
        <p class="mb-5 font-size-14"> نام : </p>
        <input class="text" placeholder="نام " name="first_name" value="{{ old('first_name',$user->first_name) }}">
        @error('first_name')
        <span class="text-error" role="alert">
            <strong>
                {{ $message }}
            </strong>
        </span>
    @enderror
        </div>
   <div class="col-49">
    <p class="mb-5 font-size-14"> نام خانوادگی : </p>
   <input class="text" placeholder="نام خانوادگی" name="last_name" value="{{ old('last_name',$user->last_name) }}">
    @error('last_name')
    <span class="text-error" role="alert">
        <strong>
            {{ $message }}
        </strong>
    </span>
@enderror
   </div>
       </div>
       <div class="row" style="justify-content: space-between; margin:0px;">
        <div class="col-49">
            <p class="mb-5 font-size-14"> نام کاربری : </p>
            <input class="text text-left" placeholder="نام کاربری" name="username" value="{{ old('username',$user->username) }}">
            @error('username')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror
        </div>
            <div class="col-49">
                <p class="mb-5 font-size-14"> ایمیل  : </p>
            <input class="text text-left" placeholder="ایمیل" name="email" value="{{ old('email',$user->email )}}">
            @error('email')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror
        </div>
    </div>
    <div class="row" style="justify-content: space-between; margin:0px;">
        <div class="col-49">
            <p class="mb-5 font-size-14"> شماره موبایل  : </p>
            <input class="text text-left" placeholder="شماره موبایل" name="mobile" value="{{ old('mobile',$user->mobile) }}">
            @error('mobile')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror
        </div>

            <div class="col-49">
                <p class="mb-5 font-size-14"> رمز  : </p>
                <input class="text text-left" name="password" placeholder="در صورت تغییر رمز این فیلد را پر کنید">

                @error('password')
                <span class="text-error" role="alert">
                    <strong>
                        {{ $message }}
                    </strong>
                </span>
            @enderror

            </div>
    </div>

    <div class="row" style="justify-content: space-between; margin:0px;">
        <div class="col-49">
            <p class="mb-5 font-size-14"> شماره کارت  : </p>
            <input class="text text-left" placeholder="شماره کارت بانکی" name="cart" value="{{ old('cart',$user->cart) }}">
            @error('cart')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror
        </div>
        <div class="col-49">
            <p class="mb-5 font-size-14"> شماره شبا  : </p>
            <input class="text text-left" placeholder="شماره شبا بانکی" name="shaba" value="{{ old('shaba',$user->shaba) }}">
            @error('shaba')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror
        </div>
    </div>
            <br>
            <p class="mb-5 font-size-14"> headline : </p>
            <input class="text " placeholder="headline" name="headline" value="{{ old('headline',$user->headline) }}">
            @error('headline')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror
            <textarea class="text" name="bio" placeholder="درباره من ">{{ $user->bio }}</textarea>
            @error('bio')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror
            <br>
            <div class="row" style="justify-content: space-between; margin:0px;">
                <div class="col-49">
                    <p class="mb-5 font-size-14"> آیدی اینستاگرام  : </p>
            <input class="text text-left" placeholder="ایدی اینستاگرام(id)" name="instagram" value="{{ old('instagram',$user->instagram) }}">
            @error('instagram')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror
                </div>
                <div class="col-49">
                    <p class="mb-5 font-size-14"> آیدی تلگرام  : </p>
        <input class="text text-left" placeholder="ایدی تلگرام(id) " name="telegram" value="{{ old('telegram',$user->telegram) }}">
        @error('telegram')
        <span class="text-error" role="alert">
            <strong>
                {{ $message }}
            </strong>
        </span>
    @enderror
                </div>
            </div>
            <br>
            <button class="btn btn-brand">ذخیره تغییرات</button>
        </form>
    </div>

</div>
</div>
@endsection
@section('script')
@include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
