<!DOCTYPE html>

<html lang="en" class="light-style"
    dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('build/assets/') }}" data-template="vertical-menu-template">
{{-- <html lang="{{ LaravelLocalization::getCurrentLocale() }}" class="light-style"
    dir="{{ LaravelLocalization::getCurrentLocaleDirection() }} " data-theme="theme-default"
    data-assets-path="{{ asset('build/assets/') }}" data-template="vertical-menu-template"> --}}

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

    <div class="invoice-print p-1" style="border: 2px solid #ffd200">
        <section style="overflow: hidden;background: none" class="mx-2 p-0">
            <div class="d-flex justify-content-between" style="background : #5d5d5d;padding:4px">
                <img width="20%" class="mx-0"
                    src="{{ asset('build/assets/img/logo/logo_' . LaravelLocalization::getCurrentLocale() . '.png') }}">
                <div>
                    <h5 style="color: #fdfdfd !important;"> <span style="color: #fdfdfd !important;">+971569949432 , +971529208563 </span>
                        <br> <span style="color: #fdfdfd !important;"> info@specialline.ae </span>
                    </h5>
                </div>
                <div>
                    <h4 style="color: red !important ;margin:5px">#{{ $shipment->shipment_refrence }}</h4>
                </div>
            </div>
            <div class="row d-flex justify-content-between mb-4 ;margin:0px ;border: 1px solid #000">
                <div class="col w-50 justify-content-center mx-0">
                    <h6 style="background: #ffd200; padding: 4px">From  من</h6>
                    <p class="mb-1"><strong> Shipper/ المرسل </strong>{{ $shipment_company->name ?? '' }}</p>
                    <p class="mb-1"><strong> address / العنوان </strong>{{ $shipment_company->address ?? '' }}</p>
                    <p class="mb-1"><strong> Emirates / الامارات </strong>
                        {{ $shipment_company->emirate->name ?? '' }}</p>
                    <p class="mb-1"><strong> phone / هاتف </strong></p>
                    <p class="mb-0"><strong> Date / التاريخ
                        </strong>{{ \Carbon\Carbon::now()->format('Y-m-d') ?? '' }}</p>
                </div>
                <div class="col w-50 mx-0">
                    <h6 style="background: #ffd200; padding: 4px">To إلى</h6>
                    <table>
                        <tbody>
                            <tr>
                                <td class="pe-3"><strong>Consignee / المرسل اليه</strong></td>
                                <td class="p-0 m-0">{{ $user->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="pe-3"><strong>address / العنوان</strong></td>
                                <td class="p-0 m-0">{{ $shipment->delivered_address ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="pe-3"><strong>Emirate/ الامارة</strong></td>
                                <td class="p-0 m-0">{{ $shipment->emirate->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="pe-3"><strong>phone / هاتف</strong></td>
                                <td class="p-0 m-0">{{ $user->mobile }}</td>
                            </tr>
                            <tr>
                                <td class="pe-3"><strong>Notes / ملاحظات</strong></td>
                                <td class="p-0 m-0">{{ $shipment->shipment_notes ?? '' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <div class="col table-responsive mx-0">
                    <div class="m-2">{!! $barcode !!}</div>

                    <table class="table border-top m-0">
                        <thead>
                            @if ($has_stock == 1)
                                <tr>
                                    <th style="background: #ffd200 !important">{{ __('admin.item') }}</th>
                                    <th style="background: #ffd200 !important">{{ __('admin.quantity') }}</th>
                                </tr>
                            @else
                                <tr>
                                    <th>{{ __('admin.shipments_shipment_Content') }}</th>
                                </tr>
                            @endif
                        </thead>
                        <tbody>
                            @if ($has_stock == 1)
                                @php $i = 1; @endphp
                                @foreach ($shipment_content as $content)
                                    <tr>
                                        <td class="p-0 m-0">{{ $content->product->name }}</td>
                                        <td class="p-0 m-0">{{ $content->quantity }}</td>

                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="p-0 m-0">{{ $shipment_content->content_text ?? '-' }}</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
                <div class="col m-0">
                    <table class="table table-bordered justify-content-center">
                        <th colspan="2" style="background: #ffd200 !important; text-align: center">
                            {{-- <td class="p-0 m-0"> --}}
                            مبلغ التوصيل <br>
                            Amount of delivery
                            {{-- </td> --}}
                            </tr>
                            {{-- <tr class="m-0 p-0">
                                <td class="p-0 m-0" style="width: 50% ;text-align: center">
                                    {{ $shipment->vendor_due }}  {{ __('admin.currency') }} <br> ({{$shipment->paymentMethod->name}})</td>
                                <td class="p-0 m-0"
                                    style="width: 50%; background: #ffd200 !important;text-align: center">
                                    <span style="font-size:12ps">قيمة البضاعة </span><br>
                                    <span style="font-size:12ps">Cost Of Goods</span>
                                </td>

                            </tr>
                            <tr class="m-0 p-0">
                                <td class="p-0 m-0" style="width: 50% ;text-align: center">
                                    {{ $shipment->delivery_fees }} {{ __('admin.currency') }} <br> ({{$shipment->feesType->name}})</td>
                                <td class="p-0 m-0" style="background: #ffd200 !important;text-align: center">
                                    قيمة التوصيل <br>
                                    Courier Amount
                                </td>

                            </tr>
                            <tr class="m-0 p-0">
                                <td class="p-0 m-0" style="width: 50% ;text-align: center">{{$shipment->delivery_extra_fees}}{{__('admin.currency')}}</td>
                                <td class="p-0 m-0" style="background: #ffd200 !important;text-align: center">
                                    القيمة المضافة <br>
                                    TAX 5%(+)
                                </td>
                            </tr> --}}
                            <tr class="m-0 p-0">
                                <td class="p-0 m-0" style="width: 50% ;text-align: center">
                                    {{ $shipment->rider_should_recive }} {{ __('admin.currency') }}</td>
                                <td class="p-0 m-0" style="background: #ffd200 !important;text-align: center">
                                    الاجمالي <br>
                                    Total
                                </td>

                            </tr>
                    </table>

                </div>
                <div class="row mx-auto p-0" style="border: 1px solid #0000;">
                    <div class="col-2" style="border: 1px solid #0000 ;padding-top:30px">
                        <h3>.....................................</h3>
                        <strong style="background: #ffd200; padding:0px">Reciver's Sign / توقيع المستلم</strong>
                    </div>
                    <div class="col-2" style="border: 1px solid #0000 ;padding-top:30px">
                        <h3>{{ $shipment->rider->name ?? '.....................................' }}</h3>
                        <strong style="background: #ffd200; padding:0px">ٌRep Name / اسم المندوب </strong>
                    </div>
                    <div class="col-8" style="padding:0px ; margin:0px ;background: #ffd200; padding:0px">
                        <table class="table table-bordered">
                            <tr>
                                <td>
                                    <input type="checkbox"> service Service/ خدمة اعادة <br>
                                    <input type="checkbox"> Others/ أخرى
                                </td>
                                <td>
                                    <input type="checkbox"> Fragile /قابل للكسر <br>
                                     <input type="checkbox">Cool Area / يحفظ في مكان بارد
                                </td>
                                <td>
                                    Special Service <input type="checkbox"> خدمة خاصة <br>
                                    Urgent Service<input type="checkbox"> عاجلة
                                </td>
                            </tr>
                        </table>

                    </div>
                </div>
                <div class="row my-2 py-2">
                    <div class="col" style="border: 1px solid #5d5d5d ; background : #5d5d5d">
                        <span style="color: #ffff !important ; "> Haroun Al Rasheed Street - Ajman Corniche Al Rumailah
                            -Al Rumailah 3 -Ajman - United Arab Emirates</span>
                    </div>
                    <div class="col" style="border: 1px solid #5d5d5d ; background : #ffd200">
                        <span style="color: #ffff !important"> محتويات الشحنة مسؤولية المرسل ولا تتحمل الشركة اي مسؤولية</span>

                    </div>
                </div>
            </div>
        </section>

        <section style="overflow: hidden;background:#fff0049e" class="mx-2 p-0">
            <div class="d-flex justify-content-between" style="background : #5d5d5d;padding:4px">
                <img width="20%" class="mx-0"
                    src="{{ asset('build/assets/img/logo/logo_' . LaravelLocalization::getCurrentLocale() . '.png') }}">
                <div>
                    <h5 style="color: #fdfdfd !important;"> <span style="color: #fdfdfd !important;">+971569949432 , +971529208563 </span>
                        <br> <span style="color: #fdfdfd !important;"> info@specialline.ae </span>
                    </h5>
                </div>
                <div>
                    <h4 style="color: red !important ;margin:5px">#{{ $shipment->shipment_refrence }}</h4>
                </div>
            </div>
            <div class="row d-flex justify-content-between mb-4 ;margin:0px ;border: 1px solid #000">
                <div class="col w-50 justify-content-center mx-0">
                    <h6 style="background: #ffd200; padding: 4px">From  من</h6>
                    <p class="mb-1"><strong> Shipper/ المرسل </strong>{{ $shipment_company->name ?? '' }}</p>
                    <p class="mb-1"><strong> address / العنوان </strong>{{ $shipment_company->address ?? '' }}</p>
                    <p class="mb-1"><strong> Emirates / الامارات </strong>
                        {{ $shipment_company->emirate->name ?? '' }}</p>
                    <p class="mb-1"><strong> phone / هاتف </strong></p>
                    <p class="mb-0"><strong> Date / التاريخ
                        </strong>{{ \Carbon\Carbon::now()->format('Y-m-d') ?? '' }}</p>
                </div>
                <div class="col w-50 mx-0">
                    <h6 style="background: #ffd200; padding: 4px">To إلى</h6>
                    <table>
                        <tbody>
                            <tr>
                                <td class="pe-3"><strong>Consignee / المرسل اليه</strong></td>
                                <td class="p-0 m-0">{{ $user->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="pe-3"><strong>address / العنوان</strong></td>
                                <td class="p-0 m-0">{{ $shipment->delivered_address ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="pe-3"><strong>Emirate/ الامارة</strong></td>
                                <td class="p-0 m-0">{{ $shipment->emirate->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="pe-3"><strong>phone / هاتف</strong></td>
                                <td class="p-0 m-0">{{ $user->mobile }}</td>
                            </tr>
                            <tr>
                                <td class="pe-3"><strong>Notes / ملاحظات</strong></td>
                                <td class="p-0 m-0">{{ $shipment->shipment_notes ?? '' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <div class="col table-responsive mx-0">
                    <div class="m-2">{!! $barcode !!}</div>

                    <table class="table border-top m-0">
                        <thead>
                            @if ($has_stock == 1)
                                <tr>
                                    <th style="background: #ffd200 !important">{{ __('admin.item') }}</th>
                                    <th style="background: #ffd200 !important">{{ __('admin.quantity') }}</th>
                                </tr>
                            @else
                                <tr>
                                    <th>{{ __('admin.shipments_shipment_Content') }}</th>
                                </tr>
                            @endif
                        </thead>
                        <tbody>
                            @if ($has_stock == 1)
                                @php $i = 1; @endphp
                                @foreach ($shipment_content as $content)
                                    <tr>
                                        <td class="p-0 m-0">{{ $content->product->name }}</td>
                                        <td class="p-0 m-0">{{ $content->quantity }}</td>

                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="p-0 m-0">{{ $shipment_content->content_text ?? '-' }}</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
                <div class="col m-0">
                    <table class="table table-bordered justify-content-center">
                        <th colspan="2" style="background: #ffd200 !important; text-align: center">
                            {{-- <td class="p-0 m-0"> --}}
                            مبلغ التوصيل <br>
                            Amount of delivery
                            {{-- </td> --}}
                            </tr>
                            {{-- <tr class="m-0 p-0">
                                <td class="p-0 m-0" style="width: 50% ;text-align: center">
                                    {{ $shipment->vendor_due }} {{ __('admin.currency') }} <br> ({{$shipment->paymentMethod->name}})</td>
                                <td class="p-0 m-0"
                                    style="width: 50%; background: #ffd200 !important;text-align: center">
                                    <span style="font-size:12ps">قيمة البضاعة </span><br>
                                    <span style="font-size:12ps">Cost Of Goods</span>
                                </td>

                            </tr>
                            <tr class="m-0 p-0">
                                <td class="p-0 m-0" style="width: 50% ;text-align: center">
                                    {{ $shipment->delivery_fees }} {{ __('admin.currency') }} <br> ({{$shipment->feesType->name}})</td>
                                <td class="p-0 m-0" style="background: #ffd200 !important;text-align: center">
                                    قيمة التوصيل <br>
                                    Courier Amount
                                </td>

                            </tr>
                            <tr class="m-0 p-0">
                                <td class="p-0 m-0" style="width: 50% ;text-align: center">{{$shipment->delivery_extra_fees}}{{__('admin.currency')}}</td>
                                <td class="p-0 m-0" style="background: #ffd200 !important;text-align: center">
                                    القيمة المضافة <br>
                                    TAX 5%(+)
                                </td>
                            </tr> --}}
                            <tr class="m-0 p-0">
                                <td class="p-0 m-0" style="width: 50% ;text-align: center">
                                    {{ $shipment->rider_should_recive }} {{ __('admin.currency') }}</td>
                                <td class="p-0 m-0" style="background: #ffd200 !important;text-align: center">
                                    الاجمالي <br>
                                    Total
                                </td>

                            </tr>
                    </table>

                </div>
                <div class="row mx-auto p-0" style="border: 1px solid #0000;">
                    <div class="col-2" style="border: 1px solid #0000 ;padding-top:30px">
                        <h3>.....................................</h3>
                        <strong style="background: #ffd200; padding:0px">Reciver's Sign / توقيع المستلم</strong>
                    </div>
                    <div class="col-2" style="border: 1px solid #0000 ;padding-top:30px">
                        <h3>{{ $shipment->rider->name ?? '.....................................' }}</h3>
                        <strong style="background: #ffd200; padding:0px">ٌRep Name / اسم المندوب </strong>
                    </div>
                    <div class="col-8" style="padding:0px ; margin:0px ;background: #ffd200; padding:0px">
                        <table class="table table-bordered">
                            <tr>
                                <td>
                                    <input type="checkbox"> service Service/ خدمة اعادة <br>
                                    <input type="checkbox"> Others/ أخرى
                                </td>
                                <td>
                                    <input type="checkbox"> Fragile /قابل للكسر <br>
                                     <input type="checkbox">Cool Area / يحفظ في مكان بارد
                                </td>
                                <td>
                                    Special Service <input type="checkbox"> خدمة خاصة <br>
                                    Urgent Service<input type="checkbox"> عاجلة
                                </td>
                            </tr>
                        </table>

                    </div>
                </div>
                <div class="row my-2 py-2">
                    <div class="col" style="border: 1px solid #5d5d5d ; background : #5d5d5d">
                        <span style="color: #ffff !important ; "> Haroun Al Rasheed Street - Ajman Corniche Al Rumailah
                            -Al Rumailah 3 -Ajman - United Arab Emirates</span>
                    </div>
                    <div class="col" style="border: 1px solid #5d5d5d ; background : #ffd200">
                        <span style="color: #ffff !important"> محتويات الشحنة مسؤولية المرسل ولا تتحمل الشركة اي مسؤولية</span>

                    </div>
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
