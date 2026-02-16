@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="">تنظیمات پنل اس ام اس </a></li>
@endsection
@section('content')
    <div class="table__box">
        <table class="table">
            <thead role="rowgroup">
                <tr role="row" class="title-row">
                    <th>#</th>
                    <th>نام انگلیسی</th>
                    <th>نام فارسی</th>
                    <th>عملیات </th>
                </tr>
            </thead>

            <tbody>

                @foreach ($smsPanels as $smsPanel)
                    <tr role="row">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $smsPanel->name_en ?? '-' }}</td>
                        <td @if($smsPanel->status == 1) style="color:green" @endif>{{ $smsPanel->status == 1 ? $smsPanel->name_fa . ' (فعال) ' : $smsPanel->name_fa}}</td>

                        <td>
                            @if ($smsPanel->status == 1)
                                <a href="{{ route('admin.setting.smsPanel.active', $smsPanel) }}" class="item-eye mlg-15"
                                    title="غیرفعال">
                                    <li class="fa-solid fa-ban"></li>
                                @else
                                    <a href="{{ route('admin.setting.smsPanel.active', $smsPanel) }}" class="item-eye mlg-15"
                                        title="قعال">
                                        <li class="fa-solid fa-check"></li>
                                    </a>
                            @endif

                            <a href="{{ route('admin.setting.smsPanel.edit', $smsPanel) }}" class="item-edit " title="ویرایش">
                                <li class="fa-solid fa-edit"></li>
                            </a>

                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    </div>

    </div>
@endsection
@section('script')
    <script type="text/javascript">
        function changeStatus(id) {
            var element = $("#" + id)
            var url = element.attr('data-url')
            var elementValue = !element.prop('checked');

            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    if (response.status) {
                        if (response.checked) {
                            element.prop('checked', true);
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'مقاله  با موفقیت فعال شد',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        } else {
                            element.prop('checked', false);
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'مقاله  با موفقیت غیرفعال شد',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    } else {
                        element.prop('checked', elementValue);
                        Swal.fire({
                            position: 'error',
                            icon: 'success',
                            title: 'هنگان ویرایش مشکلی به وجود اومد!لطفا مجدد امتحان نمایید',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                },
                error: function() {
                    element.prop('checked', elementValue);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'ارتباط برقرار نشد',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            });

            function successToast(message) {

                var successToastTag = '<section class="toast" data-delay="5000">\n' +
                    '<section class="toast-body p-3 d-flex bg-success text-white">\n' +
                    '<strong class="ml-auto">' + message + '</strong>\n' +
                    '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
                    '<span aria-hidden="true">&times;</span>\n' +
                    '</button>\n' +
                    '</section>\n' +
                    '</section>';

                $('.toast-wrapper').append(successToastTag);
                $('.toast').toast('show').delay(5500).queue(function() {
                    $(this).remove();
                })
            }

            function errorToast(message) {

                var errorToastTag = '<section class="toast" data-delay="5000">\n' +
                    '<section class="toast-body py-3 d-flex bg-danger text-white">\n' +
                    '<strong class="ml-auto">' + message + '</strong>\n' +
                    '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
                    '<span aria-hidden="true">&times;</span>\n' +
                    '</button>\n' +
                    '</section>\n' +
                    '</section>';

                $('.toast-wrapper').append(errorToastTag);
                $('.toast').toast('show').delay(5500).queue(function() {
                    $(this).remove();
                })
            }
        }
    </script>
    <script>
        function acceptAllLessons(route) {
            Swal.fire({
                title: 'آیا از این کار مطمئن هستید؟',
                text: 'تایید همه مقالات',
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
            doMultipleAction(route, "تایید مقالات انتخاب شده", 'patch')
        }

        function rejectMultiple(route) {
            doMultipleAction(route, "رد مقالات انتخاب شده ", 'patch')
        }

        function deleteMultiple(route) {
            doMultipleAction(route, "حذف مقالات انتخاب شده", "delete")
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection
