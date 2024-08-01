<x-vendor-layout>

    @section('title')
        {{ __('admin.reports') }} | {{ __('admin.payments') }}
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
            <span class="text-muted fw-light">{{ __('admin.reports') }} / </span>
            {{ __('admin.payments') }}
        </h4>

        <div class="card">
            <div class="card-body">
                <form action="" target="_blanck">
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
                    <input type="hidden" name="branch_created" value="{{Auth::guard('employee')->user()->branch_id}}">
                    <div class="row">
                        {{-- <div class="col-md-3 mb-4">
                            <label for="select2Multiple" class="form-label">{{ __('admin.branch_created') }}</label>
                            <select id="select2Multiple8" class="select2 form-select" name="branch_created">
                                <option value="0" {{ request()->branch_created == 0 ? 'selected' : '' }}>
                                    {{ __('admin.all') }}</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}"
                                        {{ request()->branch_created == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->branch_name }}</option>
                                @endforeach
                            </select>
                        </div> --}}

                        <div class="col-md-6 col-12 mb-4">
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
                        {{-- <div class="col-md-3 mb-4">
                            <label for="select2Multiple" class="form-label">{{ __('admin.search_text') }}</label>
                            <input id="select2Multiple6" value="{{ request()->search }}" class="form-control"
                                name="search">
                        </div> --}}
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
        <hr>
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
                                    <th width='1%'>#</th>
                                    <th>{{ __('admin.in_branch') }}</th>
                                    <th>{{ __('admin.date') }}</th>
                                    <th>{{ __('admin.is_split') }}</th>
                                    <th>{{ __('admin.shipments_shipment_details') }}</th>
                                    <th>{{ __('admin.payment_details') }}</th>
                                    <th>{{ __('admin.vendors_company') }}</th>
                                    <th>{{ __('admin.rider') }}</th>
                                    <th>{{ __('admin.amount') }}</th>
                                    <th>{{ __('admin.amount_with') }}</th>
                                    <th>{{ __('admin.vendor_get_due') }}</th>
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
                                        <td>{{ $payment->branch->branch_name }}</td>
                                        <td>{{ $payment->date }}</td>
                                        <td>{{ $payment->is_split == 1 ? __('admin.split') : __('admin.not_split') }}
                                            <br>
                                            {{ $payment->payment_number }}</td>
                                        <td>{{ $payment->shipment->shipment_no }} <br>
                                            #{{ $payment->shipment->shipment_refrence }} <br>
                                        </td>
                                        <td>{{ $payment->paymentMethod->name }}</td>
                                        <td>{{ $payment->company->name }}</td>
                                        <td>{{ $payment->Rider->name }}</td>
                                        <td>{{ $payment->amount }}</td>
                                        @if ($payment->is_rider_has == 1)
                                            <td>{{ __('admin.rider') }} : {{ $payment->Rider->name }}</td>
                                        @elseif($payment->is_vendor_has == 1)
                                            <td>{{ __('admin.vendors_company') }} : {{ $payment->company->name }}</td>
                                        @elseif($payment->is_bank_has == 1)
                                            <td>{{ __('admin.sp_bank') }}</td>
                                        @else
                                            <td>-</td>
                                        @endif
                                        <td>{{ $payment->is_vendor_get_due == 0 ? __('admin.no') : __('admin.yes') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $payments->appends(request()->query())->links() }}
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
        <div class="card">
            <div class="card-body">
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
                            url: "{{ route('admin.shipments_delete') }}",
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
    @endsection
</x-vendor-layout>
