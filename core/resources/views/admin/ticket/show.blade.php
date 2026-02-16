@extends('admin.layouts.master')
@section('head-tag')
<title>پاسخ به تیکت</title>
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
<li><a href="{{ route('admin.ticket.index') }}">تیکت ها</a></li>
@endsection
@section('content')
<p class="box__title"> عنوان تیکت : {{$ticket->subject}} -- {{ $ticket->user->full_name }}</p>
<div class="row no-gutters bg-white">
    <div class="col-12" style="padding: 2rem">

        <div class="message-orange">
            <p class="message-content">{{$ticket->description}} </p>
            <br>
            <div class="message-timestamp-left">{{ jdate($ticket->created_at) }}</div>
        </div>

        @foreach ($ticket->children as $children)
        @if ($children->user->id == $ticket->user->id)
        <div class="message-orange">
            <span style="font-size : 16px;color:black">{{ $children->user->full_name }}</span>
            <p class="message-content">{{$children->description}} </p>
            <br>
            <div class="message-timestamp-left">{{ jdate($children->created_at) }}</div>

        </div>
        @if ($children->file()->count() > 0)

        <div class="message-file">
            <a type="button" style="display:flex; align-items:center; gap:10px"  class="btn d delete-btn" href="{{asset($children->file->file_path)}}" download>دانلود فایل ضمیمه
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24px" height="24px">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                  </svg>

                </a>
        </div>
        @endif


        @else
        <div class="message-blue">
            <span style="font-size : 16px;color:black">{{ $children->user->full_name }}:</span>
            <p class="message-content">{{ $children->description }}</p>
            <br>
            <div class="message-timestamp-left">{{ jdate($children->created_at) }}</div>
        </div>
        @endif
        @endforeach
        <form action="{{ route('admin.ticket.answer',$ticket) }}" method="post" enctype="multipart/form-data"
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
            <input hidden type="file" name="file" id="fileTicketInp">

            <button type="button" onclick="document.querySelector('#fileTicketInp').click()" style="display:flex; align-items:center; gap:10px"  class="btn d delete-btn">انتخاب فایل ضمیمه
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24px" height="24px">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
              </svg>

            </button>

            <div style="margin:10px"></div>
            <p>وضعیت : </p>
            <select name="status">
                <option value="0" @if (old('status')==0) selected @endif>بسته</option>
                <option value="1" @if (old('status')==1) selected @endif>در انتظار پاسخ کاربر</option>
                <option value="2" @if (old('status')==2) selected @endif>در انتظار بررسی</option>
            </select>
            @error('status')
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
