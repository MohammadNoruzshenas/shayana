@extends('admin.layouts.master')
@section('breadcrumb')
    <li>
        <a href="{{ route('admin.market.course.index') }}">دوره ها</a>
    </li>
    <li>
        <a href="{{ route('admin.market.course.index', $course) }}">{{ $course->title }}</a>
    </li>
    <li>
        {{-- <a href="{{ route('admin.market.course.lession-details.index', $course) }}">قسمت ها</a> --}}
    </li>
    <li>
        <a>ویرایش درس</a>
    </li>
    <li>
        {{-- <a
            href="{{ route('admin.market.course.lession-details.edit', ['course' => $course->id, 'lession' => $lession->id]) }}">{{ $lession->title }}
        </a> --}}
    </li>
@endsection
@section('content')
    <p class="box__title">ویرایش جلسه ({{ $lession->title }})</p>
    <div class="row no-gutters bg-white">
        <div class="col-12">
            <form
                action="{{ route('admin.market.course.lession.update', ['course' => $course->id, 'lession' => $lession->id]) }}"
                method="post" enctype="multipart/form-data" class="padding-30">
                @csrf
                @method('put')
                <input type="text" name="title" value="{{ old('title', $lession->title) }}" class="text"
                    placeholder="عنوان درس">
                @error('title')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror

                <input type="text" name="time" value="{{ old('time', $lession->time) }}" class="text"
                    placeholder="زمان درس">
                @error('time')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <p class="margin-bottom-15">ایا این درس رایگان است ؟</p>
                <select name="is_free" id="">
                    <option value="0" @if (old('is_free', $lession->is_free) == 0) selected @endif>بله</option>
                    <option value="1" @if (old('is_free', $lession->is_free) == 1) selected @endif>خیر</option>

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
                    <option value="">ندارد</option>
                    @foreach ($seasons as $season)
                        <option value="{{ $season->id }}" @if (old('season_id', $lession->season_id) == $season->id) selected @endif>
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

                <input type="text" name="link" value="{{ old('link', $lession->link) }}" class="text"
                    placeholder=" لینک ویدیو">
                @error('link')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <input type="text" name="file_link" value="{{ old('file_link',$lession->file_link) }}" class="text"
                    placeholder="لینک پیوست ">
                @error('file_link')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror

                <p class="margin-bottom-15">تعداد قسط برای نمایش جلسه</p>
                <input type="number" name="installment_show_count" value="{{ old('installment_show_count', $lession->installment_show_count) }}" class="text" 
                    placeholder="تعداد قسط برای نمایش" min="1">
                @error('installment_show_count')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror

                <textarea name="body" placeholder="توضیحات دوره" class="text h">{{ old('body', $lession->body) }}</textarea>
                <button class="btn btn-brand">ویرایش جلسه</button>
            </form>
        </div>
    </div>
    </div>
    </div>
@endsection
