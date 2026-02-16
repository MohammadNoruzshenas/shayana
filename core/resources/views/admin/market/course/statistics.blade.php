@extends('admin.layouts.master')

@section('head-tag')
<title>اماره دوره ی {{ $course->title }} </title>

    <link rel="stylesheet" href="{{ asset('dashboard/css/dashboard.css') }}">
@endsection
@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="row">
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content bg-midnight-bloom">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-right">
                                <div class="widget-heading">تعداد دانشجویان</div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-numbers text-white ">{{ count($course->students) }} <span
                                        class="text-font-14"> نفر </span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content bg-arielle-smile">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-right">
                                <div class="widget-heading">فروش 1 ماهه گذشته </div>
                                {{-- <div class="widget-subheading">مجموع سود مشتریان</div> --}}
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-numbers text-white">{{ priceFormat($getSellLastMonth->price ?? 0) }}<span
                                        class="text-font-14">تومان</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content bg-grow-early">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-right">
                                <div class="widget-heading">کل فروش </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-numbers text-white">{{ priceFormat($getSellTotal->price ?? 0) }} <span
                                        class="text-font-14">تومان</span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content bg-midnight-bloom">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-right">
                                <div class="widget-heading">تعداد سرفصل ها</div>
                            </div>

                            <div class="widget-content-left">
                                <div class="widget-numbers text-white ">{{ count($course->season) }} </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content bg-arielle-smile">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-right">
                                <div class="widget-heading">تعداد جلسات</div>
                                {{-- <div class="widget-subheading">مجموع سود مشتریان</div> --}}
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-numbers text-white">{{ $lession }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content bg-grow-early">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-right">
                                <div class="widget-heading">تعداد نظرات </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-numbers text-white">{{ $comments }} </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row  font-size-13 margin-bottom-10">
                <div class="col-12  padding-20  margin-bottom-10  border-radius-3">
                    <div class="col-12 bg-white padding-30 margin-bottom-20">
                        <div id="container"></div>
                    </div>
                </div>
                <div class="col-12  padding-20 margin-bottom-10 border-radius-3">
                    <div class="col-12 bg-white padding-30 margin-bottom-20">
                        <div id="container2"></div>
                    </div>
                </div>
            </div>




        </div>
    @endsection
    @section('script')
        <script type="text/javascript" src="https://demo.dashboardpack.com/architectui-html-free/assets/scripts/main.js">
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
                            return "مبلغ : " + this.value + " تومان"
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
                        name: 'فروش ',
                        data: [
                            @foreach ($dates as $date => $value)
                                @if ($day = $summaryCourse->where('date', $date)->first())
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
                    {
                        type: 'column',
                        name: 'سود مدرس ',
                        data: [
                            @foreach ($dates as $date => $value)
                                @if ($day = $summaryCourse->where('date', $date)->first())
                                    {{ $day->totalSellerShare }},
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
                    },
                    {
                        type: 'column',
                        name: 'سود سایت ',
                        data: [
                            @foreach ($dates as $date => $value)
                                @if ($day = $summaryCourse->where('date', $date)->first())
                                    {{ $day->totalSiteShare }},
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


                ],

            });
        </script>
        <script>
            Highcharts.chart('container2', {
                chart: {
                    polar: true,
                    type: 'var',
                    backgroundColor: '#393E46',
                },
                title: {
                    style: {
                        color: '#fff',
                    },
                    text: 'نمودار تعداد فروش  روزانه ',
                },
                tooltip: {
                    useHTML: true,
                    style: {
                        fontSize: '20px',
                        fontFamily: 'Vazirmatn',
                        direction: 'rtl',
                    },
                    formatter: function() {
                        return (this.x ? "تاریخ: " + this.x + "<br>" : "") + "تعداد: " + this.y
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
                        text: "تعداد"
                    },
                    labels: {
                        formatter: function() {
                            return "فروش : " + this.value
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
                        name: 'فروش ',
                        data: [
                            @foreach ($dates as $date => $value)
                                @if ($day = $summaryCourse->where('date', $date)->first())
                                    {{ $day->buys }},
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
