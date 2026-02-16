@extends('admin.layouts.master')
@section('breadcrumb')
<li><a href="{{ route('admin.content.ads.index') }}">تبلیغات</a></li>

@endsection

@section('content')
<div class="tab__box">
    <div class="tab__items">
        <a class="tab__item is-active">لیست تبلیغات </a>
        @permission('create_ads')
        <a class="tab__item " href="{{ route('admin.content.ads.create') }}">ایجاد  تبلیغ</a>
        @endpermission

    </div>
</div>
<div class="table__box">
    <table class="table">

        <thead role="rowgroup">
        <tr role="row" class="title-row">
            <th class="p-r-90">شناسه</th>
            <th>عنوان</th>
            <th>تصویر</th>
            <th>لینک</th>
            <th>تاریخ شروع</th>
            <th>تاریخ پایان</th>

            <th>تاریخ ایجاد</th>
            <th>عملیات</th>
        </tr>
        </thead>
        <tbody>
@foreach ($adverts as $advert)
<tr role="row" class="">
    <td>{{ $loop->iteration }}</td>
    <td>{{ $advert->title }}</td>
    <td>
        <img class="img__slideshow" src="{{ asset($advert->banner)  }}" alt="" width="100" height="50">
    </td>
    <td>{{ $advert->link }}</td>
    <td>{{ jalaliDate($advert->start_at) }}</td>
    <td>{{ jalaliDate($advert->enddate_at) }}</td>
    <td>{{ jalaliDate($advert->created_at) }}</td>
    <td>
        @permission('delete_ads')
      <form action="{{ route('admin.content.ads.destory',$advert->id) }}" method="post">
        @csrf
        @method('delete')
        <button  class="item-delete mlg-15 delete" title="حذف"><li class="fa fa-trash"></li></button>
        @endpermission
        @permission('edit_ads')
        <a href="{{ route('admin.content.ads.edit',$advert->id) }}" class="item-edit" title="ویرایش">
        <li class="fa fa-edit"></li>
        </a>
        @endpermission
    </form>
    </td>
</tr>
@endforeach




        </tbody>
    </table>
</div>
</div>
         <!-- paginate -->
         {{ $adverts->links('admin.layouts.paginate') }}
         <!-- endpaginate -->
</div>
@endsection
@section('script')
@include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
