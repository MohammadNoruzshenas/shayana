    @extends('admin.layouts.master')
    @section('head-tag')
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <link rel="stylesheet" href="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.css') }}">

    @endsection
    @section('breadcrumb')
        <li>
            <a href="{{ route('admin.market.course.index') }}" title="دوره ها">دوره ها</a>
        </li>
        <li>
            <a href="{{ route('admin.market.course.details', $course->id) }}">{{ $course->title }}</a>
        </li>
    @endsection
    @section('content')
        <div class="row no-gutters  ">
            <div class="col-8 bg-white padding-30 margin-left-10 margin-bottom-15 border-radius-3">
                <div class="margin-bottom-20 flex-wrap font-size-14 d-flex bg-white padding-0">
                    <p class="mlg-15">{{ $course->title }}</p>

                </div>
                <div class="d-flex item-center flex-wrap margin-bottom-15 operations__btns">
                    @if (auth()->user()->can('own_course') || auth()->user()->can('edit_lession'))
                        <button
                            onclick="acceptAllLessons('{{ route('admin.market.course.lession-details.acceptAll', $course->id) }}')"
                            class="btn all-confirm-btn">تایید همه جلسات</button>
                    @endif
                    @if (auth()->user()->can('own_course') || auth()->user()->can('create_lession'))
                        <a class="color-2b4a83"
                            href="{{ route('admin.market.course.lession.create', ['course' => $course]) }}">
                            <button class="btn reject-btn">آپلود چلسه جدید</button>
                        </a>
                    @endif
                </div>
                <div class="table__box">
                    <table class="table">
                        <thead role="rowgroup">
                            <tr role="row" class="title-row">
                                <th style="padding: 13px 30px;">
                                    <label class="ui-checkbox">
                                        <input type="checkbox" class="checkedAll">
                                        <span class="checkmark"></span>
                                    </label>
                                </th>
                                <th>شناسه</th>
                                <th>عنوان فصل</th>
                                <th> فصل والد</th>
                                <th> جلسات</th>
                                <th>وضعیت </th>
                                <th>عملیات</th>

                            </tr>
                        </thead>
                        <tbody id="tableBodyContents">


                        @foreach ($seasons as $season)
                                <tr role="row" class="tableRow" data-id="{{ $season->id }}">
                                    <td>
                                        <label class="ui-checkbox">
                                            <input type="checkbox" name="ids[]" value="{{ $season->id }}"
                                                class="sub-checkbox" data-id="{{ $season->id }}">
                                            <span class="checkmark"></span>
                                        </label>
                                    </td>
                                    <td><a href="">{{ $loop->iteration }}</a></td>
                                    <td><a
                                            href="{{ route('admin.market.course.season.lession.index', ['course' => $course, 'season' => $season]) }}">{{ $season->title }}</a>
                                    </td>
                                    <td>{{$season?->parent?->title}}</td>
                                    <td><a class="color-2b4a83"
                                            href="{{ route('admin.market.course.season.lession.index', ['course' => $course, 'season' => $season]) }}">مشاهده</a>
                                    </td>

                                    <td @if ($season->ConfirmationStatusValue == 'رد شده') class="text-danger" @endif
                                        @if ($season->ConfirmationStatusValue == 'تایید شده') class="text-success" @else
                                class="text-warning" @endif>
                                        {{ $season->ConfirmationStatusValue }}</td>


                                    <td>
                                        @if (auth()->user()->can('delete_lession') || auth()->user()->can('manage_course'))
                                            <form
                                                action="{{ route('admin.market.course.session.destroy', ['course' => $course->id, 'season' => $season->id]) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <button class="item-delete mlg-15 delete" title="حذف">
                                                    <li class="fa-solid fa-trash"></li>
                                                </button>
                                        @endif
                                        @if (auth()->user()->can('own_course') || auth()->user()->can('manage_course'))
                                        @if ($season->confirmation_status == 1)
                                            <a href="{{ route('admin.market.course.session.reject', ['course' => $course->id, 'season' => $season->id]) }}"
                                                class="item-reject mlg-15" title="رد">
                                                <li class="fa-solid fa-xmark"></li>
                                            </a>
                                        @elseif ($season->confirmation_status == 2)
                                            <a href="{{ route('admin.market.course.session.accept', ['course' => $course->id, 'season' => $season->id]) }}"
                                                class="item-confirm mlg-15" title="تایید">
                                                <li class="fa-solid fa-check"></li>
                                                <a href="{{ route('admin.market.course.session.reject', ['course' => $course->id, 'season' => $season->id]) }}"
                                                    class="item-reject mlg-15" title="رد">
                                                    <li class="fa-solid fa-xmark"></li>
                                            </a>
                                            @else
                                            <a href="{{ route('admin.market.course.session.accept', ['course' => $course->id, 'season' => $season->id]) }}"
                                                class="item-confirm mlg-15" title="تایید">
                                                <li class="fa-solid fa-check"></li>
                                        @endif
                                    @endif
                                        @if (auth()->user()->can('edit_lession') || auth()->user()->can('manage_course'))
                                            <a href="{{ route('admin.market.course.session.edit', ['course' => $course->id, 'season' => $season->id]) }}"
                                                class="item-edit " title="ویرایش">
                                                <li class="fa-solid fa-edit"></li>
                                            </a>
                                        @endif

                                        </form>
                                    </td>


                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-4">
                @include('admin.market.course.season.create')
                @permission('add_student_course')
                    @if ($course->types != 2)
                        <div class="col-12 bg-white margin-bottom-15 border-radius-3">
                            <p class="box__title">اضافه کردن دانشجو به دوره</p>
                            <form action="{{ route('admin.market.course.details.addStudent', $course->id) }}" method="post"
                                class="padding-30">
                                @csrf

                                <input type="text" name="user" value="{{ old('user') }}"
                                    placeholder="ایمیل  یا موبایل را وارد کنید" class="text">
                                @error('user')
                                    <span class="text-error" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                                <input type="text" name="price" value="{{ old('price', 9900000) }}"
                                    placeholder="مبلغ دوره" class="text">
                                @error('price')
                                    <span class="text-error" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                                <input type="text" name="description" value="{{ old('description', $course->description) }}"
                                    placeholder="توضیح بابت هزینه پرداخت شده" class="text">
                                @error('description')
                                    <span class="text-error" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                                <label class="mb-3" for="student_count">تعداد دانشجو</label>
                                <!-- New inputs -->
                                <input type="number" name="student_count" value="{{ old('student_count',1) }}"
                                    placeholder="تعداد دانشجو" class="text" min="1">
                                @error('student_count')
                                    <span class="text-error" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                                <label class="mb-3" for="student_count"> هزینه پشتیبانی نفر اضافه</label>
                                <input type="text" name="support_price" value="{{ old('support_price', 3300000) }}"
                                placeholder="هزینه پشتیبانی نفر اضافه" class="text">
                            @error('support_price')
                                <span class="text-error" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                            @enderror
                                
                                <label class="mb-3" for="payment_method">روش پرداخت</label>
                                <select name="payment_method" id="payment_method" class="text">
                                    <option value="installment" {{ old('payment_method') == 'installment' ? 'selected' : '' }}>قسطی</option>
                                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>نقدی</option>
                                </select>
                                @error('payment_method')
                                    <span class="text-error" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                                
                                <label class="mb-3" for="installment_count">تعداد قسط</label>
                                <!-- New inputs -->
                                <input type="number" name="installment_count" value="{{ old('installment_count',3) }}"
                                    placeholder="تعداد قسط" class="text" min="1">
                                @error('installment_count')
                                    <span class="text-error" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                                <label class="mb-3" for="register_date">تاریخ ثبت نام</label>
                                <input type="text" name="register_date" id="register_date" class="text d-none">
                                <input type="text" id="register_date_view" class="text" placeholder="تاریخ ثبت نام">
                                @error('register_date')
                                    <span class="text-error" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                                
                                <div class="notificationGroup">
                                    <input id="first-installment-paid" name="first_installment_paid" value="1" type="checkbox" checked />
                                    <label for="first-installment-paid">اولین قسط پرداخت شده است</label>
                                </div>
                                
                                <p class="box__title">کارمزد مدرس ثبت شود ؟</p>
                                <div class="notificationGroup">
                                    <input id="course-detial-field-1" name="wage[]" value="1" type="radio" checked />
                                    <label for="course-detial-field-1">بله</label>
                                </div>
                                <div class="notificationGroup">
                                    <input id="course-detial-field-2" name="wage[]" value="0" type="radio" />
                                    <label for="course-detial-field-2">خیر</label>
                                </div>
                                <button onclick="ButtonDisableR()" id="SubmitButtonStudent" class="btn btn-brand">اضافه
                                    کردن</button>
                            </form>
                        @endpermission
                    </div>
                @endif

            </div>
        </div>
    @endsection
    @section('script')
    <script src="{{ asset('dashboard/js/jalalidatepicker/persian-date.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.js') }}"></script>
    
        @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])

        <script>
                    $(document).ready(function() {
            $('#register_date_view').persianDatepicker({
                format: 'YYYY/MM/DD',
                altField: '#register_date',
                autoClose: true
            });
        });
            function acceptAllLessons(route) {
                Swal.fire({
                    title: 'آیا از این کار مطمئن هستید؟',
                    text: 'تایید همه جلسات',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("<form action='" + route + "' method='post'>" +
                            "<input type='hidden' name='_token' value='" + $('meta[name="_token"]').attr(
                                'content') + "' /> " +
                            "<input type='hidden' name='_method' value='patch'> " +
                            "</form>").appendTo('body').submit();
                    }
                });

            }

            function acceptMultiple(route) {
                doMultipleAction(route, "تایید جلسات انتخاب شده", 'patch')
            }

            function rejectMultiple(route) {
                doMultipleAction(route, "رد جلسات انتخاب شده ", 'patch')
            }

            function deleteMultiple(route) {
                doMultipleAction(route, "حذف جلسات انتخاب شده", "delete")
            }

            function doMultipleAction(route, message, method) {
                var allVals = getSelectedItems();
                if (allVals.length <= 0) {
                    Swal.fire('سطری انتخاب نشده')
                } else {
                    WRN_PROFILE_DELETE = message;
                    Swal.fire({
                        title: 'آیا از این کار مطمئن هستید؟',
                        text: WRN_PROFILE_DELETE,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'خیر',
                        confirmButtonText: 'بله'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $("<form action='" + route + "' method='post'>" +
                                "<input type='hidden' name='_token' value='" + $('meta[name="_token"]').attr(
                                    'content') +
                                "' /> " +
                                "<input type='hidden' name='_method' value='" + method + "'> " +
                                "<input type='hidden' name='ids' value='" + allVals + "'>" +
                                "</form>").appendTo('body').submit();
                        }
                    });
                }
            }

            function getSelectedItems() {
                var allVals = [];
                $(".sub-checkbox:checked").each(function() {
                    allVals.push($(this).attr('data-id'));
                });
                return allVals;
            }
        </script>

        <script>
            function ButtonDisableR() {
                setTimeout(() => {
                    document.getElementById("SubmitButtonStudent").setAttribute("disabled", "true");
                }, 1);
            }

            // Handle payment method changes
            $(document).ready(function() {
                function toggleInstallmentFields() {
                    const paymentMethod = $('#payment_method').val();
                    const installmentFields = $('input[name="installment_count"], label[for="installment_count"]');
                    const firstInstallmentField = $('#first-installment-paid, label[for="first-installment-paid"]').closest('.notificationGroup');
                    
                    if (paymentMethod === 'cash') {
                        installmentFields.hide();
                        firstInstallmentField.hide();
                    } else {
                        installmentFields.show();
                        firstInstallmentField.show();
                    }
                }
                
                // Run on page load
                toggleInstallmentFields();
                
                // Run when payment method changes
                $('#payment_method').on('change', toggleInstallmentFields);
            });
        </script>


        <!-- jQuery UI CDN Link -->
        <script src="{{ asset('dashboard/js/jquery-ui.min.js') }}"></script>

        <!-- DataTables JS CDN Link -->
        <script src="{{ asset('dashboard/js/jquery.dataTables.min.js') }}"></script>

        <!-- DataTables JS ( includes Bootstrap 5 for design [UI] ) CDN Link -->
        <script type="text/javascript" src="{{ asset('dashboard/js/toastify-js.js') }}"></script>

        <script type="text/javascript">
            $(function() {

                $("#table").DataTable();

                $("#tableBodyContents").sortable({
                    items: "tr",
                    cursor: 'move',
                    opacity: 0.6,
                    update: function() {
                        sendOrderToServer();
                    }
                });

                function sendOrderToServer() {

                    var order = [];
                    var token = $('meta[name="csrf-token"]').attr('content');

                    $('tr.tableRow').each(function(index, element) {
                        order.push({
                            id: $(this).attr('data-id'),
                            position: index + 1
                        });
                    });

                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "{{ route('admin.market.course.session.reorder', $course) }}",
                        data: {
                            order: order,
                            _token: token
                        },
                        success: function(response) {
                            if (response.status == 200) {
                                Toastify({
                                    text: "ترتیب سر فصل ها با موفقیت ویرایش شد",
                                    className: "info",
                                    gravity: "top", // `top` or `bottom`
                                    position: "center", // `left`, `center` or `right`

                                    style: {
                                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                                    }
                                }).showToast();
                            } else {
                                Toastify({
                                    text: "خطا در ویرایش اطلاعات",
                                    className: "info",
                                    gravity: "top", // `top` or `bottom`
                                    position: "center", // `left`, `center` or `right`
                                    style: {
                                        background: "linear-gradient(to right, #C40C0C, #FF6500)",
                                    }
                                }).showToast();
                            }
                        }
                    });
                }
            });
        </script>
    @endsection
