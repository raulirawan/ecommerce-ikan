<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('backend') }}/assets/imgs/theme/favicon.svg">
    <!-- Template CSS -->
    @stack('up-style')
    <link href="{{ asset('backend') }}/assets/css/vendors/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend') }}/assets/css/main.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/pages/sweetalert2.css">
    @stack('down-style')
</head>

<body>
    <div class="screen-overlay"></div>
    @include('includes.backend.sidebar')
    <main class="main-wrap">
       @include('includes.backend.navbar')
        @yield('content')
        <footer class="main-footer font-xs">
            <div class="row pb-30 pt-15">
                <div class="col-sm-6">
                    <script>
                    document.write(new Date().getFullYear())
                    </script> ©, Evara - HTML Ecommerce Template .
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end">
                        All rights reserved
                    </div>
                </div>
            </div>
        </footer>
    </main>
    @stack('up-script')
    <script src="{{ asset('backend') }}/assets/js/vendors/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/vendors/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/vendors/select2.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/vendors/perfect-scrollbar.js"></script>
    <script src="{{ asset('backend') }}/assets/js/vendors/jquery.fullscreen.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/vendors/chart.js"></script>
    <!-- Main Script -->
    <script src="{{ asset('backend') }}/assets/js/main.js" type="text/javascript"></script>
    <script src="{{ asset('backend') }}/assets/js/custom-chart.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    @include('sweetalert::alert')
    @stack('down-script')
</body>


<!-- Mirrored from wp.alithemes.com/html/evara/evara-backend/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 01 Aug 2021 15:32:57 GMT -->
</html>
