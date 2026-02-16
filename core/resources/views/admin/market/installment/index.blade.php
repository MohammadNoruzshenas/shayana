@extends('admin.layouts.master')
@section('head-tag')
<title>مدیریت اقساط</title>
<link rel="stylesheet" href="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.css') }}">
<style>
    .t-header-search-content .select2-container {
        display: inline-block;
        margin: 0 5px;
        vertical-align: top;
    }
    
    .t-header-search-content .select2-container .select2-selection--single {
        height: 38px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    .t-header-search-content .select2-container .select2-selection--single .select2-selection__rendered {
        line-height: 36px;
        padding-left: 8px;
    }
    
    .t-header-search-content input[type="text"] {
        width: 150px;
        height: 38px;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 0 8px;
        margin: 0 5px;
        vertical-align: top;
        display: inline-block;
    }
</style>
@endsection
@section('breadcrumb')
<li><a href="{{ route('admin.market.installment.index') }}">مدیریت اقساط</a></li>
@endsection
@section('content')
<div class="main-content">
    <div class="bg-white padding-20">
        <div class="t-header-search">
            <form action="{{ route('admin.market.installment.index') }}">
                <div class="t-header-searchbox font-size-13">
                    <input type="text" class="text search-input__box font-size-13" placeholder="جستجوی در اقساط">
                    <div class="t-header-search-content">
                        <select name="course_id" class="text">
                            <option value="">همه دوره‌ها</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" 
                                    {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                        <select name="user_id" class="text ">
                            <option value="">همه کاربران</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" 
                                    {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->first_name }} {{ $user->last_name }}
                                </option>
                            @endforeach
                        </select>
                        <select name="payment_status" class="text">
                            <option value="">وضعیت پرداخت</option>
                            <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>پرداخت شده</option>
                            <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>پرداخت نشده</option>
                        </select>
                        {{-- <input type="hidden" name="installment_date" id="installment_date" class="text d-none" value="{{ request('installment_date') }}">
                        <input type="text" name="installment_date_view" id="installment_date_view" class="text" autocomplete="off" placeholder="تاریخ قسط" value="{{ request('installment_date_view') }}"> --}}
                        <button type="submit" class="btn btn-webamooz_net">فیلتر</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="table__box">
        <table class="table">
            <thead role="rowgroup">
                <tr role="row" class="title-row">
                    <th>#</th>
                    <th>نام کاربر</th>
                    <th>شماره موبایل</th>
                    <th>نام دوره</th>
                    <th>مبلغ قسط</th>
                    <th>تاریخ قسط</th>
                    <th>وضعیت پرداخت</th>
                    <th>تایید پرداخت</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($installments as $installment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $installment->user->full_name ?? '-' }}</td>
                    <td>{{ $installment->user->mobile ?? '-' }}</td>
                    <td>{{ $installment->course->title ?? '-' }}</td>
                    <td>{{ number_format($installment->installment_amount) }} تومان</td>
                    <td>{{ \Morilog\Jalali\Jalalian::fromDateTime(new DateTime($installment->installment_date))->format('Y/m/d') }}</td>
                    <td>
                        @if($installment->installment_passed_at)
                            <span class="badge badge-success">پرداخت شده</span>
                            <br>
                            <small>{{ \Morilog\Jalali\Jalalian::forge($installment->installment_passed_at)->format('Y/m/d H:i') }}</small>
                        @else
                            <span class="badge badge-danger">پرداخت نشده</span>
                        @endif
                    </td>
                    <td>
                        <label>
                            <input id="installment_{{ $installment->id }}"
                                onchange="changeInstallmentStatus({{ $installment->id }})"
                                data-url="{{ route('admin.market.installment.toggle-status', $installment->id) }}"
                                type="checkbox" 
                                @if ($installment->installment_passed_at) checked @endif>
                        </label>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">هیچ قسطی یافت نشد</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('dashboard/js/jalalidatepicker/persian-date.min.js') }}"></script>
<script src="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.js') }}"></script>
<script type="text/javascript">
    function changeInstallmentStatus(id) {
        var element = $("#installment_" + id);
        var url = element.attr('data-url');
        var elementValue = !element.prop('checked');

        $.ajax({
            url: url,
            type: "POST",
            data: {
                '_token': $('meta[name="_token"]').attr('content'),
            },
            success: function(response) {
                if (response.status) {
                    if (response.checked) {
                        element.prop('checked', true);
                        // Update the status cell
                        element.closest('tr').find('td:nth-child(7)').html(
                            '<span class="badge badge-success">پرداخت شده</span><br><small>هم اکنون</small>'
                        );
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'قسط با موفقیت به عنوان پرداخت شده علامت‌گذاری شد',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    } else {
                        element.prop('checked', false);
                        // Update the status cell
                        element.closest('tr').find('td:nth-child(7)').html(
                            '<span class="badge badge-danger">پرداخت نشده</span>'
                        );
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'قسط به عنوان پرداخت نشده علامت‌گذاری شد',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                } else {
                    element.prop('checked', elementValue);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'خطایی در هنگام ویرایش رخ داد! لطفا مجدد تلاش کنید',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            },
            error: function() {
                element.prop('checked', elementValue);
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'ارتباط برقرار نشد',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        });
    }

    // Initialize Persian datepicker
    $(document).ready(function() {
        $('#installment_date_view').persianDatepicker({
            format: 'YYYY/MM/DD',
            altField: '#installment_date',
            autoClose: true,
            initialValue: false,
            calendar:{
                persian: {
                    locale: 'fa'
                }
            }
        });
    });
</script>
@endsection 