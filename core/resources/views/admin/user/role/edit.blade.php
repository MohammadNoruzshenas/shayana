@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.user.permission.index') }}">نقش  ها</a></li>
    <li><a href="">{{ $role->name }}</a></li>

    <li><a href="">ویرایش نقش </a></li>

@endsection
@section('content')
    <div class="row no-gutters  ">
        <div class="col-6 bg-white">
            <p class="box__title">بروزرسانی نقش کاربری</p>
            <form action="{{ route('admin.user.role.update',$role->id) }}" method="post" class="padding-30">
                @csrf
                @method('put')
                <input type="text" name="name" required placeholder="نام نقش کاربری" class="text" value="{{ old('name',$role->name) }}">
                @error('name')
                <span class="text-error" role="alert">
                    <strong>
                        {{ $message }}
                    </strong>
                </span>
            @enderror
            <input type="text" name="description" required placeholder="توضحیات نقش کاربری" class="text" value="{{ old('description',$role->description) }}">
            @error('description')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror

        @php
        $rolePermissionsArray = $role->permissions->pluck('id')->toArray();
      @endphp

                <p class="box__title margin-bottom-15">انتخاب مجوزها</p>
                @foreach ($permissions as $permission)
                <label class="ui-checkbox pt-1 pr-3" >
                    <input type="checkbox" name="permissions[]" class="sub-checkbox" data-id="2"
                        value="{{ $permission->id }}" @if(in_array($permission->id, $rolePermissionsArray)) checked @endif">
                    <span class="checkmark"> </span>
                    <div class="ml-2" style="padding: 5px;">{{ $permission->description }}</div>
                </label>
                    @endforeach
                <hr>
                <button class="btn btn-webamooz_net mt-2">بروزرسانی</button>
            </form>
        </div>
    </div>
    </div>
@endsection
