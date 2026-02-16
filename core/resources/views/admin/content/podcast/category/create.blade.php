<div class="col-4 bg-white">
    <p class="box__title">ایجاد دسته بندی جدید</p>
    <form action="{{ route('admin.content.podcastCategory.store') }}" method="post" class="padding-30">
        @csrf
        <input type="text" name="title" required placeholder="نام دسته بندی" class="text">
        @error('title')
        <span class="text-error" role="alert">
            <strong>
                {{ $message }}
            </strong>
        </span>
    @enderror


        <p class="margin-bottom-15">انتخاب دسته پدر</p>
        <select name="parent_id" id="">
            <option value="">ندارد</option>
            @foreach ($podcastCategories as  $podcastCategory)
            <option value="{{ $podcastCategory->id }}">{{ $podcastCategory->title }}</option>
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
            <option value="1">فعال</option>
            <option value="0">غیرفعال</option>

        </select>
        @error('status')
        <span class="text-error" role="alert">
            <strong>
                {{ $message }}
            </strong>
        </span>
    @enderror
    <p class="mb-5 font-size-14"> توضیحات متا :  (اجباری)</p>
    <textarea name="meta_description" id="meta_description" placeholder="meta_description "  class="text h ltr-text">{{ old('meta_description') }}</textarea>
    @error('meta_description')
        <span class="text-error" role="alert">
            <strong>
                {{ $message }}
            </strong>
        </span>
    @enderror
        {{-- <p class=" margin-bottom-15">نمایش در منو </p>
        <select name="show_in_menu" id="">
            <option value="1">نمایش بده</option>
            <option value="0">نمایش نده</option>

        </select>
        @error('show_in_menu')
        <span class="text-error" role="alert">
            <strong>
                {{ $message }}
            </strong>
        </span>
    @enderror --}}

        <button class="btn btn-brand">اضافه کردن</button>
    </form>
</div>
