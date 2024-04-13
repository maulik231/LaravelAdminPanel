<!DOCTYPE html>
<html lang="en">
@include('admin.layouts.header')
@yield('style')


<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('theme-assets/dist/img/AdminLTELogo.png') }}" alt="Logo"
                height="100" width="100" style="border-radius: 50%;">
        </div>
        @include('admin.layouts.navbar')

        @include('admin.layouts.sidebar')

        @yield('content')

        @include('admin.layouts.footer')
        @yield('script')
        <script>
            $(document).ready(function() {

                @if (Session('success'))
                    setTimeout(function() {
                        toastr.success("Success", "{{ Session('success') }}");
                    }, 200);
                @endif

                @if (Session('info'))
                    setTimeout(function() {
                        toastr.info(
                            "Info",
                            "{{ Session('info') }}"
                        );
                    }, 200);
                @endif

                @if (Session('warning'))
                    setTimeout(function() {
                        toastr.warning(
                            "{{ Session('success') }}"
                        );
                    }, 200);
                @endif

                @if (Session('error'))
                    setTimeout(function() {
                        toastr.error(
                            "Error",
                            "{{ Session('error') }}"
                        );
                    }, 200);
                @endif
            });
        </script>
</body>

</html>
