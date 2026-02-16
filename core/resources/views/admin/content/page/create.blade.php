@extends('admin.layouts.master')
@section('head-tag')
<title>ایجاد صفحه</title>
<link rel="stylesheet" href="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.css') }}">

@endsection
@section('breadcrumb')
    <li><a href="{{ route('admin.content.page.create') }}">صفحه ساز</a></li>
@endsection
@section('content')
<p class="box__title">ایجاد صفحه جدید</p>
<div class="row no-gutters bg-white">
    <div class="col-12">
        <form action="{{ route('admin.content.page.store') }}" method="post" enctype="multipart/form-data" class="padding-30">
            @csrf
            <input type="text" value="{{ old('title') }}"  name="title" class="text" placeholder="عنوان صفحه">
            @error('title')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror


                <textarea type="text" name="body" id="upload"  class="text text-left mlg-15">
                {{ old('body') }}
                </textarea>
                @error('body')
                <span class="text-error" role="alert">
                    <strong>
                        {{ $message }}
                    </strong>
                </span>
            @enderror
            <div style="margin:5px"></div>


            <select name="status">
                <option value="0" @if (old('status') == 0) selected @endif>غیر فعال</option>
                <option value="1" @if (old('status') == 1) selected @endif>فعال  </option>
            </select>
            @error('status')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror
            <div style="margin:5px"></div>
            <button class="btn btn-brand mt-5">ایجاد صفحه</button>
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


@endsection
