@extends('admin.layouts.master')
@section('head-tag')
<title>پیشخوان</title>
<link rel="stylesheet" href="{{ asset('dashboard/css/dashboard.css') }}">


@endsection
@section('content')
@if($fullName)
<div class="userInformation">{{$fullName}}</div>

@endif
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="row" style="justify-content: space-between; margin:0px;">




            <div class="col-32 card mb-3 p-3">
                <p style="text-align:right;">  فروش روزانه</p>
                <div class="row">
                    <div class="col-4 text-center">
                        <span>{{$courseSellToday}}</span>
                        <p>تعداد فروش</p>
                    </div>
                    <div class="col-4 text-center">
                        <span>{{priceFormat($benefitTeacherToday)}} تومان</span>
                        <p>سود من</p>
                    </div>
                    <div class="col-4 text-center">
                        <span> {{priceFormat($benefitSiteToday)}} تومان</span>
                        <p>سود سایت</p>
                    </div>
                </div>
                <div class=" widget-content">
                    <div class="widget-content-outer">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-right">
                                <div class="widget-heading bg-primary p-2 rounded"><svg xmlns="http://www.w3.org/2000/svg" width="28"
                                        height="28" fill="currentColor" style="margin : 0 !important;" class="bi bi-currency-dollar"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73z" />
                                    </svg> درآمد کل</div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-numbers color-blue">{{ priceFormat($benefitSiteToday + $benefitTeacherToday) }} تومان</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-32 card mb-3 p-3">
                <p style="text-align:right;">  فروش ماهانه</p>
                <div class="row">
                    <div class="col-4 text-center">
                        <span>{{$courseSellMonth}}</span>
                        <p>تعداد فروش</p>
                    </div>
                    <div class="col-4 text-center">
                        <span>{{priceFormat($benefitTeacherMonth)}} تومان</span>
                        <p>سود من</p>
                    </div>
                    <div class="col-4 text-center">
                        <span> {{priceFormat($benefitSiteMonth)}} تومان</span>
                        <p>سود سایت</p>
                    </div>
                </div>
                <div class=" widget-content">
                    <div class="widget-content-outer">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-right">
                                <div class="widget-heading bg-primary p-2 rounded"><svg xmlns="http://www.w3.org/2000/svg" width="28"
                                        height="28" fill="currentColor" style="margin : 0 !important;" class="bi bi-currency-dollar"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73z" />
                                    </svg> درآمد کل</div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-numbers color-blue">{{ priceFormat($benefitTeacherMonth + $benefitSiteMonth) }} تومان</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-32 card mb-3 p-3">
                <p style="text-align:right;">  فروش سالانه</p>
                <div class="row">
                    <div class="col-4 text-center">
                        <span>{{$courseSellYear}}</span>
                        <p>تعداد فروش</p>
                    </div>
                    <div class="col-4 text-center">
                        <span>{{priceFormat($benefitTeacherYear)}} تومان</span>
                        <p>سود من</p>
                    </div>
                    <div class="col-4 text-center">
                        <span> {{priceFormat($benefitSiteYear)}} تومان</span>
                        <p>سود سایت</p>
                    </div>
                </div>
                <div class=" widget-content">
                    <div class="widget-content-outer">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-right">
                                <div class="widget-heading bg-primary p-2 rounded"><svg xmlns="http://www.w3.org/2000/svg" width="28"
                                        height="28" fill="currentColor" style="margin : 0 !important;" class="bi bi-currency-dollar"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73z" />
                                    </svg>
                                درآمد کل
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-numbers color-blue">{{ priceFormat($benefitSiteYear + $benefitTeacherYear) }} تومان</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            @if ($balance)
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content">
                    <div class="widget-content-outer">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-right">
                                <div class="widget-heading"> موجودی حساب فعلی </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-numbers text-success">{{ priceFormat($balance) }}
                                    تومان</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content">
                    <div class="widget-content-outer">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-right">
                                <div class="widget-heading"> کل فروش دوره ها</div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-numbers text-warning">
                                    {{ priceFormat($totalSiteShare + $totalBenefit) }} تومان</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content">
                    <div class="widget-content-outer">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-right">
                                <div class="widget-heading"> کارمزد کسر شده </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-numbers text-danger">{{ priceFormat($totalSiteShare) }} تومان</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content">
                    <div class="widget-content-outer">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-right">
                                <div class="widget-heading"> درآمد خالص </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-numbers color-blue">{{ priceFormat($totalBenefit) }} تومان</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content">
                    <div class="widget-content-outer">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-right">
                                <div class="widget-heading">تسویه حساب در حال انجام </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-numbers text-success">{{ priceFormat($settlementDoing) }} تومان
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content">
                    <div class="widget-content-outer">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-right">
                                <p>تراکنش های موفق امروز </p>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-numbers text-warning">{{ priceFormat($todaySuccessPaymentsCount) }}
                                    تراکنش </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content">
                    <div class="widget-content-outer">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-right">
                                <div class="widget-heading">تسویه شده</div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-numbers text-danger">{{ priceFormat($getSettlement) }} تومان</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <div class="main-card mb-3 card">
                        <div class="card-header">پرفروش ترین دوره 30 روز گذشته

                        </div>
                        <div class="table-responsive">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>نام</th>
                                        <th class="text-center">تعداد فروش</th>
                                        <th class="text-center">کل مبلغ فروش</th>
                                        <th class="text-center">سود خالص</th>
                                        <th class="text-center">سود سایت</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topSellCoursesMonth as $course)
                                        <tr>
                                            <td class="text-center text-muted">{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left mr-3">
                                                            <div class="widget-content-left">

                                                            </div>
                                                        </div>
                                                        <div class="widget-content-left flex2">
                                                            <div class="widget-heading">
                                                                {{ $course?->singleProduct?->title }}</div>
                                                            <div class="widget-subheading opacity-7">
                                                                {{ $course->singleProduct?->teacher?->email }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="badge badge-warning">
                                                    {{ $course?->TotalBuys }}</div>
                                            </td>
                                            <td class="text-center">
                                                {{ priceFormat($course->price) }} تومان</td>
                                                <td class="text-center">
                                                    {{ priceFormat($course->seller_share) }} تومان</td>
                                                    <td class="text-center">
                                                        {{ priceFormat($course->price - $course->seller_share) }} تومان</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="main-card mb-3 card">
                        <div class="card-header">پر فروش ترین دوره

                        </div>
                        <div class="table-responsive">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>نام</th>
                                        <th class="text-center">تعداد فروش</th>

                                        <th class="text-center">کل مبلغ فروش</th>
                                        <th class="text-center">سود خالص</th>
                                        <th class="text-center">سود سایت</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topSellCourses as $course)
                                        <tr>
                                            <td class="text-center text-muted">{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left mr-3">
                                                            <div class="widget-content-left">

                                                            </div>
                                                        </div>
                                                        <div class="widget-content-left flex2">
                                                            <div class="widget-heading">
                                                                {{ $course?->singleProduct?->title }}</div>
                                                            <div class="widget-subheading opacity-7">
                                                                {{ $course->singleProduct?->teacher?->email }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="badge badge-warning">
                                                    {{ $course->TotalBuys }}</div>
                                            </td>
                                            <td class="text-center">
                                                {{ priceFormat($course->price) }} تومان</td>
                                                <td class="text-center">
                                                    {{ priceFormat($course->seller_share) }} تومان</td>
                                                    <td class="text-center">
                                                        {{ priceFormat($course->price - $course->seller_share) }} تومان</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        <div class="row no-gutters font-size-13 margin-bottom-10">
            <div class="col-12 padding-20 bg-white margin-bottom-10 margin-left-10 border-radius-3">
                <div class="col-12 bg-white padding-30 margin-bottom-20">
                    <div id="container"></div>
                </div>
            </div>
        </div>
        @permission('manage_logs')
        <div class="row">

            <div class="col-md-12 col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">لاگ ها

                    </div>
                    <div class="table-responsive">
                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>نام</th>
                                    <th class="text-center">توضیحات</th>
                                    <th class="text-center">زمان</th>
                                    <th class="text-center">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $log)
                                <tr>
                                    <td class="text-center text-muted">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-3">
                                                    <div class="widget-content-left">

                                                    </div>
                                                </div>
                                                <div class="widget-content-left flex2">
                                                    <div class="widget-heading">{{ $log->user->email }}</div>
                                                    <div class="widget-subheading opacity-7">
                                                        {{ $log->user->full_name }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center" title="{{ strip_tags($log->description) }}">
                                        {{ Str::limit($log->description,40, '...') }}</td>
                                    <td class="text-center">
                                        <div class="badge badge-warning">
                                            {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}</div>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.log.show', $log) }}">
                                            <button type="button" id="PopoverCustomT-1"
                                                class="btn btn-primary btn-sm">جزییات</button>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>


        </div>
        @endpermission
        {{-- <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="card-shadow-danger mb-3 widget-chart widget-chart2 text-left card">
                        <div class="widget-content">
                            <div class="widget-content-outer">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left pl-2 fsize-1">
                                        <div class="widget-numbers mt-0 fsize-3 text-danger">71%</div>
                                    </div>
                                    <div class="widget-content-right w-100">
                                        <div class="progress-bar-xs progress">
                                            <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="71"
                                                aria-valuemin="0" aria-valuemax="100" style="width: 71%;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content-right fsize-1">
                                    <div class="text-muted opacity-6">هدف درامد</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card-shadow-success mb-3 widget-chart widget-chart2 text-left card">
                        <div class="widget-content">
                            <div class="widget-content-outer">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left pl-2 fsize-1">
                                        <div class="widget-numbers mt-0 fsize-3 text-success">54%</div>
                                    </div>
                                    <div class="widget-content-right w-100">
                                        <div class="progress-bar-xs progress">
                                            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="54"
                                                aria-valuemin="0" aria-valuemax="100" style="width: 54%;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content-right fsize-1">
                                    <div class="text-muted opacity-6">هزینه هدف</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card-shadow-warning mb-3 widget-chart widget-chart2 text-left card">
                        <div class="widget-content">
                            <div class="widget-content-outer">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left pl-2 fsize-1">
                                        <div class="widget-numbers mt-0 fsize-3 text-warning">32%</div>
                                    </div>
                                    <div class="widget-content-right w-100">
                                        <div class="progress-bar-xs progress">
                                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="32"
                                                aria-valuemin="0" aria-valuemax="100" style="width: 32%;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content-right fsize-1">
                                    <div class="text-muted opacity-6">هزینه هدف</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card-shadow-info mb-3 widget-chart widget-chart2 text-left card">
                        <div class="widget-content">
                            <div class="widget-content-outer">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left pl-2 fsize-1">
                                        <div class="widget-numbers mt-0 fsize-3 text-info">89%</div>
                                    </div>
                                    <div class="widget-content-right w-100">
                                        <div class="progress-bar-xs progress">
                                            <div class="progress-bar bg-info" role="progressbar" aria-valuenow="89"
                                                aria-valuemin="0" aria-valuemax="100" style="width: 89%;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content-right fsize-1">
                                    <div class="text-muted opacity-6">مجموع هدف</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        @permission('show_information')
        <div class="row">
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content bg-midnight-bloom">
                    <div class="widget-content-wrapper text-white">
                        <div class="widget-content-right">
                            <div class="widget-heading">تعداد کل کاربران وبسایت</div>
                        </div>
                        <div class="widget-content-left">
                            <div class="widget-numbers text-white ">{{ $usersCount }} <span class="text-font-14">
                                    نفر</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content bg-arielle-smile">
                    <div class="widget-content-wrapper text-white">
                        <div class="widget-content-right">
                            <div class="widget-heading">تعداد کل تیکت ها </div>
                            {{-- <div class="widget-subheading">مجموع سود مشتریان</div> --}}
                        </div>
                        <div class="widget-content-left">
                            <div class="widget-numbers text-white">{{ $ticketsCount }} <span class="text-font-14">
                                    تیکت</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content bg-grow-early">
                    <div class="widget-content-wrapper text-white">
                        <div class="widget-content-right">
                            <div class="widget-heading">تیکت های در انتظار پاسخ</div>
                        </div>
                        <div class="widget-content-left">
                            <div class="widget-numbers text-white">{{ $ticketsWatingAnswerCount }} <span
                                    class="text-font-14"> تیکت</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content bg-2">
                    <div class="widget-content-wrapper text-white">
                        <div class="widget-content-right">
                            <div class="widget-heading">تعداد نظرات در انتظار تایید </div>
                        </div>
                        <div class="widget-content-left">
                            <div class="widget-numbers text-white ">{{ $commentsWatingApproved }} <span
                                    class="text-font-14"> نظر</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content bg-2">
                    <div class="widget-content-wrapper text-white">
                        <div class="widget-content-right">
                            <div class="widget-heading">تعداد کل نظرات</div>
                        </div>
                        <div class="widget-content-left">
                            <div class="widget-numbers text-white ">{{ $commentsCount }} <span class="text-font-14">
                                    نظر</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content bg-midnight-bloom">
                    <div class="widget-content-wrapper text-white">
                        <div class="widget-content-right">
                            <div class="widget-heading">تعداد مقالات</div>
                        </div>
                        <div class="widget-content-left">
                            <div class="widget-numbers text-white ">{{ $posts }} <span class="text-font-14">
                                    مقاله</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content bg-midnight-bloom">
                    <div class="widget-content-wrapper text-white">
                        <div class="widget-content-right">
                            <div class="widget-heading"> مقالات در حال انتظار بررسی</div>
                        </div>
                        <div class="widget-content-left">
                            <div class="widget-numbers text-white ">{{ $postPending }} <span class="text-font-14">
                                    مقاله</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content bg-midnight-bloom">
                    <div class="widget-content-wrapper text-white">
                        <div class="widget-content-right">
                            <div class="widget-heading">تعداد دوره ها</div>
                        </div>
                        <div class="widget-content-left">
                            <div class="widget-numbers text-white ">{{ $numberCourses }} <span class="text-font-14">
                                    دوره</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content bg-midnight-bloom">
                    <div class="widget-content-wrapper text-white">
                        <div class="widget-content-right">
                            <div class="widget-heading">دوره های درانتظار بررسی</div>
                        </div>
                        <div class="widget-content-left">
                            <div class="widget-numbers text-white ">{{ $coursePending }} <span class="text-font-14">
                                    دوره</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endpermission
    </div>
    @endsection
    @section('script')
    <script src="{{asset('dashboard/js/main-dashboard.js')}}"></script>
    </script>
    </body>
    <script>
        Highcharts.chart('container', {
            chart: {
                polar: true,
                type: 'var',
                backgroundColor: '#393E46',
            },
            title: {
                style: {
                    color: '#fff',
                },
                text: 'نمودار فروش 30 روز گذشته',
            },
            tooltip: {
                useHTML: true,
                style: {
                    fontSize: '20px',
                    fontFamily: 'Vazirmatn',
                    direction: 'rtl',
                },
                formatter: function() {
                    return (this.x ? "تاریخ: " + this.x + "<br>" : "") + "مبلغ: " + this.y
                }
            },
            xAxis: {
                categories: [
                    @foreach ($dates as $date => $value)
                        '{{ $date }}',
                    @endforeach
                ],
                labels: {
                    style: {
                        color: '#ffffff'
                    }
                }

            },
            yAxis: {
                title: {
                    style: {
                        color: '#fff',
                    },
                    text: "مبلغ"
                },
                labels: {
                    formatter: function() {
                        return  "مبلغ : " + this.value +" تومان"
                    },
                    style: {
                        color: '#ffffff'
                    }

                }
            },
            labels: {
                items: [{
                    html: 'درامد 30 روز گذشته',
                    style: {
                        left: '50px',
                        top: '18px',
                        color: '#fff'
                    }
                }]
            },
            series: [{

                    type: 'column',
                    name: 'کارمزد وبسایت',
                    color: "green",
                    data: [
                        @foreach ($dates as $date => $value)
                            @if ($day = $summary->where('date', $date)->first())
                                {{ $day->totalSiteShare }},
                            @else
                                0,
                            @endif
                        @endforeach
                    ]
                },

                {

                    type: 'column',
                    name: 'سود من',
                    color: "pink",
                    data: [
                        @foreach ($dates as $date => $value)
                            @if ($day = $summary->where('date', $date)->first())
                                {{ $day->totalSellerShare }},
                            @else
                                0,
                            @endif
                        @endforeach
                    ]
                },
                {
                    type: 'spline',
                    name: 'فروش من',
                    data: [
                        @foreach ($dates as $date => $value)
                            @if ($day = $summary->where('date', $date)->first())
                                {{ $day->totalAmount }},
                            @else
                                0,
                            @endif
                        @endforeach
                    ],
                    marker: {
                        lineWidth: 2,
                        lineColor: "#46b2f0",
                        fillColor: '#46b2f0 '
                    },
                    color: "#46b2f0"
                },


            ],

        });
    </script>

    @endsection
