@extends('admin.layouts.master')
@section('head-tag')
    <title>ویرایش تخفیف عمومی</title>
    <link rel="stylesheet" href="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection
@section('breadcrumb')
    <li><a href="{{ route('admin.market.discount.commonDiscount') }}">تخفیف عمومی </a></li>

    <li><a href="{{ route('admin.market.discount.commonDiscount.edit', $commonDiscount) }}">ویرایش تخفیف عمومی</a></li>
    <li><a href="{{ route('admin.market.discount.commonDiscount.edit', $commonDiscount) }}">{{ $commonDiscount->title }}</a>
    </li>
@endsection
@section('content')
    <div class="col-12 bg-white">

        <div class="main-content">

            <form action="{{ route('admin.market.discount.commonDiscount.update', $commonDiscount) }}" method="POST">
                @csrf
                @method('put')
                <section class="row">

                    <section class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">عنوان مناسبت</label>
                            <input type="text" name="title"
                                value="{{ old('title', $commonDiscount->title) }}"class="text w-10">
                        </div>
                        @error('title')
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
                            <input type="text" name="percentage"
                                value="{{ old('percentage', $commonDiscount->percentage) }}" class="text w-10">
                        </div>
                        @error('percentage')
                            <span class="alert_required text-error p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </section>


                    <section class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">نوع تخفیف</label>
                            <select name="type" id="type" class="form-control form-control-sm">
                                <option value="0" @if (old('type', $commonDiscount->commonable_type) == 'App\Models\Market\Course') selected @endif>همه دوره ها
                                </option>
                                <option value="1" @if (old('type', $commonDiscount->commonable_type) == 'App\Models\Market\Course') selected @endif>دوره ی خاص</option>
                                <option value="2" @if (old('type') == 'App\Models\Market\Plan') selected @endif>همه اشتراک ها
                                </option>
                                <option value="3" @if (old('type', $commonDiscount->commonable_type) == 'App\Models\Market\Plan') selected @endif>اشتراک خاص</option>
                                <option value="4" @if (old('type', $commonDiscount->commonable_type) == null) selected @endif>همه اقلام سایت
                                </option>
                            </select>
                        </div>
                    </section>
                    <section class="col-12 col-md-6">
                        <div id="selectCourseContainer" @if ($commonDiscount->commonable_type == 'App\Models\Market\Course') @else class="d-none" @endif>
                            <div class="form-group">
                                <label for="">دوره ها</label>
                                <select name="course_id" id="course_id" class="form-control form-control-sm">
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}"
                                            @if (old('course_id', $commonDiscount->commonable_id) == $course->id) selected @endif>{{ $course->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('course_id')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                            @enderror

                        </div>
                        <div id="selectPlanContainer" @if ($commonDiscount->commonable_type == 'App\Models\Market\Plan') @else class="d-none" @endif>
                            <div class="form-group">
                                <label for="">پلن ها</label>
                                <select name="plan_id" id="plan_id" class="form-control form-control-sm">
                                    @foreach ($plans as $plan)
                                        <option value="{{ $plan->id }}"
                                            @if (old('plan_id', $plan->commonable_type) == $plan->id) selected @endif>{{ $plan->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('plan_id')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                            @enderror

                        </div>
                    </section>

                    {{-- <section class="col-12 col-md-6">
                <div class="form-group">
                    <label for="">حداکثر تخفیف</label>
                    <input type="text" name="discount_ceiling" value="{{ old('discount_ceiling',$commonDiscount->discount_ceiling) }}" class="text w-10">
                </div>
                @error('discount_ceiling')
                <span class="alert_required  text-error p-1 rounded" role="alert">
                    <strong>
                        {{ $message }}
                    </strong>
                </span>
            @enderror
            </section>

            <section class="col-12 col-md-6">
                <div class="form-group">
                    <label for="">حداقل تخفیف</label>
                    <input type="text" name="minimal_order_amount" value="{{ old('minimal_order_amount',$commonDiscount->minimal_order_amount) }}" class="text w-10">
                </div>
                @error('minimal_order_amount')
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
                            <input type="text" value="{{$commonDiscount->start_date}}" id="start_date_view" class="text w-10">
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
                            <input type="text" value="{{$commonDiscount->end_date}}" id="end_date_view" class="text w-10">
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
                                <option value="0" @if (old('status', $commonDiscount->status) == 0) selected @endif>غیرفعال</option>
                                <option value="1" @if (old('status', $commonDiscount->status) == 1) selected @endif>فعال</option>
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
                        $('#selectCourseContainer').removeClass('d-none');
                    } else {
                        $('#selectCourseContainer').addClass('d-none');
                    }
                });
                $("#type").change(function() {

                    if ($('#type').find(':selected').val() == '3') {
                        $('#selectPlanContainer').removeClass('d-none');
                    } else {
                        $('#selectPlanContainer').addClass('d-none');
                    }
                });
            </script>
        @endsection
