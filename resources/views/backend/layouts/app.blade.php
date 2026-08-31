<!doctype html>
<html lang="{{ htmlLang() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ appName() }} | @yield('title')</title>

    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="{{ asset('backend/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    @stack('before-styles')
    <livewire:styles />
    @stack('after-styles')
</head>

<body id="page-top">

    <div id="wrapper">

        {{-- Sidebar --}}
        @include('backend.includes.sidebar')

        {{-- Content Wrapper --}}
        <div id="content-wrapper" class="d-flex flex-column">

            {{-- Main Content --}}
            <div id="content">

                {{-- Topbar --}}
                @include('backend.includes.header')

                {{-- Page Content --}}
                <div class="container-fluid">

                    <!-- @include('includes.partials.messages') -->

                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            {{-- Footer --}}
            @include('backend.includes.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('backend/js/sb-admin-2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <livewire:scripts />

    @stack('before-scripts')

    {{-- Page Specific Libraries --}}
    @stack('page-libraries')
    

    {{-- Page Specific Scripts --}}
    @stack('page-scripts')

    @stack('after-scripts')

    <script>
        document.addEventListener('click', function (event) {
            const closeButton = event.target.closest('.toast-close');

            if (!closeButton) {
                return;
            }

            const toast = closeButton.closest('.global-toast');

            if (toast) {
                toast.remove();
            }
        });

        setTimeout(function () {
            document.querySelectorAll('.global-toast').forEach(function (toast) {
                toast.remove();
            });
        }, 5000);
    </script>

</body>

</html>