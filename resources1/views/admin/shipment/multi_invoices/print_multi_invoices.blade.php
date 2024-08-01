<html lang="en" class="light-style" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('build/assets/') }}" data-template="vertical-menu-template">
{{-- <html lang="{{ LaravelLocalization::getCurrentLocale() }}" class="light-style"
    dir="{{ LaravelLocalization::getCurrentLocaleDirection() }} " data-theme="theme-default"
    data-assets-path="{{ asset('build/assets/') }}" data-template="vertical-menu-template"> --}}

<head>
    <meta charset="utf-8">
    <title> {{ __('admin.print_invoice') }}</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('build/assets/img/favicon/favicon.ico') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@160..700&display=swap" rel="stylesheet">
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
            font-family: "Readex Pro", sans-serif;
            font-optical-sizing: auto;
            font-weight: <weight>;
            font-style: normal;
            font-variation-settings:
                "HEXP" 0;
            font-size: 11px;
            /* padding : 1px; */
        }

        p {
            padding: 0px 20px
        }

        div {
            overflow: hidden !important;
        }

        hr {
                {
                margin: 0px;
                padding: 0px;
                color: #bbb;
            }
        }

        /* * {
            margin: 0px;
            padding: 0px;
            font-size: 10px;
            align-items: center;
            align-content: center;
        }

        body{
            padding: 0px;
            margin: 0px;
        }
        div {
            width: 100%;
            overflow: hidden  !important;
        } */

        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;1000&display=swap');

        @page {
            size: A5 landscape
        }

        @media print {

            /* * {
            margin: 0px;
            padding: 0px;
            font-size: 10px;
            align-items: center;
            align-content: center;
        }

        div {
            width: 100%;
        } */
            @page {
                size: A5 landscape
            }

        }
    </style>

</head>
<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

@forelse ($shipments as $key => $value)

    <body class="A5 landscape my-0 mx-auto" {{-- style="height: 100mm; width:100mm" --}}>

        <section class="sheet mx-auto my-0" style="width:210mm ; height: auto">

            <section style="width:100%;height: 100%;overflow: hidden;background: null" class="m-0 p-3">
                <div class="d-flex justify-content-between my-0" style="background : #5d5d5d;padding:4px">
                    <img width="30%" class="mx-0" src="{{ asset('build/assets/img/logo/logo_print.png') }}">


                    <div>
                        <h5 style="color: #fdfdfd !important;"> <span style="color: #fdfdfd !important;">+971569949432 ,
                                +971529208563 </span>
                            <br> <span style="color: #fdfdfd !important;"> info@specialline.ae </span>
                        </h5>
                    </div>
                    <div>
                        <h4 style="color: red !important ;margin:5px">#{{ $value['shipment']->shipment_refrence }}
                        </h4>
                    </div>

                </div>
                <hr>
                {!! $barcodes[$key] !!}
                <hr>
                <div class="row d-flex justify-content-between my-0">
                    <div class="col w-50 justify-content-center mx-0">
                        <h6 style="background: #ffd200; padding: 4px">From من</h6>
                        <p class="mb-1"><strong> Shipper/ المرسل </strong>
                            <br>{{ $value['shipment_company']->name ?? '' }}
                        </p>
                        <hr>
                        <p class="mb-1"><strong> address / العنوان
                            </strong><br>{{ $value['shipment_company']->address ?? '' }}</p>
                        <hr>
                        <p class="mb-1"><strong> Emirates / الامارات </strong> <br>
                            {{ $value['shipment_company']->emirate->name ?? '' }}</p>
                        <hr>
                        {{-- <p class="mb-1"><strong> phone / هاتف </strong><br> {{ $value['shipment_company']->vendors[0]->mobile ?? '' }}</p> --}}
                        <p class="mb-0"><strong> Date / التاريخ
                            </strong><br>{{ \Carbon\Carbon::now()->format('Y-m-d') ?? '' }}</p>
                        <hr>
                    </div>
                    <div class="col w-50 mx-0">
                        <h6 style="background: #ffd200; padding: 4px">To إلى</h6>
                        <p class="mb-1"><strong>Consignee / المرسل اليه</strong> <br>{{ $value['user']->name ?? '' }}
                        </p>
                        <hr>
                        <p class="mb-1">address / العنوان</strong>
                            <br>{{ $value['shipment']->delivered_address ?? '' }}
                        </p>
                        <hr>
                        <p class="mb-1">Emirate/ الامارة</strong> <br>{{ $value['shipment']->emirate->name ?? '' }}
                        </p>
                        <hr>
                        <p class="mb-1">phone / هاتف</strong> <br>{{ $value['user']->mobile }}</p>
                        <hr>

                    </div>



                    <div class="col table-responsive p-0 mx-0">

                        <table class="table border-top m-0">
                            <thead>
                                @if ($value['has_stock'] == 1)
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
                                @if ($value['has_stock'] == 1)
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
                        <p class="mb-1">Notes / ملاحظات</strong> <br>{{ $value['shipment']->shipment_notes ?? '' }}
                        </p>
                        <hr>
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
                                        {{ $value['shipment']->vendor_due }}
                                        {{ __('admin.currency') }} <br> {{$value['shipment']->paymentMethod->name}}</td>
                                    <td class="p-0 m-0"
                                        style="width: 50%; background: #ffd200 !important;text-align: center">
                                        <span style="font-size:12ps">قيمة البضاعة </span><br>
                                        <span style="font-size:12ps">Cost Of Goods</span>
                                    </td>

                                </tr>
                                <tr class="m-0 p-0">
                                    <td class="p-0 m-0" style="width: 50% ;text-align: center">
                                        {{ $value['shipment']->delivery_fees }} {{ __('admin.currency') }} <br> {{$value['shipment']->feesType->name}} </td>
                                    <td class="p-0 m-0" style="background: #ffd200 !important;text-align: center">
                                        قيمة التوصيل <br>
                                        Courier Amount
                                    </td>

                                </tr>
                                <tr class="m-0 p-0">
                                    <td class="p-0 m-0" style="width: 50% ;text-align: center">
                                        {{ $value['shipment']->delivery_extra_fees }}{{ __('admin.currency') }}
                                    </td>
                                    <td class="p-0 m-0" style="background: #ffd200 !important;text-align: center">
                                        القيمة المضافة <br>
                                        TAX 5%(+)
                                    </td>
                                </tr> --}}
                                <tr class="m-0 p-0">
                                    <td class="p-0 m-0" style="width: 50% ;text-align: center">
                                        {{ $value['shipment']->rider_should_recive }} {{ __('admin.currency') }}</td>
                                    <td class="p-0 m-0" style="background: #ffd200 !important;text-align: center">
                                        الاجمالي <br>
                                        Total
                                    </td>

                                </tr>
                        </table>

                    </div>
                    <div class="row mx-auto p-0" style="border: 1px solid #0000;">
                        <div class="col-2" style="border: 1px solid #0000 ;padding-top:30px">
                            <strong style="background: #ffd200; padding:0px">Reciver/ المستلم</strong>
                        </div>
                        <div class="col-2" style="border: 1px solid #0000 ;padding-top:30px">
                            <span style="background: #ffd200; padding:0px"> Rep / المندوب</span> <br>
                            <span>{{ $value['shipment']->rider->name ?? '' }}
                            </span>
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
                    <div class="d-flex justify-content-between my-2 py-2"
                        style="border: 1px solid #5d5d5d ; background : #5d5d5d">
                        <div class="">
                            <span style="color: #ffff !important ; "> Haroun Al Rasheed Street Al Rumailah 3
                                -Ajman</span>
                        </div>
                        <div class="" style="border: 1px solid #5d5d5d ; background : #ffd200">
                            <span style="color: #ffff !important"> محتويات الشحنة مسؤولية المرسل ولا تتحمل الشركة
                                اي مسؤولية</span>

                        </div>
                    </div>
                </div>

            </section>
        </section>

        <section class="sheet mx-auto my-0" style="width:210mm ; height: auto">
            <section style="width:100%;height: 100%;overflow: hidden;background: none ; position: relative;"
                class="m-0 p-3">
                <h3
                    style="    position: absolute;
                right: 17%;
                top: 15%;
                font-size: 250px;
                color: #18181814">
                    copy</h3>
                <div class="d-flex justify-content-between my-0" style="background : #5d5d5d;padding:4px">
                    <img width="30%" class="mx-0" src="{{ asset('build/assets/img/logo/logo_print.png') }}">


                    <div>
                        <h5 style="color: #fdfdfd !important;"> <span style="color: #fdfdfd !important;">+971569949432
                                ,
                                +971529208563 </span>
                            <br> <span style="color: #fdfdfd !important;"> info@specialline.ae </span>
                        </h5>
                    </div>
                    <div>
                        <h4 style="color: red !important ;margin:5px">#{{ $value['shipment']->shipment_refrence }}
                        </h4>
                    </div>

                </div>
                <hr>
                {!! $barcodes[$key] !!}
                <hr>
                <div class="row d-flex justify-content-between my-0" style="">
                    <div class="col w-50 justify-content-center mx-0">
                        <h6 style="background: #ffd200; padding: 4px">From من</h6>
                        <p class="mb-1"><strong> Shipper/ المرسل </strong>
                            <br>{{ $value['shipment_company']->name ?? '' }}
                        </p>
                        <hr>
                        <p class="mb-1"><strong> address / العنوان
                            </strong><br>{{ $value['shipment_company']->address ?? '' }}</p>
                        <hr>
                        <p class="mb-1"><strong> Emirates / الامارات </strong> <br>
                            {{ $value['shipment_company']->emirate->name ?? '' }}</p>
                        <hr>
                        {{-- <p class="mb-1"><strong> phone / هاتف </strong><br> {{ $value['shipment_company']->vendors[0]->mobile ?? '' }}</p> --}}
                        <p class="mb-0"><strong> Date / التاريخ
                            </strong><br>{{ \Carbon\Carbon::now()->format('Y-m-d') ?? '' }}</p>
                        <hr>
                    </div>
                    <div class="col w-50 mx-0">
                        <h6 style="background: #ffd200; padding: 4px">To إلى</h6>
                        <p class="mb-1"><strong>Consignee / المرسل اليه</strong>
                            <br>{{ $value['user']->name ?? '' }}
                        </p>
                        <hr>
                        <p class="mb-1">address / العنوان</strong>
                            <br>{{ $value['shipment']->delivered_address ?? '' }}
                        </p>
                        <hr>
                        <p class="mb-1">Emirate/ الامارة</strong> <br>{{ $value['shipment']->emirate->name ?? '' }}
                        </p>
                        <hr>
                        <p class="mb-1">phone / هاتف</strong> <br>{{ $value['user']->mobile }}</p>
                        <hr>

                    </div>


                    <div class="col table-responsive mx-0">

                        <table class="table border-top m-0">
                            <thead>
                                @if ($value['has_stock'] == 1)
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
                                @if ($value['has_stock'] == 1)
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
                        <p class="mb-1">Notes / ملاحظات</strong> <br>{{ $value['shipment']->shipment_notes ?? '' }}
                        </p>
                        <hr>
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
                                        {{ $value['shipment']->vendor_due }}
                                        {{ __('admin.currency') }} <br> {{$value['shipment']->paymentMethod->name}}</td>
                                    <td class="p-0 m-0"
                                        style="width: 50%; background: #ffd200 !important;text-align: center">
                                        <span style="font-size:12ps">قيمة البضاعة </span><br>
                                        <span style="font-size:12ps">Cost Of Goods</span>
                                    </td>

                                </tr>
                                <tr class="m-0 p-0">
                                    <td class="p-0 m-0" style="width: 50% ;text-align: center">
                                        {{ $value['shipment']->delivery_fees }} {{ __('admin.currency') }} <br> {{$value['shipment']->feesType->name}} </td>
                                    <td class="p-0 m-0" style="background: #ffd200 !important;text-align: center">
                                        قيمة التوصيل <br>
                                        Courier Amount
                                    </td>

                                </tr>
                                <tr class="m-0 p-0">
                                    <td class="p-0 m-0" style="width: 50% ;text-align: center">
                                        {{ $value['shipment']->delivery_extra_fees }}{{ __('admin.currency') }}
                                    </td>
                                    <td class="p-0 m-0" style="background: #ffd200 !important;text-align: center">
                                        القيمة المضافة <br>
                                        TAX 5%(+)
                                    </td>
                                </tr> --}}
                                <tr class="m-0 p-0">
                                    <td class="p-0 m-0" style="width: 50% ;text-align: center">
                                        {{ $value['shipment']->rider_should_recive }} {{ __('admin.currency') }}</td>
                                    <td class="p-0 m-0" style="background: #ffd200 !important;text-align: center">
                                        الاجمالي <br>
                                        Total
                                    </td>

                                </tr>
                        </table>

                    </div>
                    <div class="row mx-auto p-0" style="border: 1px solid #0000;">
                        <div class="col-2" style="border: 1px solid #0000 ;padding-top:30px">
                            <strong style="background: #ffd200; padding:0px">Reciver/ المستلم</strong>
                        </div>
                        <div class="col-2" style="border: 1px solid #0000 ;padding-top:30px">
                            <span style="background: #ffd200; padding:0px"> Rep / المندوب</span> <br>
                            <span>{{ $value['shipment']->rider->name ?? '' }}
                            </span>
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
                    <div class="d-flex justify-content-between my-2 py-2"
                        style="border: 1px solid #5d5d5d ; background : #5d5d5d">
                        <div class="">
                            <span style="color: #ffff !important ; "> Haroun Al Rasheed Street Al Rumailah 3
                                -Ajman</span>
                        </div>
                        <div class="" style="border: 1px solid #5d5d5d ; background : #ffd200">
                            <span style="color: #ffff !important"> محتويات الشحنة مسؤولية المرسل ولا تتحمل الشركة
                                اي مسؤولية</span>

                        </div>
                    </div>
                </div>
            </section>
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
@empty

    <body>
        <div class="row">

            <img src="{{ asset('build/assets/img/pages/nodata.jpg') }}" width="100%" alt="">
        </div>
    </body>

@endforelse


</html>
