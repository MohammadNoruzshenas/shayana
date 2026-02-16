@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.user.permission.index') }}">دسترسی ها</a></li>

@endsection
@section('content')
    <div class="row no-gutters  ">
        <div class="col-8 margin-left-10 margin-bottom-15 border-radius-3">
            <p class="box__title">نقش های کاربری</p>
            <div class="table__box">
                <table class="table">
                    <thead role="rowgroup">
                        <tr role="row" class="title-row">
                            <th>شناسه</th>
                            <th>نقش کاربری</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($roles as $role)

                        <tr role="row" class="">
                            <td><a href="">{{ $loop->iteration }}</a></td>
                            <td><a href="">{{ $role->name }}</a></td>

                            <td>
                                <form action="{{ route('admin.user.permission.destroy',$role) }}" method="post">
                                    @csrf
                                    @method('delete')
                                <button class="item-delete mlg-15 delete" title="حذف"><li class="fa-solid fa-trash"></li></button>
                                <a href="{{ route('admin.user.role.edit',$role) }}" class="item-edit "
                                    title="ویرایش"><li class="fa-solid fa-edit"></li></a>
                                </form>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            {{ $roles->links('admin.layouts.paginate') }}

        </div>
        <div class="col-4 bg-white">

            <p class="box__title">ایجاد نقش  جدید</p>
            <form action="{{ route('admin.user.permission.store') }}" method="post" class="padding-30">
                @csrf
                 <input type="text" name="name" required placeholder="عنوان" class="text">
                    <input type="text" name="description" required placeholder="توضیحات" class="text">
                <p class="box__title margin-bottom-15">انتخاب مجوزها</p>
                @foreach ($permissions as $permission)
                <label class="ui-checkbox pt-1 pr-3">
                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="sub-checkbox" data-id="{{ $permission->id }}">
                    <span class="checkmark"></span>
                    <div class="ml-2" style="padding: 5px;">{{ $permission->description }}</div>
                </label>
                @endforeach




                <hr>
                <button class="btn btn-webamooz_net mt-2">اضافه کردن</button>
            </form>
        </div>
    </div>
    </div>
    </div>
@endsection
@section('script')
@include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection
