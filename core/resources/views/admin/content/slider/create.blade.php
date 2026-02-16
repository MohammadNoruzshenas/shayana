@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.content.slider.index') }}">اسلایدر</a></li>
    <li><a href="">افزودن اسلایدر</a></li>


@endsection
@section('content')
<p class="box__title">ایجاد اسلاید جدید</p>
<div class="row no-gutters bg-white">
    <div class="col-12">
        <form action="{{ route('admin.content.slider.store') }}" enctype="multipart/form-data" method="post" class="padding-30">
            @csrf
            <input type="text" name="title" value="{{ old('title') }}" class="text" placeholder="عنوان اسلاید">
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
        <p class="margin-bottom-15">وضعیت</p>
        <select name="status" id="">
            <option value="1">فعال</option>
            <option value="0">غیرفعال</option>

        </select>
        @error('status')
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
