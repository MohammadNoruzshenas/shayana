@extends('admin.layouts.master')
@section('head-tag')
<title>ایجاد کالا</title>
<link rel="stylesheet" href="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection
@section('breadcrumb')
    <li><a href="{{ route('admin.content.faq.index') }}">سوالات متداول</a></li>
    <li><a> ویرایش سوال</a></li>
    <li><a> {{$faq->question}}</a></li>

@endsection
@section('content')
<p class="box__title">ویرایش سوال </p>
<div class="row no-gutters bg-white">
    <div class="col-12">
        <form action="{{ route('admin.content.faq.update',$faq) }}" method="post" enctype="multipart/form-data" class="padding-30">
            @csrf
            @method('put')
            <input type="text" value="{{ old('question',$faq->question) }}"  name="question" class="text" placeholder="عنوان سوال">
            @error('question')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror

                <p>پاسخ</p>
                <textarea type="text" name="answer" class="text text-left mlg-15">
                {{ old('answer',$faq->answer) }}
                </textarea>
                @error('answer')
                <span class="text-error" role="alert">
                    <strong>
                        {{ $message }}
                    </strong>
                </span>
            @enderror
            <div style="margin:5px"></div>


            <select name="status">
                <option value="0" @if (old('status',$faq->status) == 0) selected @endif>غیر فعال</option>
                <option value="1" @if (old('status',$faq->status) == 1) selected @endif>فعال  </option>
            </select>
            @error('status')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror
            <div style="margin:5px"></div>
            <button class="btn btn-brand mt-5">ایجاد سوال</button>
        </form>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('dashboard/js/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('dashboard/js/jalalidatepicker/persian-date.min.js') }}"></script>
<script src="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.js') }}"></script>




@endsection
