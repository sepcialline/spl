<!DOCTYPE html>

<html lang="{{ LaravelLocalization::getCurrentLocale() }}" class="light-style" dir="{{LaravelLocalization::getCurrentLocaleDirection()}} " data-theme="theme-default"
    data-assets-path="{{ asset('build/assets/') }}" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ __('admin.print_invoice') }}</title>

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
    <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/typeahead-js/typeahead.css') }}" />

    <!-- Page CSS -->

    <link rel="stylesheet" href="{{ asset('build/assets/vendor/css/pages/app-invoice-print.css') }}" />
    <!-- Helpers -->
    <script src="{{ asset('build/assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('build/assets/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('build/assets/js/config.js') }}"></script>

</head>

<body>
    <!-- Content -->

    <div class="invoice-print p-5" style="border: 2px solid #ffd200">
        <div class="d-flex justify-content-between flex-row">
            <div class="mb-4">
                <div class="d-flex svg-illustration mb-3 gap-2">
                    <img
                        src="{{ asset('build/assets/img/logo/logo_' . LaravelLocalization::getCurrentLocale() . '.png') }}" width="50%">
                </div>
                <p class="mb-1" style="width:50%">{{ __('admin._company_address_') }}</p>
            </div>
            <div>
                <h4>Invoice #3492</h4>
                <div class="mb-2">
                    <span>Date Issues:</span>
                    <span class="fw-semibold">April 25, 2021</span>
                </div>
                <div>
                    <span>Date Due:</span>
                    <span class="fw-semibold">May 25, 2021</span>
                </div>
            </div>
        </div>

        <hr />

        <div class="row d-flex justify-content-between mb-4">
            <div class="col-sm-6 w-50">
                <h6>Invoice To:</h6>
                <p class="mb-1">Thomas shelby</p>
                <p class="mb-1">Shelby Company Limited</p>
                <p class="mb-1">Small Heath, B10 0HF, UK</p>
                <p class="mb-1">718-986-6062</p>
                <p class="mb-0">peakyFBlinders@gmail.com</p>
            </div>
            <div class="col-sm-6 w-50">
                <h6>Bill To:</h6>
                <table>
                    <tbody>
                        <tr>
                            <td class="pe-3">Total Due:</td>
                            <td>$12,110.55</td>
                        </tr>
                        <tr>
                            <td class="pe-3">Bank name:</td>
                            <td>American Bank</td>
                        </tr>
                        <tr>
                            <td class="pe-3">Country:</td>
                            <td>United States</td>
                        </tr>
                        <tr>
                            <td class="pe-3">IBAN:</td>
                            <td>ETD95476213874685</td>
                        </tr>
                        <tr>
                            <td class="pe-3">SWIFT code:</td>
                            <td>BR91905</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table border-top m-0">
                <thead>
                    @if ($has_stock == 1)
                        <tr>
                            <th>#</th>
                            <th>{{ __('admin.item') }}</th>
                            <th>{{ __('admin.quantity') }}</th>
                        </tr>
                    @else
                        <tr>
                            <th>{{ __('admin.description') }}</th>
                        </tr>
                    @endif
                </thead>
                <tbody>
                    @if ($has_stock == 1)
                    @php $i = 1; @endphp
                        @foreach ($shipment_content as $content)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{ $content->product->name }}</td>
                                <td>{{ $content->quantity }}</td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>{{ $shipment_content->content_text }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="1" class="align-top px-0 py-3">
                            <p class="mb-2">
                                <span class="me-1 fw-bold">{{__('admin.Specialline_team')}}</span>
                            </p>
                            <span>{{__('admin.thank_you')}}</span>
                        </td>
                        <td class="text-end px-0 py-3">
                            <p class="mb-2">Subtotal:</p>
                            <p class="mb-2">Discount:</p>
                            <p class="mb-2">Tax:</p>
                            <p class="mb-0">Total:</p>
                        </td>
                        <td class="px-4 py-3">
                            <p class="fw-semibold mb-2">$154.25</p>
                            <p class="fw-semibold mb-2">$00.00</p>
                            <p class="fw-semibold mb-2">$50.00</p>
                            <p class="fw-semibold mb-0">$204.25</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-12">
                <span class="fw-semibold">{{ __('admin.note:') }}</span>
                <span>{{ __('admin.it_was_a_pleasure_working_with_you_we_hope_you_will_keep_us_in_mind_for_future_shipments._thank_you!') }}</span>
            </div>
        </div>
    </div>
    <!-- / Content -->

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

    <!-- Main JS -->
    <script src="{{ asset('build/assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('build/assets/js/app-invoice-print.js') }}"></script>
</body>

</html>
