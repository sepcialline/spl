<!DOCTYPE html>

<html lang="{{ LaravelLocalization::getCurrentLocale() }}" class="light-style"
    dir="{{ App::isLocale('ar') ? 'rtl' : 'ltr' }}" data-theme="theme-default"
    data-assets-path="{{ asset('build/assets/') }}" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ __('admin.payments') }}</title>

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
        @if (isset($payments) && count($payments) > 0)
        <div class="card" id="content_table">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        {{-- <div class="float-start my-2">@include('includes.shipment_table_reports',['shipments'=>$shipments])</div> --}}
                        {{-- <div class="float-end my-2"><input type="search" class="form-control" placeholder="{{__('admin.search_text')}}"></div> --}}
                        {{-- <a href="" target="_blank" rel="noopener noreferrer"><i class="bx bx-printer">{{}}</i></a> --}}
                    </div>
                    <table class="table table-striped table-bordered my-2">
                        <thead>


                            <tr>
                                <th>#</th>
                                <th>{{__('admin.date')}}</th>
                                <th>{{__('admin.in_branch')}}</th>
                                <th>{{__('admin.shipment_refrence')}}</th>
                                <th>{{__('admin.shipments_client_details')}}</th>
                                <th>{{__('admin.vendors_company')}}</th>
                                <th>{{__('admin.rider')}}</th>
                                <th>{{__('admin.payment_method')}}</th>
                                <th>{{__('admin.shipment_amount')}}</th>
                                <th>{{__('admin.delivery_fees')}}</th>
                                <th>{{__('admin.due_amount_for_vendor')}}</th>
                                <th>{{__('admin.pay/dont_pay')}}</th>
                            </tr>

                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach ($payments as $payment)
                                <tr>
                                    <input type="hidden" id="id" value="{{ $payment->id }}">
                                    <td>{{ $i++ }} <br>
                                    @if($payment->image)
                                        <a href="{{asset('build/assets/img/uploads/documents/'.$payment->image)}}" target="_blank" rel="noopener noreferrer"><i class="bx bx-receipt text-danger"></i></a>
                                    @endif
                                    </td>
                                    <td>{{ $payment->date }}</td>
                                    <td>{{ $payment->branch->branch_name }}</td>
                                    <td>{{ $payment->is_split == 1 ? __('admin.split') : '' }}
                                        <br>
                                        {{-- {{ $payment->payment_number }} --}}
                                        {{ $payment->shipment->shipment_no }} <br>
                                        #{{ $payment->shipment->shipment_refrence }}
                                    </td>
                                    <td>
                                        {{ $payment->shipment->Client->mobile }}<br>
                                        {{ $payment->shipment->Client->name }} <br>
                                        {{ $payment->shipment->emirate->name }} - {{$payment->shipment->city->name}} <br>
                                        {{$payment->shipment->delivered_address}}
                                    </td>
                                    <td>{{ $payment->company->name }}</td>
                                    <td>{{ $payment->Rider->name }}</td>
                                    <td>{{ $payment->paymentMethod->name }} <br> {{ $payment->shipment?->Status->name }} </td>
                                    <td>{{ $payment->amount }}</td>
                                    <td>{{$payment->delivery_fees}}</td>
                                    <td>{{$payment->due_amount}}</td>
                                    <td>{{ $payment->is_vendor_get_due == 0 ? __('admin.no') : __('admin.yes') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- {{ $payments->appends(request()->query())->links() }} --}}
                </div>
            </div>
        </div>
    @else
        <div class="row justify-center">
            <div class="col-md">
                <img src="{{ asset('build/assets/img/pages/nodata.jpg') }}" width="100%" alt="">

            </div>
        </div>
    @endif
    <hr>

            <div class="d-flex justify-content-around">
                <div>
                    <table class="table">
                        <thead><tr><th>{{__('admin.total')}}</th></tr></thead>
                        <tbody><tr><td>  {{$total}} {{__('admin.currency')}}</td></tr></tbody>
                    </table>

                </div>
                <div>
                    <table class="table">
                        <thead><tr><th>{{__('admin.cash_on_delivery')}}</th></tr></thead>
                        <tbody><tr><td>  {{$cash_on_delivery}} {{__('admin.currency')}}</td></tr></tbody>
                    </table>

                </div>
                <div>
                    <table class="table">
                        <thead><tr><th>{{__('admin.transfer_to_Bank')}}</th></tr></thead>
                        <tbody><tr><td>  {{$transfer_to_Bank}} {{__('admin.currency')}}</td></tr></tbody>
                    </table>

                </div>
                <div>
                    <table class="table">
                        <thead><tr><th>{{__('admin.transfer_to_vendor_company')}}</th></tr></thead>
                        <tbody><tr><td>  {{$transfer_to_vendor_company}} {{__('admin.currency')}}</td></tr></tbody>
                    </table>

                </div>

            </div>
            <hr>
            <div class="d-flex justify-content-around">
                <div>
                    <table class="table">
                        <thead><tr><th>{{__('admin.due_amount_for_vendor')}}</th></tr></thead>
                        <tbody><tr><td>  {{$vendor_amount_due}} {{__('admin.currency')}}</td></tr></tbody>
                    </table>

                </div>
                <div>
                    {{-- <table class="table">
                        <thead><tr><th>{{__('admin.due_amount_for_sp')}}</th></tr></thead>
                        <tbody><tr><td>  {{$spl_amount_due}} {{__('admin.currency')}}</td></tr></tbody>
                        <tbody><tr><td>  soon {{__('admin.currency')}}</td></tr></tbody>
                    </table> --}}

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
