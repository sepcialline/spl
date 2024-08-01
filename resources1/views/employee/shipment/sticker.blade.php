<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

<head>
    <meta charset="utf-8">
    <title>{{ __('admin.print_qr') }} | {{ __('admin.app_name') }}</title>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Page CSS -->

    {{-- <link rel="stylesheet" href="{{ asset('build/assets/vendor/css/pages/app-invoice-print.css') }}" /> --}}
    <!-- Helpers -->
    <script src="{{ asset('build/assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('build/assets/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('build/assets/js/config.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">

    <style type="text/css">
        * {
            margin: 0px;
            padding: 0px;
            font-size: 10px;
            align-items: center;
            align-content: center;
        }

        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;1000&display=swap');

        @page {
            size: A5 landscape
        }

        @media print {
            @page {
                size: A5 landscape
            }

        }
    </style>

</head>
<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A5 landscape mx-auto" style="height: 100mm; width:100mm">

    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet mx-auto p-2" style="width : 100%;height: 100%">

        <div class="d-flex justify-content-around">
            <img width="25%"
                src="{{ asset('build/assets/img/logo/logo_' . LaravelLocalization::getCurrentLocale() . '.png') }}">
            <div>
                {!! $barcode !!}
                {{ $shipment->shipment_no }}#{{ $shipment->shipment_refrence }}
            </div>
            {{-- <div class="col">
                <p class="" >{{ __('admin._company_address_') }}</p>

            </div> --}}

        </div>
        <hr class="p-0 m-0" />

        <div class="row d-flex justify-content-between mb-4">
            <div class="col-sm-5">
                <thead>
                    <tr>
                        <th colspan="">{{ __('admin.from') }}</th>
                    </tr>
                </thead>
                <table>
                    <tbody>
                        <tr>
                            <td class="pe-3">{{ $shipment->Company->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="pe-3">{{ $shipment->Company->mobile ?? '' }}</td>
                        </tr>
                        <p class="mb-1">{{ $shipment->Company->address ?? '' }} -
                            {{ $shipment->Company->city->name ?? '' }} - {{ $shipment->Company->emirate->name ?? '' }}
                        </p>
                        </tr>
                        <tr>

                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-5">
                <table>
                    <thead>
                        <tr>
                            <th colspan="">{{ __('admin.to') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $shipment->Client->name ?? '' }}
                                {{ $shipment->Client->mobile ?? '' }}
                                {{ $shipment->delivered_address ?? '' }} - {{ $shipment->city->name ?? '' }} -
                                {{ $shipment->emirate->name ?? '' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-2">
                <p>{{ __('admin.total') }}</p>
                <p class="mb-1">{{ $shipment->rider_should_recive ?? '' }} {{ __('admin.currency') }}</p>
            </div>

        </div>
        <div class="table-responsive">
            <table class="table border-top m-0">
                <thead>
                    @if ($has_stock == 1)
                    @if ($shipment->shipment_content && count($shipment->shipment_content) > 0)
                        <tr>
                            <th>#</th>
                            <th>{{ __('admin.item') }}</th>
                            <th>{{ __('admin.quantity') }}</th>
                        </tr>
                        @endif
                    @else
                        <tr>
                            <th>{{ __('admin.description') }}</th>
                        </tr>
                    @endif
                </thead>
                <tbody>
                    @if ($has_stock == 1)
                    @if (count($shipment_content) > 0)
                    @php $i = 1; @endphp
                    @foreach ($shipment_content as $content)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $content->product->name }}</td>
                            <td>{{ $content->quantity }}</td>

                        </tr>
                    @endforeach
                    @endif

                    @else
                        <tr>
                            <td>{{ $value->shipment_content->content_text ?? '' }}</td>
                        </tr>
                    @endif
                    {{-- <tr>
                    <td colspan="1" class="align-top px-0 py-3">
                        <p class="mb-2">
                            <span class="me-1 fw-bold">{{ __('admin.Specialline_team') }}</span>
                        </p>
                        <span>{{ __('admin.thank_you') }}</span>
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
                </tr> --}}
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-12">
                <span class="fw-semibold">{{ __('admin.note:') }}</span>
                <span>{{ __('admin.it_was_a_pleasure_working_with_you_we_hope_you_will_keep_us_in_mind_for_future_shipments._thank_you!') }}</span>
            </div>
        </div>
    </section>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</body>

</html>
