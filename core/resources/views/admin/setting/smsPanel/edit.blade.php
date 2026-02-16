@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.setting.smsPanel.index') }}">تنظیمات پنل اس ام اس</a></li>
    <li><a href="#">ویراش پنل اس ام اس ({{ $smsPanel->name_en . ' | ' . $smsPanel->name_fa }})</a></li>
@endsection
@section('content')
    <p class="box__title">ویراش درگاه ({{ $smsPanel->name_en . ' | ' . $smsPanel->name_fa }})</p>
    <div class="row no-gutters bg-white">
        <div class="col-12">
            <form action="{{ route('admin.setting.smsPanel.update', $smsPanel->id) }}" method="post" class="padding-30">
                @csrf
                @method('put')
                @if ($smsPanel->name_en == 'Melipayamak')
                    <p>Username:</p>
                    <input type="text" name="username" value="{{ old('username', $smsPanel->username) }}" class="text"
                        placeholder="username">
                    @error('username')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror
                    <p>Password:</p>
                    <input type="text" name="password" value="{{ old('password', $smsPanel->password) }}" class="text"
                        placeholder="password">
                    @error('password')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror
                    <p>number:</p>
                    <input type="text" name="number" value="{{ old('number', $smsPanel->number) }}" class="text"
                        placeholder="number">
                    @error('number')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror
                @endif


                <button class="btn btn-brand">ذخیره</button>
            </form>
        </div>
    </div>
    </div>
    </div>
@endsection
