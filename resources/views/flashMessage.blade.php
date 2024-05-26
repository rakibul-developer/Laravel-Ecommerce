@if (Session::has('success'))
    <script>
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: "{{ Session::get('success') }}",
            showConfirmButton: false,
            timer: 1500
        })
    </script>
@endif

@if (Session::has('error'))
    <script>
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: "{{ Session::get('error') }}",
            showConfirmButton: false,
            timer: 1500
        })
    </script>
@endif

@if (Session::has('info'))
    <script>
        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: "{{ Session::get('info') }}",
            showConfirmButton: false,
            timer: 1500
        })
    </script>
@endif

@if (Session::has('danger'))
    <script>
        Swal.fire({
            position: 'top-end',
            icon: 'danger',
            title: "{{ Session::get('danger') }}",
            showConfirmButton: false,
            timer: 1500
        })
    </script>
@endif
