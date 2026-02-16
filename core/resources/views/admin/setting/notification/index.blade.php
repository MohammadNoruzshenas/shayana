@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.setting.notification.index') }}">مدیریت اطلاع رسانی</a></li>
@endsection
@section('content')
<div class="main-content">
    <form action="{{ route('admin.setting.notification.update') }}" method="post">
    <div class="row no-gutters border-radius-3">
            @csrf
            @method('put')
            @foreach ($notifications as $notification)
        <div class="col-6 notification__box">
            <p class="margin-bottom-15">{{$notification->persian_name}}</p>
            <select  name="{{ $notification->id }}" id="">
                <option value="0" @if(old($notification->id,$notification->status) == 0) selected @endif>غیرفعال</option>
                <option value="1" @if(old($notification->id,$notification->status) == 1) selected @endif>ایمیل</option>
                @if ($notification->id == 3 | $notification->id == 4)
                <option value="2" @if(old($notification->id,$notification->status) ==2) selected @endif>پیامک</option>
                <option value="3" @if(old($notification->id,$notification->status) == 3) selected @endif>هردو</option>
                @endif

            </select>
            @error('{{ $notification->id }}')
            <span class="text-error" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror
        </div>
            @endforeach
    </div>
    <button class="btn btn-brand">ذخیره</button>
</form>

</div>
</div>
@endsection

