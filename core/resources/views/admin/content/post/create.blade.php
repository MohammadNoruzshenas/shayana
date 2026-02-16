@extends('admin.layouts.master')
@section('head-tag')
    <title>ایچاد مطلب جدید</title>
    <link rel="stylesheet" href="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection
@section('breadcrumb')
    <li><a href="{{ route('admin.content.post.index') }}">مقالات</a></li>

    <li><a href="{{ route('admin.content.post.create') }}" title="یجاد مطلب جدید">ایجاد مطلب جدید</a></li>
@endsection
@section('content')
    <p class="box__title">ایجاد مطلب جدید</p>
    <div class="row no-gutters bg-white">
        <div class="col-12">
            <form action="{{ route('admin.content.post.store') }}" method="post" enctype="multipart/form-data"
                class="padding-30">
                @csrf
                <p class="mb-5 font-size-14"> عنوان مطلب : </p>
                <input type="text" value="{{ old('title') }}" name="title" class="text" placeholder="عنوان مطلب">
                @error('title')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                @permission('manage_post')
                <p class="mb-5 font-size-14">انتخاب نویسنده : </p>
                    <select name="author_id">
                        <option value="">انتخاب نویسنده</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @if (old('author_id') == $user->id) selected @endif>
                                {{ $user->FullName }}</option>
                        @endforeach
                    </select>
                    @error('author_id')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror


                    <p class="mb-5 font-size-14">وضعیت  : </p>
                    <select name="status">
                        <option value="">وضعیت</option>
                        <option value="0" @if (old('status') == 0) selected @endif>غیرفعال </option>
                        <option value="1" @if (old('status') == 1) selected @endif>فعال </option>
                    </select>
                    @error('status')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror
                @endpermission
                <p class="mb-5 font-size-14">دسته بندی  : </p>
                <select name="category_id">
                    <option value="">دسته بندی</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if (old('category_id') == $category->id) selected @endif>
                            {{ $category->title }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <p class="box__title">پست فقط برای اعضای ویژه باشد ؟</p>
                <br>
                <select name="is_vip" id="is_vip">
                    <option value="0" @if (old('is_vip') == 0) selected @endif>خیر </option>
                    <option value="1" @if (old('is_vip') == 1) selected @endif>بله </option>
                </select>
                @error('is_vip')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <input type="text" id="limit_body" value="{{ old('limit_body') }}" name="limit_body" class="text d-none"
                    placeholder="تعداد کارکتر نمایش برای کسانی که اشتراک تهیه نکردن">
                @error('limit_body')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <div class="file-upload">
                    <div class="i-file-upload">
                        <span>آپلود تصویر شاخص</span>
                        <input type="file" class="file-upload" id="files" name="image" />
                    </div>
                    <span class="filesize"></span>
                    <span class="selectedFiles">فایلی انتخاب نشده است</span>
                </div>
                @error('image')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror

                <section class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="">تاریخ انتشار</label>
                        <input type="text" name="published_at" id="published_at" class="text w-10 d-none">
                        <input type="text" id="published_at_view" class="text w-10">
                    </div>
                    @error('published_at')
                        <span class="alert_required  text-error p-1 rounded" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror
                </section>
                <textarea name="body" id="upload" placeholder="متن" class="text h">{{ old('body') }}</textarea>
                @error('body')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <br>

                <textarea name="summary" id="summary" placeholder="خلاصه" class="text h">{{ old('summary') }}</textarea>
                @error('summary')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <div style="margin:5px"></div>
                <button class="btn btn-brand mt-5">ایجاد مقاله</button>
            </form>
        </div>
    </div>

@endsection

@section('script')
    {{-- <script src="{{ asset('dashboard/js/ckeditor/ckeditor.js') }}"></script> --}}
    <script src="{{ asset('dashboard/js/jalalidatepicker/persian-date.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#published_at_view').persianDatepicker({
                format: 'YYYY/MM/DD',
                altField: '#published_at',
                autoClose: true
            })
        });

        $("#is_vip").change(function() {
            if ($('#is_vip').find(':selected').val() == '1') {

                $('#limit_body').removeClass('d-none');
            } else {
                $('#limit_body').addClass('d-none');
            }
        });
    </script>
    <script>
        ClassicEditor.create(document.querySelector('#upload'), {
                ckfinder: {
                    uploadUrl: '{{ route('admin.content.media.uploadCkeditorImage') . '?_token=' . csrf_token() }} '
                },

                language: {
                    // The UI will be English.
                    ui: 'fa',

                    // But the content will be edited in Arabic.
                    content: 'fa'
                }
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(err => {
                console.error(err.stack);
            });
    </script>
@endsection
