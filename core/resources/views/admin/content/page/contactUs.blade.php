@extends('admin.layouts.master')
@section('head-tag')
    <title>تماس با ما</title>
    <link rel="stylesheet" href="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection
@section('breadcrumb')
    <li><a href="{{ route('admin.content.page.contactUs') }}">صفحه تماس با ما</a></li>
@endsection
@section('content')
    <p class="box__title">ویرایش صفحه تماس با ما  </p>

    <div class="row no-gutters bg-white">
        <div class="col-12">
            <form action="{{ route('admin.content.page.contactUs.update') }}" method="post" enctype="multipart/form-data"
                class="padding-30">
                @csrf
                @method('PUT')
                <div class="row" style="justify-content: space-between; margin:0px;">
                    <p class="mb-5 font-size-14"> آدرس صفحه  : (غیر قابل تغییر) </p>
                        <input type="text" value="{{isset($_SERVER['https']) ? 'https://' : 'http://'.request()->getHost() .'/contactUs' }}"  disabled class="text text-left">

                    <div class="col-49">
                        <p class="mb-5 font-size-14"> عنوان : </p>
                        <input type="text" value="{{ old('title',$contactUs->title) }}" name="title" class="text"
                            placeholder="عنوان صفحه">
                        @error('title')
                            <span class="text-error" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-49">
                        <p class="mb-5 font-size-14"> متن زیر عنوان : </p>
                        <input type="text" value="{{ old('second_text',$contactUs->second_text) }}" name="second_text" class="text"
                            placeholder="متن زیر عنوان">
                        @error('second_text')
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
                        <p class="mb-5 font-size-14"> طول جغرافیایی : </p>
                        <input type="text" value="{{ old('longitude',$contactUs->longitude) }}" name="longitude" class="text"
                            placeholder="عنوان صفحه">
                        @error('longitude')
                            <span class="text-error" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-49">
                        <p class="mb-5 font-size-14"> عرض  جغرافیایی : </p>
                        <input type="text" value="{{ old('latitude',$contactUs->latitude) }}" name="latitude" class="text"
                            placeholder="متن زیر عنوان">
                        @error('latitude')
                            <span class="text-error" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror


                    </div>
                </div>
                <p class="mb-5 font-size-14"> آدرس : </p>
                <input type="text" value="{{ old('address',$contactUs->address) }}" name="address" class="text"
                    placeholder=" آدرس">
                @error('address')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <p class="mb-5 font-size-14"> آدرس اکانت اینستاگرام : </p>
                <input type="text" value="{{ old('instagram',$contactUs->instagram) }}" name="instagram" class="text"
                    placeholder=" ادرس اینستاگرام">
                @error('instagram')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
               <p class="mb-5 font-size-14"> آدرس تلگرام : </p>
                <input type="text" value="{{ old('telegram',$contactUs->telegram) }}" name="telegram" class="text"
                    placeholder=" آدرس تلگرام">
                @error('telegram')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <p class="mb-5 font-size-14"> آدرس ایمیل : </p>
                <input type="text" value="{{ old('email',$contactUs->email) }}" name="email" class="text"
                    placeholder=" آدرس ایمیل">
                @error('email')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror

                <p class="mb-5 font-size-14"> ساعات کاری : </p>
                <input type="text" value="{{ old('working_hours',$contactUs->working_hours) }}" name="working_hours" class="text"
                    placeholder="ساعات کاری">
                @error('working_hours')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <textarea type="text" name="description"  class="text text-right mlg-15">{{ old('description',$contactUs->description) }}</textarea>
                @error('description')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <div style="margin:5px"></div>
                <p class="mb-5 font-size-14"> نمایش فرم : </p>
                <select name="isActive_form">
                    <option value="0" @if (old('isActive_form',$contactUs->isActive_form) == 0) selected @endif>غیر فعال</option>
                    <option value="1" @if (old('isActive_form',$contactUs->isActive_form) == 1) selected @endif>فعال </option>
                </select>
                @error('isActive_form')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <div style="margin:5px"></div>
                <button class="btn btn-brand mt-5"> ویرایش</button>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('dashboard/js/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('dashboard/js/jalalidatepicker/persian-date.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.js') }}"></script>


@endsection
