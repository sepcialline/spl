<x-employee-layout>

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

        @if (count($errors) > 0)
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            @foreach ($errors->all() as $error)
                                <li><span class="text-danger"> {{ $error }}</span></li>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        @endif

        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">{{ __('admin.shipments') }} / </span>
            {{ __('admin.shipments_shipments_list') }}
        </h4>

        <div class="card">
            <div class="card-body">
                <form action="">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <label for="select2Multiple" class="form-label">{{ __('admin.company_list') }}</label>
                            <select id="select2Multiple1" class="select2 form-select" name="company_id">
                                <option value="0" {{ request()->company_id == 0 ? 'selected' : '' }}>
                                    {{ __('admin.all') }}</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}"
                                        {{ request()->company_id == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-4">
                            <label for="select2Multiple"
                                class="form-label">{{ __('admin.user_management_rider_list') }}</label>
                            <select id="select2Multiple2" class="select2 form-select" name="rider_id">
                                <option value="0" {{ request()->rider_id == 0 ? 'selected' : '' }}>
                                    {{ __('admin.all') }}</option>
                                @foreach ($riders as $rider)
                                    <option value="{{ $rider->id }}"
                                        {{ request()->rider_id == $rider->id ? 'selected' : '' }}>
                                        {{ $rider->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-4">
                            <label for="select2Multiple"
                                class="form-label">{{ __('admin.payment_method_list') }}</label>
                            <select id="select2Multiple3" class="select2 form-select" name="payment_method_id">
                                <option value="0" {{ request()->payment_method_id == 0 ? 'selected' : '' }}>
                                    {{ __('admin.all') }}</option>
                                @foreach ($payment_methods as $payment_method)
                                    <option value="{{ $payment_method->id }}"
                                        {{ request()->payment_method == $payment_method->id ? 'selected' : '' }}>
                                        {{ $payment_method->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-4">
                            <label for="select2Multiple" class="form-label">{{ __('admin.status') }}</label>
                            <select id="select2Multiple4" class="select2 form-select" name="status_id">
                                <option value="0" {{ request()->status_id == 0 ? 'selected' : '' }}>
                                    {{ __('admin.all') }}</option>
                                @foreach ($shipment_status as $status)
                                    <option value="{{ $status->id }}"
                                        {{ request()->status_id == $status->id ? 'selected' : '' }}>
                                        {{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <label for="select2Multiple" class="form-label">{{ __('admin.emirates') }}</label>
                            <select id="select2Multiple5" class="select2 form-select" name="emirate_id">
                                <option value="0" {{ request()->emirate_id == 0 ? 'selected' : '' }}>
                                    {{ __('admin.all') }}</option>
                                @foreach ($emirates as $emirate)
                                    <option value="{{ $emirate->id }}"
                                        {{ request()->emirate_id == $emirate->id ? 'selected' : '' }}>
                                        {{ $emirate->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-4">
                            <label for="select2Multiple" class="form-label">{{ __('admin.city_city_list') }}</label>
                            <select id="select2Multiple6" class="select2 form-select" name="city_id">
                                <option value="0" {{ request()->city_id == 0 ? 'selected' : '' }}>
                                    {{ __('admin.all') }}</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}"
                                        {{ request()->city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="branch_created"
                            value="{{ Auth::guard('employee')->user()->branch_id }}">
                        <input type="hidden" name="branch_destination" value="0">
                        <div class="col-md-3 mb-4">
                            <label for="select2Multiple" class="form-label">{{ __('admin.branch_created') }}</label>
                            <input type="text" class="form-control" disabled
                                value="{{ Auth::guard('employee')->user()->branch->branch_name }}">
                            <input type="hidden" name="branch_created"
                                value="{{ Auth::guard('employee')->user()->branch->id }}">
                        </div>
                        <div class="col-md-3 mb-4">
                            <label for="select2Multiple"
                                class="form-label">{{ __('admin.branch_destination') }}</label>
                            <select id="select2Multiple7" class="select2 form-select" name="branch_destination">
                                <option value="0" {{ request()->branch_destination == 0 ? 'selected' : '' }}>
                                    {{ __('admin.all') }}</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}"
                                        {{ request()->branch_destination == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->branch_name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-6 col-12 mb-4">
                            <label for="dateRangePicker" class="form-label">{{ __('admin.date') }}</label>
                            <div class="input-group input-daterange" id="bs-datepicker-daterange">
                                <span class="input-group-text">{{ __('admin.from') }}</span>
                                <input type="date" name="date_from" id="dateRangePicker" placeholder="MM/DD/YYYY"
                                    class="form-control"
                                    value="{{ \Carbon\Carbon::parse($from)->format('Y-m-d') }}" />
                                <span class="input-group-text">{{ __('admin.to') }}</span>
                                <input type="date" name="date_to" placeholder="MM/DD/YYYY" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($to)->format('Y-m-d') }}" />
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <label for="select2Multiple" class="form-label">{{ __('admin.search_text') }}</label>
                            <input id="select2Multiple6" value="{{ request()->search }}" class="form-control"
                                name="search">
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
            <div class="row px-4 py-1">
                <div class="col-md-4">
                    <a href="{{ route('employee.shipment.downloadfile') }}" class="btn btn-label-danger"><i
                            class='bx bx-download'></i></a>
                    @include('employee.shipment.includes.import_admin_excel')
                </div>
                <div class="col-md-8"></div>

            </div>
        </div>
        <hr>
        @if (isset($shipments) && count($shipments) > 0)
            <div class="card" id="content_table">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 table-responsive">
                            <table class="table table-striped table-bordered my-2">
                                <thead>
                                    <tr>
                                        <th width='1%'>#</th>
                                        <th>{{ __('admin.shipments_delivered_Date') }}</th>
                                        <th>{{ __('admin.shipment_no') }}/<br>{{ __('admin.shipment_refrence') }}</th>
                                        <th>{{ __('admin.rider') }}</th>
                                        <th>{{ __('admin.client') }}</th>
                                        <th>{{ __('admin.shipments_client_address') }}</th>
                                        <th>{{ __('admin.vendors_companies') }}</th>
                                        <th>{{ __('admin.payment_method') }}</th>
                                        <th>{{ __('admin.status') }}</th>
                                        <th>{{ __('admin.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach ($shipments as $shipment)
                                        <tr>
                                            <input type="hidden" id="id" value="{{ $shipment->id }}">
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $shipment->delivered_date ?? '' }}</td>
                                            <td>{{ $shipment->shipment_no ?? '' }} <br>
                                                #{{ $shipment->shipment_refrence ?? '' }}</td>
                                            <td>{{ $shipment->Rider->name ?? 'لا يوجد' }}</td>
                                            <td>{{ $shipment->Client->name ?? '' }} <br>
                                                {{ $shipment->Client?->mobile ?? '' }}</td>
                                            <td>{{ $shipment->emirate->name ?? '' }} <br>
                                                {{ $shipment->city->name ?? '' }} <br>
                                                {{ $shipment->delivered_address ?? '' }}</td>
                                            <td>{{ $shipment->Company->name ?? '' }}</td>
                                            <td>{{ $shipment->paymentMethod->name ?? '' }} <br>
                                                @if (count($shipment->payments) > 0)
                                                    <ul class="list-group-item">
                                                        @foreach ($shipment->payments as $payment)
                                                            <li class="item">
                                                                <span class="text-danger" style="font-size: 10px">
                                                                    {{ $payment->paymentMethod->name }}
                                                                    ({{ $payment->amount }}
                                                                    {{ __('admin.currency') }})</span><br>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </td>
                                            <td><span
                                                    class="{{ $shipment->Status->html_code }}">{{ $shipment->Status->name }}</span>
                                            </td>
                                            <td>
                                                @include('includes.shipment_action_dropdown_employee', [
                                                    'shipment' => $shipment,
                                                ])
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $shipments->appends(Request()->all())->links() }}
                        <strong> {{ __('admin.total') }} {{ $shipments->total() }}
                            {{ __('admin.shipments') }}</strong>
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

        <script>
            $(document).on('click', '#delete_shipment', function() {
                var id = $(this).closest('tr').find('#id').val();
                Swal.fire({
                    title: "{{ __('admin.msg_are_you_sure_for_delete') }}",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "{{ __('admin.yes') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: 'GET',
                            url: "{{ route('employee.shipments_delete') }}",
                            data: {
                                id: id
                            },
                            success: function(res) {
                                console.log(res);
                                if (res.code == 200) {
                                    Swal.fire({
                                        title: "{{ __('admin.deleted') }}",
                                        text: "{{ __('admin.msg_success_delete') }}",
                                        icon: "success"
                                    });
                                    $("#content_table").load(location.href + " #content_table");
                                }

                            }

                        })

                    }
                });
            });
        </script>
        <script>
            function submitForm() {
                document.getElementById("clk").disabled = true;
            }
        </script>
    @endsection
</x-employee-layout>
