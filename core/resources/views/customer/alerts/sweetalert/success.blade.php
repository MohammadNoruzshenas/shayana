@if(session('swal-success'))
    <script>
            Swal.fire({
                title: 'عملیات با موفقیت انجام شد',
                 text: '{{ session('swal-success') }}',
                 icon: 'success',
                 confirmButtonText: 'باشه',
      });

    </script>
@endif
