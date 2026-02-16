@extends('admin.layouts.master')
@section('head-tag')
<!-- CSRF Token -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('breadcrumb')
<li>
    <a href="{{ route('admin.market.course.index') }}" title="دوره ها">دوره ها</a>
</li>
<li>
    <a href="{{ route('admin.market.course.details', $course->id) }}">{{ $course->title }}</a>
</li>
<li>
    <a>فصل </a>
</li>
<li>
    <a>{{$season->title}} </a>
</li>

@endsection
@section('content')
<a href="{{ route('admin.market.course.details',$course) }} " class="item-reject mlg-15 btn all-confirm-btn font-size-13 mb-5"
type="submit">برگشت </a>
<div class="row no-gutters  ">
    <div class="col-12 bg-white padding-30 margin-left-10 margin-bottom-15 border-radius-3">
        <div class="margin-bottom-20 flex-wrap font-size-14 d-flex bg-white padding-0">
            <p class="mlg-15">{{ $course->title }}</p>

            @if (auth()->user()->can('manage_course') || auth()->user()->can('create_lession'))
            <a class="color-2b4a83"
                href="{{ route('admin.market.course.lession.create',['course' =>$course,'season'=>$season]) }}">آپلود
                جلسه جدید</a>
            @endif
        </div>
        <div class="d-flex item-center flex-wrap margin-bottom-15 operations__btns">
            @if (auth()->user()->can('own_course') || auth()->user()->can('manage_course'))

            <button
                onclick="acceptMultiple('{{ route('admin.market.course.lession.acceptMultiple',['course' => $course->id,'season' => $season]) }}')"
                class="btn confirm-btn ml-2">تایید جلسات</button>
            <button
                onclick="rejectMultiple('{{ route('admin.market.course.lession.rejectMultiple', [$course->id,'season' => $season]) }}')"
                class="btn reject-btn ml-2">رد جلسات</button>
            <button
                onclick="deleteMultiple('{{ route('admin.market.course.lession.destroyMultiple', [$course->id,'season' => $season]) }}')"
                class="btn d delete-btn">حذف جلسات</button>
            @endif
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
                        <th>عنوان جلسه</th>
                        <th>عنوان فصل</th>
                        <th>مدت زمان جلسه</th>
                        <th>وضعیت تایید</th>
                        <th>سطح دسترسی</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody id="tableBodyContents">

                    @foreach ($season->lession as $lession)
                    <tr role="row" class="tableRow" data-id="{{ $lession->id }}">
                        <td>
                            <label class="ui-checkbox">
                                <input type="checkbox" name="ids[]" value="{{ $lession->id }}" class="sub-checkbox"
                                    data-id="{{ $lession->id }}">
                                <span class="checkmark"></span>
                            </label>
                        </td>
                        <td><a href="">{{ $loop->iteration }}</a></td>
                        <td><a class="text-blue" href="{{route('customer.course.showLession',['course' => $course,'lession' => $lession])}}">{{ $lession->title }}</a></td>
                        <td>{{ $lession->season->title ?? '-' }}</td>
                        <td>{{ $lession->time }} دقیقه</td>
                        <td @if ($lession->confirmation_status_value == 'رد شده') class="text-danger" @endif
                            @if ($lession->confirmation_status_value == 'تایید شده') class="text-success" @else
                            class="text-warning" @endif>
                            {{ $lession->confirmation_status_value }}</td>
                        <td>@if ($lession->is_free == 0)
                            رایگان
                            @else
                            نقدی
                            @endif</td>


                        <td>
                            @if(auth()->user()->can('delete_lession') || auth()->user()->can('manage_course'))
                            <form
                                action="{{ route('admin.market.course.lession.destory', ['course' => $course->id, 'lession' => $lession->id,'season' => $season]) }}"
                                method="post">
                                @csrf
                                @method('delete')
                                <button class="item-delete mlg-15 delete" data-id="1" title="حذف">
                                    <li class="fa-solid fa-trash"></li>
                                </button>
                                @endif
                                @if (auth()->user()->can('manage_course') || auth()->user()->can('own_course'))
                                <a href="{{ route('admin.market.course.lession.reject', ['course' => $course->id, 'lession' => $lession]) }}"
                                    class="item-reject mlg-15" title="رد">
                                    <li class="fa-solid fa-xmark"></li>
                                </a>
                                <a href="{{ route('admin.market.course.lession.pending', ['course' => $course->id,'season' => $season, 'lession' => $lession->id]) }}"
                                    class="item-lock mlg-15" title="قفل ">
                                    <li class="fa-solid fa-lock"></li>
                                </a>
                                <a href="{{ route('admin.market.course.lession.accept', ['course' => $course->id, 'lession' => $lession,'season' => $season]) }}"
                                    class="item-confirm mlg-15" title="تایید">
                                    <li class="fa-solid fa-check"></li>
                                </a>
                                @endif
                                @if(auth()->user()->can('edit_lession') || auth()->user()->can('manage_course'))
                                <a href="{{ route('admin.market.course.lession.edit', ['course' => $course->id, 'lession' => $lession->id]) }}"
                                    class="item-edit " title="ویرایش">
                                    <li class="fa-solid fa-edit"></li>
                                </a>
                                @endif
                            </form>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

</div>
</div>
@endsection
@section('script')
@include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])

<script>
function acceptAllLessons(route) {
    Swal.fire({
        title: 'آیا از این کار مطمئن هستید؟',
        text: 'تایید همه جلسات',
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
    doMultipleAction(route, "تایید جلسات انتخاب شده", 'patch')
}

function rejectMultiple(route) {
    doMultipleAction(route, "رد جلسات انتخاب شده ", 'patch')
}

function deleteMultiple(route) {
    doMultipleAction(route, "حذف جلسات انتخاب شده", "delete")
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

<script>
function ButtonDisableR() {
    setTimeout(() => {
        document.getElementById("SubmitButtonStudent").setAttribute("disabled", "true");
    }, 1);
}
</script>

  <!-- jQuery UI CDN Link -->
  <script src="{{ asset('dashboard/js/jquery-ui.min.js') }}"></script>

  <!-- DataTables JS CDN Link -->
  <script src="{{ asset('dashboard/js/jquery.dataTables.min.js') }}"></script>

  <!-- DataTables JS ( includes Bootstrap 5 for design [UI] ) CDN Link -->
  <script type="text/javascript" src="{{ asset('dashboard/js/toastify-js.js') }}"></script>
<script type="text/javascript">
$(function() {

    $("#table").DataTable();

    $("#tableBodyContents").sortable({
        items: "tr",
        cursor: 'move',
        opacity: 0.6,
        update: function() {
            sendOrderToServer();
        }
    });

    function sendOrderToServer() {

        var order = [];
        var token = $('meta[name="csrf-token"]').attr('content');

        $('tr.tableRow').each(function(index, element) {
            order.push({
                id: $(this).attr('data-id'),
                position: index + 1
            });
        });

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ route('admin.market.course.lession.reorder', ['course' => $course,'season' => $season]) }}",
            data: {
                order: order,
                _token: token
            },
            success: function(response) {
                if (response.status == 200) {
                    Toastify({
                        text: "ترتیب جلسات با موفقیت ویرایش شد",
                        className: "info",
                        gravity: "top", // `top` or `bottom`
                        position: "center", // `left`, `center` or `right`

                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                        }
                    }).showToast();
                } else {
                    Toastify({
                        text: "خطا در ویرایش اطلاعات",
                        className: "info",
                        gravity: "top", // `top` or `bottom`
                        position: "center", // `left`, `center` or `right`
                        style: {
                            background: "linear-gradient(to right, #C40C0C, #FF6500)",
                        }
                    }).showToast();
                }
            }
        });
    }
});
</script>
@endsection
