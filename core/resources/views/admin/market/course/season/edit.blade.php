@extends('admin.layouts.master')
@section('breadcrumb')
    <li>
        <a href="{{ route('admin.market.course.index') }}" title="دوره ها">دوره ها</a>
    </li>
    <li>
        <a href="{{ route('admin.market.course.details',$course->id) }}" title="{{ $course->title }}">{{ $course->title }}</a>
    </li>
    <li>
        <a  title=" دوره ها">ویرایش سرفصل</a>
    </li>
    <li>
        <a href="{{route('admin.market.course.session.edit', ['course' => $course->id,'season' => $season->id])}}" title=" دوره ها">{{ $season->title}}</a>
    </li>
@endsection
@section('content')
    <div class="main-content font-size-13">
        <div class="row no-gutters bg-white margin-bottom-20">
            <div class="col-12">
                <p class="box__title">ویرایش  سرفصل</p>
                <form action="{{ route('admin.market.course.session.update', ['course' => $course->id,'season' => $season->id]) }}" class="padding-30"
                    method="post">
                    {{ method_field('put') }}
                    @csrf

                    <input type="text" name="title" value="{{ old('title', $season->title) }}" class="text"
                        placeholder="عنوان">
                    @error('title')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror

                    <select name="parent_id" class="text">
                        <option value="">انتخاب سرفصل والد (اختیاری)</option>
                        @foreach($course->season()->where('id', '!=', $season->id)->orderBy('number', 'asc')->get() as $seasonOption)
                            <option value="{{ $seasonOption->id }}" {{ old('parent_id', $season->parent_id) == $seasonOption->id ? 'selected' : '' }}>
                                {{ $seasonOption->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror






                    <button class="btn btn-brand">به روزرسانی</button>
                </form>

            </div>
        </div>
    </div>
@endsection
