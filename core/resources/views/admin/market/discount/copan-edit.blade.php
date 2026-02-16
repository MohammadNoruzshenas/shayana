@extends('admin.layouts.master')
@section('head-tag')
    <title> یرایش کوپن تخفیف</title>
    <link rel="stylesheet" href="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection
@section('breadcrumb')
    <li><a href="{{ route('admin.market.discount.copan') }}">کوپن تخفیف</a></li>
    <li><a href="{{ route('admin.market.discount.copan') }}">{{ $copan->code }}</a></li>
    <li><a href="{{ route('admin.market.discount.copan.edit', $copan) }}">ویرایش</a></li>
@endsection
@section('content')
    <div class="col-12 bg-white">

        <div class="main-content">
            <form action="{{ route('admin.market.discount.copan.update', $copan) }}" method="POST">
                @csrf
                @method('put')
                <section class="row">

                    <section class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">کد کوپن</label>
                            <input type="text" name="code" value="{{ old('code', $copan->code) }}"class="text w-10">
                        </div>
                        @error('code')
                            <span class="alert_required text-error p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </section>
                    <section class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">نوع کوپن</label>
                            <select name="type" id="type" class="form-control form-control-sm">
                                <option value="0" @if (old('type', $copan->type) == 0) selected @endif>عمومی</option>
                                <option value="1" @if (old('type', $copan->type) == 1) selected @endif>خصوصی</option>
                            </select>
                        </div>
                    </section>
                    <section class="col-12 col-md-6">

                        <div id="selectUsersContainer" class="@if ($copan->type == 0) d-none @endif">

                            <input type="text" name="user"
                                @if ($copan->type == 0) value="{{ old('user') }}"
                                 @else
                                 value="{{ old('user', $copan->user->email ?? $copan->user->mobile) }}" @endif
                                placeholder="ایمیل  یا موبایل را وارد کنید" class="text">
                            @error('user')
                                <span class="text-error" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                            @enderror

                        </div>
                    </section>

                    <section class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">نوع تخفیف</label>
                            <select name="amount_type" id="amount_type" class="form-control form-control-sm">
                                <option value="0" @if (old('amount_type', $copan->amount_type) == 0) selected @endif>درصدی</option>
                                {{-- <option value="1" @if (old('amount_type', $copan->amount_type) == 1) selected @endif>عددی</option> --}}
                            </select>
                        </div>
                        @error('amount_type')
                            <span class="alert_required text-error p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </section>


                    <section class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">میزان تخفیف</label>
                            <input type="text" name="amount" value="{{ old('amount', $copan->amount) }}"
                                class="text w-10">
                        </div>
                        @error('amount')
                            <span class="alert_required text-error p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </section>


                    {{-- <section class="col-12 col-md-6">
                <div class="form-group">
                    <label for="">حداکثر تخفیف</label>
                    <input type="text" name="discount_ceiling" value="{{ old('discount_ceiling',$copan->discount_ceiling) }}" class="text w-10">
                </div>
                @error('discount_ceiling')
                <span class="alert_required  text-error p-1 rounded" role="alert">
                    <strong>
                        {{ $message }}
                    </strong>
                </span>
            @enderror
            </section> --}}

                    <section class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">تاریخ شروع</label>
                            <input type="text" name="start_date" id="start_date" class="text w-10 d-none">
                            <input type="text" value="{{ $copan->start_date }}" id="start_date_view" class="text w-10">
                        </div>
                        @error('start_date')
                            <span class="alert_required  text-error p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </section>

                    <section class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">تاریخ پایان</label>
                            <input type="text" name="end_date" id="end_date" class="text w-10 d-none">
                            <input type="text" value="{{ $copan->end_date }}" id="end_date_view" class="text w-10">
                        </div>
                        @error('end_date')
                            <span class="alert_required  text-error p-1 rounded" role="alert">
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
                                <option value="0" @if (old('status', $copan->status) == 0) selected @endif>غیرفعال</option>
                                <option value="1" @if (old('status', $copan->status) == 1) selected @endif>فعال</option>
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

            <script>
                $(document).ready(function() {
                    $('#start_date_view').persianDatepicker({
                            format: 'YYYY/MM/DD',
                            altField: '#start_date',
                            autoClose: true
                        }),
                        $('#end_date_view').persianDatepicker({
                            format: 'YYYY/MM/DD',
                            altField: '#end_date',
                            autoClose: true
                        })
                });
                $("#type").change(function() {

                    if ($('#type').find(':selected').val() == '1') {
                        $('#selectUsersContainer').removeClass('d-none');
                    } else {
                        $('#selectUsersContainer').addClass('d-none');
                    }
                });
            </script>
        @endsection
