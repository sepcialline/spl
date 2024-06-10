<!DOCTYPE html>

<html lang="{{ LaravelLocalization::getCurrentLocale() }}" class="light-style"
    dir="{{ App::isLocale('ar') ? 'rtl' : 'ltr' }}" data-theme="theme-default"
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

    <div class="invoice-print p-2">
        <div class="d-flex justify-content-between flex-row">
            <div class="mb-0">
                <div class="d-flex svg-illustration mb-3 gap-2">
                    <img width="50%"
                        src="{{ asset('build/assets/img/logo/logo_' . LaravelLocalization::getCurrentLocale() . '.png') }}">
                </div>
                <p class="mb-1" style="width:50%">{{ __('admin._company_address_') }}</p>
                <p class="mb-1" style="width:50%">{{ __('admin.warehouse_report') }}</p>
            </div>
            <div>

            </div>
        </div>
        @if (isset($query) && count($query) > 0)
        <table class="table table-striped table-bordered my-2">
            <thead>
                <tr>
                    <th width='1%'>#</th>
                    <th>{{ __('admin.products_product_company') }}</th>
                    <th>{{ __('admin.warehouse_transfer_product') }}</th>
                    <th>{{ __('admin.warehouse_transfer_branch') }}</th>
                    <th>{{ __('admin.warehouse_transfer_quantity') }}</th>
                    <th>{{ __('admin.date') }}</th>
                    <th>{{ __('admin.operation') }}</th>
                    <th>{{ __('admin.added_by') }}</th>
                    <th> code</th>
                    <th>{{ __('admin.note:') }}</th>
                    {{-- <th>{{ __('admin.status') }}</th>
                    <th>{{ __('admin.actions') }}</th> --}}
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach ($query as $item)
                    <tr>
                        <input type="hidden" id="id" value="{{ $item->id }}">
                        <td>{{ $i++ }}</td>
                        <td>{{ $item->company->name ?? '' }}</td>
                        <td>{{ $item->product->name ?? '' }}</td>
                        <td>{{ $item->branch->branch_name ?? '' }}</td>
                        <td>{{ $item->quantity ?? '' }}</td>
                        <td>{{ $item->date ?? '' }}</td>
                        <td>{{ $item->operation->name ?? '' }}</td>
                        <td>{{ $item->user->name ?? '' }}</td>
                        <td>{{ $item->dispatch_ref_no ?? '' }}</td>
                        <td>{{ $item->notes ?? '' }}</td>
                        {{-- <td>{{ $shipment->shipment_no ?? '' }} <br>
                            #{{ $shipment->shipment_refrence ?? '' }}</td>
                        <td>{{ $shipment->Client->name ?? '' }} <br>
                            {{ $shipment->Client?->mobile ?? '' }}</td>
                        <td>{{ $shipment->Client?->emirate->name ?? '' }} <br>
                            {{ $shipment->Client?->city->name ?? '' }} <br>
                            {{ $shipment->Client?->address ?? '' }}</td>
                        <td>{{ $shipment->Company->name ?? '' }}</td>
                        <td>{{ $shipment->paymentMethod->name ?? '' }}</td>
                        <td><span
                                class="{{ $shipment->Status->html_code }}">{{ $shipment->Status->name }}</span>
                        </td>
                        <td>
                            @include('includes.shipment_action_dropdown', [
                                'shipment',
                                $shipment,
                            ])

                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <div class="row justify-center">
                <div class="col-md">
                    <img src="{{ asset('build/assets/img/pages/nodata.jpg') }}" width="100%" alt="">
                </div>
            </div>
        @endif

        <hr>

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
