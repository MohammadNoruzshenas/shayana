@extends('admin.layouts.master')

@section('head-tag')

@endsection

@section('breadcrumb')
    <li><a href="{{ route('admin.setting.index') }}">تنظیمات</a></li>
    <li><a href="{{ route('admin.setting.secureRecord.index') }}">تنظیمات سرویس</a></li>
@endsection
@section('content')
    <div class="settings">
        <a href="{{ route('admin.setting.secureRecord.index') }}" style="margin-bottom: 5px"></a>
        <div class="user-info bg-white padding-30 font-size-13">
            <form action="{{ route('admin.setting.secureRecord.update', $secureRecord) }}" id="form" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('put')

                <h2>تنظیمات  سرویس ایمیل</h2>

                <div class="row" style="justify-content: space-between; margin:0px;">
                    <div class="col-49">
                        <p class="ltr-text">mail transport: </p>
                        <input class="text text-left" name="mail_transport"
                            value="{{ old('mail_transport', $secureRecord->mail_transport) }}" placeholder="smtp">
                        @error('mail_transport')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-49">
                        <p class="ltr-text">mail host: </p>
                        <input class="text text-left" name="mail_host"
                            value="{{ old('mail_host', $secureRecord->mail_host) }}" placeholder="mail host">
                        @error('mail_host')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row" style="justify-content: space-between; margin:0px;">
                    <div class="col-49">
                        <p class="ltr-text">mail port: </p>
                        <input class="text text-left" name="mail_port"
                            value="{{ old('mail_port', $secureRecord->mail_port) }}" placeholder="mail port">
                        @error('mail_port')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-49">
                        <p class="ltr-text">mail username: </p>
                        <input class="text text-left" name="mail_username"
                            value="{{ old('mail_username', $secureRecord->mail_username) }}" placeholder="mail username">
                        @error('mail_username')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row" style="justify-content: space-between; margin:0px;">
                    <div class="col-49">
                        <p class="ltr-text">mail password: </p>
                        <input class="text text-left" name="mail_password"
                            value="{{ old('mail_password', $secureRecord->mail_password) }}" placeholder="mail password">
                        @error('mail_password')
                            <p style="color: red">{{ $message }}</p>
                        @enderror

                    </div>
                    <div class="col-49">
                        <p class="ltr-text"> mail encyption: </p>
                        <input class="text text-left" name="mail_encyption"
                            value="{{ old('mail_encyption', $secureRecord->mail_encyption) }}"
                            placeholder="mail encyption">
                        @error('mail_encyption')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <br>
                <span>کلید اسپات پلیر پیشفرض</span>
                <input class="text text-left" name="spot_api_key"
                    value="{{ old('spot_api_key', $secureRecord->spot_api_key) }}" placeholder="کلید اسپات پلیر">
                @error('spot_api_key')
                    <p style="color: red">{{ $message }}</p>
                @enderror
                <br>
                <h2>تنظیمات کپچا</h2>

                <div class="row" style="justify-content: space-between; margin:0px;">
                    <div class="col-49">
                        <p class="ltr-text"> site key</p>
                        <input class="text text-left " id="recaptcha_site_key" name="recaptcha_site_key"
                            value="{{ old('recaptcha_site_key', $secureRecord->recaptcha_site_key) }}"
                            placeholder="site key">
                        @error('recaptcha_site_key')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-49">
                        <p class="ltr-text"> recaptcha secret key</p>
                        <input class="text text-left " id="recaptcha_secret_key" name="recaptcha_secret_key"
                            value="{{ old('recaptcha_secret_key ', $secureRecord->recaptcha_secret_key) }}"
                            placeholder="secret key">
                        @error('recaptcha_secret_key')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <span> کد اچ تی ام ال چت انلاین</span>
                <textarea class="text ltr-text " id="chat_online_key" name="chat_online_key" placeholder="کد اچ تی ام ال چت انلاین">{{ old('crips_code', $secureRecord->chat_online_key) }}</textarea>
                @error('chat_online_key')
                    <p style="color: red">{{ $message }}</p>
                @enderror
                <br>
                <p class="" id="site_repair_help">کلید دسترسی به سایت ({{isset($_SERVER['https']) ? 'https://' : 'http://'.request()->getHost().'/'.$secureRecord->site_repair_key }})</p>
                <input class="text text-left" id="site_repair_key" name="site_repair_key"
                    value="{{ old('site_repair_key', $secureRecord->site_repair_key) }}"
                    placeholder="کلید دسترسی به سایت در دست تعمیر">
                @error('site_repair_key')
                    <p style="color: red">{{ $message }}</p>
                @enderror
                <input class="text text-left" id="site_url" name="site_url"
                    value="{{ old('site_url', $secureRecord->site_url) }}" placeholder="ادرس وبسایت">
                @error('site_url')
                    <p style="color: red">{{ $message }}</p>
                @enderror
                <br>
                <h2>تنظیمات کلود </h2>

                <div class="row" style="justify-content: space-between; margin:0px;">
                    <div class="col-49">
                        <p class="ltr-text">s3 key: </p>
                        <input class="text text-left" id="s3_key" name="s3_key"
                            value="{{ old('s3_key', $secureRecord->s3_key) }}" placeholder="s3 key">
                        @error('s3_key')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-49">
                        <p class="ltr-text"> s3 secret: </p>
                        <input class="text text-left" id="s3_secret" name="s3_secret"
                            value="{{ old('s3_secret', $secureRecord->s3_secret) }}" placeholder="s3_secret">
                        @error('s3_secret')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row" style="justify-content: space-between; margin:0px;">
                    <div class="col-49">
                        <p class="ltr-text"> s3 bucket: </p>
                        <input class="text text-left" id="s3_bucket" name="s3_bucket"
                            value="{{ old('s3_bucket', $secureRecord->s3_bucket) }}" placeholder="s3_bucket">
                        @error('s3_bucket')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-49">
                        <p class="ltr-text"> s3 endpoint: </p>
                        <input class="text text-left" id="s3_endpoint" name="s3_endpoint"
                            value="{{ old('s3_endpoint', $secureRecord->s3_endpoint) }}" placeholder="s3_endpoint">
                        @error('s3_endpoint')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                </div>


                {{-- <p>تنظیمات FTp</p>
<input class="text text-left" id="ftp_host" name="ftp_host"
value="{{ old('ftp_host', $secureRecord->ftp_host) }}" placeholder="ftp_host">
<input class="text text-left" id="ftp_username" name="ftp_username"
value="{{ old('ftp_username', $secureRecord->ftp_username) }}" placeholder="ftp_username">
 <input class="text text-left" id="ftp_password" name="ftp_password"
value="{{ old('ftp_password', $secureRecord->ftp_password) }}" placeholder="ftp_password">
 <input class="text text-left" id="ftp_port" name="ftp_port"
value="{{ old('ftp_port', $secureRecord->ftp_port) }}" placeholder="ftp_port"> --}}
                <button class="btn btn-brand">ذخیره تغییرات</button>
            </form>
        </div>
    </div>
@endsection

