@extends('admin.layouts.master')

@section('head-tag')
<link rel="stylesheet" href="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection
@section('breadcrumb')
<li><a href="{{ route('admin.content.ads.index') }}">تبلیغات</a></li>
<li><a href="{{ route('admin.content.ads.edit',$ads) }}">ویرایش</a></li>

@endsection
@section('content')

<p class="box__title">ایجاد تبلیغات جدید</p>
<div class="row no-gutters bg-white">
    <div class="col-12">
        <form action="{{ route('admin.content.ads.update',$ads) }}" enctype="multipart/form-data" method="post" class="padding-30">
            @csrf
            @method('put')
            <input type="text" name="title" value="{{ old('title',$ads->title) }}" class="text" placeholder="عنوان تبلیغ">
            @error('title')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror
            <input type="text" name="link" value="{{ old('link',$ads->link) }}" class="text text-left " placeholder="لینک تبلیغ">
            @error('link')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror
        <input type="text" name="amount" value="{{ old('amount',numberFormat($ads->amount)) }}" class="text text-left " placeholder="مبلغ دریافت شده">
        @error('amount')
        <span class="text-error" role="alert">
            <strong>
                {{ $message }}
            </strong>
        </span>
    @enderror
    <input type="text" name="description" value="{{ old('description',$ads->description) }}" class="text text-left " placeholder="توضیحات پرداخت">
    @error('description')
    <span class="text-error" role="alert">
        <strong>
            {{ $message }}
        </strong>
    </span>
@enderror

<section class="col-12 col-md-6">
    <div class="form-group">
        <label for="">تاریخ شروع</label>
        <input type="text" name="start_at" id="start_at" class="text w-10 d-none">
        <input type="text" id="start_at_view" class="text w-10">
    </div>
    @error('start_at')
    <span class="alert_required  text-error p-1 rounded" role="alert">
        <strong>
            {{ $message }}
        </strong>
    </span>
@enderror
</section>


<section class="col-12 col-md-6">
    <div class="form-group">
        <label for="">تاریخ پایان</label>
        <input type="text" name="enddate_at" id="enddate_at" class="text w-10 d-none">
        <input type="text" id="enddate_at_view" class="text w-10">
    </div>
    @error('enddate_at')
    <span class="alert_required  text-error p-1 rounded" role="alert">
        <strong>
            {{ $message }}
        </strong>
    </span>
@enderror
</section>



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
        <select name="status">
            <option value="0" @if (old('status',$ads->status) == 0) selected @endif>غیر فعال</option>
            <option value="1" @if (old('status',$ads->status) == 1) selected @endif>فعال  </option>
        </select>
        @error('status')
        <span class="text-error" role="alert">
            <strong>
                {{ $message }}
            </strong>
        </span>
    @enderror
    <select name="position">
        <option value="0" @if (old('position',$ads->position) == 0) selected @endif>صفحات دوره ها و مقالات</option>
        <option value="1" @if (old('position',$ads->position) == 1) selected @endif>اولین بنر صفحه اصلی  </option>
        <option value="2" @if (old('position',$ads->position) == 2) selected @endif>دومین بنر صفحه اصلی  </option>

    </select>
    @error('position')
    <span class="text-error" role="alert">
        <strong>
            {{ $message }}
        </strong>
    </span>
@enderror
    <br>
            <button class="btn btn-brand">ذخیره</button>
        </form>
    </div>
</div>
</div>
</div>
@endsection

@section('script')
<script src="{{ asset('dashboard/js/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('dashboard/js/jalalidatepicker/persian-date.min.js') }}"></script>
<script src="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.js') }}"></script>

<script>
    $(document).ready(function () {
        $('#start_at_view').persianDatepicker({
            format: 'YYYY/MM/DD',
            altField: '#start_at',
            autoClose: true
        })
    });

</script>
<script>
    $(document).ready(function () {
        $('#enddate_at_view').persianDatepicker({
            format: 'YYYY/MM/DD',
            altField: '#enddate_at',
            autoClose: true
        })
    });

</script>
@endsection
