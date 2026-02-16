@extends('admin.layouts.master')
@section('breadcrumb')
    <title>کاربران</title>
    <li><a href="{{ route('admin.user.index') }}">کاربران</a></li>
@endsection

@section('content')
    <div class="tab__box">
        <div class="tab__items">
            <a class="tab__item @if(request('status') == null) is-active @endif" href="{{ route('admin.user.index') }}">همه کاربران</a>
            <a class="tab__item @if(request('status') == 3) is-active @endif" href="?status=3">کاربران تاییده نشده</a>
            <a class="tab__item @if(request('status') == 1) is-active @endif" href="?status=1">کاربران تایید شده</a>
            @permission('create_user')
            <a class="tab__item" href="{{ route('admin.user.create') }}">ایجاد کاربر جدید</a>
            @endpermission

        </div>
    </div>
    <div class="d-flex flex-space-between item-center flex-wrap padding-30 border-radius-3 bg-white">
        <div class="t-header-search">
            <form action="" method="get">
                <div class="t-header-searchbox font-size-13">
                    <input type="text" class="text search-input__box" placeholder="جستجوی در کاربران وبسایت">
                    <div class="t-header-search-content ">
                        <input type="text" class="text" name="first_name" value="{{ request('first_name') }}"
                            placeholder="نام">
                        <input type="text" class="text" name="last_name" value="{{ request('last_name') }}"
                            placeholder="خانوادگی">
                        <input type="text" class="text" name="mobile" value="{{ request('mobile') }}"
                            placeholder="شماره موبایل">
                        <input type="text" class="text" name="email" value="{{ request('email') }}"
                            placeholder="ایمیل">
                        <input type="text" class="text" name="username" value="{{ request('username') }}"
                            placeholder="نام کاربری">


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
                    <th>نام والد</th>
                    <th>سن</th>
                    <th>جنسیت</th>
                    <th>تاریخ تولد</th>
                    <th>اینستاگرام</th>
                    <th>تلگرام</th>
                    <th>تاریخ عضویت</th>
                    <th>درحال یادگیری</th>
                    <th>نقش‌ها</th>
                    <th>وضعیت حساب</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr role="row" class="">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->FullName }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->mobile ?? '-' }}</td>
                        <td>{{ $user->parent_name ?? '-' }}</td>
                        <td>
                            @if($user->birth)
                                {{ \Carbon\Carbon::parse($user->birth)->age }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($user->gender == 'male')
                                مرد
                            @elseif($user->gender == 'female')
                                زن
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $user->birth ? miladiDateTojalali($user->birth) : '-' }}</td>
                        <td>{{ $user->instagram ?? '-' }}</td>
                        <td>{{ $user->telegram ?? '-' }}</td>
                        <td>{{ jalaliDate($user->created_at) }}</td>
                        <td><a class="color-link" href="{{ route('admin.market.order.userOrder',$user) }}">{{count($user->orderItems) }}</td>
                        <td>
                            @if($user->roles->count() > 0)
                                @foreach($user->roles as $role)
                                    <span class="badge badge-primary" style="background-color: #007bff; color: white; padding: 2px 8px; border-radius: 12px; font-size: 11px; margin: 2px;">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                            <td class="@if ($user->status == 1) text-success @else text-danger @endif">
                            {{ $user->status_value }}</td>
                        <td>
                            <form action="{{ route('admin.user.destroy', $user->id) }}" method="post">
                                @method('delete')
                                @csrf
                                @permission('delete_user')
                                    <button class="item-delete mlg-15 delete" title="حذف"><li class="fa-solid fa-trash"></li></button>
                                @endpermission
                                <a href="{{ route('admin.user.user-information.index', $user) }}" target="_blank"
                                    class="item-eye mlg-15" title="مشاهده"><li class="fa-solid fa-eye"></li></a>
                                @permission('edit_user')
                                @if($user->status == 0)
                                    <a href="{{ route('admin.user.accept', $user) }}" class="item-confirm mlg-15"
                                        title="تایید"><li class="fa-solid fa-check"></li></a>
                                        @else
                                    <a href="{{ route('admin.user.reject', $user) }}" class="item-reject mlg-15"
                                        title="رد"><li class="fa-solid fa-xmark"></li></a>
                                        @endif
                                    <a href="{{ route('admin.user.edit', $user->id) }}" class="item-edit " title="ویرایش"><li class="fa-solid fa-edit"></li></a>
                                @endpermission
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
         <!-- paginate -->
         {{ $users->links('admin.layouts.paginate') }}
         <!-- endpaginate -->
@endsection
@section('script')
    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection
