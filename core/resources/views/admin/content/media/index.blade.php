@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.content.media.index') }}" title="مدیا">مدیا</a></li>
@endsection
@section('content')
<div class="tab__box">
    <div class="tab__items">
        <a class="tab__item is-active" href="{{ route('admin.content.media.index') }}">لیست  مدیا</a>
        <a class="tab__item" href="{{ route('admin.content.media.create') }}">افزودن پرونده </a>
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
                        <th>ایجاد پرونده </th>
                        <th> عنوان</th>
                        <th>نوع</th>
                        <th>محل ذخیره</th>
                        <th>مشاهده </th>

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
                            <td><a href="">{{ $loop->iteration }}</a></td>
                            <td><a href="">{{ $media->user->FullName ?? '-' }}</a></td>
                            <td>{{ $media->title }}</td>
                            <td>{{ $media->is_private == 0 ? 'عمومی' : 'خصوصی' }}</td>
                            <td>{{ $media->storage_space}}</td>
                            <td>
                                    <a href="{{route('admin.content.media.details',$media)}}"
                                        title="مشاهده"><li class="fa-solid fa-eye"></li></a>
                            </td>
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
