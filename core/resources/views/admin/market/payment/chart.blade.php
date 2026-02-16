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

            @if (auth()->user()->can('manage_financial'))
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
                        lineColor: "green",
                        fillColor: 'white'
                    },
                    color: "green"
                }, {
                    type: 'spline',
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
                        lineColor: "green",
                        fillColor: 'white'
                    },
                    color: "green"
                }, {

                    type: 'spline',
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
                        lineColor: "green",
                        fillColor: 'white'
                    },
                    color: "green"
                },
            @endif

            {
                type: 'pie',
                name: 'نسبت',
                data: [{
                    name: 'درصد سایت',
                    y: {{ $totalSiteShare }},
                    color: "green"
                }, {
                    name: 'درصد مدرس',
                    y: {{ $last30DaysBenefit }},
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
