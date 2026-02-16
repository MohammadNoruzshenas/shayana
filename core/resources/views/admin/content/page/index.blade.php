@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.content.page.index') }}"> صفحه ساز</a></li>
@endsection
@section('content')
        <div class="tab__box">
            <div class="tab__items">
                    <a class="tab__item" href="{{ route('admin.content.page.create') }}">ایجاد  صفحه جدید </a>
            </div>
        </div>
                <table class="table">

                    <thead role="rowgroup">
                        <tr role="row" class="title-row">
                            <th>شناسه</th>
                            <th>عنوان صفحه</th>
                            <th>ادرس صفحه</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pages as $page)
                            <tr role="row">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $page->title }}</td>
                                <td class="ltr-text" style="text-align: center">{{isset($_SERVER['https']) ? 'https://' : 'http://'.request()->getHost() .'/page/'. $page->slug }}</td>

                                <td>
                                    <label>
                                        <input id="{{ $page->id }}"
                                            onchange="changeStatus({{ $page->id }})"
                                            data-url="{{ route('admin.content.page.status', $page->id) }}"
                                            type="checkbox" @if ($page->status === 1) checked @endif>
                                    </label>
                                </td>
                                <td>
                                    <form action="{{ route('admin.content.page.destroy', $page->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                    <button class="item-delete mlg-15 delete"
                                                title="حذف"><i class="fa fa-trash"></i></button>
                                        <a href="{{ route('customer.page',$page->slug) }}" target="_blank" class="item-eye mlg-15" title="مشاهده"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('admin.content.page.edit', $page->id) }}" class="item-edit "
                                            title="ویرایش"><i class="fa fa-edit"></i></a>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
                 <!-- paginate -->
 {{ $pages->links('admin.layouts.paginate') }}
 <!-- endpaginate -->
        </div>
             <!-- paginate -->
 {{ $pages->links('admin.layouts.paginate') }}
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
                                title: 'وضعیت با موفقیت فعال شد',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        } else {
                            element.prop('checked', false);
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: ' وضعیت با موفقیت غیرفعال شد',
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


            }
    </script>
    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection
