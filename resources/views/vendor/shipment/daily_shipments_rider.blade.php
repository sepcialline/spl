<x-vendor-layout>

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
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    @if (isset($shipments) && count($shipments) > 0)
                    <div class="card" id="content_table">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                </div>
                                <table class="table table-striped table-bordered my-2">
                                    <thead>
                                        <tr>
                                            <th width='1%'>#</th>
                                            <th>{{ __('admin.shipments_delivered_Date') }}</th>
                                            <th>{{ __('admin.shipment_no') }}/<br>{{ __('admin.shipment_refrence') }}</th>
                                            <th>{{ __('admin.client') }}</th>
                                            <th>{{ __('admin.shipments_client_address') }}</th>
                                            <th>{{ __('admin.vendors_companies') }}</th>
                                            <th>{{ __('admin.payment_method') }}</th>
                                            <th>{{ __('admin.status') }}</th>
                                            {{-- <th>{{ __('admin.actions') }}</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1; @endphp
                                        @foreach ($shipments as $tracking)
                                            <tr>
                                                {{-- <input type="hidden" id="id" value="{{ $shipment->id }}"> --}}
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $tracking->shipment->delivered_date ?? '' }}</td>
                                                <td>{{ $tracking->shipment->shipment_no ?? '' }} <br>
                                                    #{{ $tracking->shipment->shipment_refrence ?? '' }}</td>
                                                <td>{{ $tracking->shipment->Client->name ?? '' }} <br>
                                                    {{ $tracking->shipment->Client?->mobile ?? '' }}</td>
                                                <td>{{ $tracking->shipment->Client?->emirate->name ?? '' }} <br>
                                                    {{ $tracking->shipment->Client?->city->name ?? '' }} <br>
                                                    {{ $tracking->shipment->Client?->address ?? '' }}</td>
                                                <td>{{ $tracking->shipment->Company->name ?? '' }}</td>
                                                <td>{{ $tracking->shipment->paymentMethod->name ?? '' }} | <br>
                                                    {{ $tracking->shipment->feesType->name ?? '' }}
                                                </td>
                                                <td><span
                                                        class="{{ $tracking->shipment->Status->html_code }}">{{ $tracking->shipment->Status->name }}</span>
                                                </td>
                                                {{-- <td>
                                                    @include('includes.shipment_action_dropdown', [
                                                        'shipment' => $tracking->shipment,
                                                    ])
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- {{ $shipments->appends(Request()->all())->links() }} --}}
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
                    @if ($all != 0)
                    <table class="table table-bordered">
                        <tr>
                            <th>{{ __('admin.all') }}</th>
                            @if($in_progress != 0)<th>{{ __('admin.in_progress') }}</th>@endif
                            @if($delivered != 0)<th>{{ __('admin.delivered') }}</th>@endif
                            @if($delayed != 0 )<th>{{ __('admin.delayed') }}</th>@endif
                            @if($transferred != 0)<th>{{ __('admin.transferred') }}</th>@endif
                            @if($canceled != 0)<th>{{ __('admin.canceled') }}</th>@endif
                            @if($damaged != 0)<th>{{ __('admin.damaged') }}</th>@endif
                            @if($returned_to_store != 0)<th>{{ __('admin.returned_to_store') }}</th>@endif
                        </tr>
                        <tbody>
                            <tr>
                                <td>{{$all}}</td>
                                @if($in_progress != 0)<td>{{$in_progress}}</td>@endif
                                @if($delivered != 0)<td>{{$delivered}}</td>@endif
                                @if($delayed != 0 )<td>{{$delayed}}</td>@endif
                                @if($transferred != 0)<td>{{$transferred}}</td>@endif
                                @if($canceled != 0)<td>{{$canceled}}</td>@endif
                                @if($damaged != 0)<td>{{$damaged}}</td>@endif
                                @if($returned_to_store != 0)<td>{{$returned_to_store}}</td>@endif
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
                            <th>{{__('admin.cash_on_hand')}}</th>
                            <th>{{__('admin.commission')}}</th>
                        </tr>
                        <tbody>
                            <tr>
                                <td>{{$cod}} {{__('admin.currency')}}</td>
                                <td>{{$tr_to_bank}} {{__('admin.currency')}}</td>
                                <td>{{$tr_to_vendor}} {{__('admin.currency')}}</td>

                                @foreach ($expenses as $key => $value)
                                    <th> {{ $value }} {{__('admin.currency')}}</th>
                                @endforeach
                                <td>{{ $cod - $sum_expenses}} {{ __('admin.currency') }}</td>
                                <td>{{ $commissions }} {{ __('admin.currency') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <hr>


                </div>

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
</x-vendor-layout>
