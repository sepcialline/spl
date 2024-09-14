<!DOCTYPE html>

<html lang="en" class="light-style" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('build/assets/') }}" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ __('admin.compensation_request') }}</title>

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
    <link rel="stylesheet"
        href="{{ asset('build/assets/vendor/css/rtl/core.css" class="template-customizer-core-css') }}" />
    <link rel="stylesheet"
        href="{{ asset('build/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css') }}" />
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <style>
        @font-face {
            font-family: 'Simplified Arabic';
            src: url('fonts/Simplified Arabic Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;

        }

        body {
            font-family: 'Simplified Arabic', sans-serif;
            font-size: 32px;
        }
    </style>
</head>

<body>
    <!-- Content -->

    <div class="invoice-print p-5">
        <div class="d-flex justify-content-center align-items-center">
            <div>
                <!-- تحسين عرض الصورة -->
                <img src="{{ asset('build/assets/img/uploads/sp_header.png') }}" alt="">
            </div>

        </div>
        <div class="d-flex justify-content-center align-items-center pt-2">
            <div>
                <!-- إضافة مسافة بين الصورة والنص -->
                <h3 class="ml-3">{{ __('admin.compensation_request') }}</h3>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col">
                <h5 class="text-center"> {{ __('admin.date') }} : {{ $request->date }}</h5>
            </div>
        </div>
        <hr>
        <div class="d-flex justify-content-center">
            <div style="width : 80%">
                <table class="table table-bordered">
                    <tbody>
                        <tr class="text-center">
                            <td style="background :#ffd200">{{ __('admin.shipments_company_name') }}</td>
                            <td>{{ $request?->company?->name }}</td>
                        </tr>
                        <tr class="text-center">
                            <td style="background :#ffd200">{{ __('admin.accounts_code') }}</td>
                            <td>{{ $request?->company?->account_number }}</td>
                        </tr>

                    </tbody>
                </table>
            </div>

        </div>

        <div class="d-flex justify-content-center">
            <table class="table table-bordered" style="width: 80%">
                <thead>
                    <tr class="text-center">
                        <th colspan="2" style="background: #ffd200">{{ __('admin.compensation_info') }}</th>
                    </tr>
                    <tr class="text-center">
                        <th>{{ __('admin.shipments_shipments_list') }}</th>
                        <th>{{ __('admin.amount') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($request_infos as $info)
                        <tr class="text-center">
                            <td>#{{ $info->shipment }}</td>
                            <td>{{ $info->amount }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="text-center">
                        <td style="background: #FFD200; font-weight: bold;">{{ __('admin.total') }}</td>
                        <td> {{ App\Models\CompensationRequest_info::where('compensation_request_id', $request->id)->sum('amount') ?? 0 }}
                            {{ __('admin.currency') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        @if ($request->store_check == 1)
            <div class="d-flex justify-content-center" style="position: relative">
                <div style="width: 80%">
                    <h3 class="text-center py-2">
                        {{ __('admin.store_report') }}
                    </h3>
                    <textarea name="" id="" class="form-control text-center" cols="5" rows="2" readonly>{{ $request?->store_report }}</textarea>

                    <div class="d-flex justify-content-evenly mb-4">
                        <div>{{ __('admin.store_keeper_name') }} <strong>{{ $request->store_keeper }}</strong></div>
                        <div class="d-flex flex-column align-items-center"
                            style="border: 2px solid #002efb;padding: 0px 19px;position: absolute;top: 25%;right: 18%;transform: rotate(-18deg);">
                            <span style="margin: 0 0px -24px 0px; color: #9989e8 !important;">سبيشل لاين لخدمات
                                التوصيل</span><br>
                            <span style="margin: 0 0px -24px 0px; color: #9989e8 !important;">SPECIALLINE DELIVERY
                                SERVICE</span><br>
                            <span
                                style=" color: #e06a3b !important;">{{ Carbon\Carbon::parse($request->date)->format('Y-M-d') }}</span>
                            <span style=" color: #9989e8 !important;">Store المستودع</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <hr>
        @if ($request->operation_check == 1)
            <div class="d-flex justify-content-center" style="position: relative">
                <div style="width: 80%">
                    <h3 class="text-center py-2">
                        {{ __('admin.operation_report') }}
                    </h3>
                    <textarea name="" id="" class="form-control text-center" cols="5" rows="2" readonly>{{ $request?->operation_report }}</textarea>

                    <div class="d-flex justify-content-evenly mb-4">
                        <div>{{ __('admin.operation_name') }} <strong>{{ $request->operation }}</strong></div>
                        <div class="d-flex flex-column align-items-center"
                            style="border: 2px solid #002efb;padding: 0px 19px;position: absolute;top: 25%;right: 18%;transform: rotate(-18deg);">
                            <span style="margin: 0 0px -24px 0px; color: #9989e8 !important;">سبيشل لاين لخدمات
                                التوصيل</span><br>
                            <span style="margin: 0 0px -24px 0px; color: #9989e8 !important;">SPECIALLINE DELIVERY
                                SERVICE</span><br>
                            <span
                                style=" color: #e06a3b !important;">{{ Carbon\Carbon::parse($request->date)->format('Y-M-d') }}</span>
                            <span style=" color: #9989e8 !important;">operation العمليات</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <hr>
        @if ($request->ceo_check == 1)
            <div class="d-flex justify-content-center" style="width:100% ; position: relative;">
                <div class="p-2">
                    <h2 class="text-center">{{__('admin.ceo')}}</h2>
                    <h3 class="text-center">{{$request->ceo}}</h3>
                    <h4 class="text-center">{{$request->ceo_report}}</h4>
                </div>
                <div>
                    <div class="d-flex flex-column align-items-center"
                    style="border: 2px solid #002efb;padding: 0px 19px;position: absolute;transform: rotate(0deg);">
                    <h3 style="color:#002efb!important;">يعتمد -  approved </h3>
                    <span
                        style=" color: #e06a3b !important;">{{ Carbon\Carbon::parse($request->updated_at)->format('Y-M-d') }}</span>
                </div>
                </div>
            </div>
        @endif
        @if ($request->decline_check == 1)
            <div class="d-flex justify-content-center" style="width:100% ; position: relative;">
                <div class="p-2">
                    <h2 class="text-center">{{__('admin.ceo')}}</h2>
                    <h3 class="text-center">{{$request->ceo}}</h3>
                    <h4 class="text-center">{{$request->ceo_report}}</h4>
                </div>
                <div>
                    <div class="d-flex flex-column align-items-center"
                    style="border: 2px solid #970000;padding: 0px 19px;position: absolute;transform: rotate(0deg);">
                    <h3 style="color:#970000!important;">مرفوض -  Rejected </h3>
                    <span
                        style=" color: #970000 !important;">{{ Carbon\Carbon::parse($request->updated_at)->format('Y-M-d') }}</span>
                </div>
                </div>
            </div>
        @endif
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
