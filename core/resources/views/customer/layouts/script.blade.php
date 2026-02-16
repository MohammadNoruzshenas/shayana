
<script src="{{ asset('customer/js/script.js') }}" ></script>
<script src="{{ asset('dashboard/js/sweetalert/sweetalert2.min.js') }}"></script>
<script src="{{asset('customer/js/aos.js')}}"></script>
<script>
    AOS.init();
</script>

@if (cache('settings')['chat_online'] == 1)
      {!!  cache('secureRecord')['chat_online_key'] !!}
@endif
{{-- <script src="{{ asset('customer/js/jquery-3.6.1.min.js') }}"></script> --}}

@yield('script')
