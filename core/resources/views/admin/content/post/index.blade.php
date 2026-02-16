@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.content.post.index') }}" title="مقالات">مقالات</a></li>
@endsection
@section('content')
    <div class="tab__box">
        <div class="tab__items">
            <a class="tab__item" href="{{ route('admin.content.post.index') }}">لیست مقالات</a>
            <a class="tab__item @if(request('confirmation_status') == 1) is-active @endif" href="?confirmation_status=1">مقالات تایید شده</a>
            <a class="tab__item @if(request('confirmation_status') == 2) is-active @endif" href="?confirmation_status=2">مقالات درحال بررسی </a>
            <a class="tab__item @if(request('confirmation_status') == 3) is-active @endif" href="?confirmation_status=3"> مقالات تایید نشده</a>
            @permission('create_post')
                <a class="tab__item" href="{{ route('admin.content.post.create') }}">ایجاد مقاله جدید</a>
            @endpermission
        </div>
    </div>

    <div class="bg-white padding-20">
        <div class="t-header-search">
            <form action="" method="get">
                <div class="t-header-searchbox font-size-13">
                    <input type="text" class="text search-input__box" placeholder="جستجوی در مقالات وبسایت">
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
        @permission('manage_post')
            <div class="d-flex item-center flex-wrap margin-bottom-15 operations__btns">
                <button onclick="acceptAllLessons('{{ route('admin.content.post.acceptAll') }}')"
                    class="btn all-confirm-btn">تایید همه مقالات</button>
                <button onclick="acceptMultiple('{{ route('admin.content.post.acceptMultiple') }}')"
                    class="btn confirm-btn ml-2">تایید مقالات</button>
                <button onclick="rejectMultiple('{{ route('admin.content.post.rejectMultiple') }}')"
                    class="btn reject-btn ml-2">رد مقالات</button>
                <button onclick="deleteMultiple('{{ route('admin.content.post.destroyMultiple') }}')"
                    class="btn d delete-btn">حذف مقالات</button>

            </div>
        @endpermission
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
                    <th>عنوان</th>
                    <th>تصویر</th>
                    <th>نویسنده </th>
                    <th>دسته بندی</th>
                    <th>نوع دسترسی</th>

                    {{-- <th>تعداد بازدید</th> --}}
                    <th>نظرات</th>
                    <th>وضعیت تایید</th>
                    @permission('manage_post')
                        <th>وضعیت نمایش</th>
                    @endpermission
                    <th>عملیات</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($posts as $post)
                    <tr role="row">
                        <td>
                            <label class="ui-checkbox">
                                <input type="checkbox" name="ids[]" value="{{ $post->id }}" class="sub-checkbox"
                                    data-id="{{ $post->id }}">
                                <span class="checkmark"></span>
                            </label>
                        </td>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $post->title ?? '-' }}</td>
                        <td>
                            <img src="{{ asset($post->image) }}" alt="" width="100" height="50">
                        </td>
                        <td>{{ $post->author->FullName ?? '-' }}</td>
                        <td>{{ $post->category->title ?? '-' }}</td>
                        <td>{{ $post->is_vip == 1 ? 'ویژه' : 'همه' }}</td>

                        {{-- <td>{{ $post->views ?? '-' }}</td> --}}
                        <td>{{ $post->comments->count() ?? '-' }}</td>
                        <td @if ($post->confirmation_status == 0) class="text-danger" @endif
                            @if ($post->confirmation_status == 1) class="text-success" @endif
                            @if ($post->confirmation_status == 2) class="text-warning" @endif>
                            {{ $post->ConfirmationStatusValue }}</td>
                        @permission('manage_post')
                            <td>

                                <label>
                                    <input id="{{ $post->id }}" onchange="changeStatus({{ $post->id }})"
                                        data-url="{{ route('admin.content.post.status', $post->id) }}" type="checkbox"
                                        @if ($post->status === 1) checked @endif>
                                </label>
                            </td>
                        @endpermission

                        <td>
                            @permission('delete_post')
                                <form action="{{ route('admin.content.post.destory', $post->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="item-delete mlg-15 delete" style="" title="حذف">
                                        <li class="fa-solid fa-trash"></li>
                                    </button>
                                @endpermission
                                <a href="{{ route('customer.singlePost', $post->slug) }}" target="_blank"
                                    class="item-eye mlg-15" title="مشاهده">
                                    <li class="fa-solid fa-eye"></li>
                                </a>
                                @permission('manage_post')
                           @if($post->confirmation_status == 1)
                                    <a href="{{ route('admin.content.post.reject', $post->id) }}" class="item-reject mlg-15"
                                        title="رد">
                                        <li class="fa-solid fa-xmark"></li>
                                    </a>
                                    @elseif ($post->confirmation_status == 2)
                                    <a href="{{ route('admin.content.post.reject', $post->id) }}" class="item-reject mlg-15"
                                        title="رد">
                                        <li class="fa-solid fa-xmark"></li>
                                        <a href="{{ route('admin.content.post.accept', $post->id) }}" class="item-confirm mlg-15"
                                            title="تایید">
                                            <li class="fa-solid fa-check"></li>
                                        </a>
                                    </a>
                                    @else
                                    <a href="{{ route('admin.content.post.accept', $post->id) }}" class="item-confirm mlg-15"
                                        title="تایید">
                                        <li class="fa-solid fa-check"></li>
                                    </a>
                                    @endif
                                @endpermission
                                @permission('edit_post')
                                <a href="{{ route('admin.content.post.edit', $post->id) }}" class="item-edit "
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
    {{ $posts->links('admin.layouts.paginate') }}
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
