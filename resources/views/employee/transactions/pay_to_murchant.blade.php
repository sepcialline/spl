<x-employee-layout>

    @section('title')
        {{ __('admin.transactions') }} | {{ __('admin.transactions_pay_to_merchant') }}
    @endsection

    @section('VendorsCss')
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/select2/select2.css') }}" />
    @endsection
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">{{ __('admin.transactions') }} / </span>
            {{ __('admin.transactions_pay_to_merchant') }}
        </h4>

        <div class="card">
            <div class="card-body">
                <form action="">
                    <div class="row">
                        <div class="col-md mb-4">
                            <label for="select2Multiple" class="form-label">{{ __('admin.vendors_companies') }}</label>
                            <select id="select2Multiple2" class="select2 form-select" name="company_id">
                                <option value="">
                                    {{ __('admin.please_select') }}</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}"
                                        {{ request()->company_id == $vendor->id ? 'selected' : '' }}>
                                        {{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md col-12 mb-4">
                            <label for="dateRangePicker" class="form-label">{{ __('admin.date') }}</label>
                            <div class="input-group input-daterange" id="bs-datepicker-daterange">
                                <span class="input-group-text">{{ __('admin.from') }}</span>
                                <input type="date" name="date_from" id="dateRangePicker" placeholder="MM/DD/YYYY"
                                    class="form-control" value="{{ \Carbon\Carbon::parse($from)->format('Y-m-d') }}" />
                                <span class="input-group-text">{{ __('admin.to') }}</span>
                                <input type="date" name="date_to" placeholder="MM/DD/YYYY" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($to)->format('Y-m-d') }}" />
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-3 mb-0">

                            <button name="action" value="search_action" type="submit"
                                class="btn btn-label-facebook">{{ __('admin.send') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('total') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $sum }} {{ __('admin.currency') }}</td>
                </tr>
            </tbody>
        </table>
        @if (isset($shipments) && count($shipments) > 0)

            <div class="card my-3" id="table_collect">
                <div class="card-body">

                    <table class="table">
                        <thead>
                            <th><input type="checkbox" id='selectall' class="select-checkbox"></th>
                            <th>{{ __('admin.shipments_shipment_details') }}</th>
                            <th>{{ __('admin.payment_number') }}</th>
                            <th>{{ __('admin.due') }}</th>
                        </thead>
                        <tbody>
                            @foreach ($shipments as $shipment)
                                <tr>
                                    <td><input type="checkbox" name="payments[]" value="{{ $shipment->id }}"
                                            class="select-checkbox check"></td>
                                    <td>{{ $shipment->shipment_no }} <br>
                                        #{{ $shipment->shipment_refrence }} <br>
                                        {{ $shipment->Company->name }} <br>
                                        {{$shipment->paymentMethod->name}} | {{$shipment->feesType->name}}
                                    </td>
                                    <td>
                                        @foreach ($shipment->payments as $payment)
                                            {{ $payment->payment_number }} | {{ $payment->paymentMethod->name }} : {{$payment->amount}} <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if ($shipment->is_split_payment == 0)
                                            {{ $shipment->vendor_due }} <br>
                                        @else
                                            @php $to_vendor = 0 @endphp
                                            @foreach ($shipment->payments as $payment)
                                                @php if($vendor_amount = App\Models\Payment::where('shipment_id', $shipment->id)->where('payment_method_id',3)->first()){
                                                    $to_vendor = $vendor_amount->amount;
                                                }
                                                @endphp
                                                @php $amount = $shipment->vendor_due - $to_vendor  @endphp
                                            @endforeach
                                            {{ $amount }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $sum }} {{ __('admin.currency') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="p-2">
                        <button id="collect" class="btn btn-primary">{{ __('admin.collect') }}</button>
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

        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>

        <script>
            $('#selectall').change(function() {
                if ($(this).prop('checked')) {
                    $('input').prop('checked', true);
                } else {
                    $('input').prop('checked', false);
                }
            });
            $('#selectall').trigger('change');
        </script>

        <script>
            $(document).on('click', '#collect', function() {
                var payments = new Array();
                var removeItem = 'on';

                $('input:checked').each(function() { // or listview id
                    payments.push($(this).val()); // instead of .attr("value")
                });

                payments = jQuery.grep(payments, function(value) {
                    return value != removeItem;
                });

                $.ajax({
                    method: 'POST',
                    url: "{{ route('employee.transactions_pay_to_the_merchant') }}",
                    data: {
                        payments: payments
                    },
                    success: function(res) {
                        console.log(res);
                        Swal.fire({
                            title: "Are you sure?",
                            text: "You won't be able to revert this!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes, delete it!"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                if (res.code == 200) {
                                    Swal.fire({
                                        title: "{{ __('admin.collect') }}",
                                        text: "{{ __('admin.are_you_sure?') }}",
                                        icon: "success"
                                    });
                                }
                                location.reload();
                            }
                        });


                    }
                })


            });
        </script>
    @endsection
</x-employee-layout>
