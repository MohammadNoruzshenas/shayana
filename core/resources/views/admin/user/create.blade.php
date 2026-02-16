@extends('admin.layouts.master')

@section('head-tag')
    <link type="text/css" rel="stylesheet" href="{{asset('dashboard/css/jalalidatepicker.min.css')}}" />
@endsection

@section('breadcrumb')
<li><a href="{{ route('admin.user.index') }}">کاربران</a></li>

    <li><a href="{{ route('admin.user.create') }}">ایجاد کاربر جدید</a></li>

@endsection
@section('content')
    <div class="main-content font-size-13">
        <div class="row no-gutters  bg-white">
            <div class="col-12">
                <p class="box__title">اضافه کردن کاربر</p>
                <form action="{{ route('admin.user.store') }}" class="padding-30" method="post">
                    @csrf
                    <input type="text" value="{{ old('first_name') }}" name="first_name" class="text" placeholder="نام">

                    @error('first_name')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror
                    <input type="text" name="last_name" value="{{ old('last_name') }}" class="text"
                        placeholder="نام خانوادگی">
                    @error('last_name')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror
                    <input type="text" name="email" value="{{ old('email') }}" class="text" placeholder="ایمیل">
                    @error('email')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror
                    <input type="text" name="mobile" value="{{ old('mobile') }}" class="text" placeholder="شماره موبایل">
                    @error('mobile')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror
                    <input type="text" name="username" value="{{ old('username') }}" class="text"
                        placeholder="نام کاربری">
                    @error('username')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror
                    <input type="text" name="password" value="{{ old('password') }}" class="text"
                        placeholder="کلمه عبور">
                    @error('password')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror

                    <input type="text" name="instagram" value="{{ old('instagram') }}" class="text" placeholder="اینستاگرام">
                    @error('instagram')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror

                    <input type="text" name="telegram" value="{{ old('telegram') }}" class="text" placeholder="تلگرام">
                    @error('telegram')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror

                    <input type="text" name="parent_name" value="{{ old('parent_name') }}" class="text" placeholder="نام والد">
                    @error('parent_name')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror


                    <select name="gender" id="">
                        <option value="">انتخاب جنسیت</option>
                        <option value="male" @if (old('gender') == 'male') selected @endif>مرد</option>
                        <option value="female" @if (old('gender') == 'female') selected @endif>زن</option>
                    </select>
                    @error('gender')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror

                    <input type="text" name="birth" autocomplete="off" id="birth_date_create" data-jdp value="{{ old('birth') }}" class="text" placeholder="تاریخ تولد">
                    @error('birth')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror

                    <select name="is_admin" id="is_admin">
                        <option value="0" @if (old('is_admin') == 0) selected @endif>کاربر عادی</option>
                        <option value="1" @if (old('is_admin') == 1) selected @endif>مدیر</option>
                    </select>
                    @error('is_admin')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror

                    <div id="roles-section" style="display: none;">
                        <p class="mb-5">انتخاب نقش‌ها</p>
                        <select name="roles[]" id="roles" multiple>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" @if(old('roles') && in_array($role->id, old('roles'))) selected @endif>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('roles')
                            <span class="text-error" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </div>
                    <p class="mb-5">وضعیت حساب</p>
                    <select name="status" id="">
                        <option value="1" @if (old('status') == 1) selected @endif>فعال</option>
                        <option value="0" @if (old('status') == 0) selected @endif>غیرفعال</option>
                    </select>
                    @error('status')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror

                    <button class="btn btn-brand">افزودن</button>
                </form>

            </div>
        </div>
        @endsection
@section('script')
    <script type="text/javascript" src="{{asset('dashboard/js/jalalidatepicker.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            // Initialize general date picker
            jalaliDatepicker.startWatch();

            // Handle is_admin change
            $('#is_admin').change(function() {
                if ($(this).val() == '1') {
                    $('#roles-section').show();
                } else {
                    $('#roles-section').hide();
                    $('#roles').val([]);
                }
            });

            // Show roles section if is_admin is already set to 1 (for old input)
            if ($('#is_admin').val() == '1') {
                $('#roles-section').show();
            }
        });
    </script>
@endsection
