@extends('admin.layouts.master')
@section('head-tag')
<title>ویرایش دسته بندی دوره ها</title>
@endsection
@section('breadcrumb')
    <li><a href="{{ route('admin.market.category.index') }}" title="دسته بندی ها">دسته بندی ها</a></li>
    <li><a href="{{ route('admin.market.category.edit',$courseCategory) }}" title="ویرایش دسته بندی ها">ویرایش دسته بندی</a></li>
    <li><a title="{{$courseCategory->title}}">{{$courseCategory->title}}</a></li>


@endsection

@section('content')
    <div class="main-content font-size-13">
        <div class="row no-gutters bg-white margin-bottom-20">
            <div class="col-12">
                <p class="box__title">ویرایش دسته بندی</p>
                <form action="{{ route('admin.market.category.update', $courseCategory->id) }}" class="padding-30"
                    method="post">
                    {{ method_field('put') }}
                    @csrf

                    <input type="text" name="title" required value="{{ old('name', $courseCategory->title) }}" class="text"
                        placeholder="نام دسته">
                    @error('title')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror
                    <p class="mb-5 font-size-14">code svg : </p>
                    <textarea name="svg_code" id="svg_code" placeholder="کد اس وی جی"  class="text h ltr-text">{{ old('svg_code', $courseCategory->svg_code) }}</textarea>
                    @error('svg_code')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>

                    @enderror
                    <p class="mb-5 font-size-14"> توضیحات متا : </p>
                    <textarea name="meta_description" id="meta_description" placeholder="meta description"  class="text h ltr-text">{{ old('meta_description', $courseCategory->meta_description) }}</textarea>
                    @error('meta_description')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror

                    <p class="margin-bottom-15">وضعیت</p>
                    <select name="status" id="">
                        <option value="1" @if (old('status', $courseCategory->status) == 1) selected @endif>فعال</option>
                        <option value="0" @if (old('status', $courseCategory->status) == 0) selected @endif>غیرفعال</option>
                    </select>
                    {{-- <p class="margin-bottom-15">نمایش در منو</p>
                    <select name="show_in_menu" id="">
                        <option value="1" @if (old('show_in_menu', $courseCategory->status) == 1) selected @endif>فعال</option>
                        <option value="0" @if (old('show_in_menu', $courseCategory->status) == 0) selected @endif>غیرفعال</option>
                    </select> --}}


                    <p class="margin-bottom-15">انتخاب دسته پدر</p>

                    <select name="parent_id" id="">
                        <option value="">ندارد</option>
                        @foreach ($courseCategories as $categoryItem)

                            <option value="{{ $categoryItem->id }}" @if ($categoryItem->id == $courseCategory->parent_id) selected @endif>
                                {{ $categoryItem->title }}</option>
                        @endforeach
                    </select>






                    <button class="btn btn-brand">ویرایش</button>
                </form>

            </div>
        </div>
    </div>
@endsection
