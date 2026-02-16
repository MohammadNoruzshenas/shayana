<div class="col-4 bg-white">
    <p class="box__title">ایجاد منو</p>
    <form action="{{ route('admin.content.menu.store') }}" method="post" class="padding-30">
        @csrf
        <input type="text" name="name" value="{{ old('name') }}" placeholder="نام  منو" class="text">
        @error('name')
        <span class="text-error" role="alert">
            <strong>
                {{ $message }}
            </strong>
        </span>
    @enderror
    <input type="text" name="url" value="{{ old('url') }}" placeholder="ادرس  (url)" class="text ltr-text">
    @error('url')
    <span class="text-error" role="alert">
        <strong>
            {{ $message }}
        </strong>
    </span>
@enderror
<input type="text" name="priority" value="{{ old('priority') }}" placeholder="الویت نمایش" class="text">
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
            <option value="{{ $parent_menu->id }}" @if(!empty($menu) && old('parent_id') == $menu->id) selected @endif>{{ $parent_menu->name }}</option>
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
            <option value="0" @if(old('status') == 0) selected @endif>غیرفعال</option>
            <option value="1" @if(old('status') == 1) selected @endif>فعال</option>

        </select>
        @error('status')
        <span class="text-error" role="alert">
            <strong>
                {{ $message }}
            </strong>
        </span>
    @enderror
        <button class="btn btn-brand">اضافه کردن</button>
    </form>
</div>
