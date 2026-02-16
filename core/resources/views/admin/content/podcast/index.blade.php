@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.content.podcast.index') }}" title="پادکست ها">پادکست ها</a></li>
@endsection
@section('content')
    <div class="tab__box">
        <div class="tab__items">
            <a class="tab__item @if(request('confirmation_status') == null) is-active @endif" href="{{ route('admin.content.podcast.index') }}">لیست پادکست ها</a>
            <a class="tab__item @if(request('confirmation_status') == 1) is-active @endif" href="?confirmation_status=1">پادکست ها تایید شده</a>
            <a class="tab__item @if(request('confirmation_status') == 2) is-active @endif" href="?confirmation_status=2">پادکست ها درحال بررسی </a>
            <a class="tab__item @if(request('confirmation_status') == 3) is-active @endif" href="?confirmation_status=3"> پادکست ها تایید نشده</a>
            @permission('create_podcast')
                <a class="tab__item" href="{{ route('admin.content.podcast.create') }}">ایجاد پادکست  جدید</a>
            @endpermission
        </div>
    </div>

    <div class="bg-white padding-20">
        <div class="t-header-search">
            <form action="" method="get">
                <div class="t-header-searchbox font-size-13">
                    <input type="text" class="text search-input__box" placeholder="جستجوی در پادکست ها وبسایت">
                    <div class="t-header-search-content ">
                        <input type="text" class="text" name="title" value="{{ request('title') }}"
                            placeholder="عنوان">
                        <input type="text" class="text" name="email" value="{{ request('email') }}"
                            placeholder="ایمیل">
                        <button type="submit" class="btn">جستجو</button>
                    </div>
                </div>
            </form>
        </div>
        @permission('manage_podcast')
            <div class="d-flex item-center flex-wrap margin-bottom-15 operations__btns">
                <button onclick="acceptAllLessons('{{ route('admin.content.podcast.acceptAll') }}')"
                    class="btn all-confirm-btn">تایید همه پادکست ها</button>
                <button onclick="acceptMultiple('{{ route('admin.content.podcast.acceptMultiple') }}')"
                    class="btn confirm-btn ml-2">تایید پادکست ها</button>
                <button onclick="rejectMultiple('{{ route('admin.content.podcast.rejectMultiple') }}')"
                    class="btn reject-btn ml-2">رد پادکست ها</button>
                <button onclick="deleteMultiple('{{ route('admin.content.podcast.destroyMultiple') }}')"
                    class="btn d delete-btn">حذف پادکست ها</button>

            </div>
        @endpermission
    </div>


    <div class="table__box">
        <table class="table">
            <thead role="rowgroup">

                <tr role="row" class="title-row">
                    @permission('manage_podcast')
                    <th style="padding: 13px 30px;">
                        <label class="ui-checkbox">
                            <input type="checkbox" class="checkedAll">
                            <span class="checkmark"></span>
                        </label>
                    </th>
                    @endpermission
                    <th>شناسه</th>
                    <th>عنوان</th>
                    <th>تصویر</th>
                    <th>گوینده </th>
                    <th>دسته بندی</th>
                    <th>نوع دسترسی</th>

                    {{-- <th>تعداد بازدید</th> --}}
                    <th>نظرات</th>
                    <th>وضعیت تایید</th>
                    @permission('manage_podcast')
                        <th>وضعیت نمایش</th>
                    @endpermission
                    <th>عملیات</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($podcasts as $podcast)
                    <tr role="row">
                        @permission('manage_podcast')
                        <td>
                            <label class="ui-checkbox">
                                <input type="checkbox" name="ids[]" value="{{ $podcast->id }}" class="sub-checkbox"
                                    data-id="{{ $podcast->id }}">
                                <span class="checkmark"></span>
                            </label>
                        </td>
                        @endpermission
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $podcast->title ?? '-' }}</td>
                        <td>
                            <img src="{{ asset($podcast->image) }}" alt="" width="100" height="50">
                        </td>
                        <td>{{ $podcast->podcaster->FullName ?? '-' }}</td>
                        <td>{{ $podcast->category->title ?? '-' }}</td>
                        <td>{{ $podcast->is_vip == 1 ? 'ویژه' : 'همه' }}</td>

                        {{-- <td>{{ $podcast->views ?? '-' }}</td> --}}
                        <td>{{ $podcast->comments->count() ?? '-' }}</td>
                        <td @if ($podcast->confirmation_status == 0) class="text-danger" @endif
                            @if ($podcast->confirmation_status == 1) class="text-success" @endif
                            @if ($podcast->confirmation_status == 2) class="text-warning" @endif>
                            {{ $podcast->ConfirmationStatusValue }}</td>
                        @permission('manage_podcast')
                            <td>

                                <label>
                                    <input id="{{ $podcast->id }}" onchange="changeStatus({{ $podcast->id }})"
                                        data-url="{{ route('admin.content.podcast.status', $podcast->id) }}" type="checkbox"
                                        @if ($podcast->status === 1) checked @endif>
                                </label>
                            </td>
                        @endpermission

                        <td>
                            @permission('delete_podcast')
                                <form action="{{ route('admin.content.podcast.destory', $podcast->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="item-delete mlg-15 delete" style="" title="حذف">
                                        <li class="fa-solid fa-trash"></li>
                                    </button>
                                @endpermission
                                <a href="{{ route('customer.singlePodcast', $podcast->slug) }}" target="_blank"
                                    class="item-eye mlg-15" title="مشاهده">
                                    <li class="fa-solid fa-eye"></li>
                                </a>
                                @permission('manage_podcast')
                           @if($podcast->confirmation_status == 1)
                                    <a href="{{ route('admin.content.podcast.reject', $podcast->id) }}" class="item-reject mlg-15"
                                        title="رد">
                                        <li class="fa-solid fa-xmark"></li>
                                    </a>
                                    @else
                                    <a href="{{ route('admin.content.podcast.accept', $podcast->id) }}" class="item-confirm mlg-15"
                                        title="تایید">
                                        <li class="fa-solid fa-check"></li>
                                    </a>
                                    @endif
                                @endpermission
                                @permission('edit_podcast')
                                <a href="{{ route('admin.content.podcast.edit', $podcast->id) }}" class="item-edit "
                                    title="ویرایش">
                                    <li class="fa-solid fa-edit"></li>
                                </a>
                                @endpermission
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    </div>
    <!-- paginate -->
    {{ $podcasts->links('admin.layouts.paginate') }}
    <!-- endpaginate -->
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
                                title: 'پادکست   با موفقیت فعال شد',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        } else {
                            element.prop('checked', false);
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'پادکست   با موفقیت غیرفعال شد',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    } else {
                        element.prop('checked', elementValue);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
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
                text: 'تایید همه پادکست ها',
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
            doMultipleAction(route, "تایید پادکست ها انتخاب شده", 'patch')
        }

        function rejectMultiple(route) {
            doMultipleAction(route, "رد پادکست ها انتخاب شده ", 'patch')
        }

        function deleteMultiple(route) {
            doMultipleAction(route, "حذف پادکست ها انتخاب شده", "delete")
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
