<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel')</title>
    
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css') }}">
    
    @stack('styles')
    
</head>

<body>
    <div id="wrapper">
        @include('admin.layouts.sidebar')
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                @include('admin.layouts.header')
            </div>
            <x-breadcrumb />
                @yield('content');
            @include('admin.layouts.footer')
        </div>
    </div>
    <!-- Mainly scripts -->
    <script src="{{ asset('assets/js/jquery-3.1.1.min.js') }} "></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }} "></script>
    <script src="{{ asset('assets/js/plugins/metisMenu/jquery.metisMenu.js') }} "></script>
    <script src="{{ asset('assets/js/plugins/slimscroll/jquery.slimscroll.min.js') }} "></script>

    <!-- Flot -->
    <script src="{{ asset('assets/js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flot/jquery.flot.spline.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flot/jquery.flot.symbol.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flot/jquery.flot.time.js') }}"></script>

    <!-- Peity -->
    <script src="{{ asset('assets/js/plugins/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('assets/js/demo/peity-demo.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('assets/js/inspinia.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/pace/pace.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('assets/js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- Jvectormap -->
    <script src="{{ asset('assets/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>

    <!-- EayPIE -->
    <script src="{{ asset('assets/js/plugins/easypiechart/jquery.easypiechart.js') }}"></script>

    <!-- Sparkline -->
    <script src="{{ asset('assets/js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Sparkline demo data  -->
    <script src="{{ asset('assets/js/demo/sparkline-demo.js') }}"></script>

    
    @stack('scripts')

</body>

</html>