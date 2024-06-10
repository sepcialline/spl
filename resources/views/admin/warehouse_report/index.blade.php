<x-app-layout>

    @section('title')
        {{ __('admin.warehouse') }} | {{ __('admin.warehouse_report') }}
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
            <span class="text-muted fw-light">{{ __('admin.warehouse') }} / </span>
            {{ __('admin.warehouse_report') }}
        </h4>

        <div class="card">
            <div class="card-body">
                <form action="">
                    <div class="row">
                        <div class="col-md-4 mb-4">
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
                        <div class="col-md-4 mb-4">
                            <label for="select2Multiple"
                                class="form-label">{{ __('admin.warehouse_transfer_branch') }}</label>
                            <select id="select2Multiple8" class="select2 form-select" name="branch_id">
                                <option value="0" {{ request()->branch_created == 0 ? 'selected' : '' }}>
                                    {{ __('admin.all') }}</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}"
                                        {{ request()->branch_created == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->branch_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="select2Multiple"
                                class="form-label">{{ __('admin.warehouse_products') }}</label>
                            <select id="select2Multiple8" class="select2 form-select" name="product_id">
                                <option value="0" {{ request()->product_id == 0 ? 'selected' : '' }}>
                                    {{ __('admin.all') }}</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ request()->product_id == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>


                    </div>
                    <div class="row">

                        {{-- <div class="col-md-8 mb-4">
                            <label for="select2Multiple" class="form-label">{{ __('admin.search_text') }}</label>
                            <input id="select2Multiple6" value="{{ request()->search }}" class="form-control"
                                name="search">
                        </div> --}}
                        <div class="col-md-4 col-12 mb-4">
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
                                class="btn btn-label-facebook">{{ __('admin.search') }}</button>

                            <button name="action" value="report" type="submit"
                                class="btn btn-label-facebook">{{ __('admin.products_export') }}</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <hr>

        @if (isset($query) && count($query) > 0)
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
                                    <th>{{ __('admin.products_product_company') }}</th>
                                    <th>{{ __('admin.warehouse_transfer_product') }}</th>
                                    <th>{{ __('admin.warehouse_transfer_branch') }}</th>
                                    <th>{{ __('admin.warehouse_transfer_quantity') }}</th>
                                    <th>{{ __('admin.date') }}</th>
                                    <th>{{ __('admin.operation') }}</th>
                                    <th>{{ __('admin.added_by') }}</th>
                                    <th> code</th>
                                    <th>{{ __('admin.note:') }}</th>
                                    {{-- <th>{{ __('admin.status') }}</th>
                                    <th>{{ __('admin.actions') }}</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($query as $item)
                                    <tr>
                                        <input type="hidden" id="id" value="{{ $item->id }}">
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $item->company->name ?? '' }}</td>
                                        <td>{{ $item->product->name ?? '' }}</td>
                                        <td>{{ $item->branch->branch_name ?? '' }}</td>
                                        <td>{{ $item->quantity ?? '' }}</td>
                                        <td>{{ $item->date ?? '' }}</td>
                                        <td>{{ $item->operation->name ?? '' }}</td>
                                        <td>{{ $item->user->name ?? '' }}</td>
                                        <td>{{ $item->dispatch_ref_no ?? '' }}</td>
                                        <td>{{ $item->notes ?? '' }}</td>
                                        {{-- <td>{{ $shipment->shipment_no ?? '' }} <br>
                                            #{{ $shipment->shipment_refrence ?? '' }}</td>
                                        <td>{{ $shipment->Client->name ?? '' }} <br>
                                            {{ $shipment->Client?->mobile ?? '' }}</td>
                                        <td>{{ $shipment->Client?->emirate->name ?? '' }} <br>
                                            {{ $shipment->Client?->city->name ?? '' }} <br>
                                            {{ $shipment->Client?->address ?? '' }}</td>
                                        <td>{{ $shipment->Company->name ?? '' }}</td>
                                        <td>{{ $shipment->paymentMethod->name ?? '' }}</td>
                                        <td><span
                                                class="{{ $shipment->Status->html_code }}">{{ $shipment->Status->name }}</span>
                                        </td>
                                        <td>
                                            @include('includes.shipment_action_dropdown', [
                                                'shipment',
                                                $shipment,
                                            ])

                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $query->appends(Request::all())->links() }}
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
</x-app-layout>
