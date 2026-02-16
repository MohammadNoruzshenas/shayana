@extends('admin.layouts.master')

@section('head-tag')
<title>ارسال پیامک گروهی</title>
@endsection

@section('breadcrumb')
<li><a href="{{ route('admin.notify.sms.index') }}">اطلاعیه پیامکی</a></li>
<li><a href="{{ route('admin.notify.bulk-sms.create') }}">ارسال پیامک گروهی</a></li>
@endsection

@section('content')

<p class="box__title">ارسال پیامک گروهی</p>
<div class="row no-gutters bg-white">
    <div class="col-12">
        <form action="{{ route('admin.notify.bulk-sms.store') }}" method="post" enctype="multipart/form-data" class="padding-30">
            @csrf
            
            <div class="row" style="gap:10px">
                <div class="col-32">
                    <p class="mb-5 font-size-14">نوع پیامک :</p>
                    <select name="sms_type" id="sms_type" onchange="toggleFields()">
                        <option value="">نوع پیامک را انتخاب کنید</option>
                        <option value="confirm" {{ old('sms_type') == 'confirm' ? 'selected' : '' }}>تأیید</option>
                        <option value="reject" {{ old('sms_type') == 'reject' ? 'selected' : '' }}>رد</option>
                    </select>
                    @error('sms_type')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror
                </div>

{{--                <div class="col-32" id="month-container">--}}
{{--                    <p class="mb-5 font-size-14">ماه :</p>--}}
{{--                    <select name="month" id="month">--}}
{{--                        <option value="">ماه را انتخاب کنید</option>--}}
{{--                        @foreach($persianMonths as $key => $month)--}}
{{--                            <option value="{{ $key }}" {{ old('month') == $key ? 'selected' : '' }}>--}}
{{--                                {{ $month }}--}}
{{--                            </option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                    @error('month')--}}
{{--                        <span class="text-error" role="alert">--}}
{{--                            <strong>--}}
{{--                                {{ $message }}--}}
{{--                            </strong>--}}
{{--                        </span>--}}
{{--                    @enderror--}}
{{--                </div>--}}

                {{-- <div class="col-32" id="year-container">
                    <p class="mb-5 font-size-14">سال :</p>
                    <select name="year" id="year">
                        <option value="">سال را انتخاب کنید</option>
                        @foreach($years as $key => $year)
                            <option value="{{ $key }}" {{ old('year') == $key ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                    @error('year')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror
                </div> --}}
            </div>

            <div class="row" style="gap:10px">
                <div class="col-48">
                    <p class="mb-5 font-size-14">فایل اکسل :</p>
                    <input type="file" name="excel_file" id="excel_file" class="text" accept=".xlsx,.xls,.csv">
                    <small class="d-block mt-2 text-muted">
                        فایل اکسل باید دو ستون داشته باشد: نام و شماره تلفن
                    </small>
                    <br>
                    <small class="d-block mt-2 text-muted " style="color: red">
                        فایل اکسل حداکثر 100 رکورد داشته باشد.
                    </small>
                    @error('excel_file')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row" style="gap:10px">
                <div class="col-12">
                    <div class="alert alert-info bg-info-light p-3 mt-3">
                        <h6 class="mb-2">راهنمای فایل اکسل:</h6>
                        <ul class="mb-0">
                            <li>ستون اول: شماره تلفن (مثال: 09123456789)</li>
                            <li>ستون دوم: نام (مثال: علی)</li>
                            <li>فایل باید دارای سطر اول به عنوان عنوان ستون‌ها باشد</li>
                        </ul>
                        <div class="mt-3">
                            <a href="{{ asset('sample-bulk-sms-template.csv') }}" class="btn btn-sm btn-outline-primary" download>
                                <i class="fa fa-download"></i> دانلود فایل نمونه
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" style="gap:10px">
                <div class="col-12">
                    <div id="sms-preview" class="alert alert-secondary mt-3" style="display:none;">
                        <strong>پیش‌نمایش پیامک:</strong><br>
                        <span id="preview-text"></span>
                    </div>
                </div>
            </div>

            <button class="btn btn-brand">ارسال پیامک‌ها</button>
        </form>
    </div>
</div>

@endsection

@section('script')
<script>
    // SMS templates from language file
    const confirmTemplate = @json(__('sms.confirmStudent'));
    const rejectTemplate = @json(__('sms.rejectStudent'));
    const defaultName = '[نام دانش آموز]';
    const defaultSupportName ='[نام مشاور]';
    const defaultParenttName ='[نام والد]';
    // Show/hide month and year fields based on SMS type
    function toggleFields() {
        const smsType = document.getElementById('sms_type').value;
        const monthDiv = document.getElementById('month-container');
        //const yearDiv = document.getElementById('year-container');
        
        if (smsType === 'reject') {
            if (monthDiv) monthDiv.style.display = 'none';
            //if (yearDiv) yearDiv.style.display = 'none';
            // Clear values when hidden
            const monthSelect = document.getElementById('month');
           // const yearSelect = document.getElementById('year');
            if (monthSelect) monthSelect.value = '';
           // if (yearSelect) yearSelect.value = '';
        } else {
            if (monthDiv) monthDiv.style.display = 'block';
            //if (yearDiv) yearDiv.style.display = 'block';
        }
        
        updatePreview();
    }

    // Show preview of SMS message
    function updatePreview() {
        const smsType = document.getElementById('sms_type').value;
        const month = document.getElementById('month');
        //const year = document.getElementById('year').value;
        
        const selectedMonth = month ? month.options[month.selectedIndex].text : '';
        
        if (smsType) {
            let preview = '';
            if (smsType === 'confirm') {
                preview = confirmTemplate
                    .replace(':supportName', defaultSupportName)
                    .replace(':parentName', defaultParenttName)
                    .replace(':studentName', defaultName);
            } else if (smsType === 'reject') {
                preview = rejectTemplate
                    .replace(':supportName', defaultSupportName)
                    .replace(':parentName', defaultParenttName)
                    .replace(':studentName', defaultName);
            }
            
            const previewText = document.getElementById('preview-text');
            const smsPreview = document.getElementById('sms-preview');
            if (previewText) previewText.innerHTML = preview.replace(/\n/g, '<br>');
            if (smsPreview) smsPreview.style.display = 'block';
        } else {
            const smsPreview = document.getElementById('sms-preview');
            if (smsPreview) smsPreview.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Add event listeners for month and year changes
        const monthSelect = document.getElementById('month');
       // const yearSelect = document.getElementById('year');
        
        if (monthSelect) {
            monthSelect.addEventListener('change', updatePreview);
        }
        // if (yearSelect) {
        //     yearSelect.addEventListener('change', updatePreview);
        // }
        
        // Initial call to set proper state
        toggleFields();
    });
</script>
@endsection 