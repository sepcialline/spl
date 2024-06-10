<x-app-layout>

    @section('title')
        {{ __('admin.shipments') }} | {{ __('admin.shipments_shipments_list') }}
    @endsection

    @section('VendorsCss')
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/select2/select2.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/tagify/tagify.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
        <link rel="stylesheet"
            href="{{ asset('build/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}" />
        <link rel="stylesheet"
            href="{{ asset('build/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/pickr/pickr-themes.css') }}" />
        <style>
            .table td {
                text-align: center;
            }
        </style>
    @endsection
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">{{ __('admin.shipments') }} / </span>
            {{ __('admin.shipments_shipments_list') }}
        </h4>

        <div class="card">
            <div class="card-body">
                <form action="" class="row g-3 needs-validation" novalidate>
                    <div class="row">

                        <div class="col">
                            <label for="select2Multiple"
                                class="form-label">{{ __('admin.user_management_rider_list') }}</label>
                            <select id="select2Multiple2" class="select2 form-select" name="rider_id" required>
                                <option value="">{{ __('admin.please_select') }}
                                <option>
                                    @foreach ($riders as $rider)
                                <option value="{{ $rider->id }}"
                                    {{ request()->rider_id == $rider->id ? 'selected' : '' }}>
                                    {{ $rider->name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col">
                            <label for="dateRangePicker" class="form-label">{{ __('admin.date') }}</label>
                            <div class="input-group input-daterange" id="bs-datepicker-daterange">
                                <span class="input-group-text">{{ __('admin.date') }}</span>
                                <input type="date" name="date" id="dateRangePicker" placeholder="MM/DD/YYYY"
                                    class="form-control" value="{{ \Carbon\Carbon::parse($from)->format('Y-m-d') }}" />
                                {{-- <span class="input-group-text">{{ __('admin.to') }}</span>
                                <input type="date" name="to" placeholder="MM/DD/YYYY" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($to)->format('Y-m-d') }}" /> --}}
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-3 mb-0">

                            <button name="action" value="search_action" type="submit"
                                class="btn btn-label-facebook">{{ __('admin.send') }}</button>

                            <button name="action" value="report" type="submit"
                                class="btn btn-label-facebook">{{ __('admin.accounts_reports') }}</button>
                        </div>

                    </div>
                </form>
            </div>
            <hr>
            <div class="table-responsive">
                @if (isset($shipments) && count($shipments) > 0)


                    <table class="table table-striped table-bordered my-2">
                        <thead>
                            <tr>
                                <th width='1%'>#</th>
                                <th>{{ __('admin.status') }}</th>
                                <th>{{ __('admin.shipment_no') }}/<br>{{ __('admin.shipment_refrence') }}
                                </th>
                                <th>{{ __('admin.client') }}</th>
                                <th>{{ __('admin.shipments_client_address') }}</th>
                                <th>{{ __('admin.vendors_companies') }}</th>
                                {{-- <th>{{ __('admin.payment_method') }}</th> --}}
                                <th> {{ __('admin.rider_should_recive') }}</th>
                                <th>{{ __('admin.note:') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach ($all_shipments as $shipment)
                                {{-- @php $shipment  = App\Models\Shipment::where('id',$tracking->shipment_id)->first(); @endphp --}}
                                <tr>
                                    {{-- <input type="hidden" id="id" value="{{ $shipment->id }}"> --}}
                                    <td>{{ $i++ }}</td>
                                    <td><span
                                            class="{{ $shipment->Status->html_code }}">{{ $shipment->Status->name }}</span>
                                    </td>
                                    <td>
                                        {{-- {!! DNS2D::getBarcodeHTML("$shipment->shipment_no", 'DATAMATRIX') !!} --}}
                                        <span>{{ $shipment->shipment->shipment_no ?? '' }}#{{ $shipment->shipment->shipment_refrence ?? '' }}</span>
                                    </td>
                                    <td>{{ $shipment->shipment->Client->name ?? '' }} <br>
                                        {{ $shipment->shipment->Client?->mobile ?? '' }}</td>
                                    <td>{{ $shipment->shipment->emirate->name ?? '' }} <br>
                                        {{ $shipment->shipment->city->name ?? '' }} <br>
                                        {{ $shipment->shipment->delivered_address ?? '' }}</td>
                                    <td>{{ $shipment->Company->name ?? '' }}</td>
                                    {{-- <td>{{ $shipment->paymentMethod->name ?? '' }} | <br>
                                        {{ $shipment->feesType->name ?? '' }}
                                    </td> --}}
                                    <td>{{ $shipment->shipment->rider_should_recive }} {{ __('admin.currency') }}</td>
                                    <td>
                                        {{ $shipment->shipment->shipment_notes ?? '' }}
                                    </td>


                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                    <h3>Operation report - تقرير العمليات</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('admin.company_list') }}</th>
                                <th>{{ __('admin.total') }}</th>
                                <th>-</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                                $all = 0;
                            @endphp
                            @foreach ($vendor_count_shipments as $vendor_count)
                                @php $all = $all + $vendor_count['count']@endphp
                                @php @endphp
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $vendor_count['vendor'] }}</td>
                                    <td>{{ $vendor_count['count'] }}</td>

                                    @foreach (App\Models\ShipmentStatuses::get() as $status)
                            @if (isset($vendor_count['shipments'][$status->id]))
                                        <td class="mx-0">
                                             <span class="btn btn-sm {{ $status->html_code }}">{{ $vendor_count['shipments'][$status->id]->count() }} : {{ $status->name }} </span>
                                        </td>
                            @endif
                @endforeach


                </tr>
                @endforeach
                <tr>
                    <td>#</td>
                    <td>{{ __('admin.all') }}</td>
                    <td>{{ $all }}</td>
                </tr>
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
                @if ($all != 0)
                    <table class="table table-bordered">
                        <tr>
                            <th>{{ __('admin.all') }}</th>
                            @if ($in_progress != 0)
                                <th>{{ __('admin.in_progress') }}</th>
                            @endif
                            @if ($delivered != 0)
                                <th>{{ __('admin.delivered') }}</th>
                            @endif
                            @if ($delayed != 0)
                                <th>{{ __('admin.delayed') }}</th>
                            @endif
                            @if ($transferred != 0)
                                <th>{{ __('admin.transferred') }}</th>
                            @endif
                            @if ($canceled != 0)
                                <th>{{ __('admin.canceled') }}</th>
                            @endif
                            @if ($damaged != 0)
                                <th>{{ __('admin.damaged') }}</th>
                            @endif
                            @if ($returned_to_store != 0)
                                <th>{{ __('admin.returned_to_store') }}</th>
                            @endif
                        </tr>
                        <tbody>
                            <tr>
                                <td>{{ $all }}</td>
                                @if ($in_progress != 0)
                                    <td>{{ $in_progress }}</td>
                                @endif
                                @if ($delivered != 0)
                                    <td>{{ $delivered }}</td>
                                @endif
                                @if ($delayed != 0)
                                    <td>{{ $delayed }}</td>
                                @endif
                                @if ($transferred != 0)
                                    <td>{{ $transferred }}</td>
                                @endif
                                @if ($canceled != 0)
                                    <td>{{ $canceled }}</td>
                                @endif
                                @if ($damaged != 0)
                                    <td>{{ $damaged }}</td>
                                @endif
                                @if ($returned_to_store != 0)
                                    <td>{{ $returned_to_store }}</td>
                                @endif
                            </tr>

                        </tbody>
                    </table>
                @endif

                <table class="table table-bordered">
                    <tr>

                        <th>{{ __('admin.cod') }}</th>
                        <th>{{ __('admin.transfer_to_Bank') }}</th>
                        <th>{{ __('admin.transfer_to_vendor_company') }}</th>
                        @foreach ($expenses as $key => $value)
                            <th> {{ App\Models\ExpenseType::where('id', $key)->first()->name }}</th>
                        @endforeach
                        @foreach ($expenses_sim as $key => $value)
                            <th> {{ App\Models\ExpenseType::where('id', $key)->first()->name }} <span class="text-danger">شريحة</span> </th>
                        @endforeach
                        @if ($recived_shipments_count && $recived_shipments_count != 0)
                            <th>الاستلامات  <span class="text-danger">({{$recived_shipments_count}} طرد)</span></th>
                        @endif
                        <th>عمولة توصيل واستلام</th>
                        <th>{{ __('admin.cash_on_hand') }}</th>
                    </tr>
                    <tbody>
                        <tr>
                            <td>{{ $cod }} {{ __('admin.currency') }}</td>
                            <td>{{ $tr_to_bank }} {{ __('admin.currency') }}</td>
                            <td>{{ $tr_to_vendor }} {{ __('admin.currency') }}</td>

                            @foreach ($expenses as $key => $value)
                                <th> {{ $value }} {{ __('admin.currency') }}</th>
                            @endforeach
                            @foreach ($expenses_sim as $key => $value)
                                <th> {{ $value }} {{ __('admin.currency') }}</th>
                            @endforeach
                            @if ($recived_shipments_count && $recived_shipments_count != 0)
                            <td>{{$recived_shipments_prize}}</td>
                            @endif
                            <td>{{ $commissions + $recived_shipments_prize }} {{ __('admin.currency') }}</td>
                            <td>{{ $cod - $sum_expenses - $commissions - $recived_shipments_prize }} {{ __('admin.currency') }}</td>
                        </tr>
                    </tbody>
                </table>

                <hr>


            </div>
        </div>


    </div>
    @section('VendorsJS')
        <!-- Vendors JS -->
        <script src="{{ asset('build/assets/vendor/libs/select2/select2.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/tagify/tagify.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/bloodhound/bloodhound.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/moment/moment.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/jquery-timepicker/jquery-timepicker.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/pickr/pickr.js') }}"></script>



        <!-- Page JS -->
        <script src="{{ asset('build/assets/js/forms-selects.js') }}"></script>
        <script src="{{ asset('build/assets/js/forms-tagify.js') }}"></script>
        <script src="{{ asset('build/assets/js/forms-typeahead.js') }}"></script>
        <script src="{{ asset('build/assets/js/forms-pickers.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function() {
                'use strict'

                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.querySelectorAll('.needs-validation')

                // Loop over them and prevent submission
                Array.prototype.slice.call(forms)
                    .forEach(function(form) {
                        form.addEventListener('submit', function(event) {
                            if (!form.checkValidity()) {
                                event.preventDefault()
                                event.stopPropagation()
                            }

                            form.classList.add('was-validated')
                        }, false)
                    })
            })()
        </script>
    @endsection
</x-app-layout>
