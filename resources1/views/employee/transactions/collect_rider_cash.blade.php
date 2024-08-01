<x-employee-layout>

    @section('title')
        {{ __('admin.transactions') }} | {{ __('admin.collect_rider_cash') }}
    @endsection

    @section('VendorsCss')
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/select2/select2.css') }}" />
    @endsection
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">{{ __('admin.transactions') }} / </span>
            {{ __('admin.collect_rider_cash') }}
        </h4>

        <div class="card">
            <div class="card-body">
                <form action="">
                    <div class="row">
                        <div class="col-md mb-4">
                            <label for="select2Multiple"
                                class="form-label">{{ __('admin.user_management_rider_list') }}</label>
                            <select id="select2Multiple2" class="select2 form-select" name="rider_id">
                                <option value="">
                                    {{ __('admin.please_select') }}</option>
                                @foreach ($riders as $rider)
                                    <option value="{{ $rider->id }}"
                                        {{ request()->rider_id == $rider->id ? 'selected' : '' }}>
                                        {{ $rider->name }}</option>
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
        @if (isset($payments) && count($payments) > 0)

            <div class="card my-3" id="table_collect">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $cod }} {{ __('admin.currency') }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <table class="table">
                        <thead>
                            <th><input type="checkbox" id='selectall' class="select-checkbox"></th>
                            <th>{{ __('admin.shipments_shipment_details') }}</th>
                            <th>{{ __('admin.payment_number') }}</th>
                            <th>{{ __('admin.amount') }}</th>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                {{-- @foreach ($shipment->payments as $payment) --}}
                                <tr>
                                    <td><input type="checkbox" name="payments[]" value="{{ $payment->id }}"
                                            class="select-checkbox check"></td>
                                    <td>{{ $payment->shipment->shipment_no }} <br>
                                        #{{ $payment->shipment->shipment_refrence }} <br>
                                        {{ $payment->shipment->Company->name }}
                                    </td>
                                    <td>{{ $payment->payment_number }}</td>
                                    <td>{{ $payment->amount }}</td>
                                </tr>
                                {{-- @endforeach --}}
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
                                <td>{{ $cod }} {{ __('admin.currency') }}</td>
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


                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "{{ __('admin.yes') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('employee.transactions_collect_rider_cash') }}",
                            data: {
                                payments: payments
                            },
                            success: function(res) {
                                console.log(res);
                                if (res.code == 200) {
                                    Swal.fire({
                                        title: "{{ __('admin.collect') }}",
                                        text: "{{ __('admin.are_you_sure?') }}",
                                        icon: "success"
                                    });
                                }
                                location.reload();
                            }
                        })
                    }
                });
            });
        </script>
    @endsection
</x-employee-layout>
