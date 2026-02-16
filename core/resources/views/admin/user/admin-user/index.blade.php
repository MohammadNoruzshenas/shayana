@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.user.admin-user.index') }}">مدیران</a></li>

@endsection

@section('content')
<div class="tab__box">
    <div class="tab__items">
        <a class="tab__item is-active" href="users.html">همه کاربران</a>
        <a class="tab__item" href="{{ route('admin.user.create') }}">ایجاد کاربر جدید</a>
    </div>
</div>
<div class="d-flex flex-space-between item-center flex-wrap padding-30 border-radius-3 bg-white">
    <div class="t-header-search">
        <form action="" method="get">
            <div class="t-header-searchbox font-size-13">
                <input type="text" class="text search-input__box" placeholder="جستجوی در کاربران وبسایت">
                <div class="t-header-search-content ">
                    <input type="text"  class="text" name="first_name" value="{{ request('first_name') }}"  placeholder="نام">
                    <input type="text"  class="text" name="last_name" value="{{ request('last_name') }}"  placeholder="خانوادگی">
                    <input type="text"  class="text" name="mobile" value="{{ request('mobile') }}" placeholder="شماره موبایل">
                    <input type="text"  class="text" name="email" value="{{ request('email') }}" placeholder="ایمیل">
                    <input type="text"  class="text" name="username" value="{{ request('username') }}" placeholder="نام کاربری">


                    <button type="submit" class="btn btn-webamooz_net">جستجو</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="table__box">
    <table class="table">
        <thead role="rowgroup">
        <tr role="row" class="title-row">
            <th>شناسه</th>
            <th>نام و نام خانوادگی</th>
            <th>ایمیل</th>
            <th>شماره موبایل</th>
            @permission('manage_financial')
            <th>موجودی</th>
            <th>مالی</th>

            @endpermission

            <th>نقش</th>
            <th>دسترسی خاص</th>
            <th>وضعیت حساب</th>
            <th>عملیات</th>
        </tr>
        </thead>
        <tbody>
@foreach ($users as $user)
        <tr role="row" class="">
            <td><a href="">{{ $loop->iteration}}</a></td>
            <td><a href="">{{ $user->FullName }}</a></td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->mobile ?? '-' }}</td>
            @permission('manage_financial')
            <td>{{ priceFormat($user->balance) }} تومان</td>
            <td><a class="color-link" href="{{route('admin.index')}}?userId={{$user->id}}">مشاهده</a></td>

            @endpermission
            <td>

                @forelse ($user->roles as $role)
                    {{ $role->name }}
                    @empty
                    نقش ندارد
                @endforelse
            </td>

            <td>@forelse ($user->permissions as  $permission)
                   <div> {{$permission->description}}</div>

            @empty
                دسترسی خاص ندارد
            @endforelse</td>
            <td class="@if ($user->status == 1) text-success @else text-danger @endif">
                {{ $user->status_value }}</td>            <td>

                <form action="{{ route('admin.user.destroy',$user->id) }}" method="post">
                    @method('delete')
                    @csrf
                <button href="" class="item-delete mlg-15 delete" title="حذف"><li class="fa-solid fa-trash"></li></button>
                <a href="{{ route('admin.user.admin-user.roles',$user) }}" class="item-role mlg-15" title="نقش کاربری"><li class="fa-solid fa-universal-access"></li></a>
                <a href="{{ route('admin.user.admin-user.permissions',$user) }}" class="item-permission mlg-15" title="دسترسی"><li class="fa-solid fa-shield"></li></a>
                <a href="{{ route('admin.user.user-information.index', $user) }}" target="_blank"
                class="item-eye mlg-15" title="مشاهده"><li class="fa-solid fa-eye"></li></a>

                <a href="{{ route('admin.user.edit',$user->id) }}" class="item-edit " title="ویرایش"><li class="fa-solid fa-edit"></li></a>


            </form>

            </td>
        </tr>
@endforeach
        </tbody>
    </table>
</div>
{{ $users->links('admin.layouts.paginate') }}
@endsection
@section('script')
@include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
