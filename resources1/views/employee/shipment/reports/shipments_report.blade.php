<!DOCTYPE html>

<html lang="{{ LaravelLocalization::getCurrentLocale() }}" class="light-style"
    dir="{{ App::isLocale('ar') ? 'rtl' : 'ltr' }}" data-theme="theme-default"
    data-assets-path="{{ asset('build/assets/') }}" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ __('admin.shipments') }}</title>

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
                    <img width="20%"
                        src="{{ asset('build/assets/img/logo/logo_' . LaravelLocalization::getCurrentLocale() . '.png') }}">
                </div>
                <p class="mb-1" style="width:50%">{{ __('admin._company_address_') }}</p>
            </div>
            <div>

            </div>
        </div>
        @if (isset($shipments) && count($shipments) > 0)

            <table class="table table-striped table-bordered my-2">
                <thead>
                    <tr>
                        <th width='1%'>#</th>
                        <th>{{ __('admin.shipments_delivered_Date') }}</th>
                        <th>{{ __('admin.shipment_no') }}/<br>{{ __('admin.shipment_refrence') }}</th>
                        <th>{{ __('admin.rider') }}</th>
                        <th>{{ __('admin.client') }}</th>
                        <th>{{ __('admin.shipments_client_address') }}</th>
                        <th>{{ __('admin.vendors_companies') }}</th>
                        <th>{{ __('admin.payment_method') }}</th>
                        <th>{{ __('admin.status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach ($shipments as $shipment)
                        <tr>
                            <input type="hidden" id="id" value="{{ $shipment->id }}">
                            <td>{{ $i++ }}</td>
                            <td>{{ $shipment->delivered_date ?? '' }}</td>
                            <td>{{ $shipment->shipment_no ?? '' }} <br>
                                #{{ $shipment->shipment_refrence ?? '' }} <br>
                                {!! DNS1D::getBarcodeHTML("$shipment->shipment_no", 'C39') !!}</td>
                            <td>{{ $shipment->Rider->name ?? __('admin.un_assigned') }}</td>
                            <td>{{ $shipment->Client->name ?? '' }} <br>
                                {{ $shipment->Client?->mobile ?? '' }}</td>
                            <td>{{ $shipment->Client?->emirate->name ?? '' }} <br>
                                {{ $shipment->Client?->city->name ?? '' }} <br>
                                {{ $shipment->Client?->address ?? '' }}</td>
                            <td>{{ $shipment->Company->name ?? '' }}</td>
                            <td>{{ $shipment->paymentMethod->name ?? '' }}</td>
                            <td><span class="{{ $shipment->Status->html_code }}">{{ $shipment->Status->name }}</span>
                            </td>
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
        <div id="emirate_status">
            {{ __('admin.emirates') }} / {{ __('admin.status') }}
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('admin.pending_approval') }}</th>
                        <th>{{ __('admin.new') }}</th>
                        <th>{{ __('admin.in_progress') }}</th>
                        <th>{{ __('admin.delivered') }}</th>
                        <th>{{ __('admin.delayed') }}</th>
                        <th>{{ __('admin.transferred') }}</th>
                        <th>{{ __('admin.canceled') }}</th>
                        <th>{{ __('admin.damaged') }}</th>
                        <th>{{ __('admin.duplicated') }}</th>
                        <th>{{ __('admin.returned_to_store') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($emirates_shipment as $emirate)
                        <tr>
                            <td>{{ $emirate->name }}</td>
                            <td>{{ App\Models\Shipment::where('status_id', 1)->whereIn('id', $shipments->pluck('id'))->whereHas('Client', function ($q) use ($emirate) {return $q->where('emirate_id', $emirate->id);})->count() }}
                            </td>
                            <td>{{ App\Models\Shipment::where('status_id', 10)->whereIn('id', $shipments->pluck('id'))->whereHas('Client', function ($q) use ($emirate) {return $q->where('emirate_id', $emirate->id);})->count() }}
                            </td>
                            <td>{{ App\Models\Shipment::where('status_id', 2)->whereIn('id', $shipments->pluck('id'))->whereHas('Client', function ($q) use ($emirate) {return $q->where('emirate_id', $emirate->id);})->count() }}
                            </td>
                            <td>{{ App\Models\Shipment::where('status_id', 3)->whereIn('id', $shipments->pluck('id'))->whereHas('Client', function ($q) use ($emirate) {return $q->where('emirate_id', $emirate->id);})->count() }}
                            </td>
                            <td>{{ App\Models\Shipment::where('status_id', 4)->whereIn('id', $shipments->pluck('id'))->whereHas('Client', function ($q) use ($emirate) {return $q->where('emirate_id', $emirate->id);})->count() }}
                            </td>
                            <td>{{ App\Models\Shipment::where('status_id', 5)->whereIn('id', $shipments->pluck('id'))->whereHas('Client', function ($q) use ($emirate) {return $q->where('emirate_id', $emirate->id);})->count() }}
                            </td>
                            <td>{{ App\Models\Shipment::where('status_id', 6)->whereIn('id', $shipments->pluck('id'))->whereHas('Client', function ($q) use ($emirate) {return $q->where('emirate_id', $emirate->id);})->count() }}
                            </td>
                            <td>{{ App\Models\Shipment::where('status_id', 7)->whereIn('id', $shipments->pluck('id'))->whereHas('Client', function ($q) use ($emirate) {return $q->where('emirate_id', $emirate->id);})->count() }}
                            </td>
                            <td>{{ App\Models\Shipment::where('status_id', 8)->whereIn('id', $shipments->pluck('id'))->whereHas('Client', function ($q) use ($emirate) {return $q->where('emirate_id', $emirate->id);})->count() }}
                            </td>
                            <td>{{ App\Models\Shipment::where('status_id', 9)->whereIn('id', $shipments->pluck('id'))->whereHas('Client', function ($q) use ($emirate) {return $q->where('emirate_id', $emirate->id);})->count() }}
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>{{ __('admin.total') }}</td>
                        <td>{{ App\Models\Shipment::where('status_id', 1)->whereIn('id', $shipments->pluck('id'))->count() }}
                        </td>
                        <td>{{ App\Models\Shipment::where('status_id', 10)->whereIn('id', $shipments->pluck('id'))->count() }}
                        </td>
                        <td>{{ App\Models\Shipment::where('status_id', 2)->whereIn('id', $shipments->pluck('id'))->count() }}
                        </td>
                        <td>{{ App\Models\Shipment::where('status_id', 3)->whereIn('id', $shipments->pluck('id'))->count() }}
                        </td>
                        <td>{{ App\Models\Shipment::where('status_id', 4)->whereIn('id', $shipments->pluck('id'))->count() }}
                        </td>
                        <td>{{ App\Models\Shipment::where('status_id', 5)->whereIn('id', $shipments->pluck('id'))->count() }}
                        </td>
                        <td>{{ App\Models\Shipment::where('status_id', 6)->whereIn('id', $shipments->pluck('id'))->count() }}
                        </td>
                        <td>{{ App\Models\Shipment::where('status_id', 7)->whereIn('id', $shipments->pluck('id'))->count() }}
                        </td>
                        <td>{{ App\Models\Shipment::where('status_id', 8)->whereIn('id', $shipments->pluck('id'))->count() }}
                        </td>
                        <td>{{ App\Models\Shipment::where('status_id', 9)->whereIn('id', $shipments->pluck('id'))->count() }}
                        </td>
                    </tr>
                </tbody>
            </table>
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
