@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.content.slider.index') }}">اسلایدر</a></li>
@endsection
@section('content')
<div class="tab__box">
    <div class="tab__items">
        <a class="tab__item is-active" href="{{ route('admin.content.slider.index') }}">لیست اسلاید ها</a>
        <a class="tab__item" href="{{ route('admin.content.slider.create') }}">ایجاد اسلاید جدید</a>

    </div>
</div>
<div class="table__box">
    <table class="table">

        <thead role="rowgroup">
        <tr role="row" class="title-row">
            <th class="p-r-90">شناسه</th>
            <th>عنوان</th>
            <th>تصویر</th>
            <th>وضعیت</th>
            <th>تاریخ ایجاد</th>
            <th>عملیات</th>
        </tr>
        </thead>
        <tbody>
@foreach ($sliders as $slider)
<tr role="row" class="">
    <td>{{ $loop->iteration }}</td>
    <td>{{ $slider->title }}</td>
    <td>
        <img class="img__slideshow" src="{{ asset($slider->banner) }}" alt="" width="100" height="50">
    </td>
    <td>
        <label>
            <input id="{{ $slider->id }}" onchange="changeStatus({{ $slider->id }})" data-url="{{ route('admin.content.slider.status', $slider->id) }}" type="checkbox" @if ($slider->status === 1)
            checked
            @endif>
        </label>
    </td>
    <td>{{ jalaliDate($slider->created_at) }}</td>
    <td>
      <form action="{{ route('admin.content.slider.destory',$slider->id) }}" method="post">
        @csrf
        @method('delete')
        <button  class="item-delete mlg-15 delete" title="حذف"><li class="fa-solid fa-trash"></li></button>
        <a href="{{ route('admin.content.slider.edit',$slider->id) }}" class="item-edit" title="ویرایش"><li class="fa fa-edit"></li></a>
    </form>
    </td>
</tr>
@endforeach




        </tbody>
    </table>
</div>
</div>
 <!-- paginate -->
 {{ $sliders->links('admin.layouts.paginate') }}
 <!-- endpaginate -->
</div>
@endsection
@section('script')
@include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
<script>
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
                    successToast('اسلاید  با موفقیت فعال شد')
                } else {
                    element.prop('checked', false);
                    successToast('اسلاید  با موفقیت غیر فعال شد')
                }
            } else {
                element.prop('checked', elementValue);
                errorToast('هنگام ویرایش مشکلی بوجود امده است')
            }
        },
        error: function() {
            element.prop('checked', elementValue);
            errorToast('ارتباط برقرار نشد')
        }
    });

    function successToast(message) {
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: message,
            showConfirmButton: false,
            timer: 1500
        })
    }
    function errorToast(message) {

        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: message,
            showConfirmButton: false,
            timer: 1500
        })
    }
}
</script>
@endsection
