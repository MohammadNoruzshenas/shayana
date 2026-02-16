@extends('admin.layouts.master')
@section('head-tag')
<title>ایچاد اطلاعیه جدید</title>
<link rel="stylesheet" href="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection
@section('breadcrumb')
    <li><a href="#"> اطلاعیه ها</a></li>
    <li><a href="{{ route('admin.notify.email.index') }}"> اطلاعیه ایمیلی</a></li>
    <li><a href="{{ route('admin.notify.email.create') }}"> ایجاد اطلاعیه ایمیلی</a></li>
@endsection
@section('content')
<p class="box__title">ایجاد اطلاعیه ایمیلی </p>
<div class="row no-gutters bg-white">
    <div class="col-12">
        <form action="{{ route('admin.notify.email.store') }}" method="post" enctype="multipart/form-data" class="padding-30">
            @csrf
            <input type="text" value="{{ old('subject') }}"  name="subject" class="text" placeholder="عنوان ">
            @error('subject')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror


            <select name="status" >
                <option value="">وضعیت</option>
                <option value="0" @if (old('status') == 0) selected @endif>غیر  فعال</option>
                <option value="1" @if (old('status') == 1) selected @endif>فعال </option>
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
            <option value="1">دوره</option>
        </select>

        <div class="d-none" id="course">
            <p>دوره</p>
            <select name="course_id">
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->title }}</option>
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
                <option value="1" @if(old('receive_it') == 0) selected @endif>همه</option>
                <option value="2" @if(old('receive_it') == 1) selected @endif>فقط کسانی که دوره خریدن</option>
                <option value="3" @if(old('receive_it') == 2) selected @endif>فقط کسانی که دوره نخریدن</option>
                <option value="4" @if(old('receive_it') == 3) selected @endif>مدیران</option>



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
            <textarea name="body" id="upload" placeholder="متن" class="text h">{{ old('body') }}</textarea>
            @error('body')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror
        <div style="margin:5px"></div>
            <div style="margin:5px"></div>
            <button class="btn btn-brand mt-5">ایجاد</button>
        </form>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('dashboard/js/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('dashboard/js/jalalidatepicker/persian-date.min.js') }}"></script>
<script src="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.js') }}"></script>


<script>


    ClassicEditor
        .create( document.querySelector('#upload'), {
            ckfinder:{
                uploadUrl:'{{ route('admin.content.media.uploadCkeditorImage').'?_token='.csrf_token()}} '
            },

            language: {
                // The UI will be English.
                ui: 'fa',

                // But the content will be edited in Arabic.
                content: 'fa'
            }
        } )
        .then( editor => {
            window.editor = editor;
        } )
        .catch( err => {
            console.error( err.stack );
        } );



    </script>
<script>
    $("#type").change(function() {

if ($('#type').find(':selected').val() == '1') {
    $('#course').removeClass('d-none');
} else {
    $('#course').addClass('d-none');
}
});
    $(document).ready(function() {
        $('#published_at_view').persianDatepicker({
            format: 'YYYY/MM/DD',
            altField: '#published_at',
            timePicker: {
                enabled: true,
                meridiem: {
                    enabled: true
                }
            }
        })
    });

</script>

@endsection
