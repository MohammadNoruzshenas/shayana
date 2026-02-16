@extends('admin.layouts.master')
@section('head-tag')
    <title>ایچاد اطلاعیه جدید</title>
    <link rel="stylesheet" href="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection
@section('breadcrumb')
    <li><a href="#"> اطلاعیه ها</a></li>
    <li><a href="{{ route('admin.notify.notification.index') }}"> اعلان </a></li>
    <li><a href="{{ route('admin.notify.notification.create') }}"> ایجاد اعلان </a></li>
@endsection
@section('content')
    <p class="box__title">ایجاد اعلان  </p>
    <div class="row no-gutters bg-white">
        <div class="col-12">
            <form action="{{ route('admin.notify.notification.update',$notification) }}" method="post" enctype="multipart/form-data"
                class="padding-30">
                @csrf
                @method('put')
                <input type="text" value="{{ old('title',$notification->title) }}" name="title" class="text" placeholder="عنوان ">
                @error('title')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror


                <select name="status">
                    <option value="">وضعیت</option>
                    <option value="0" @if (old('status',$notification->status) == 0) selected @endif>غیر فعال</option>
                    <option value="1" @if (old('status',$notification->status) == 1) selected @endif>فعال </option>
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
                    <option value="1" @if(!is_null($notification->course_id)) selected @endif>دوره</option>
                </select>

                <div class="@if(is_null($notification->course_id)) d-none @endif" id="course">
                    <p>دوره</p>
                    <select name="course_id">
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" @if($notification->course_id == $course->id) selected @endif>{{ $course->title }}</option>
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



                <textarea name="description" placeholder="متن" required class="text h">{{ old('description',$notification->description) }}</textarea>
                @error('description')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
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
        $(document).ready(function() {
            $('#published_at_view').persianDatepicker({
                format: 'YYYY/MM/DD',
                altField: '#published_at'
            })
        });
        $("#type").change(function() {

            if ($('#type').find(':selected').val() == '1') {
                $('#course').removeClass('d-none');
            } else {
                $('#course').addClass('d-none');
            }
        });
    </script>
@endsection
