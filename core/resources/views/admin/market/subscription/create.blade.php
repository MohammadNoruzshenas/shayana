@extends('admin.layouts.master')
@section('head-tag')
    <title>افزودن  اشتراک</title>
    <link rel="stylesheet" href="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection
@section('breadcrumb')
<li><a href="{{ route('admin.market.subscription.index') }}">اشتراک </a></li>
<li><a href="#">افزودن اشتراک</a></li>
@endsection
@section('content')
    <div class="col-12 bg-white">

        <div class="main-content">
            <form action="{{ route('admin.market.subscription.store') }}" method="POST">
                @csrf
                <section class="row">
                    <section class="col-12 col-md-6">
                        <input type="text" name="user" value="{{ old('user') }}"
                        required
                        placeholder="ایمیل  یا موبایل را وارد کنید" class="text">
                    @error('user')
                        <span class="text-error" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror

                        <select name="plan_id" id="">
                            <option value="0">انتخاب پلن</option>
                            @foreach ($plans as $plan)
                                <option value="{{ $plan->id }}" @if (old('plan_id') == $plan->id) selected @endif>{{ $plan->name }}</option>
                            @endforeach
                        </select>
                        @error('plan_id')
                            <span class="text-error" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror

                        <div class="form-group">
                            <label for=""> هزینه دریافت شده</label>
                            <input type="text" name="price" value="{{ old('price') }}"class="text w-10">
                        </div>
                        @error('price')
                            <span class="alert_required text-error p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                        <div class="form-group">
                            <label for="">توضیح بابت پرداخت</label>
                            <input type="text" name="description" value="{{ old('description') }}"class="text w-10">
                        </div>
                        @error('description')
                            <span class="alert_required text-error p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </section>

                    <section class="col-12">
                        <div class="form-group">
                            <label for="status">وضعیت</label>
                            <select name="status" id="" class="text w-10" id="status">
                                <option value="0" @if (old('status') == 0) selected @endif>غیرفعال</option>
                                <option value="1" @if (old('status') == 1) selected @endif>فعال</option>

                            </select>
                        </div>
                        @error('status')
                            <span class="alert_required  text-error p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </section>



                    <section class="col-12">
                        <button class="btn btn-primary btn-sm">ثبت</button>
                    </section>
                </section>
            </form>
            </section>

        @endsection

        @section('script')
            <script src="{{ asset('dashboard/js/jalalidatepicker/persian-date.min.js') }}"></script>
            <script src="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.js') }}"></script>
        @endsection
