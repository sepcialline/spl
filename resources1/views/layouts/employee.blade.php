<!DOCTYPE html>

<html lang="{{ LaravelLocalization::getCurrentLocale() }}" class="light-style customizer-hide"
    dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}" data-assets-path="{{ asset('build/assets') . '/' }}"
    data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    @php
        $App_Settings = App\Models\Settings::first();
    @endphp
    <title>@yield('title') | {{ $App_Settings->name }}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('build/assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('build/assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('build/assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('build/assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/vendor/css/rtl/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('build/assets/vendor/css/rtl/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('build/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->


    @yield('VendorsCss')


    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('build/assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('build/assets/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('build/assets/js/config.js') }}"></script>
    <style>
        .card {
    background-clip: padding-box;
    box-shadow: -8px 14px 10px rgba(38, 60, 85, 0.16);
    border: 1px solid #ffd200 !important;
}
    </style>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('layouts.inc.saidbarEmployee')

            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                @include('layouts.inc.header_employee')

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    {{ $slot }}
                    <!-- / Content -->



                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('build/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('build/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('build/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('build/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('build/assets/vendor/libs/hammer/hammer.js') }}"></script>

    <script src="{{ asset('build/assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('build/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>

    <script src="{{ asset('build/assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    @yield('VendorsJS')


    <!-- Main JS -->
    <script src="{{ asset('build/assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('build/assets/js/dashboards-analytics.js') }}"></script>


</body>

</html>
