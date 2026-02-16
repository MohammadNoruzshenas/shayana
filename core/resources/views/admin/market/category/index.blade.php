@extends('admin.layouts.master')

@section('head-tag')
<title>دسته بندی دوره ها</title>
@endsection

@section('breadcrumb')
    <li><a href="{{ route('admin.market.category.index') }}" title="دسته بندی ها">دسته بندی ها</a></li>
@endsection


@section('content')
        <div class="row no-gutters ">
            <div class="col-8 margin-left-10 margin-bottom-15 border-radius-3">
                <p class="box__title">دسته بندی ها</p>
                <div class="table__box">
                    <table class="table">
                        <thead role="rowgroup">
                            <tr role="row" class="title-row">
                                <th>شناسه</th>
                                <th>نام دسته بندی</th>
                                <th>دسته پدر</th>
                                {{-- <th>نمایش در منو</th> --}}
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($courseCategories as $courseCategory)
                                <tr role="row" class="">
                                    <td><a href="">{{ $loop->iteration }}</a></td>
                                    <td><a href="">{{ $courseCategory->title }}</a></td>
                                    <td> {{ $courseCategory->parent->title ?? '-' }}</td>
                                    {{-- <td>
                                        <label>
                                            <input id="{{ $courseCategory->id }}"
                                                onchange="changeStatus({{ $courseCategory->id }})"
                                                data-url="{{ route('admin.market.category.status', $courseCategory->id) }}"
                                                type="checkbox" @if ($courseCategory->status === 1) checked @endif>
                                        </label>
                                    </td> --}}
                                    <td>
                                        <form action="{{ route('admin.market.category.destory', $courseCategory->id) }}"
                                            method="post">
                                            @csrf
                                            @method('delete')
                                            @permission('delete_category')
                                                <button class="item-delete mlg-15 delete" title="حذف"><li class="fa fa-trash"></li></button>
                                            @endpermission
                                            <a href="{{ route('customer.courses',$courseCategory->slug) }}" target="_blank" class="item-eye mlg-15" title="مشاهده"><li class="fa fa-eye"></li></a>
                                            @permission('edit_category')
                                                <a href="{{ route('admin.market.category.edit', $courseCategory->id) }}"
                                                    class="item-edit " title="ویرایش"><li class="fa fa-edit"></li></a>
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
            {{ $courseCategories->links('admin.layouts.paginate') }}
            <!-- endpaginate -->
                </div>
        @permission('create_category')
            @include('admin.market.category.create')
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
                                title: 'دسته بندی با موفقیت فعال شد',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        } else {
                            element.prop('checked', false);
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'دسته بندی با موفقیت غیرفعال شد',
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
