@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.setting.index') }}">تنظیمات</a></li>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>

        .select2,
        .selection {
            width: 100% !important;
            margin: 5px 0px;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border: none !important;

        }

        .select2-dropdown--below {
            background-color: #202831 !important;
            border: none !important;
        }

        .select2-container--default .select2-selection--multiple {
            border: none;
            padding-right: 20px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #111;
            color: #fff;
            padding-right: 10px;
        }

        .select2-selection .select2-selection--multiple {
            direction: rtl !important;
        }

        .select2-selection {
            background-color: #222831 !important;

        }

        .select2-search__field {
            color: #eeeeee !important;
            direction: rtl;
            width: 100% !important;
            margin-top: 0 !important;
            margin-left: 0 !important;
            height: 40px !important;

        }


        .acceptFormat .dropdown-select {
            display: none !important;
        }
    </style>
@endsection
@section('content')
    <div class="settings">
        <div class="tab__box"></div>
        <div class="user-info bg-white padding-30 font-size-13">
            <form action="{{ route('admin.setting.update', $setting) }}" method="post" id="form"
                enctype="multipart/form-data">
                @csrf
                @method('put')



                <p>حداکثر زمان واریزی</p>
                <input class="text text-left" name="settlement_pay_time"
                    value="{{ old('settlement_pay_time', $setting->settlement_pay_time) }}" placeholder="مثال : 3">
                @error('settlement_pay_time')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <p>حداقل مبلغ برای ثبت درخواست واریزی ({{ priceFormat($setting->minimum_deposit_request) }})</p>
                <input class="text text-left" name="minimum_deposit_request"
                    value="{{ old('minimum_deposit_request', numberFormat($setting->minimum_deposit_request)) }}"
                    placeholder="100000">
                @error('minimum_deposit_request')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <label class="ui-checkbox">
                    <input type="checkbox" id="can_request_settlements" name="can_request_settlements" class="checkedAll"
                        @if ($setting->can_request_settlements == 1) checked @endif>

                    <span class="checkmark"></span>
                    <span class="ui-checkbox__span">فعال بودن درخواست تسویه </span>
                </label>
                @error('can_request_settlements')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <label class="ui-checkbox">
                    <input type="checkbox" name="account_confirmation" class="checkedAll"
                        @if ($setting->account_confirmation == 1) checked @endif>

                    <span class="checkmark"></span>
                    <span class="ui-checkbox__span"> فعال سازی تایید ایمیل</span>
                </label>
                @error('account_confirmation')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <label class="ui-checkbox">
                    <input type="checkbox" name="site_repair" id="site_repair" class="checkedAll"
                        @if ($setting->site_repair == 1) checked @endif>
                    <span class="checkmark"></span>
                    <span class="ui-checkbox__span">فعال سازی سایت در دست تعمیر (
                        {{isset($_SERVER['https']) ? 'https://' : 'http://'.request()->getHost().'/'. cache('secureRecord')['site_repair_key'] }})</span>
                </label>
                @error('site_repair')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <label class="ui-checkbox">
                    <input type="checkbox" name="can_send_ticket" class="checkedAll"
                        @if ($setting->can_send_ticket == 1) checked @endif>
                    <span class="checkmark"></span>
                    <span class="ui-checkbox__span"> قابلیت ارسال تیکت </span>
                </label>
                @error('can_send_ticket')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <label class="ui-checkbox">
                    <input type="checkbox" name="commentable" class="checkedAll"
                        @if ($setting->commentable == 1) checked @endif>
                    <span class="checkmark"></span>
                    <span class="ui-checkbox__span"> قابلیت ارسال کامنت و نمایش کامنت ها </span>
                </label>
                @error('commentable')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <label class="ui-checkbox">
                    <input type="checkbox" name="comment_default_approved" class="checkedAll"
                        @if ($setting->comment_default_approved == 1) checked @endif>
                    <span class="checkmark"></span>
                    <span class="ui-checkbox__span">دیدگاه برای نمایش نیاز به تایید ادمین ندارد</span>
                </label>
                @error('comment_default_approved')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <label class="ui-checkbox">
                    <input type="checkbox" name="stop_selling" class="checkedAll"
                        @if ($setting->stop_selling == 1) checked @endif>

                    <span class="checkmark"></span>
                    <span class="ui-checkbox__span">بسته بودن امکان خرید دوره در سایت</span>
                </label>
                @error('stop_selling')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <label class="ui-checkbox">
                    <input type="checkbox" name="can_register_user" class="checkedAll"
                        @if ($setting->can_register_user == 1) checked @endif>

                    <span class="checkmark"></span>
                    <span class="ui-checkbox__span">امکان ثبت نام دانشجو در سایت</span>
                </label>
                @error('can_register_user')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <label class="ui-checkbox">
                    <input type="checkbox" id="chat_online" name="chat_online" class="checkedAll"
                        @if ($setting->chat_online == 1) checked @endif>

                    <span class="checkmark"></span>
                    <span class="ui-checkbox__span">فعال بودن چت انلاین سایت</span>
                </label>
                @error('chat_online')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <label class="ui-checkbox">
                    <input type="checkbox" id="recaptcha" name="recaptcha" class="checkedAll"
                        @if ($setting->recaptcha == 1) checked @endif>
                    <span class="checkmark"></span>
                    <span class="ui-checkbox__span">فعال بودن ریکپچا گوگل</span>
                </label>
                @error('recaptcha')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror

                <br>

                <span style="font-size: 13px">فضای آپلود عمومی به صورت پیشفرض</span>
                <select name="defult_uploader_public">
                    <option value="local" @if (old('defult_uploader_public', $setting->defult_uploader_public) == 'local') selected @endif>فضای هاست(سرور)</option>
                </select>
                @error('defult_uploader_public')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <span style="font-size: 13px">فضای آپلود خصوصی به صورت پیشفرض</span>
                <select name="defult_uploader_private">
                    <option value="local" @if (old('defult_uploader_private', $setting->defult_uploader_private) == 'local') selected @endif>فضای هاست(سرور)</option>
                    <option value="s3" @if (old('defult_uploader_private', $setting->defult_uploader_private) == 's3') selected @endif>فضای ابری(S3)</option>
                    {{-- <option value="ftp" @if (old('defult_uploader_private', $setting->defult_uploader_private) == 'ftp') selected @endif>FTP</option> --}}
                </select>
                @error('defult_uploader_private')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror


                <span style="font-size: 13px">روش ثبت نام و لاگین به وبسایت</span>
                <select name="method_login_register">
                    <option value="0" @if (old('method_login_register', $setting->method_login_register) == '0') selected @endif>ایمیل و شماره</option>
                    <option value="1" @if (old('method_login_register', $setting->method_login_register) == '1') selected @endif>ایمیل</option>
                    <option value="2" @if (old('method_login_register', $setting->method_login_register) == '2') selected @endif>شماره</option>

                </select>
                @error('defult_uploader_public')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <section class="col-12 acceptFormat">
                    <div class="form-group">
                        <label for="upload_file_format">فرمت های مجاز اپلود</label>
                        <input type="hidden" class="form-control form-control-sm" name="upload_file_format"
                            id="upload_file_format"
                            value="{{ old('upload_file_format', $setting->upload_file_format) }}">
                        <select class="select2 js-states form-control" id="select_format" multiple>
                        </select>
                    </div>
                    @error('upload_file_format')
                        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror
                </section>

                <div style="margin:20px 0"></div>
                <p style="font-size: 16px; font-weight: bold;">قوانین و مقررات سایت</p>
                <textarea name="rules" id="rules_editor" placeholder="قوانین و مقررات سایت را وارد کنید" class="text h">{{ old('rules', $setting->rules) }}</textarea>
                @error('rules')
                    <span class="text-error" role="alert">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                @enderror
                <div style="margin:10px 0"></div>

                <button class="btn btn-brand">ذخیره تغییرات</button>
            </form>
        </div>

    </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('dashboard/js/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(document).ready(function() {
            var tags_input = $('#upload_file_format');
            var select_format = $('#select_format');
            var default_tags = tags_input.val();
            var default_data = null;

            if (tags_input.val() !== null && tags_input.val().length > 0) {
                default_data = default_tags.split(',');
            }

            select_format.select2({
                placeholder: 'لطفا فرمت های خود را وارد نمایید',
                tags: true,
                data: default_data
            });
            select_format.children('option').attr('selected', true).trigger('change');


            $('#form').submit(function(event) {
                if (select_format.val() !== null && select_format.val().length > 0) {
                    var selectedSource = select_format.val().join(',');
                    tags_input.val(selectedSource)
                }
            })
        })
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#rules_editor'), {
                ckfinder: {
                    uploadUrl: '{{ route('admin.content.media.uploadCkeditorImage') . '?_token=' . csrf_token() }}'
                },
                language: {
                    ui: 'fa',
                    content: 'fa'
                }
            })
            .then(editor => {
                window.rulesEditor = editor;
            })
            .catch(err => {
                console.error(err.stack);
            });
    </script>
@endsection
