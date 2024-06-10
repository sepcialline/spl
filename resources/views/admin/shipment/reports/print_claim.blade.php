<!DOCTYPE html>

<html lang="{{ LaravelLocalization::getCurrentLocale() }}" class="light-style customizer-hide"
    dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}" data-assets-path="{{ asset('build/assets') . '/' }}"
    data-template="vertical-menu-template">

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
        <div class="d-flex justify-content-between">
                    <img width="20%"
                        src="{{ asset('build/assets/img/logo/logo_' . LaravelLocalization::getCurrentLocale() . '.png') }}">
                        <p class="mb-1" style="width:50%">{{ __('admin._company_address_') }}</p>
                        <div class="p-1">
                            <h4>{{ __('admin.claim_invoice') }}</h4>
                            <div class="mb-2">
                                {{-- <span>{{__('admin.date')}}</span> --}}
                                <span class="fw-semibold">{{ Carbon\Carbon::now()->format('Y-M-d') }}</span>
                                <p>TRN : 100603385400003</p>
                                <br>
                                +971569949432 | +971529208563
                </div>
                {{-- <div>
                    <span>Date Due:</span>
                    <span class="fw-semibold">May 25, 2021</span>
                </div> --}}
            </div>
        </div>

        <hr />
        <div class="row d-flex justify-content-between mb-4">
            <div class="col-sm-6 w-50">
                <h6>{{ __('admin.invoice_to') }}</h6>
                <p class="mb-1">{{ $company->name }}</p>
                <p class="mb-1">{{ $company->address }}, {{ $company->city->name }}, {{ $company->emirate->name }}
                </p>
                <p class="mb-1">{{ $company->vendors[0]->mobile }}</p>
                <p class="mb-0">{{ $company->vendors[0]->email }}</p>
            </div>
            {{-- <div class="col-sm-6 w-50">
                <h6>{{__('admin.bill_to')}}</h6>
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
            </div> --}}
        </div>

        <div class="table-responsive">
            <table class="table border-top m-0">
                <thead>

                    <tr>
                        <th>{{ __('admin.description') }}</th>
                        <th>{{ __('admin.quantity') }}</th>
                        <th>{{ __('admin.delivery_fees') }}</th>
                        <th>{{ __('admin.amount') }}</th>
                        {{-- <th>{{ __('VAT%') }}</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @php $sum_total = 0;@endphp
                    @foreach ($claims as $claim)
                        <tr>
                            @php $sum_total = $sum_total + ($claim->specialline_due * $claim->count)  @endphp
                            <td>{{ __('admin.delivery_fees') }}</td>
                            <td>{{ $claim->count }}</td>
                            <td>{{ $claim->specialline_due }}</td>
                            <td>{{ $claim->count * $claim->specialline_due }} {{__('admin.currency')}}</td>
                            {{-- <td>5%</td> --}}

                        </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-around">
            <div></div>
            <div></div>
            <div>
                <table class="table">
                    <tr>
                        <th>{{__('admin.sub_total')}}</th>
                        <td>{{$sum_total}} {{__('admin.currency')}}</td>
                    </tr>
                    <tr>
                        <th>Vat 5%</th>
                        <td>- {{__('admin.currency')}}</td>
                    </tr>
                    <tr>
                        <th>{{__('admin.total')}}</th>
                        <td>- {{__('admin.currency')}}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <span class="fw-semibold">{{ __('admin.note:') }}</span>
                <span>هذه الفاتورة رسمية ويعتمد بها</span>
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
