@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.setting.template.footer') }}" >تنظیمات فوتر</a></li>
@endsection
@section('content')
    <div class="tab__box"></div>
    <div class="user-info bg-white padding-30 font-size-13">
        <form action="{{ route('admin.setting.template.footer.update') }}" method="post"
            enctype="multipart/form-data">
            @csrf
            @method('put')
            <input type="hidden" name="footer_request" value="true" id="">
            <p>فوتر:</p>
            <input class="text" name="about_footer" placeholder="متن فوتر"
                value="{{ old('about_footer', $templateSetting->about_footer) }}">
            @error('about_footer')
                <p class="text-error" role="alert">
                    {{ $message }}
                </p>
            @enderror
            <p>کپی رایت:</p>
            <input class="text" name="copyright" placeholder="متن فوتر"
                value="{{ old('copyright', $templateSetting->copyright) }}">
            @error('copyright')
                <p class="text-error" role="alert">
                    {{ $message }}
                </p>
            @enderror
            <p>محل کد ایکون اینماد زرین پال و ... </p>
            <textarea class="text ltr-text" name="icon_html" placeholder="محل کد ایکون ">{{ old('icon_html', $templateSetting->icon_html) }}</textarea>
            @error('icon_html')
                <span class="text-error" role="alert">
                    <strong>
                        {{ $message }}
                    </strong>
                </span>
            @enderror

            <div class="row" style="justify-content: space-between; margin:0px;">
                <div class="col-49">
            <p>آیدی اینستاگرام:</p>
            <input class="text text-left" name="link_instagram"
                value="{{ old('link_instagram', $templateSetting->link_instagram) }}" placeholder="لینک اینستاگرام">
            @error('link_instagram')
                <p class="text-error" role="alert">
                    {{ $message }}
                </p>
            @enderror
                </div>
                <div class="col-49">
            <p>آیدی تلگرام:</p>
            <input class="text text-left" name="link_telegram"
                value="{{ old('link_telegram', $templateSetting->link_telegram) }}" placeholder="لینک تلگرام">
            @error('link_telegram')
                <p class="text-error" role="alert">
                    {{ $message }}
                </p>
            @enderror
                </div>
                </div>

            <br>
            <p>عنوان لینک های بخش اول فوتر:</p>
            <input class="text" name="footer_title_link" placeholder="عنوان 1"
                value="{{ old('footer_title_link', $templateSetting->footer_title_link) }}">
            @error('footer_title_link')
                <p class="text-error" role="alert">
                    {{ $message }}
                </p>
            @enderror
               <div class="footerContent1" style="display: flex;
    flex-direction: column;
    gap: 15px;
    margin-bottom: 30px;">
               @foreach ($footer_link as $link)
                    <div class="d-flex multi-text" id="id-{{ $link->id }}">
                        <input type="text" name="link_title[]" class="text  mlg-15"
                            value="{{ $link->title }}" placeholder="عنوان ">
                        <input type="text" name="link_href[]" placeholder="لینک "
                            value="{{ $link->link }}" class="text-left text mlg-15">
                            <button type="button" class="btn delete-btn" style="height: 45px;
        width: auto;" onclick="deleteInput('id-{{ $link->id }}')"
                        >حذف</button>
                    </div>

                @endforeach
               </div>
                <section>
                    <button type="button" id="btn-copy-1" class="btn all-confirm-btn">افزودن</button>
                </section>
            <br>
            <p>عنوان لینک های بخش دوم فوتر:</p>
            <input class="text" name="footer_title_link2" placeholder="عنوان 2"
                value="{{ old('footer_title_link2', $templateSetting->footer_title_link2) }}">
            @error('footer_title_link2')
                <p class="text-error" role="alert">
                    {{ $message }}
                </p>
            @enderror
            <div class="footerContent2">
            @foreach ($footer_link2 as $link)
                <div class="d-flex multi-text" id="id-{{ $link->id }}">
                    <input type="text" name="link_title2[]" class="text mlg-15" value="{{ $link->title }}"
                        placeholder="عنوان ">
                    <input type="text" name="link_href2[]" placeholder="لینک " value="{{ $link->link }}"
                        class="text-left text mlg-15">
                        <button type="button" class="btn delete-btn" style="height: 45px;
        width: auto;" onclick="deleteInput('id-{{ $link->id }}')"
                        >حذف</button>
                </div>
            @endforeach
</div>
<section>
                    <button type="button" id="btn-copy-2" class="btn all-confirm-btn">افزودن</button>
                </section>

                <br>

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
            <input type="text" name="link_title2[]" class="text mlg-15" value="" placeholder="عنوان ">
            <input type="text" name="link_href2[]" placeholder="لینک " value="" class="text-left text mlg-15">
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
