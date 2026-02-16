@extends('admin.layouts.master')
@section('head-tag')
    <title>ایچاد کوپن جدید</title>
    <link rel="stylesheet" href="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection
@section('breadcrumb')
<li><a href="#">اشتراک </a></li>
<li><a href="#">طرح های اشتراک </a></li>
@endsection
@section('content')
    <div class="col-12 bg-white">

        <div class="main-content">
            <form action="{{ route('admin.market.subscription.plans.store') }}" method="POST">
                @csrf
                <section class="row">

                    <section class="col-12 col-md-6">
                        <div class="form-group">
                            <label for=""> اسم پلن</label>
                            <input type="text" name="name" value="{{ old('name') }}"class="text w-10">
                        </div>
                        @error('name')
                            <span class="alert_required text-error p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                        <div class="form-group">
                            <label for=""> توضیحات پلن</label>
                            <input type="text" name="description" value="{{ old('description') }}"class="text w-10">
                        </div>
                        @error('description')
                            <span class="alert_required text-error p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                        <div class="form-group">
                            <label for=""> قیمت پلن</label>
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
                            <label for="">تعداد روز اشتراک</label>
                            <input type="text" name="subscription_day" value="{{ old('subscription_day') }}"class="text w-10">
                        </div>
                        @error('subscription_day')
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

            <script>
                $(document).ready(function() {
                    $('#start_date_view').persianDatepicker({
                            format: 'YYYY/MM/DD',
                            altField: '#start_date'
                        }),
                        $('#end_date_view').persianDatepicker({
                            format: 'YYYY/MM/DD',
                            altField: '#end_date'
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
