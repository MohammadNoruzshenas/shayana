@extends('admin.layouts.master')
@section('head-tag')
<title>ایچاد اطلاعیه جدید</title>
<link rel="stylesheet" href="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection
@section('breadcrumb')
    <li><a href="#"> اطلاعیه ها</a></li>
    <li><a href="{{ route('admin.notify.sms.index') }}"> اطلاعیه پیامکی</a></li>
    <li><a href="{{ route('admin.notify.sms.edit',$sms) }}"> ویرایش اطلاعیه پیامکی</a></li>
    <li><a>{{ $sms->title }}</a></li>

@endsection
@section('content')
<p class="box__title">ویرایش اطلاعیه {{$sms->title}}</p>
<div class="row no-gutters bg-white">
    <div class="col-12">
        <form action="{{ route('admin.notify.sms.update',$sms) }}" method="post" enctype="multipart/form-data" class="padding-30">
            @csrf
            @method('put')
            <input type="text" value="{{ old('title',$sms->title) }}"  name="title" class="text" placeholder="عنوان ">
            @error('title')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror


            <select name="status" >
                <option value="">وضعیت</option>
                <option value="0" @if (old('status',$sms->status) == 0) selected @endif>غیر  فعال</option>
                <option value="1" @if (old('status',$sms->status) == 1) selected @endif>فعال </option>
            </select>
            @error('status')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror

        <select name="type" id="type">
            <option value="0">همه</option>
            <option value="1" @if(!is_null($sms->course_id)) selected @endif>دوره</option>
        </select>

        <div class="@if(is_null($sms->course_id)) d-none @endif" id="course">
            <p>دوره</p>
            <select name="course_id">
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}" @if($sms->course_id == $course->id) selected @endif>{{ $course->title }}</option>
                @endforeach

            </select>
            @error('course_id')
                <span class="text-error" role="alert">
                    <strong>
                        {{ $message }}
                    </strong>
                </span>
            @enderror
        </div>
        {{-- دریافت کنندگان
            <select name="receive_it">
                <option value="1" @if(old('receive_it',$sms->receive_it) == 1) selected @endif>همه</option>
                <option value="2" @if(old('receive_it',$sms->receive_it) == 2) selected @endif>فقط کسانی که دوره خریدن</option>
                <option value="3" @if(old('receive_it',$sms->receive_it) == 3) selected @endif>فقط کسانی که دوره نخریدن</option>
                <option value="4" @if(old('receive_it',$sms->receive_it) == 4) selected @endif>مدیران</option>



            </select>
            @error('receive_it')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror --}}

        {{-- <section class="col-12 col-md-6">
            <div class="form-group">
                <label for="">تاریخ انتشار</label>
                <input type="text" name="published_at" id="published_at" class="text w-10 d-none">
                <input type="text" id="published_at_view" class="text w-10">
            </div>
            @error('published_at')
            <span class="alert_required  text-error p-1 rounded" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror
        </section> --}}
            <textarea name="body" id="body" placeholder="متن" class="text h">{{ old('body',$sms->body) }}</textarea>
            @error('body')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror
        <div style="margin:5px"></div>
            <div style="margin:5px"></div>
            <button class="btn btn-brand mt-5">ویرایش </button>
        </form>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('dashboard/js/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('dashboard/js/jalalidatepicker/persian-date.min.js') }}"></script>
<script src="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.js') }}"></script>


<script>
     $("#type").change(function() {

if ($('#type').find(':selected').val() == '1') {
    $('#course').removeClass('d-none');
} else {
    $('#course').addClass('d-none');
}
});
    $(document).ready(function () {
        $('#published_at_view').persianDatepicker({
            format: 'YYYY/MM/DD',
            altField: '#published_at'
        })
    });

</script>

@endsection
