@extends('admin.layouts.master')
@section('head-tag')
<title>پاسخ به تماس</title>
<link rel="stylesheet" href="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.css') }}">

<style>
    .message-blue {
        position: relative;
        margin-left: 20px;
        margin-bottom: 10px;
        padding:15px;
        background-color: #A8DDFD;
        width: 200px;
        height: auto;
        font: 400 .9em 'Vazirmatn', sans-serif;
        border: 1px solid #97C6E3;
        border-radius: 10px;

    }

    .message-orange {
        position: relative;
         margin-bottom: 10px;
        margin-right: calc(100% - 240px);
        padding: 15px;
        background-color: #f8e896;
        width: auto;
        height: auto;
        text-align: left;
        font: 400 .9em 'Vazirmatn', sans-serif;
        border: 1px solid #dfd087;
        border-radius: 10px;
    }
    .message-file{
        position: relative;
        margin-bottom: 10px;
        margin-right: calc(100% - 240px);
        width: auto;
        height: auto;
        text-align: left;
    }

    .message-content {
        padding: 0;
        margin: 0;
        margin-top : 10px;
        color: black;

    }

    .message-timestamp-right {
        position: absolute;
        font-size: .85em;
        font-weight: 300;
        bottom: 5px;
        right: 5px;
    }

    .message-timestamp-left {
        position: absolute;
        font-size: .85em;
        font-weight: 300;
        bottom: 5px;
        left: 5px;
        color: black

    }

    .message-blue:after {
        content: '';
        position: absolute;
        width: 0;
        height: 0;
        border-top: 15px solid #A8DDFD;
        border-left: 15px solid transparent;
        border-right: 15px solid transparent;
        top: 0;
        right: -15px;
    }

    .message-blue:before {
        content: '';
        position: absolute;
        width: 0;
        height: 0;
        border-top: 17px solid #97C6E3;
        border-left: 16px solid transparent;
        border-right: 16px solid transparent;
        top: -1px;
        right: -17px;
    }

    .message-orange:after {
        content: '';
        position: absolute;
        width: 0;
        height: 0;
        border-bottom: 15px solid #f8e896;
        border-left: 15px solid transparent;
        border-right: 15px solid transparent;
        bottom: 0;
        left: -15px;
    }

    .message-orange:before {
        content: '';
        position: absolute;
        width: 0;
        height: 0;
        border-bottom: 17px solid #dfd087;
        border-left: 16px solid transparent;
        border-right: 16px solid transparent;
        bottom: -1px;
        left: -17px;
    }
    </style>
@endsection
@section('breadcrumb')
<li><a href="{{ route('admin.contact.index') }}">تماس ها</a></li>
@endsection
@section('content')
<p class="box__title"> عنوان تماس : {{$contact->title}} -- {{ $contact->full_name }}</p>
<div class="row no-gutters bg-white">
    <div class="col-12" style="padding: 2rem">

        <div class="message-orange">
            <p class="message-content">{!! $contact->description !!} </p>
        </div>

         @foreach ($contact->children as $children)
        <div class="message-blue">
            <span style="font-size : 16px;color:black">{{ $children->full_name }}</span>
            <p class="message-content">{{ $children->description }}</p>
            <div class="message-timestamp-left">{{ jalaliDate($children->created_at) }}</div>
        </div>
        @endforeach

        <form action="{{ route('admin.contact.answer',$contact) }}" method="post"
            class="padding-30">
            @csrf
            <p>پاسخ</p>
            <textarea type="text" name="description" id="upload"
                class="text text-left mlg-15">{{ old('description') }}</textarea>
            @error('description')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
            @enderror

            <div style="margin:10px"></div>
            <p>ارسال پاسخ در : </p>
            <select name="send_message">
                <option value="0" @if (old('send_message')==0) selected @endif>ایمیل</option>
                <option value="1" @if (old('send_message')==1) selected @endif>اس ام اس</option>
            </select>
            @error('send_message')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
            @enderror

            <div style="margin:5px"></div>
            <button class="btn btn-brand mt-5">ارسال</button>

        </form>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('dashboard/js/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('dashboard/js/jalalidatepicker/persian-date.min.js') }}"></script>
<script src="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.js') }}"></script>

@endsection
