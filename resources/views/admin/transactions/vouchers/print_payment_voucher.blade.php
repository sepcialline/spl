<!DOCTYPE html>

<html lang="{{ LaravelLocalization::getCurrentLocale() }}" class="light-style"
    dir="{{ LaravelLocalization::getCurrentLocaleDirection() }} " data-theme="theme-default"
    data-assets-path="{{ asset('build/assets/') }}" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ __('admin.print_invoice') }}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('build/assets/img/favicon/favicon.ico') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">

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
    {{-- <style>
        @page {
            size: A4;
        }

    </style> --}}

</head>

<body>
    <!-- Content -->

    <div class="invoice-print p-3 " style="border: 2px solid #ffd200">
        <section class="bg-label-danger px-3 py-3">
            <div class="row">
                <div class="col-5">
                    <div class="d-flex svg-illustration mb-3 gap-2">
                        <img width="50%"
                            src="{{ asset('build/assets/img/logo/logo_' . LaravelLocalization::getCurrentLocale() . '.png') }}">
                    </div>
                    {{-- <p class="mb-1" style="">{{ __('admin._company_address_') }}</p> --}}
                </div>
                <div class="col-4">
                    <h5>سند صرف</h5>
                    <h5>Payment Voucher</h5>
                </div>
                <div class="col-3">
                    درهم اماراتي AED

                    <input type="number" class="form-control" disabled readonly value="{{ $voucher->debit }}">
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    Date : {{ Carbon\Carbon::parse($voucher->transaction_date)->format('Y/M/d') }}
                </div>
                <div class="col-4">
                    <h4 style="color: red !important">{{ $voucher->number }}</h4>
                </div>
                <div class="col-3">
                    التاريخ : {{ Carbon\Carbon::parse($voucher->transaction_date)->format('Y/m/d') }}
                </div>
            </div>
            <hr />

                <div class=" d-flex justify-content-center mb-4">
                    <div class="">Pay To Mr/Ms/Mrs ............<strong>{{$account->getTranslation('account_name','en')}}</strong> </div>
                    <div class="">  يصرف لـ السيد/ة/السادة  ............<strong>{{$account->getTranslation('account_name','ar')}}</strong></div>
                </div>
                <div class=" d-flex justify-content-center mb-4">
                    <div class="">Amount ............ <strong>   {{ $debit_en }} AED -</strong> </div>

                    <div class=""> مبلغ وقدره .........<strong>     {{ $debit_ar }} درهم اماراتي فقط لا غير</strong></div>
                </div>
                <div class=" d-flex justify-content-center mb-4">
                    <div class="">For ............ <strong>   {{ $voucher->statment }} </strong> .............</div>

                    <div class=""> وذلك عن</div>
                </div>

                <div class=" d-flex  justify-content-evenly mb-4">
                    <div>Accountant .......................................  المحاسب </div>
                    <div class="d-flex flex-column align-items-center" style="    border: 2px solid #002efb;
                    padding: 0px 42px;">
                        <span style="margin: 0 0px -24px 0px;
                        color: #9989e8 !important;">سبيشل لاين لخدمات التوصيل</span><br>
                        <span style="margin: 0 0px -24px 0px; color: #9989e8 !important;">SPECIALLINE DELIVERY SERVICE</span><br>
                        <span style=" color: #e06a3b !important;">{{Carbon\Carbon::now()->format('Y-M-d')}}</span>
                        <span style=" color: #9989e8 !important;">ACCOUNTANT المحاسبة</span>
                    </div>
                    <div>Reciver ............................................ المستلم<div>
                </div>
        </section>

        <hr>

        <section class="px-3 py-3">
            <div class="row">
                <div class="col-5">
                    <div class="d-flex svg-illustration mb-3 gap-2">
                        <img width="50%"
                            src="{{ asset('build/assets/img/logo/logo_' . LaravelLocalization::getCurrentLocale() . '.png') }}">
                    </div>
                    {{-- <p class="mb-1" style="">{{ __('admin._company_address_') }}</p> --}}
                </div>
                <div class="col-4">
                    <h5>سند صرف</h5>
                    <h5>Payment Voucher</h5>
                </div>
                <div class="col-3">
                    درهم اماراتي AED

                    <input type="number" class="form-control" disabled readonly value="{{ $voucher->debit }}">
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    Date : {{ Carbon\Carbon::parse($voucher->transaction_date)->format('Y/M/d') }}
                </div>
                <div class="col-4">
                    <h4 style="color: red !important">{{ $voucher->number }}</h4>
                </div>
                <div class="col-3">
                    التاريخ : {{ Carbon\Carbon::parse($voucher->transaction_date)->format('Y/m/d') }}
                </div>
            </div>
            <hr />

                <div class=" d-flex justify-content-center mb-4">
                    <div class="">Pay To Mr/Ms/Mrs ............<strong>{{$account->getTranslation('account_name','en')}}</strong> </div>
                    <div class="">  يصرف لـ السيد/ة/السادة  ............<strong>{{$account->getTranslation('account_name','ar')}}</strong></div>
                </div>
                <div class=" d-flex justify-content-center mb-4">
                    <div class="">Amount ............ <strong>   {{ $debit_en }} AED -</strong> </div>

                    <div class=""> مبلغ وقدره .........<strong>     {{ $debit_ar }} درهم اماراتي فقط لا غير</strong></div>
                </div>
                <div class=" d-flex justify-content-center mb-4">
                    <div class="">For ............ <strong>   {{ $voucher->statment }} </strong> .............</div>

                    <div class=""> وذلك عن</div>
                </div>

                <div class=" d-flex  justify-content-evenly mb-4">
                    <div>Accountant .......................................  المحاسب </div>
                    <div class="d-flex flex-column align-items-center" style="    border: 2px solid #002efb;
                    padding: 0px 42px;">
                        <span style="margin: 0 0px -24px 0px;
                        color: #9989e8 !important;">سبيشل لاين لخدمات التوصيل</span><br>
                        <span style="margin: 0 0px -24px 0px; color: #9989e8 !important;">SPECIALLINE DELIVERY SERVICE</span><br>
                        <span style=" color: #e06a3b !important;">{{Carbon\Carbon::now()->format('Y-M-d')}}</span>
                        <span style=" color: #9989e8 !important;">ACCOUNTANT المحاسبة</span>
                    </div>
                    <div>Reciver ............................................ المستلم<div>
                </div>
        </section>

        <hr>
        <section class="bg-label-success px-3 py-3">
            <div class="row">
                <div class="col-5">
                    <div class="d-flex svg-illustration mb-3 gap-2">
                        <img width="50%"
                            src="{{ asset('build/assets/img/logo/logo_' . LaravelLocalization::getCurrentLocale() . '.png') }}">
                    </div>
                    {{-- <p class="mb-1" style="">{{ __('admin._company_address_') }}</p> --}}
                </div>
                <div class="col-4">
                    <h5>سند صرف</h5>
                    <h5>Payment Voucher</h5>
                </div>
                <div class="col-3">
                    درهم اماراتي AED

                    <input type="number" class="form-control" disabled readonly value="{{ $voucher->debit }}">
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    Date : {{ Carbon\Carbon::parse($voucher->transaction_date)->format('Y/M/d') }}
                </div>
                <div class="col-4">
                    <h4 style="color: red !important">{{ $voucher->number }}</h4>
                </div>
                <div class="col-3">
                    التاريخ : {{ Carbon\Carbon::parse($voucher->transaction_date)->format('Y/m/d') }}
                </div>
            </div>
            <hr />

                <div class=" d-flex justify-content-center mb-4">
                    <div class="">Pay To Mr/Ms/Mrs ............<strong>{{$account->getTranslation('account_name','en')}}</strong> </div>
                    <div class="">  يصرف لـ السيد/ة/السادة  ............<strong>{{$account->getTranslation('account_name','ar')}}</strong></div>
                </div>
                <div class=" d-flex justify-content-center mb-4">
                    <div class="">Amount ............ <strong>   {{ $debit_en }} AED -</strong> </div>

                    <div class=""> مبلغ وقدره .........<strong>     {{ $debit_ar }} درهم اماراتي فقط لا غير</strong></div>
                </div>
                <div class=" d-flex justify-content-center mb-4">
                    <div class="">For ............ <strong>   {{ $voucher->statment }} </strong> .............</div>

                    <div class=""> وذلك عن</div>
                </div>

                <div class=" d-flex  justify-content-evenly mb-4">
                    <div>Accountant .......................................  المحاسب </div>
                    <div class="d-flex flex-column align-items-center" style="    border: 2px solid #002efb;
                    padding: 0px 42px;">
                        <span style="margin: 0 0px -24px 0px;
                        color: #9989e8 !important;">سبيشل لاين لخدمات التوصيل</span><br>
                        <span style="margin: 0 0px -24px 0px; color: #9989e8 !important;">SPECIALLINE DELIVERY SERVICE</span><br>
                        <span style=" color: #e06a3b !important;">{{Carbon\Carbon::now()->format('Y-M-d')}}</span>
                        <span style=" color: #9989e8 !important;">ACCOUNTANT المحاسبة</span>
                    </div>
                    <div>Reciver ............................................ المستلم<div>
                </div>
        </section>

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
