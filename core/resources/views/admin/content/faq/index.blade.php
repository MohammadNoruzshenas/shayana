@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.market.course.index') }}"> سوال های متداول</a></li>
@endsection
@section('content')
        <div class="tab__box">
            <div class="tab__items">
                    <a class="tab__item" href="{{ route('admin.content.faq.create') }}">ایجاد سوال</a>
            </div>
        </div>
                <table class="table">

                    <thead role="rowgroup">
                        <tr role="row" class="title-row">
                            <th>شناسه</th>
                            <th>سوال</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($faqs as $faq)
                            <tr role="row">
                                <td>{{ $loop->iteration }}</a></td>
                                <td>{{ $faq->question }}</a></td>
                                <td>
                                    <label>
                                        <input id="{{ $faq->id }}"
                                            onchange="changeStatus({{ $faq->id }})"
                                            data-url="{{ route('admin.content.faq.status', $faq->id) }}"
                                            type="checkbox" @if ($faq->status === 1) checked @endif>
                                    </label>
                                </td>
                                <td>
                                    <form action="{{ route('admin.content.faq.destroy', $faq->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                    <button  class="item-delete mlg-15 delete" style=""
                                                title="حذف"><i class="fa fa-trash"></i></button>
                                        <a href="{{ route('admin.content.faq.edit', $faq->id) }}" class="item-edit "
                                            title="ویرایش"><i class="fa fa-edit"></i></a>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
          <!-- paginate -->
 {{ $faqs->links('admin.layouts.paginate') }}
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
