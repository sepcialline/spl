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
            {{ __('admin.shipments_shipments_list') }} / {{ __('admin.search') }} / {{ $search }}
        </h4>


        @if (isset($shipments) && count($shipments) > 0)
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
                                                        {{ $payment->paymentMethod->name }} ({{$payment->amount}} {{__('admin.currency')}})</span><br>
                                                </li>

                                                @endforeach
                                            </ul>

                                            @endif
                                        </td>
                                        <td><span
                                                class="{{ $shipment->Status->html_code }}">{{ $shipment->Status->name }}</span>
                                        </td>
                                        <td>
                                            @include('includes.shipment_action_dropdown_admin', [
                                                'shipment' => $shipment,
                                            ])
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $shipments->appends(Request()->all())->links() }}
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
