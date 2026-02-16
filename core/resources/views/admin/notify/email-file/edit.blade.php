@extends('admin.layouts.master')
@section('head-tag')
<title>اپلود فایل</title>
<link rel="stylesheet" href="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection
@section('breadcrumb')
    <li><a href="#"> اطلاعیه ها</a></li>
    <li><a href="{{ route('admin.notify.email.index') }}"> اطلاعیه ایمیلی</a></li>
    <li><a href="#">پیوست  فایل</a></li>
    <li><a href="#">ویرایش  فایل</a></li>





@endsection
@section('content')
<p class="box__title">اپلود فایل</p>
<div class="row no-gutters bg-white">
    <div class="col-12">
        <form action="{{ route('admin.notify.email-file.update',$file) }}" method="post" enctype="multipart/form-data" class="padding-30">
            @csrf
            @method('put')

            <div class="file-upload">
                <div class="i-file-upload">
                    <span>آپلود فایل </span>
                    <input type="file" class="file-upload" id="files" name="file"/>
                </div>
                <span class="filesize"></span>
                <span class="selectedFiles">فایلی انتخاب نشده است</span>
            </div>
            @error('file')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror
        <select name="status" >
            <option value="">وضعیت</option>
            <option value="0" @if (old('status',$file->status) == 0) selected @endif>غیر  فعال</option>
            <option value="1" @if (old('status',$file->status) == 1) selected @endif>فعال </option>
        </select>
        @error('status')
        <span class="text-error" role="alert">
            <strong>
                {{ $message }}
            </strong>
        </span>
    @enderror

            <div style="margin:5px"></div>
            <button class="btn btn-brand mt-5">اپلود</button>
        </form>
    </div>
</div>

@endsection
