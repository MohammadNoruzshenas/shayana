@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.setting.template.index') }}" >تنظیمات قالب</a></li>
@endsection
@section('content')
    <div class="tab__box"></div>
    <div class="user-info bg-white padding-30 font-size-13">
        <form action="{{ route('admin.setting.template.update', $templateSetting) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="profile__info border cursor-pointer text-center">
                <div class="avatar__img">
                    <img src="{{ asset($templateSetting->logo) }}" na class="avatar___img">
                    <input type="file" name="logo" accept="image/*" class="hidden avatar-img__input">
                    <div class="v-dialog__container" style="display: block;"></div>
                    <div class="box__camera default__avatar"></div>
                </div>
                @error('logo')
                    <p class="text-error" role="alert">
                        {{ $message }}
                    </p>
                @enderror
                <span class="profile__name">لوگوی سایت</span>


            </div>
            <p> عنوان سایت:</p>

            <input class="text" name="title" value="{{ old('title', $templateSetting->title) }}"
                placeholder="عنوان  سایت">
            @error('title')
                <p class="text-error" role="alert">
                    {{ $message }}
                </p>
            @enderror
            <p>توضیحات متا:</p>

            <textarea class="text" name="meta_description" placeholder="توضیحات متا">{{ old('meta_description', $templateSetting->meta_description) }}</textarea>
            @error('meta_description')
                <p class="text-error" role="alert">
                    {{ $message }}
                </p>
            @enderror

            <br>
            <p>عنوان نوشته صفحه اصلی:</p>
            <input class="text" name="title_site_index" placeholder="عنوان نوشته صفحه اصلی"
                value="{{ old('title_site_index', $templateSetting->title_site_index) }}">
            @error('title_site_index')
                <p class="text-error" role="alert">
                    {{ $message }}
                </p>
            @enderror
            <p>توضحیات صفحه اصلی:</p>
            <textarea class="text" name="description_site_index" placeholder="توضحیات صفحه اصلی">{{ old('description_site_index', $templateSetting->description_site_index) }}</textarea>
            @error('description_site_index')
                <p class="text-error" role="alert">
                    {{ $message }}
                </p>
            @enderror
            <p> توضحیات خرید پلن در صفحه اصلی</p>
            <textarea class="text" name="description_plan_index" placeholder="توضحیات خرید پلن در صفحه اصلی">{{ old('description_plan_index', $templateSetting->description_plan_index) }}</textarea>
            @error('description_plan_index')
                <p class="text-error" role="alert">
                    {{ $message }}
                </p>
            @enderror


            <p>اطلاعیه : </p>
            <input class="text" name="sticky_banner" placeholder="متن اطلاعیه"
                value="{{ old('sticky_banner', $templateSetting->sticky_banner) }}">
            @error('sticky_banner')
                <p class="text-error" role="alert">
                    {{ $message }}
                </p>
            @enderror

            <br>
            <h2>تنظیمات رنگی</h2>
            <br>
            <p>رنگ اصلی </p>
            <input type="color" value="{{ old('main_color', $main_color) }}" name="main_color" id="">
            <p>رنگ ثانویه</p>
            <input type="color" value="{{ old('secondary_color', $secondary_color) }}" name="secondary_color"
                id="">
            <p>دارک مود</p>
            <input type="color" value="{{ old('dark_color', $dark_color) }}" name="dark_color" id="">
            <p>رنگ سفید</p>
            <input type="color" value="{{ old('white_color', $white_color) }}" name="white_color" id="">
            <br>
            <br>

            <div class="row" style="justify-content: space-between; margin:0px;">
                <div class="col-49">
            <p>تعداد نمایش پست در صفحه</p>
            <input class="text text-left" name="number_post_page" type="number" max="50"
                value="{{ old('number_post_page', $templateSetting->number_post_page) }}">
            @error('number_post_page')
                <p class="text-error" role="alert">
                    {{ $message }}
                </p>
            @enderror
                </div>
                <div class="col-49">
            <p>تعداد نمایش دوره در صفحه</p>
            <input class="text text-left" name="number_course_page" type="number" max="50"
                value="{{ old('number_course_page', $templateSetting->number_course_page) }}">
            @error('number_course_page')
                <p class="text-error" role="alert">
                    {{ $message }}
                </p>
            @enderror
                </div>
            </div>
            <label class="ui-checkbox">
                <input type="checkbox" name="show_students" class="checkedAll"
                    @if ($templateSetting->show_students == 1) checked @endif>
                <span class="checkmark"></span>
                <span class="ui-checkbox__span" style="padding: 5px;"> نمایش دانشجوهان دوره </span>
            </label>
            <label class="ui-checkbox">
                <input type="checkbox" name="show_social_user" class="checkedAll"
                    @if ($templateSetting->show_social_user == 1) checked @endif>
                <span class="checkmark"></span>
                <span class="ui-checkbox__span" style="padding: 5px;"> نمایش شبکه های اجتماعی مدرس </span>
            </label>
            <label class="ui-checkbox ">
                <input type="checkbox" name="show_rate" class="checkedAll"
                    @if ($templateSetting->show_rate == 1) checked @endif>
                <span class="checkmark"></span>
                <span class="ui-checkbox__span" style="padding: 5px;"> نمایش امتیاز درس </span>
            </label>
            <label class="ui-checkbox ">
                <input type="checkbox" name="show_info" class="checkedAll"
                    @if ($templateSetting->show_info == 1) checked @endif>
                <span class="checkmark"></span>
                <span class="ui-checkbox__span" style="padding: 5px;"> نمایش اطلاعات وبسایت (تعداد دوره ها و...) </span>
            </label>

            <label class="ui-checkbox ">
                <input type="checkbox" name="show_comments_index" class="checkedAll"
                    @if ($templateSetting->show_comments_index == 1) checked @endif>
                <span class="checkmark"></span>
                <span class="ui-checkbox__span" style="padding: 5px;">نمایش نظرات (صفحه اصلی)</span>
            </label>
            <label class="ui-checkbox ">
                <input type="checkbox" name="show_vipPost_index" class="checkedAll"
                    @if ($templateSetting->show_vipPost_index == 1) checked @endif>
                <span class="checkmark"></span>
                <span class="ui-checkbox__span" style="padding: 5px;">نمایش پست های ویژه (صفحه اصلی)</span>
            </label>
            <label class="ui-checkbox ">
                <input type="checkbox" name="show_courseFree_index" class="checkedAll"
                    @if ($templateSetting->show_courseFree_index == 1) checked @endif>
                <span class="checkmark"></span>
                <span class="ui-checkbox__span" style="padding: 5px;">نمایش دوره های رایگان (صفحه اصلی)</span>
            </label>
            <label class="ui-checkbox ">
                <input type="checkbox" name="show_plan_index" class="checkedAll"
                    @if ($templateSetting->show_plan_index == 1) checked @endif>
                <span class="checkmark"></span>
                <span class="ui-checkbox__span" style="padding: 5px;">نمایش پلن ها (صفحه اصلی)</span>
            </label>
            <br>








            <p>تصویر صفحه ورود و ثبت نام:</p>
            <br>

            <div class="file-upload">

                <div class="i-file-upload">
                    <span>آپلود تصویر </span>
                    <input type="file" class="file-upload" id="files" name="image_auth" />
                </div>
                <span class="filesize"></span>
                <span class="selectedFiles">فایلی انتخاب نشده است</span>
            </div>
            @error('image_auth')
                <span class="text-error" role="alert">
                    <strong>
                        {{ $message }}
                    </strong>
                </span>
            @enderror

            <button class="btn btn-brand">ذخیره تغییرات</button>
        </form>

    </div>
    </div>
    </div>
@endsection
@section('script')
<script>
    const btnCopy1 = document.querySelector("#btn-copy-1");
    const footerContent1 = document.querySelector(".footerContent1");
    const btnCopy2 = document.querySelector("#btn-copy-2");
    const footerContent2 = document.querySelector(".footerContent2");


    btnCopy1.addEventListener("click", () => {
    let randomID = Math.floor(Math.random() * 10000);
    let newElementHTML = `
        <div class="d-flex multi-text" id="footerContent1-${randomID}">
            <input type="text" name="link_title[]" class="text mlg-15" value="" placeholder="عنوان ">
            <input type="text" name="link_href[]" placeholder="لینک " value="" class="text-left text mlg-15">
            <button type="button" class="btn delete-btn" style="height: 45px; width: 7%;" onclick="deleteInput('footerContent1-${randomID}')">حذف</button>
        </div>`
    ;
    footerContent1.insertAdjacentHTML('beforeend', newElementHTML);
});

    btnCopy2.addEventListener("click", () => {
    let randomID = Math.floor(Math.random() * 10000);
    let newElementHTML = `
        <div class="d-flex multi-text" id="footerContent1-${randomID}">
            <input type="text" name="link_title[]" class="text mlg-15" value="" placeholder="عنوان ">
            <input type="text" name="link_href[]" placeholder="لینک " value="" class="text-left text mlg-15">
            <button type="button" class="btn delete-btn" style="height: 45px; width: 7%;" onclick="deleteInput('footerContent1-${randomID}')">حذف</button>
        </div>`
    ;
    footerContent2.insertAdjacentHTML('beforeend', newElementHTML);
});


    function deleteInput(id) {
        var elements = document.querySelectorAll('#' + id);
        elements.forEach(function(element) {
            element.remove();
        });
    }
</script>
@endsection
