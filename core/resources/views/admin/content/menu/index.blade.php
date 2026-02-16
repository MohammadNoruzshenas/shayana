@extends('admin.layouts.master')

@section('breadcrumb')
    <li><a href="{{ route('admin.content.menu.index') }}">منو</a></li>
@endsection
@section('content')
    <div class="row no-gutters  ">
        <div class="col-8 margin-left-10 margin-bottom-15 border-radius-3 ">
            <p class="box__title">منو</p>
            <div class="table__box">
                <table class="table">
                    <thead role="rowgroup">
                        <tr role="row" class="title-row">
                            <th>#</th>
                            <th>نام منو</th>
                            <th>منوی والد</th>
                            <th>الویت </th>
                            <th> لینک منو</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($menus as $key => $menu)
                            <tr role="row" class="">

                                <td>{{ $key + 1 }}</td>
                                <td>{{ $menu->name }}</td>
                                <td>{{ $menu->parent_id ? $menu->parent->name : 'منوی اصلی' }}</td>
                                <td>{{ $menu->priority }}</td>

                                <td>{{ Str::limit($menu->url, 50, '') }}</td>
                                <td>
                                    <label>
                                        <input id="{{ $menu->id }}" onchange="changeStatus({{ $menu->id }})"
                                            data-url="{{ route('admin.content.menu.status', $menu->id) }}" type="checkbox"
                                            @if ($menu->status === 1) checked @endif>
                                    </label>
                                </td>
                                <td>
                                    @permission('delete_menu')
                                        <form action="{{ route('admin.content.menu.destory', $menu) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="item-delete mlg-15 delete" title="حذف">
                                                <li class="fa-solid fa-trash"></li>
                                            </button>
                                        @endpermission
                                        <a href="{{ $menu->link() }}" target="_blank" class="item-eye mlg-15"
                                            title="مشاهده">
                                            <li class="fa-solid fa-eye"></li>
                                        </a>
                                        @permission('edit_menu')
                                            <a href="{{ route('admin.content.menu.edit', $menu->id) }}" class="item-edit "
                                                title="ویرایش">
                                                <li class="fa-solid fa-edit"></li>
                                            </a>
                                        @endpermission

                                    </form>

                                </td>
            </div>
            </tr>
            @endforeach

            </tbody>
            </table>
        </div>
        <!-- paginate -->
        {{ $menus->links('admin.layouts.paginate') }}
        <!-- endpaginate -->
    </div>
    @permission('create_menu')
        @include('admin.content.menu.create')
    @endpermission
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
                                title: 'منو  با موفقیت فعال شد',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        } else {
                            element.prop('checked', false);
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: ' منو با موفقیت غیرفعال شد',
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
    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection
