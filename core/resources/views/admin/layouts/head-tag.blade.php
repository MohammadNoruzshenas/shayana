<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('dashboard/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset ('dashboard/css/responsive_991.css')}}" media="(max-width:991px)">
    <link rel="stylesheet" href="{{ asset ('dashboard/css/responsive_768.css')}}" media="(max-width:768px)">
    <link rel="stylesheet" href="{{asset('dashboard/css/all.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset ('dashboard/css/font.css')}}">
    <link rel="stylesheet" href="{{ asset('dashboard/js/sweetalert/sweetalert2.css') }}">
    <link rel="icon" type="image/x-icon" href="{{asset(cache('templateSetting')['logo'])}}">

    <script src="{{ asset('dashboard/ckeditor.js') }}"></script>

    <script src="{{asset('dashboard/js/highChart/highcharts.js')}}"></script>
    <script src="{{asset('dashboard/js/highChart/exporting.js')}}"></script>
    {{-- <script src="https://code.highcharts.com/modules/series-label.js"></script> --}}
    <script src="{{asset('dashboard/js/highChart/accessibility.js')}}"></script>
    <script src="{{asset('dashboard/js/highChart/export-data.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('dashboard/js/select2/css/select2.min.css') }}">
    <title>پنل مدیریت</title>

    {{-- <script src="http://rawgithub.com/babakhani/PersianDate/master/dist/persian-date.min.js"></script> --}}


    {{-- <script src="{{ asset('dashboard/tinymce/tinymce.min.js') }}"></script> --}}
    @yield('head-tag')

    <style>

        .toast-wrapper {
            position: fixed;
            z-index: 9999;
            top: 3rem;
            left: 0;
            width: 26rem;
            max-width: 80%;
            padding: 2rem;
        }
        .flex-row-reverse {
  -ms-flex-direction: row-reverse !important;
  flex-direction: row-reverse !important;
}
</style>

</head>
