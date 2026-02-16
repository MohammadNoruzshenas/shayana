@extends('admin.layouts.master')

@section('head-tag')
<title>مدیریت پیامک گروهی</title>
@endsection

@section('breadcrumb')
<li><a href="{{ route('admin.notify.sms.index') }}">اطلاعیه پیامکی</a></li>
<li><a  href="{{ route('admin.notify.bulk-sms.index') }}">مدیریت پیامک گروهی</a></li>
@endsection

@section('content')

<div class="tab__box" style="display: flex; gap: 10px;">
    <div class="tab__items">
        <p>مدیریت پیامک گروهی</p>
    </div>
    @permission('create-bulk-sms')
    <div class="tab__items">
        <a class="btn btn-primary tab__item" href="{{ route('admin.notify.bulk-sms.create') }}">ارسال پیامک گروهی جدید</a>
    </div>
    @endpermission
</div>

<div class="table__box">
    <table class="table">
        <thead role="rowgroup">
            <tr role="row" class="title-row">
                <th>#</th>
                <th>ایجاد کننده</th>
                <th>نوع پیامک</th>
                <th>ماه/سال</th>
                <th>تعداد کل</th>
                <th>تاریخ ایجاد</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $record)
                <tr role="row">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $record->creator->full_name ?? 'نامشخص' }}</td>
                    <td>
                        @if($record->data['sms_type'] == 'confirm')
                            <span class="badge badge-success">تأیید</span>
                        @else
                            <span class="badge badge-danger">رد</span>
                        @endif
                    </td>
                    <td>{{ $record->data['month_name'] ?? '' }} {{ $record->data['year'] ?? '' }}</td>
                    <td>{{ $record->total_count }}</td>
        
                    <td>{{ jalaliDate($record->created_at) }}</td>
                    <td>
                        <a href="{{ route('admin.notify.bulk-sms.show', $record) }}" class="btn btn-sm btn-info">
                            <i class="fa fa-eye"></i> مشاهده
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- paginate -->
{{ $records->links('admin.layouts.paginate') }}
<!-- endpaginate -->

@endsection 