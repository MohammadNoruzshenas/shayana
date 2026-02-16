@extends('admin.layouts.master')
@section('head-tag')
    <title>اپلود فایل</title>
    <link rel="stylesheet" href="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/resumable/style.css') }}">


@endsection
@section('breadcrumb')
    <li><a href="{{ route('admin.content.media.index') }}">مدیا</a></li>
    <li><a href="{{ route('admin.content.media.create') }}">افزودن مدیا جدید</a></li>
@endsection
@section('content')
    <p class="box__title">اپلودر</p>
    <div class="row no-gutters bg-white">
        <div class="col-12">
            <form action="{{ route('admin.content.media.store') }}" method="post" enctype="multipart/form-data"
                class="padding-30">
                @csrf
                <input type="text" value="{{ old('title') }}" name="title" class="text" placeholder="عنوان">
                @error('title')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <select name="is_private" id="is_private">
                    <option value="">دسترسی</option>
                    <option value="0" @if (old('is_private') == 0) selected @endif>عمومی</option>
                    <option value="1" @if (old('is_private') == 1) selected @endif>خصوصی</option>
                </select>
                @error('is_private')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                @permission('manage_uploader')
                    <div id="disk" class="d-none">
                        <span>فضای اپلود</span>
                        <select name="disk">
                            <option value="local" @if (old('disk') == 'local') selected @endif>فضای هاست(سرور)</option>
                            {{-- <option value="ftp" @if (old('disk') == 'ftp') selected @endif>FTP</option> --}}
                            <option value="s3" @if (old('disk') == 's3') selected @endif>S3</option>

                        </select>
                        @error('disk')
                            <span class="text-error" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </div>
                    <div id="private">
                    </div>
                @endpermission
                <br>
                <div style="margin:5px"></div>
                <button class="btn btn-brand mt-5">ایجاد</button>
            </form>
        </div>
    </div>
@endsection


@section('script')
    <script>
                $("#is_private").change(function() {
            if ($('#is_private').find(':selected').val() == '1') {
                $('#disk').removeClass('d-none');
            } else {
                $('#disk').addClass('d-none');
            }
        });
    </script>


@endsection
