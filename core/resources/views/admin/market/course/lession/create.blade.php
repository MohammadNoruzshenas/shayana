@extends('admin.layouts.master')
@section('breadcrumb')
    <li>
        <a href="{{ route('admin.market.course.index') }}" title="دوره ها">دوره ها</a>
    </li>
    <li>
        <a href="{{ route('admin.market.course.index', $course) }}" title="{{ $course->title }}">{{ $course->title }}</a>
    </li>
    {{-- <li>
        <a href="{{ route('admin.market.course.lession.index', $course) }}" title=" دوره ها">قسمت ها</a>
    </li> --}}
    <li>
        <a title=" دوره ها">افزودن قسمت جدید</a>
    </li>
@endsection
@section('content')
    <p class="box__title">ایجاد جلسه جدید</p>
    <div class="row no-gutters bg-white">

        <div class="col-12">
            <form action="{{ route('admin.market.course.lession.store', ['course' => $course,'season' => $season]) }}" method="post"
                enctype="multipart/form-data" class="padding-30">
                @csrf
                <input type="text" name="title" value="{{ old('title') }}" class="text" placeholder="عنوان درس">
                @error('title')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror

                <input type="text" name="time" value="{{ old('time') }}" class="text" placeholder="زمان درس">
                @error('time')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <p class="margin-bottom-15">ایا این درس رایگان است ؟</p>
                <select name="is_free" id="">
                    <option value="0" @if (old('is_free') == 0) selected @endif>بله</option>
                    <option value="1" @if (old('is_free') == 1) selected @endif>خیر</option>

                </select>
                @error('is_free')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror



                <p class="margin-bottom-15">انتخاب سر فصل</p>
                <select name="season_id" id="">
                    @foreach ($seasons as $season)
                        <option value="{{ $season->id }}" @if (old('season_id') == $season->id) selected @endif>
                            {{ $season->title }}</option>
                    @endforeach
                </select>
                @error('season_id')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror


                <input type="text" name="link" value="{{ old('link') }}" class="text" placeholder="لینک ">
                @error('link')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <input type="text" name="file_link" value="{{ old('file_link') }}" class="text"
                    placeholder="لینک پیوست ">
                @error('file_link')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror

                <p class="margin-bottom-15">تعداد قسط برای نمایش جلسه</p>
                <input type="number" name="installment_show_count" value="{{ old('installment_show_count', 1) }}" class="text" 
                    placeholder="تعداد قسط برای نمایش" min="1">
                @error('installment_show_count')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror

                <textarea name="body" placeholder="توضیحات جلسه" class="text h">{{ old('body') }}</textarea>
                <button class="btn btn-brand">افزودن جلسه</button>
            </form>
        </div>
    </div>
    </div>
    </div>
@endsection
