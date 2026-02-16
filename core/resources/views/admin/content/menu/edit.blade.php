@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.content.menu.index') }}">منوها</a></li>
    <li><a href="" >{{ $menu->name }}</a></li>
    <li><a href="" >ویرایش</a></li>
@endsection

@section('content')
    <div class="main-content font-size-13">
        <div class="row no-gutters bg-white margin-bottom-20">
            <div class="col-12">
                <p class="box__title">ویرایش منو </p>
                <form action="{{ route('admin.content.menu.update', $menu->id) }}" class="padding-30"
                    method="post">
                    {{ method_field('put') }}
                    @csrf
                    <p class="mb-5 font-size-14">نام منو : </p>
                    <input type="text" value="{{ old('name',$menu->name) }}" name="name" placeholder="نام  منو" class="text">
                    @error('name')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <p class="mb-5 font-size-14"> آدرس منو : </p>
                <input type="text" value="{{ old('url',$menu->url) }}" name="url" placeholder="ادرس  (url)" class="text ltr-text">
                @error('url')
                <span class="text-error" role="alert">
                    <strong>
                        {{ $message }}
                    </strong>
                </span>
            @enderror
            <p class="mb-5 font-size-14">الویت نمایش  : </p>
            <input type="text" value="{{ old('priority',$menu->priority) }}" name="priority" placeholder="الویت نمایش" class="text">
            @error('priority')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror
                    <p class="margin-bottom-15">انتخاب دسته پدر</p>
                    <select name="parent_id" id="">
                        <option value="">ندارد</option>

                        @foreach ($parent_menus as  $parent_menu)

                        <option value="{{ $parent_menu->id }}" @if($parent_menu->id == $menu->parent_id) selected @endif>{{ $parent_menu->name }}</option>

                        @endforeach
                    </select>
                    @error('parent_id')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                    <p class="margin-bottom-15">وضعیت</p>
                    <select name="status" id="">
                        <option value="1" @if (old('status',$menu->status == 1)) selected @endif>فعال</option>
                        <option value="0" @if (old('status',$menu->status == 0)) selected @endif>>غیرفعال</option>

                    </select>
                    @error('status')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                    <button class="btn btn-brand">ویرایش کردن</button>
                </form>
            </div>
        </div>
    </div>
@endsection
