@extends('admin.layouts.master')

@section('head-tag')
<title>جزئیات پیامک گروهی</title>
@endsection

@section('breadcrumb')
<li><a href="{{ route('admin.notify.sms.index') }}">اطلاعیه پیامکی</a></li>
<li><a href="{{ route('admin.notify.bulk-sms.index') }}">مدیریت پیامک گروهی</a></li>
<li><a href="{{ route('admin.notify.bulk-sms.show', $bulkSMSRecord) }}">جزئیات</a></li>
@endsection

@section('content')

<div class="row no-gutters">
    <div class="col-8 bg-white padding-30 margin-left-10 margin-bottom-15 border-radius-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>جزئیات پیامک گروهی</h4>
            <a href="{{ route('admin.notify.bulk-sms.index') }}" class="btn btn-info btn-sm">بازگشت</a>
        </div>

        <div class="table__box">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td><strong>ایجاد کننده:</strong></td>
                        <td>{{ $bulkSMSRecord->creator->full_name ?? 'نامشخص' }}</td>
                    </tr>
                    <tr>
                        <td><strong>نوع پیامک:</strong></td>
                        <td>
                            @if($bulkSMSRecord->data['sms_type'] == 'confirm')
                                <span class="badge badge-success">تأیید</span>
                            @else
                                <span class="badge badge-danger">رد</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>ماه/سال:</strong></td>
                        <td>
                            @if($bulkSMSRecord->data['sms_type'] == 'confirm')
                                {{ $bulkSMSRecord->data['month_name'] ?? '' }} {{ $bulkSMSRecord->data['year'] ?? '' }}
                            @else
                                <span class="text-muted">غیر قابل اعمال</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>نام فایل:</strong></td>
                        <td>{{ $bulkSMSRecord->data['file_name'] ?? 'نامشخص' }}</td>
                    </tr>
                    <tr>
                        <td><strong>تعداد کل:</strong></td>
                        <td>{{ $bulkSMSRecord->total_count }}</td>
                    </tr>
                    {{-- <tr>
                        <td><strong>وضعیت:</strong></td>
                        <td>
                            <span class="badge badge-{{ $bulkSMSRecord->status_color }}">
                                {{ $bulkSMSRecord->status_text }}
                            </span>
                        </td>
                    </tr> --}}
                    <tr>
                        <td><strong>تاریخ ایجاد:</strong></td>
                        <td>{{ jalaliDate($bulkSMSRecord->created_at) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if(isset($bulkSMSRecord->data['excel_data']) && !empty($bulkSMSRecord->data['excel_data']))
            <div class="mt-4">
                <h5>داده‌های اکسل:</h5>
                <div class="table__box">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام</th>
                                <th>شماره تلفن</th>
                            
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bulkSMSRecord->data['excel_data'] as $index => $row)
                                @if($index > 0 && !empty($row[0]) && !empty($row[1])) {{-- Skip header row --}}
                                    <tr>
                                        <td>{{ $index }}</td>
                                
                                        <td>{{ $row[1] }}</td>
                                        <td>{{ $row[0] }}</td>
        
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

   
</div>

@endsection 