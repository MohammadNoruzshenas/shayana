@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.content.category.index') }}">دسته بندی پست ها</a></li>
    <li><a href="" >{{ $podcastCategory->title }}</a></li>
    <li><a href="" >ویرایش</a></li>
@endsection

@section('content')
    <div class="main-content font-size-13">
        <div class="row no-gutters bg-white margin-bottom-20">
            <div class="col-12">
                <p class="box__title">ویرایش دسته بندی</p>
                <form action="{{ route('admin.content.podcastCategory.update', $podcastCategory->id) }}" class="padding-30"
                    method="post">
                    {{ method_field('put') }}
                    @csrf

                    <input type="text" name="title" required value="{{ old('name', $podcastCategory->title) }}" class="text"
                        placeholder="نام دسته">
                    @error('title')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror

                    <p class="margin-bottom-15">وضعیت</p>
                    <select name="status" id="">
                        <option value="1" @if (old('status', $podcastCategory->status) == 1) selected @endif>فعال</option>
                        <option value="0" @if (old('status', $podcastCategory->status) == 0) selected @endif>غیرفعال</option>
                    </select>
                    {{-- <p class="margin-bottom-15">نمایش در منو</p>
                    <select name="show_in_menu" id="">
                        <option value="1" @if (old('show_in_menu', $podcastCategory->status) == 1) selected @endif>فعال</option>
                        <option value="0" @if (old('show_in_menu', $podcastCategory->status) == 0) selected @endif>غیرفعال</option>
                    </select> --}}
                    <p class="mb-5 font-size-14"> توضیحات متا : </p>
                    <textarea name="meta_description" id="meta_description" placeholder="meta description"  class="text h ltr-text">{{ old('meta_description', $podcastCategory->meta_description) }}</textarea>
                    @error('meta_description')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror

                    <p class="margin-bottom-15">انتخاب دسته پدر</p>

                    <select name="parent_id" id="">
                        <option value="">ندارد</option>
                        @foreach ($postCategories as $categoryItem)

                        <option value="{{ $categoryItem->id }}" @if ($categoryItem->id == $podcastCategory->parent_id) selected @endif>
                            {{ $categoryItem->title }}</option>
                    @endforeach
                    </select>

                    </select>





                    <button class="btn btn-brand">به روزرسانی</button>
                </form>

            </div>
        </div>
    </div>
@endsection
