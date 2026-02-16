@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.content.media.index') }}" title="مدیا">مدیا</a></li>
    <li><a href="">{{$media->title}}</a></li>

@endsection
@section('content')
<div class="tab__box">
    <div class="tab__items">
        <a class="tab__item " href="{{ route('admin.content.media.index') }}">لیست  پرونده ها</a>
        <a class="tab__item is-active" href="{{ route('admin.content.media.upload',$media) }}">افزودن رسانه </a>

    </div>
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
                        <th>کاربر اپلود کرده</th>
                        <th> عنوان فایل</th>
                        <th>لینک </th>
                        @permission('manage_uploader')
                        <th>عملیات</th>
                        @endpermission
                    </tr>
                </thead>
                <div class="d-flex item-center flex-wrap margin-bottom-15 operations__btns">
                    <button
                        onclick="deleteMultiple('{{ route('admin.content.media.destroyMultiple') }}')"
                        class="btn d delete-btn">حذف مدیا</button>
                <tbody>
                    @foreach ($medias as $media)
                        <tr role="row">

                            <td>
                                <label class="ui-checkbox">
                                    <input type="checkbox" name="ids[]" value="{{ $media->id }}" class="sub-checkbox"
                                        data-id="{{ $media->id }}">
                                    <span class="checkmark"></span>
                                </label>
                            </td>
                            <td>{{ $loop->iteration }}</a></td>
                            <td>{{ $media->user->FullName ?? '-' }}</a></td>
                            <td>{{ $media->title }}</td>
                            <td class="ltr-text" style="text-align: center">{{ $media->media }}</td>

                            @permission('manage_uploader')
                            <td>
                                <form action="{{ route('admin.content.media.destory', $media) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button  class="item-delete mlg-15 delete"
                                        title="حذف"><li class="fa-solid fa-trash"></li></button>
                                </form>
                            </td>
                            @endpermission
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
     <!-- paginate -->
 {{ $medias->links('admin.layouts.paginate') }}
 <!-- endpaginate -->
    </div>
@endsection
@section('script')
   <script>
        function deleteMultiple(route) {

            doMultipleAction(route, "حذف مدیا انتخاب شده", "delete")
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
