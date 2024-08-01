<x-app-layout>

    @section('title')
        {{ __('admin.shipments') }} | {{ __('admin.assign_shipments_to_rider') }}
    @endsection

    @section('VendorsCss')
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/select2/select2.css') }}" />

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">{{ __('admin.shipments') }} / </span>
            {{ __('admin.assign_shipments_to_rider') }}
        </h4>

        @if (isset($shipments) && count($shipments) > 0)
            <div class="card my-3" id="table_collect">
                <div class="card-body">
                    <table class="table table">
                        <thead>
                            <thead>
                                <tr>
                                    <th width='1%'><input type="checkbox" id='selectall' class="select-checkbox">
                                    </th>
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

                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach ($shipments as $shipment)
                                <tr>
                                    <td>{{ $i++ }}<input type="checkbox" name="payments[]"
                                            value="{{ $shipment->id }}" class="select-checkbox check"></td>
                                    <td>{{ $shipment->delivered_date ?? '' }}</td>
                                    <td>{{ $shipment->shipment_no ?? '' }} <br>
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
                                    {{-- <td>
                                        @include('includes.shipment_action_dropdown', [
                                            'shipment' => $shipment,
                                        ])
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr>
                    <div class="form-group">
                        <label for="">{{ __('admin.rider') }}</label>
                        <select name="rider_id" id="rider_id" class="form-control js-example-basic-single">
                            <option value="">{{ __('admin.please_select') }}</option>
                            @foreach ($riders as $rider)
                                <option value="{{ $rider->id }}">{{ $rider->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group my-2">
                        <a id="assign" class="btn btn-primary">{{__('admin.assign_shipments_to_rider')}}</a>
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
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            $(document).on('click', '#assign', function() {
                var rider_id = $('#rider_id').val();
                var shipments = new Array();
                var removeItem = 'on';

                $('input:checked').each(function() { // or listview id
                    shipments.push($(this).val()); // instead of .attr("value")
                });

                shipments = jQuery.grep(shipments, function(value) {
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
                            url: "{{ route('admin.assignShipments') }}",
                            data: {
                                shipments: shipments,
                                rider_id : rider_id
                            },
                            success: function(res) {
                                console.log(res);
                                if (res.code == 200) {
                                    Swal.fire({
                                        title: "{{ __('admin.assigned') }}",
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
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });
        </script>

    @endsection
</x-app-layout>
