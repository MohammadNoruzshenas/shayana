@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="#">کیف پول</a></li>
@endsection
@section('content')
    <div class="tab__box">
        <div class="tab__items">
            @permission('manage_financial')
            <a class="tab__item is-active" href="{{ route('admin.market.wallet.create') }}">افزودن</a>
            @endpermission



        </div>
    </div>

    <div class="row no-gutters">
        <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">
            <div class="bg-white padding-20">
                <div class="t-header-search">
                    <form action="">
                        <div class="t-header-searchbox font-size-13">
                            <input type="text" class="text search-input__box font-size-13"
                                placeholder="جستجوی در  کیف پول ">
                            <div class="t-header-search-content ">
                                @permission('manage_financial')
                                    <input type="text" class="text" name="email" value="{{ request('email') }}"
                                        placeholder="ایمیل">
                                @endpermission
                                <input type="text" class="text" name="amount" value="{{ request('amount') }}"
                                    placeholder="مبلغ">
                                <button type="submit" class="btn btn-webamooz_net">جستجو</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table__box">
                <div class="table-box">
                    <table class="table">
                        <thead role="rowgroup">
                            <tr role="row" class="title-row">
                                <th>#</th>
                                @permission('manage_financial')
                                    <th>ایمیل</th>
                                    <th>نام و نام خانوادگی</th>
                                @endpermission
                                <th>مبلغ</th>
                                <th>نوع</th>
                                <th>زمان</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($wallets as $wallet)
                                <tr role="row" class="">
                                    <td>{{ $loop->iteration }}</td>
                                    @permission('manage_financial')
                                        <td>{{ $wallet->user->email }} </td>
                                        <td>{{ $wallet->user->full_name }} </td>
                                    @endpermission
                                    <td class="{{$wallet->type == 1 ? 'text-success' : 'text-danger'}}">{{ priceFormat($wallet->price) }} تومان</td>
                                    <th class="">{{ $wallet->type == 1 ? 'واریز' : 'کسر' }}</th>
                                    <td> {{ \Carbon\Carbon::parse($wallet->created_at)->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{ route('admin.market.wallet.detail', $wallet) }}" class="item-edit "
                                            title="نمایش"><i class="fa fa-eye"></i></a>

                                    </td>
                            @endforeach

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- paginate -->
    {{ $wallets->links('admin.layouts.paginate') }}
    <!-- endpaginate -->
    </div>
@endsection
@section('script')
    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
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
                                title: ' تخفیف با موفقیت فعال شد',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        } else {
                            element.prop('checked', false);
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: ' تخفیف با موفقیت غیرفعال شد',
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
@endsection
