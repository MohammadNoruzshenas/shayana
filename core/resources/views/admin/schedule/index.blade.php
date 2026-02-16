@extends('admin.layouts.master')

@section('head-tag')
<title>مدیریت برنامه هفتگی</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .send-sms-btn {
        margin-left: 5px;
    }
    
    /* Custom Modal Styles */
    .custom-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
    }
    
    .custom-modal-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }
    
    .custom-modal-content {
        position: relative;
        background: white;
        margin: 5% auto;
        width: 90%;
        max-width: 600px;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        animation: modalSlideIn 0.3s ease-out;
    }
    
    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .custom-modal-header {
        padding: 20px 25px 15px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .custom-modal-title {
        margin: 0;
        font-size: 18px;
        font-weight: bold;
        color: #333;
    }
    
    .custom-modal-close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #999;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .custom-modal-close:hover {
        color: #333;
    }
    
    .custom-modal-body {
        padding: 25px;
    }
    
    .custom-modal-footer {
        padding: 15px 25px 25px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
    
    .sms-preview {
        min-height: 100px;
        padding: 15px;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        font-size: 14px;
        line-height: 1.6;
        text-align: right;
        direction: rtl;
        white-space: pre-line;
        font-family: 'Vazir', sans-serif;
        color: #495057;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #333;
    }
    
    .btn-outline {
        background-color: transparent;
        border: 1px solid #6c757d;
        color: #6c757d;
    }
    
    .btn-outline:hover {
        background-color: #6c757d;
        color: white;
    }
    
    /* SweetAlert above modal */
    .swal-above-modal {
        z-index: 10000 !important;
    }
</style>
@endsection

@section('breadcrumb')
<li><a href="{{ route('admin.index') }}">خانه</a></li>
<li><a href="{{ route('admin.schedule.index') }}">مدیریت برنامه هفتگی</a></li>
@endsection

@section('content')

<div class="tab__box" style="display: flex; gap: 10px;">
    <div class="tab__items">
        <p>مدیریت برنامه هفتگی</p>
    </div>
    @permission('create-schedule-panel')
    <div class="tab__items">
        <a class="btn btn-primary tab__item" href="{{ route('admin.schedule.create') }}">ایجاد برنامه جدید</a>
    </div>
    @endpermission
</div>

<div class="d-flex flex-space-between item-center flex-wrap padding-30 border-radius-3 bg-white">
    <div class="t-header-search">
        <form action="" method="get">
            <div class="t-header-searchbox font-size-13">
                <input type="text" class="text search-input__box" placeholder="جستجوی کاربران در برنامه هفتگی">
                <div class="t-header-search-content ">
                    <input type="text" class="text" name="first_name" value="{{ request('first_name') }}"
                        placeholder="نام">
                    <input type="text" class="text" name="last_name" value="{{ request('last_name') }}"
                        placeholder="نام خانوادگی">
                    <input type="text" class="text" name="mobile" value="{{ request('mobile') }}"
                        placeholder="شماره موبایل">
                    <input type="text" class="text" name="email" value="{{ request('email') }}"
                        placeholder="ایمیل">
                    <input type="text" class="text" name="username" value="{{ request('username') }}"
                        placeholder="نام کاربری">

                    <button type="submit" class="btn btn-webamooz_net">جستجو</button>
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
                <th>کاربر</th>
                <th>عنوان</th>
                <th>تاریخ شروع هفته</th>
                <th>وضعیت</th>
                <th>تاریخ ایجاد</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($schedules as $key => $schedule)
                <tr role="row">
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $schedule->user->full_name }}</td>
                    <td>{{ $schedule->title ?? 'بدون عنوان' }}</td>
                    <td>{{ \Morilog\Jalali\Jalalian::fromCarbon($schedule->week_start_date)->format('Y/m/d') }}</td>
                    <td>
                        <span class="badge badge-{{ $schedule->status ? 'success' : 'danger' }}">
                            {{ $schedule->status_value }}
                        </span>
                    </td>
                    <td>{{ \Morilog\Jalali\Jalalian::fromCarbon($schedule->created_at)->format('Y/m/d H:i') }}</td>
                    <td>
                        @permission('show-schedule-panel')
                        <a href="{{ route('admin.schedule.show', $schedule->id) }}" 
                           class="btn btn-sm btn-info" title="نمایش">
                            <i class="fa fa-eye"></i> مشاهده
                        </a>
                        @endpermission
                        @permission('edit-schedule-panel')
                        <a href="{{ route('admin.schedule.edit', $schedule->id) }}" 
                           class="btn btn-sm btn-warning" title="ویرایش">
                            <i class="fa fa-edit"></i> ویرایش
                        </a>
                        @endpermission
                        @permission('delete-schedule-panel')
                        <form class="d-inline" 
                              action="{{ route('admin.schedule.destroy', $schedule->id) }}" 
                              method="post">
                            @csrf
                            {{ method_field('delete') }}
                            <button class="btn btn-sm btn-danger delete" 
                                    type="submit" title="حذف">
                                <i class="fa fa-trash-alt"></i> حذف
                            </button>
                        </form>
                        @endpermission
                        @permission('send-sms-schedule-panel')
                        <button class="btn btn-sm btn-success send-sms-btn" 
                                data-schedule-id="{{ $schedule->id }}"
                                data-parent-name="{{ $schedule->user->parent_name ?: '' }}"
                                data-student-name="{{ $schedule->user->first_name ?: 'فرزند شما' }}"
                                title=" پیامک جدول برنامه ریزی">
                            <i class="fa fa-mobile"></i>  پیامک برنامه ریزی
                        </button>
                        <form class="d-inline button" action="{{ route('admin.schedule.sms-warning', $schedule->id) }}"
                              method="post">
                            @csrf
                            <button class="btn btn-sm btn-danger smsWarning"
                                    type="submit" title=" پیامک اخطار">
                                <i class="fa fa-warning"></i> پیامک اخطار
                            </button>
                        </form>
                        @endpermission
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- paginate -->
{{ $schedules->links('admin.layouts.paginate') }}
<!-- endpaginate -->

<!-- SMS Modal -->
<div id="smsModal" class="custom-modal" style="display: none;">
    <div class="custom-modal-overlay"></div>
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h5 class="custom-modal-title">ارسال پیامک برنامه جدید</h5>
            <button type="button" class="custom-modal-close" id="closeSmsModal">
                <span>&times;</span>
            </button>
        </div>
        <div class="custom-modal-body">
            <form id="smsForm">
                @csrf
                <div class="form-group">
                    <label for="adjective">صفت مناسب برای والدین:</label>
                    <input type="text" class="text" id="adjective" name="adjective" 
                           placeholder="مثال: عزیز، گرامی، محترم" required>
                </div>
                
                <div class="form-group" style="margin-top: 20px;">
                    <label>پیش‌نمایش پیامک:</label>
                    <div id="smsPreview" class="sms-preview">
                    </div>
                </div>
            </form>
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn btn-outline" id="cancelSmsBtn">انصراف</button>
            <button type="button" class="btn btn-webamooz_net" id="sendSmsBtn">ارسال پیامک</button>
        </div>
    </div>
</div>

@endsection

@section('script')

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'موفقیت',
                    text: "{{ session('success') }}",
                    confirmButtonText: 'باشه',
                });
            });
        </script>
    @endif
    <script type="text/javascript">
        function sweetalertSuccess() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                onOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: '{{ session('alert-section-success') }}'
            })
        }

        $(document).ready(function () {
            var successMessage = '{{ session('alert-section-success') }}';
            if (successMessage) {
                sweetalertSuccess();
            }

            $('.delete').click(function (event) {
                var form = $(this).closest("form");
                var name = $(this).attr("name");
                event.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: "این عمل قابل بازگشت نیست!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'بله، حذف کن!',
                    cancelButtonText: 'انصراف'
                }).then((result) => {
                    if (result.value) {
                        form.submit();
                    }
                })
            });

            $('.smsWarning').click(function (event) {
                var form = $(this).closest("form");
                event.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: "این عمل قابل بازگشت نیست!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'بله، ارسال کن!',
                    cancelButtonText: 'انصراف'
                }).then((result) => {
                    if (result.value) {
                        form.submit();
                    }
                })
            });

            // SMS Modal functionality
            let currentScheduleId = null;
            let currentParentName = '';
            let currentStudentName = '';

            // Custom modal functions
            function showSmsModal() {
                $('#smsModal').fadeIn(300);
                $('body').css('overflow', 'hidden');
            }

            function hideSmsModal() {
                $('#smsModal').fadeOut(300);
                $('body').css('overflow', 'auto');
            }

            $('.send-sms-btn').click(function() {
                currentScheduleId = $(this).data('schedule-id');
                currentParentName = $(this).data('parent-name');
                currentStudentName = $(this).data('student-name');
                
                $('#adjective').val('');
                updateSmsPreview();
                showSmsModal();
            });

            // Close modal events
            $('#closeSmsModal, #cancelSmsBtn').click(function() {
                hideSmsModal();
            });

            // Close modal when clicking on overlay
            $('.custom-modal-overlay').click(function() {
                hideSmsModal();
            });

            // Prevent modal from closing when clicking on modal content
            $('.custom-modal-content').click(function(e) {
                e.stopPropagation();
            });

            // Close modal with Escape key
            $(document).keydown(function(e) {
                if (e.keyCode === 27 && $('#smsModal').is(':visible')) { // Escape key
                    hideSmsModal();
                }
            });

            $('#adjective').on('input', function() {
                updateSmsPreview();
            });

            function updateSmsPreview() {
                const adjective = $('#adjective').val() || '[صفت]';
                const smsTemplate = `{!! __('sms.newSchedule', ['parentName' => ':parentName', 'studentName' => ':studentName', 'adjective' => ':adjective']) !!}`;
                
                const message = smsTemplate
                    .replace(':parentName', currentParentName)
                    .replace(/:studentName/g, currentStudentName)
                    .replace(':adjective', adjective);
                
                $('#smsPreview').text(message);
            }

            $('#sendSmsBtn').click(function() {
                const adjective = $('#adjective').val();
                if (!adjective) {
                    Swal.fire({
                        title: 'خطا',
                        text: 'لطفاً صفت مناسب را وارد کنید.',
                        icon: 'error',
                        customClass: {
                            container: 'swal-above-modal'
                        }
                    });
                    return;
                }

                // Show loading
                $(this).prop('disabled', true).text('در حال ارسال...');

                $.ajax({
                    url: `{{ url('admin/schedule/send-sms') }}/${currentScheduleId}`,
                    method: 'POST',
                    data: {
                        adjective: adjective,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        hideSmsModal();
                        Swal.fire({
                            title: 'موفق',
                            text: response.message,
                            icon: 'success'
                        });
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        Swal.fire({
                            title: 'خطا',
                            text: response.message || 'خطایی در ارسال پیامک رخ داد.',
                            icon: 'error',
                            customClass: {
                                container: 'swal-above-modal'
                            }
                        });
                    },
                    complete: function() {
                        $('#sendSmsBtn').prop('disabled', false).text('ارسال پیامک');
                    }
                });
            });
        });
    </script>
@endsection 