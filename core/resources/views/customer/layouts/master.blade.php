<!DOCTYPE html>
<html dir="rtl" lang="fa" class="scroll-smooth dark">
@include('customer.layouts.head-tag')
<body class="font-sans dark:bg-secondary lg:overflow-vizible">
    @include('customer.layouts.header')
    <div style="min-height: 100vh">
    @yield('content')
    </div>
    @include('customer.layouts.footer')
    @include('customer.layouts.script')
    @include('customer.alerts.sweetalert.error')
    @include('customer.alerts.sweetalert.success')
</body>

</html>
