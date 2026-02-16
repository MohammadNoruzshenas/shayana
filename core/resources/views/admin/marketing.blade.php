@extends('admin.layouts.master')
@section('head-tag')
<title>مارکتینگ</title>
    <link rel="stylesheet" href="{{ asset('dashboard/css/dashboard.css') }}">
@endsection
@section('content')
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
                            <p>سود مدرسین</p>
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
                            <p>سود مدرسین</p>
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
                            <p>سود مدرسین</p>
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

                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content ">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-right">
                                <div class="widget-heading">کل  فروش سایت  </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-numbers text-white ">{{ priceFormat($totalSiteBenefit + $totalTeacherBenefit) }} <span
                                        class="text-font-14"> تومان</span></div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-right">
                                <div class="widget-heading">کل درآمد خالص سایت</div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-numbers text-white">{{ priceFormat($totalSiteBenefit) }} <span
                                        class="text-font-14">تومان</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content ">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-right">
                                <div class="widget-heading">کل درامد خالص مدرسین</div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-numbers text-white">{{ priceFormat($totalTeacherBenefit) }} <span
                                        class="text-font-14">تومان</span></div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content ">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-right">
                                <div class="widget-heading">مجموع حساب های پرداخت شده</div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-numbers text-white ">{{ priceFormat($totalPaymentSettlement) }} <span
                                        class="text-font-14"> تومان</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content ">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-right">
                                <div class="widget-heading">   مجموع موجودی کل مدرسین   </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-numbers text-white ">{{ priceFormat($accountBlanace) }} <span
                                        class="text-font-14"> تومان</span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-right">
                                <div class="widget-heading">مجموع درامد حاصل از تبلیغات </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-numbers text-white">{{ priceFormat($totalPaymentAds) }} <span
                                        class="text-font-14">تومان</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-right">
                                <div class="widget-heading">مجموع درامد حاصل از اشتراک ها</div>
                                {{-- <div class="widget-subheading">مجموع سود مشتریان</div> --}}
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-numbers text-white">{{ priceFormat($totalPaymentSubs) }} <span
                                        class="text-font-14">تومان</span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-right">
                                <div class="widget-heading">کل فروش تبلیغات در یک ماهه گذشته</div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-numbers text-white">{{ priceFormat($totalPaymentAdsInMonth) }} <span
                                        class="text-font-14">تومان</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content ">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-right">
                                <div class="widget-heading">کل فروش اشتراک در یک ماهه گذشته</div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-numbers">{{ priceFormat($totalPaymentSubsInMonth) }} <span
                                        class="text-font-14">تومان</span></div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <div class="main-card mb-3 card">
                        <div class="card-header">پر درآمدترین مدرسین 30روز گذشته

                        </div>
                        <div class="table-responsive">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>نام</th>
                                        <th class="text-center">تعداد فروش</th>
                                        <th class="text-center">کل مبلغ فروش</th>
                                        <th class="text-center">سود مدرس</th>
                                        <th class="text-center">سود سایت</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bestSellingTeachersMonths as $teacher)
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
                                                            <div class="widget-heading">{{ $teacher->user->email }}</div>
                                                            <div class="widget-subheading opacity-7">
                                                                {{ $teacher->user->full_name }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="badge badge-warning">
                                                    {{ $teacher->TotalBuys }}</div>
                                            </td>
                                            <td class="text-center">
                                                {{ priceFormat($teacher->price) }} تومان</td>
                                                <td class="text-center">
                                                    {{ priceFormat($teacher->seller_share) }} تومان</td>
                                                    <td class="text-center">
                                                        {{ priceFormat($teacher->price - $teacher->seller_share) }} تومان</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="main-card mb-3 card">
                        <div class="card-header">پر درآمدترین مدرسین

                        </div>
                        <div class="table-responsive">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>نام</th>
                                        <th class="text-center">تعداد فروش</th>
                                        <th class="text-center">کل مبلغ فروش</th>
                                        <th class="text-center">سود مدرس</th>
                                        <th class="text-center">سود سایت</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bestSellingTeachersTotal as $teacher)
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
                                                            <div class="widget-heading">{{ $teacher->user->email }}</div>
                                                            <div class="widget-subheading opacity-7">
                                                                {{ $teacher->user->full_name }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="badge badge-warning">
                                                    {{ $teacher->TotalBuys }}</div>
                                            </td>
                                            <td class="text-center">
                                                {{ priceFormat($teacher->price) }} تومان</td>
                                                <td class="text-center">
                                                    {{ priceFormat($teacher->seller_share) }} تومان</td>
                                                    <td class="text-center">
                                                        {{ priceFormat($teacher->price - $teacher->seller_share) }} تومان</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
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
                                        <th class="text-center">سود مدرس</th>
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
                                                                {{ $course->singleProduct ? $course->singleProduct->title : '-' }}</div>
                                                            <div class="widget-subheading opacity-7">
                                                                {{ $course->singleProduct ? $course->singleProduct->teacher->email : '-' }}</div>
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
                                        <th class="text-center">سود مدرس</th>
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
                                                                {{ $course->singleProduct ? $course->singleProduct->title : '-' }}</div>
                                                            <div class="widget-subheading opacity-7">
                                                                {{ $course->singleProduct ? $course->singleProduct->teacher->email : '-' }}</div>
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
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <div class="main-card mb-3 card">
                        <div class="card-header">خریداران برتر 1 ماه گذشته

                        </div>
                        <div class="table-responsive">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>نام</th>
                                        <th class="text-center">تعداد خرید</th>
                                        <th class="text-center">کل مبلغ خرید</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bestStudentsMonth as $student)
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
                                                            <div class="widget-heading">{{ $student->user->full_name }}
                                                            </div>
                                                            <div class="widget-subheading opacity-7">
                                                                {{ $student->user->email }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="badge badge-warning">
                                                    {{ $student->TotalBuys }}</div>
                                            </td>
                                            <td class="text-center">
                                                {{ priceFormat($student->total_price) }} تومان</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="main-card mb-3 card">
                        <div class="card-header">خریداران برتر

                        </div>
                        <div class="table-responsive">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>نام</th>
                                        <th class="text-center">تعداد خرید</th>
                                        <th class="text-center">کل مبلغ خرید</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bestStudents as $student)
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
                                                            <div class="widget-heading">{{ $student->user->full_name }}
                                                            </div>
                                                            <div class="widget-subheading opacity-7">
                                                                {{ $student->user->email }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="badge badge-warning">
                                                    {{ $student->TotalBuys }}</div>
                                            </td>
                                            <td class="text-center">
                                                {{ priceFormat($student->total_price) }} تومان</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

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
                series: [
                        {
                            type: 'spline',
                            name: 'فروش بسایت',
                            data: [
                                @foreach ($dates as $date => $value)
                                    @if ($day = $days->where('date', $date)->first())
                                        {{ $day->totalAmount }},
                                    @else
                                        0,
                                    @endif
                                @endforeach
                            ],
                            marker: {
                                lineWidth: 2,
                                lineColor: "rgb(44, 175, 254)",
                                fillColor: 'rgb(44, 175, 254)'
                            },
                            color: "rgb(44, 175, 254)"
                        }, {
                            type: 'column',
                            name: 'سود کل بسایت',
                            data: [
                                @foreach ($dates as $date => $value)
                                    @if ($day = $days->where('date', $date)->first())
                                        {{ $day->totalSiteShare }},
                                    @else
                                        0,
                                    @endif
                                @endforeach
                            ],
                            marker: {
                                lineWidth: 2,
                                lineColor: "rgb(0,226,114)",
                                fillColor: 'rgb(0,226,114)'
                            },
                            color: "rgb(0,226,114)"
                        }, {

                            type: 'column',
                            name: 'کل کارمزد  مدریس بسایت',
                            data: [
                                @foreach ($dates as $date => $value)
                                    @if ($day = $days->where('date', $date)->first())
                                        {{ $day->totalSellerShare }},
                                    @else
                                        0,
                                    @endif
                                @endforeach
                            ],
                            marker: {
                                lineWidth: 2,
                                lineColor: "rgb(84,79,197)",
                                fillColor: 'rgb(84,79,197)'
                            },
                            color: "rgb(84,79,197)"
                        },

                    {
                        type: 'pie',
                        name: 'نسبت',
                        data: [{
                            name: 'سود سایت',
                            y:{{$benefitSiteMonth}},
                            color: "green"
                        }, {
                            name: 'درصد مدرسین',
                            y: {{$benefitTeacherMonth}},
                            color: "pink"
                        }, ],
                        center: [100, 80],
                        size: 100,
                        showInLegend: false,
                        dataLabels: {
                            enabled: true
                        }
                    }
                ],

            });
        </script>

    @endsection
