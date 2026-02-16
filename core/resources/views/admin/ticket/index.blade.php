@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.ticket.index') }}">تیکت ها</a></li>
@endsection
@section('content')
        <div class="tab__box">
    <div class="tab__items">
    <a class="tab__item @if(request('status') == null) is-active @endif" href="{{ route('admin.ticket.index') }}">همه تیکت ها  </a>
    <a class="tab__item @if(request('status') == 2) is-active @endif" href="?status=2">تیکت های در حال بررسی</a>
    <a class="tab__item @if(request('status') == 1) is-active @endif" href="?status=1">تیکت های در انتظار کاربر</a>
    <a class="tab__item @if(request('status') == 3) is-active @endif" href="?status=3">تیکت های بسته  </a>



    </div>
    </div>
        <table class="table">

            <thead role="rowgroup">
                <tr role="row" class="title-row">
                    <th>#</th>
                    <th>نویسنده تیکت</th>
                    <th>عنوان تیکت</th>
                    <th>وضعیت </th>
                    <th>تاریخ ایجاد </th>
                    <th>تاریخ آخرین پاسخ </th>
                    <th>عملیات</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($tickets as $ticket)
                    @php
                        $lastChildren = $ticket->children[0] ?? $ticket;

                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><a href="{{route('admin.user.user-information.index',$ticket->user)}}">{{ $ticket->user->full_name}}</a></td>
                        <td>{{ $ticket->subject }}</td>
                        <td class="@if ($ticket->status == 1) text-success @endif @if ($ticket->status == 2)
                            text-blue @endif
                            @if($ticket->status == 0)
                             text-danger @endif
                        ">
                            {{ $ticket->status_value }}</td>
                        <td>{{ \Morilog\Jalali\Jalalian::fromCarbon($ticket->created_at)->format('Y/m/d H:i') }}</td>
                        <td>{{ \Morilog\Jalali\Jalalian::fromCarbon($lastChildren->created_at)->format('Y/m/d H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.ticket.show',$ticket) }}"  class="item-eye mlg-15" title="مشاهده"><i class="fa fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    </div>
      <!-- paginate -->
  {{ $tickets->links('admin.layouts.paginate') }}
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


        }
    </script>
    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection
