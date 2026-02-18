<html lang="fa">
@include('admin.layouts.head-tag')

<body>
    @include('admin.layouts.side-bar')

    <div class="content">

        @include('admin.layouts.header')

        @include('admin.layouts.breadcrumb')
        <div class="main-content">
            @yield('content')
        </div>
    </div>
</body>
@include('admin.layouts.footer')
@include('admin.layouts.script')
@yield('script')
@include('admin.alerts.sweetalert.error')
@include('admin.alerts.sweetalert.success')
<section class="toast-wrapper flex-row-reverse">
    @include('admin.alerts.toast.success')
    @include('admin.alerts.toast.error')
</section>

</html>
