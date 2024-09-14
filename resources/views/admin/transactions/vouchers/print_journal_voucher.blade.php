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
    <style>
        @font-face {
            font-family: 'Simplified Arabic';
            src: url('fonts/Simplified Arabic Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: 'Simplified Arabic', sans-serif;
        }
    </style>


</head>

<body>
    <!-- Content -->

    <div class="invoice-print pt-5 mt-5 " style="border: 2px solid #ffd200 ; height:100%">
        <div id="back" style="position: fixed;
        top: 10px;
        left: 10px;"> <a
                href="{{ route('admin.account.journal_voucher') }}"> 🔙</a></div>
        <section class="mx-4 p-4" style="height: 33.3%">
            <div class="d-flex justify-content-center">
                <img width="20%"
                    src="{{ asset('build/assets/img/logo/logo_' . LaravelLocalization::getCurrentLocale() . '.png') }}">
            </div>
            <hr>
            <div class="d-flex justify-content-between">
                <h5>JV - {{ $journals[0]->number }}</h5>
                <h5>{{ $journals[0]?->statment_for_journal }}</h5>
                <h5>{{ $journals[0]->transaction_date }}</h5>

            </div>
            <table class="table table-bordered pt-4 mt-4" id="entries-table">
                <thead>
                    <tr>
                        <th width="15%"> <span style="font-size:24px">{{ __('admin.account_name') }}</span> </th>
                        <th width="15%"> <span style="font-size:24px">{{ __('admin.credit') }}</span> </th>
                        <th width="15%"> <span style="font-size:24px">{{ __('admin.debit') }}</span> </th>
                        <th width="15%"> <span style="font-size:24px">{{ __('admin.cost_center') }}</span> </th>
                        <th width="15%"> <span style="font-size:24px">{{ __('admin.statment') }}</span> </th>
                        <th width="15%"> <span style="font-size:24px">{{ __('admin.branch_branch_name') }}</span>
                        </th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    <!-- Add two initial rows here -->
                    <input type="hidden" value="{{ $journals[0]->number }}" name="number">

                    @php
                        $credit = 0;
                        $debit = 0;
                    @endphp
                    @foreach ($journals as $key => $journal)
                        @php
                            if ($journal->amount_debit) {
                                $debit += $journal->amount_debit;
                            } else {
                                $credit += $journal->amount_credit;
                            }
                        @endphp

                        <input type="hidden" name="entry_id[]" value="{{ $journal->id }}">
                        <tr class="entry-row">
                            <td class="p-0 text-center align-middle">
                                @if ($journal->debit_account_number != null)
                                    {{ $journal?->debit_account_number }} - {{ $journal?->debit_account_name }}
                                @else
                                    {{ $journal?->credit_account_number }} - {{ $journal?->credit_account_name }}
                                @endif
                            </td>
                            <td class="p-0 text-center align-middle">
                                {{ $journal?->amount_credit }} {{ $journal?->amount_credit ? 'AED' : '' }}
                            </td>
                            <td class="p-0 text-center align-middle">
                                {{ $journal?->amount_debit }} {{ $journal?->amount_debit ? 'AED' : '' }}
                            </td>
                            <td class="text-center align-middle">
                                {{ $journal?->costCenter?->car_name }} {{ $journal?->costCenter?->car_plate }}
                            </td>
                            <td class="text-center align-middle">
                                {{ $journal?->statment }}
                            </td>
                            <td class="text-center align-middle">
                                {{ $journal?->branch?->branch_name }}
                            </td>
                        </tr>
                    @endforeach
                    <tr style="background: #ffd200">
                        <td class="text-center align-middle">{{ __('admin.total') }}</td>
                        <td class="text-center align-middle">{{ $credit }} AED</td>
                        <td class="text-center align-middle">{{ $debit }} AED</td>
                        <td colspan="3"></td>
                    </tr>
                </tbody>

            </table>
            <div class="d-flex justify-content-around mt-4 pt-4">
                <div>
                    <h4 style="font-size: 24px"> prepared By : </h4>
                    <h5> {{ $journals[0]->created_by }}</h5>
                </div>
                <div>
                    <h4 style="font-size: 24px"> Approved By : </h4>

                </div>
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
