@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.content.slider.index') }}">اسلایدر</a></li>
    <li><a href="">{{ $slider->title }}</a></li>
    <li><a href="{{ route('admin.content.slider.edit',$slider) }}">ویرایش</a></li>
@endsection
@section('content')
<p class="box__title">ویراش اسلاید ({{$slider->title}})</p>
<div class="row no-gutters bg-white">
    <div class="col-12">
        <form action="{{ route('admin.content.slider.update',$slider->id) }}" enctype="multipart/form-data" method="post" class="padding-30">
            @csrf
            @method('put')
            <input type="text" name="title" value="{{ old('title',$slider->title) }}" class="text" placeholder="عنوان اسلاید">
            @error('title')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror

            <div class="file-upload">
                <div class="i-file-upload">
                    <span>آپلود تصویر</span>
                    <input type="file" class="file-upload" name="banner"/>
                </div>
                <span class="filesize"></span>
                <span class="selectedFiles">فایلی انتخاب نشده است</span>
            </div>
            @error('banner')
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
