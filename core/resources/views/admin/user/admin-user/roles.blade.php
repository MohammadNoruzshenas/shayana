@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.user.admin-user.index') }}">مدیران</a></li>
    <li><a href="{{ route('admin.user.user-information.index', $admin) }}">{{ $admin->full_name }}</a></li>
    <li><a href="">ویرایش نقش</a></li>
@endsection
@section('content')
    <div class="row no-gutters  ">
        <div class="col-6 bg-white">
            <p class="box__title">بروزرسانی نقش کاربر</p>
            <form action="{{ route('admin.user.admin-user.roles.store', $admin) }}" method="post" class="padding-30">
                @csrf
                @php
                    $userRolesArray = $admin->roles->pluck('id')->toArray();
                @endphp

                <p class="box__title margin-bottom-15">انتخاب مجوزها</p>
                @foreach ($roles as $role)
                    <label class="ui-checkbox pt-1 pr-3" style="margin-bottom: 5px;margin-right:5px">
                        <input type="checkbox" name="roles[]" @if (in_array($role->id, $userRolesArray)) checked @endif
                        class="sub-checkbox" data-id="2" value="{{ $role->id }}">
                        <span class="checkmark" ></span>
                       <p style="margin-right: 5px;"> {{ $role->name }}</p> </label>
                @endforeach
                <hr>
                <button class="btn btn-webamooz_net mt-2">بروزرسانی</button>
            </form>
        </div>
    </div>
    </div>
@endsection
