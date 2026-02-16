@extends('admin.layouts.master')
@section('head-tag')
    <title>ویرایش دوره</title>
    <link rel="stylesheet" href="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection
@section('breadcrumb')
    <li>
        <a href="{{ route('admin.market.course.index') }}" title="دوره ها">دوره ها</a>
    </li>
    <li>
        <a href="{{ route('admin.market.course.details', $course->id) }}" title="{{ $course->title }}">{{ $course->title }}</a>
    </li>
    <li>
        <a title=" دوره ها">ویرایش دوره</a>
    </li>
@endsection
@section('content')
    <p class="box__title">ویرایش دوره ({{ $course->title }})</p>
    <div class="row no-gutters bg-white">
        <div class="col-12">
            <form action="{{ route('admin.market.course.update', $course->id) }}" method="post"
                enctype="multipart/form-data" class="padding-30">
                @csrf
                {{ method_field('put') }}
                <div class="row " style="gap:10px">
                    <div class="col-32 ">
                        <p class="mb-5 font-size-14">عنوان : </p>
                        <input type="text" value="{{ old('title', $course->title) }}" required name="title"
                            class="text" placeholder="عنوان دوره">
                        @error('title')
                            <span class="text-error" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-32 ">
                        <p class="mb-5 font-size-14">مدرس دوره : </p>
                        @if (auth()->user()->can('manage_course'))
                            <select name="teacher_id">
                                <option value="">انتخاب مدرس دوره</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @if (old('teacher_id', $course->teacher_id) == $user->id) selected @endif>
                                        {{ $user->FullName }}</option>
                                @endforeach
                            </select>
                            @error('teacher_id')
                                <span class="text-error" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                            @enderror
                        @else
                            <select name="teacher_id">
                                <option value="{{ auth()->user()->id }}">{{ auth()->user()->full_name }}</option>
                            </select>
                            @error('teacher_id')
                                <span class="text-error" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                            @enderror
                        @endif
                    </div>
                    <div class="col-32 ">
                        <p class="mb-5 font-size-14">نوع دوره : </p>
                        <select name="types" id="types">
                            <option value="">نوع دوره</option>
                            <option value="1" @if (old('types', $course->types) == 1) selected @endif>نقدی</option>
                            <option value="0" @if (old('types', $course->types) == 0) selected @endif>رایگان</option>
                            <option value="2" @if (old('types', $course->types) == 2) selected @endif>اشتراک</option>
                        </select>

                        @error('types')
                            <span class="text-error" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <input type="text" id="price" value="{{ old('price', $course->price) }}" name="price"
                    placeholder="مبلغ دوره" class="text @if ($course->types == 1) @else d-none @endif ">
                @error('price')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror

                <input type="text" id="percent" value="{{ old('percent', $course->percent) }}" name="percent"
                    placeholder="سود مدرس" class="text @if ($course->types == 1) @else d-none @endif">
                @error('percent')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror

                <div class="row " style="gap:10px">
                    <div class="col-32 ">
                        <p class="mb-5 font-size-14">روش دریافت دوره : </p>
                        <select name="get_course_option" id="get_course_option">
                            <option value="">روش دریافت دوره</option>
                            <option value="0" @if (old('get_course_option', $course->get_course_option) == 0) selected @endif>از طریق سایت</option>
                            <option value="1" @if (old('get_course_option', $course->get_course_option) == 1) selected @endif>اسپات پلیر</option>
                        </select>
                    </div>

                    @error('get_course_option')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror
                    <input type="text" id="spot_api_key" value="{{ old('spot_api_key', $course->spot_api_key) }}"
                        name="spot_api_key" class="text text-left @if($course->get_course_option == 0) d-none @endif" placeholder="api key">
                    @error('spot_api_key')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror
                    <input type="text" id="spot_course_license"
                        value="{{ old('spot_course_license', $course->spot_course_license) }}" name="spot_course_license"
                        class="text text-left @if($course->get_course_option == 0) d-none @endif" placeholder="course license">
                    @error('spot_course_license')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror
                    <div class="col-32 ">
                        <p class="mb-5">وضعیت دوره : </p>
                        <select name="status">
                            <option value="0" @if (old('status', $course->status) == 0) selected @endif>قفل شده</option>
                            <option value="4" @if (old('status', $course->status) == 4) selected @endif>پیش فروش</option>
                            <option value="1" @if (old('status', $course->status) == 1) selected @endif>درحال برگذاری
                            </option>
                            <option value="2" @if (old('status', $course->status) == 2) selected @endif>تکمیل شده</option>
                            <option value="3" @if (old('status', $course->status) == 3) selected @endif>توقف فروش</option>
                        </select>
                        @error('status')
                            <span class="text-error" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-32 ">
                        <p class="mb-5 font-size-14">سطح دوره : </p>
                        <select name="course_level">
                            <option value="0" @if (old('course_level', $course->course_level) == 0) selected @endif>مقدماتی</option>
                            <option value="1" @if (old('course_level', $course->course_level) == 1) selected @endif>متوسط </option>
                            <option value="2" @if (old('course_level', $course->course_level) == 2) selected @endif>پیشرفته</option>
                            <option value="3" @if (old('course_level', $course->course_level) == 3) selected @endif>مقدماتی تا پیشرفته
                            </option>

                        </select>
                        @error('course_level')
                            <span class="text-error" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row " style="gap:10px">
                    <div class="col-32 ">
                        <p class="mb-5 font-size-14">پیش نیاز : </p>
                        <input type="text" name="prerequisite"
                            value="{{ old('prerequisite', $course->prerequisite) }}" class="text text-left mlg-15"
                            placeholder="پیشنیاز">
                        @error('prerequisite')
                            <span class="text-error" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-32 ">

                        <p class="mb-5 font-size-14">دسته بندی : </p>
                        <select name="category_id">
                            <option value="">دسته بندی</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if (old('category_id', $course->category_id) == $category->id) selected @endif>
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
                    </div>
                    <div class="col-32 ">
                        <p class="mb-5 font-size-14">لینک پیش نمایش : </p>
                        <input dir="ltr" type="text" name="video_link" value="{{ old('video_link', $course->video_link) }}"
                            class="text text-left mlg-15" placeholder="لینک پیشنمایش">
                        @error('video_link')
                            <span class="text-error" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row " style="gap:10px">



                    <div class="col-32 ">
                        @if (auth()->user()->can('manage_course'))
                            <p class="mb-5 font-size-14"> الویت نمایش دوره : </p>
                            <input type="text" id="priority" value="{{ old('priority', $course->priority) }}"
                                name="priority" class="text" placeholder="0">
                            @error('priority')
                                <span class="text-error" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                            @enderror
                        @endif
                    </div>
                    <div class="col-32 ">
                        <p class="mb-5 font-size-14"> حداکثر ثبت نامی دوره: </p>
                        <input type="text" id="maximum_registration"
                            value="{{ old('maximum_registration', $course->maximum_registration) }}"
                            name="maximum_registration" class="text" placeholder="">
                        @error('maximum_registration')
                            <span class="text-error" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-32">
                        <p class="mb-5 font-size-14">  تاریخ انتشار </p>
                        <input type="text" name="published_at" id="published_at" class="text w-10 d-none">
                        <input type="text" value="{{$course->published_at}}" id="published_at_view" class="text w-10">
                        @error('published_at')
                            <span class="text-error" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                </div>
                </div>
                <div class="file-upload">
                    <div class="i-file-upload">
                        <span>آپلود بنر دوره</span>
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

                <p class="mb-5 font-size-14">توضیحات دوره : </p>
                <textarea name="body" id="upload" placeholder="توضیحات دوره" class="text h">{{ old('body', $course->body) }}</textarea>
                @error('body')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <br>
                <p class="mb-5 font-size-14">توضیحات متا : </p>
                <textarea name="summary" placeholder="توضیحات متا" class="text h">{{ old('summary', $course->summary) }}</textarea>
                @error('summary')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <div style="margin:5px"></div>
                <button class="btn btn-brand mt-5">ویرایش دوره</button>
            </form>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('dashboard/js/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('dashboard/js/jalalidatepicker/persian-date.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.js') }}"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#upload'), {
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
            $(document).ready(function() {
            $('#published_at_view').persianDatepicker({
                format: 'YYYY/MM/DD',
                altField: '#published_at',
                autoClose: true
            })
        });
        $("#types").change(function() {

            if ($('#types').find(':selected').val() == '1') {
                $('#price').removeClass('d-none');
                $('#percent').removeClass('d-none');

            } else {
                $('#price').addClass('d-none');
                $('#percent').addClass('d-none');
            }
        });
        $("#get_course_option").change(function() {

            if ($('#get_course_option').find(':selected').val() == '1') {
                $('#spot_course_license').removeClass('d-none');
                $('#spot_api_key').removeClass('d-none');

            } else {
                $('#spot_course_license').addClass('d-none');
                $('#spot_api_key').addClass('d-none');
            }
        });
    </script>

@endsection
