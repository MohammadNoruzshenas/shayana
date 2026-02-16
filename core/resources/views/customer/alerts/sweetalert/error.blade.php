@if(session('swal-error'))
    <script>
    Swal.fire({
                title: 'خطا!',
                 text: '{{ session('swal-error') }}',
                 icon: 'error',
                 confirmButtonText: 'باشه',
      });
    </script>

@endif
