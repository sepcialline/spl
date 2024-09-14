<x-app-layout>
    @section('title')
        {{ __('admin.shipments') }} | {{ __('admin.actions') }}
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

    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row invoice-preview">
            <!-- Invoice -->
            <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-4">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-md-0 mb-4">
                                <div class="d-flex svg-illustration mb-4 gap-2">
                                    <img src="{{ asset('build/assets/img/logo/logo_' . LaravelLocalization::getCurrentLocale() . '.png') }}"
                                        width="50%" alt="">
                                    <span class="app-brand-text h3 mb-0 fw-bold"></span>
                                </div>
                                <p class="mb-1">{{ __('admin._company_address_') }}</p>
                            </div>
                            <div class="col-md-6">
                                <dl class="row mb-2">
                                    <dt class="col-sm-6 mb-2 mb-sm-0 text-md-end">
                                        <span class="fw-normal">{{ __('admin.shipment_refrence') }}
                                            #<span>
                                    </dt>
                                    <dd class="col-sm-6 d-flex justify-content-md-end">
                                        <div class="w-px-150">
                                            {{ $shipment->shipment_refrence }}
                                            <div class="invalid-feedback">{{ __('admin.this_field_is_required') }}
                                            </div>
                                            @error('shipment_refrence')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                    </dd>
                                    <dt class="col-sm-6 mb-2 mb-sm-0 text-md-end">
                                        <span class="fw-normal">{{ __('admin.shipments_created_Date') }}</span>
                                    </dt>
                                    <dd class="col-sm-6 d-flex justify-content-md-end">
                                        <div class="w-px-150">
                                            {{ \Carbon\Carbon::parse($shipment->created_date)->format('Y-m-d') }}
                                        </div>
                                    </dd>
                                    <dt class="col-sm-6 mb-2 mb-sm-0 text-md-end">
                                        <span class="fw-normal">{{ __('admin.shipments_delivered_Date') }}</span>
                                    </dt>
                                    <dd class="col-sm-6 d-flex justify-content-md-end">
                                        <div class="w-px-150">
                                            {{ \Carbon\Carbon::parse($shipment->delivered_date)->format('Y-m-d') }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>

                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                        <div class="row p-sm-3 p-0">
                            <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
                                <h6 class="pb-2">{{ __('admin.shipments_client_details') }}</h6>
                                <p class="mb-1">{{ $shipment->Client->name ?? '' }}</p>
                                <p class="mb-1">{{ $shipment->Client->mobile ?? '' }}</p>
                                <p class="mb-1">{{ $shipment->Client?->email ?? '' }}</p>
                                <p class="mb-1">{{ $shipment->delivered_address ?? '' }}</p>
                                <p class="mb-1">{{ $shipment->city->name ?? '' }}</p>
                                <p class="mb-1">{{ $shipment->emirate->name ?? '' }}</p>

                            </div>
                            <div class="col-xl-6 col-md-12 col-sm-7 col-12">
                                <h6 class="pb-2">{{ __('admin.shipments_shipment_details') }}</h6>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="pe-3">{{ __('admin.vendors_company') }}:</td>
                                            <td>{{ $shipment->Company->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-3">{{ __('admin.shipment_amount') }}:</td>
                                            <td>{{ $shipment->shipment_amount }} {{ __('admin.currency') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-3">{{ __('admin.delivery_fees') }}:</td>
                                            <td>{{ $shipment->delivery_fees }} {{ __('admin.currency') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-3">{{ __('admin.delivery_extra_fees') }}:</td>
                                            <td>{{ $shipment->delivery_extra_fees }} {{ __('admin.currency') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-3">{{ __('admin.payment_method') }}:</td>
                                            <td>{{ $shipment->paymentMethod->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-3">{{ __('admin.fees_type') }}:</td>
                                            <td>{{ $shipment->feesType->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-3">{{ __('admin.note:') }}:</td>
                                            <td>{{ $shipment->shipment_notes }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                    <div class="table-responsive">
                        <table class="table border-top m-0">
                            <thead>
                                @if ($has_stock == 1 && count($shipment_content) > 0)
                                    @if (count($shipment_content) > 0)
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('admin.item') }}</th>
                                            <th>{{ __('admin.quantity') }}</th>
                                        </tr>
                                    @endif
                                @else
                                    <tr>
                                        <th>{{ __('admin.shipment_content_text') }}</th>
                                    </tr>
                                @endif
                            </thead>
                            <tbody>
                                @if ($has_stock == 1 && count($shipment_content) > 0)
                                    @php $i = 1; @endphp
                                    @if (count($shipment_content) > 0)
                                        @foreach ($shipment_content as $content)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $content->product->name ?? '' }}</td>
                                                <td>{{ $content->quantity ?? '' }}</td>

                                            </tr>
                                        @endforeach
                                    @endif
                                @else
                                    <tr>
                                        <td>{{ $shipment_content->content_text ?? '' }}</td>
                                    </tr>
                                @endif
                            </tbody>

                        </table>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <span class="fw-semibold">{{ __('admin.note:') }}</span>
                                <span>{{ __('admin.it_was_a_pleasure_working_with_you_we_hope_you_will_keep_us_in_mind_for_future_shipments._thank_you!') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Invoice -->

            <!-- Invoice Actions -->
            <div class="col-xl-3 col-md-4 col-12 invoice-actions">
                <div class="card">
                    <div class="card-body">
                        @can('admin-Shipment-assign rider')
                            <button class="btn btn-primary d-grid w-100 mb-3" data-bs-toggle="offcanvas"
                                data-bs-target="#assign_to_rider">
                                <span class="d-flex align-items-center justify-content-center text-nowrap"><i
                                        class="bx bx-car bx-xs me-1"></i>{{ __('admin.assign_to_rider') }}</span>
                            </button>
                        @endcan
                        @can('admin-Shipment-print')
                            <a class="btn btn-label-secondary d-grid w-100 mb-3" target="_blank"
                                href="{{ route('admin.shipment_print_invoice', ['id' => $shipment->id]) }}">
                                {{ __('admin.print_invoice') }} & {{ __('admin.download_pdf') }}</a>
                        @endcan

                        @can('admin-Shipment-edit')
                            <a href="{{ route('admin.shipments_edit', ['id' => $shipment->id]) }}"
                                class="btn btn-label-secondary d-grid w-100 mb-3">
                                <span class="d-flex align-items-center justify-content-center text-nowrap"> <i
                                        class="bx bx-edit bx-xs me-1"></i>{{ __('admin.edit') }}</span>
                            </a>
                        @endcan

                        @can('admin-Shipment-print')
                            <a href="{{ route('admin.shipment_print_sticker', ['id' => $shipment->id]) }}"
                                class="btn btn-label-secondary d-grid w-100 mb-3" target="_blank">
                                <span class="d-flex align-items-center justify-content-center text-nowrap"> <i
                                        class="bx bx-printer bx-xs me-1"></i>{{ __('admin.print_qr') }}</span>
                            </a>
                        @endcan
                        @can('admin-Shipment-change-status')
                            <button class="btn btn-primary d-grid w-100" data-bs-toggle="offcanvas"
                                data-bs-target="#change_status">
                                <span class="d-flex align-items-center justify-content-center text-nowrap"><i
                                        class="bx bx-stats bx-xs me-1"></i>{{ __('admin.change_status') }}</span>
                            </button>
                        @endcan
                    </div>
                </div>
                <a class="btn btn-label-danger my-2"
                    href="{{ route('admin.shipments_index') }}">{{ __('admin.back') }}</a>
            </div>
            <!-- /Invoice Actions -->
        </div>

        <div class="card my-2">
            <h3 class="p-4">{{ __('admin.tracking') }}</h3>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('admin.status') }}</th>
                                    <th>{{ __('admin.user') }}</th>
                                    <th>{{ __('admin.action') }}</th>
                                    <th>{{ __('admin.rider') }}</th>
                                    <th>created_at</th>
                                    <th>#{{ __('admin.date') }}</th>
                                    <th>{{ __('admin.note:') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trackings as $tracking)
                                    <tr>
                                        <td>{{ $tracking->status->name }}</td>
                                        <td>
                                            @if ($tracking->guard == 'admin')
                                                {{ App\Models\Admin::where('id', $tracking->user_id)->first()->name }}
                                            @endif
                                            @if ($tracking->guard == 'rider')
                                                {{ App\Models\Rider::where('id', $tracking->user_id)->first()->name }}
                                            @endif
                                            @if ($tracking->guard == 'employee')
                                                {{ App\Models\Employee::where('id', $tracking->user_id)->first()->name }}
                                            @endif
                                        </td>
                                        <td>{{ $tracking->action }}</td>
                                        <td>{{ $tracking->Rider->name ?? '-' }}</td>
                                        <td>{{ $tracking->created_at }}</td>
                                        <td>{{ $tracking->time }}</td>
                                        <td>{{ $tracking->notes }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <!-- Offcanvas -->
        <!-- Send Invoice Sidebar -->
        <div class="offcanvas offcanvas-end" id="assign_to_rider" aria-hidden="true">
            <div class="offcanvas-header border-bottom">
                <h6 class="offcanvas-title">{{ __('admin.assign_to_rider') }}</h6>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form action="{{ route('admin.shipment_assign_rider') }}" method="post" id="actions"
                    enctype="multipart/form-data" class="row g-3 needs-validation">
                    @csrf
                    <div class="mb-3">
                        <label for="invoice-from" class="form-label">{{ __('admin.current_rider') }}</label>
                        <h5>{{ $shipment->Rider->name ?? __('admin.un_assigned') }}</h5>
                    </div>
                    <input type="hidden" name="id" value="{{ $shipment->id }}">
                    <div class="mb-3">
                        <label for="invoice-to" class="form-label">{{ __('admin.assigned_to') }}</label>
                        <select id="select2Multiple1" class="select2 form-select" name="rider_id" required>
                            <option value="">{{ __('admin.please_select') }}</option>
                            @foreach ($riders as $rider)
                                <option value="{{ $rider->id }}">{{ $rider->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3 d-flex flex-wrap">
                        <button type="submit" class="btn btn-primary me-3">{{ __('admin.send') }}</button>
                        <button type="button" class="btn btn-label-secondary"
                            data-bs-dismiss="offcanvas">{{ __('admin.close') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /Send Invoice Sidebar -->


        {{-- change status offcanvas --}}
        <div class="offcanvas offcanvas-end" id="change_status" aria-hidden="true">
            <div class="offcanvas-header border-bottom">
                <h6 class="offcanvas-title">{{ __('admin.change_status') }}</h6>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form action="{{ route('admin.shipments_change_status') }}" method="post"
                    enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="invoice-from" class="form-label">{{ __('admin.current_status') }}</label>
                        <h5 class="{{ $shipment->Status->html_code }}">{{ $shipment->Status->name }}</h5>
                    </div>
                    <input type="hidden" name="id" value="{{ $shipment->id }}">
                    <div class="mb-3">
                        <label for="invoice-to" class="form-label">{{ __('admin.status') }}</label>
                        <select id="select2Multiple1 " class="select2 form-select change_status_id" name="status_id"
                            required>
                            <option value="">{{ __('admin.please_select') }}</option>
                            @foreach ($change_statuss as $status)
                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    @include('includes.shipments_actions.new')
                    @include('includes.shipments_actions.in_progress')
                    @include('includes.shipments_actions.delayed')
                    @include('includes.shipments_actions.transfered')
                    @include('includes.shipments_actions.delivered', ['shipment' => $shipment])
                    @include('includes.shipments_actions.returned')
                    <div class="mb-3">
                        <label for="invoice-to" class="form-label">{{ __('admin.note:') }}</label>
                        <textarea name="notes" id="notes" class="form-control" cols="10" rows="5"></textarea>
                    </div>
                    <div class="mb-3 d-flex flex-wrap">
                        <button type="submit" class="btn btn-primary me-3">{{ __('admin.send') }}</button>
                        <button type="button" class="btn btn-label-secondary"
                            data-bs-dismiss="offcanvas">{{ __('admin.close') }}</button>
                    </div>
                </form>
            </div>
        </div>
        {{-- change status offcanvas --}}


        <!-- /Offcanvas -->
    </div>
    <!-- / Content -->



    @section('VendorsJS')
        <script>
            $(document).ready(function() {
                $(document).on('submit', 'form', function() {
                    $('button').attr('disabled', 'disabled');
                });
            });
        </script>
        <script>
            $(document).on('change', '.change_status_id', function() {
                var id = $(this).val();
                $('#new').addClass('d-none');
                $('#in_progress').addClass('d-none');
                $('#delivered').addClass('d-none');
                $('#delayed').addClass('d-none');
                $('#transfer').addClass('d-none');


                $('#rider_id').prop('required', false);
                $('#branch_id').prop('required', false);
                $('#delivered_amount').prop('required', false)
                $('#delivered_date').prop('required', false);
                $('#notes').prop('required', false);
                $('#client_emirate_id').prop('required', false);
                $('#client_city_id').prop('required', false);
                $('#client_address').prop('required', false);
                $('#img').prop('required', false);
                $('#branch_created_id').prop('required', false);
                $('#returned').addClass('d-none');
                $('#fees_amount').prop('required', false);
                $('#fess_branch_id').prop('required', false);
                $('#branch_destination_id').prop('required', false);
                $('#payment_method').prop('required', false);





                if (id == 2) {
                    $('#in_progress').removeClass('d-none');
                    $('#rider_id').prop('required', true);
                }
                if (id == 3) {
                    $('#delivered').removeClass('d-none');
                    $('#payment_method').prop('required', true);
                    $('#branch_id').prop('required', true);

                }
                if (id == 4) {
                    $('#delayed').removeClass('d-none');
                    $('#delivered_date').prop('required', true);
                    $('#notes').prop('required', true);
                }
                if (id == 5) {
                    $('#transfer').removeClass('d-none');
                    $('#client_emirate_id').prop('required', true);
                    $('#client_city_id').prop('required', true);
                    $('#client_address').prop('required', true);
                }
                if (id == 6) {

                    $('#notes').prop('required', true);
                }

                if (id == 9) {
                    $('#returned').removeClass('d-none');
                    $('#fees_amount').prop('required', true);
                    $('#fess_branch_id').prop('required', true);

                }

                if (id == 10) {

                    $('#new').removeClass('d-none');
                    $('#branch_created_id').prop('required', true);
                    $('#branch_destination_id').prop('required', true);
                }



            });
        </script>
        <script>
            $(document).on('change', '#client_emirate_id', function() {
                var locale = '{{ config('app.locale') }}';
                $.ajax({
                    type: 'GET',
                    url: "{{ route('admin.shipment_get_cities') }}",
                    data: {
                        emirate_id: $(this).val()
                    },
                    success: function(res) {
                        $('#client_city_id').empty();
                        $.each(res, function(key, value) {
                            if (locale === "en") {
                                $('#client_city_id').append("<option value=" + value.id + ">" +
                                    value.name.en + "</option>");
                            } else {
                                $('#client_city_id').append("<option value=" + value.id + ">" +
                                    value.name.ar + "</option>");
                            }
                        });
                    }
                })
            });
        </script>
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
        <script>
            $(document).on('change', '#payment_method', function() {

                $('#delivered_amount').val('');
                $('#transferred_amount').val('');
                $('#img').prop('src', '')


                $('#cash_payment').addClass('d-none');
                $('#transfer_payment').addClass('d-none');
                $('#cash_payment').addClass('d-none');
                $('#image').addClass('d-none');

                $('#delivered_amount').prop('required', false);
                $('#transferred_amount').prop('required', false);
                $('#img').prop('required', false)

                if ($(this).val() == 1) { //cash
                    $('#cash_payment').removeClass('d-none');
                    $('#delivered_amount').prop('required', true)
                    $('#delivered_amount').val({{ $shipment->rider_should_recive }})
                }
                if ($(this).val() == 2 || $(this).val() == 3) { //transfer to SDL or Vendor
                    $('#image').removeClass('d-none');
                    $('#transfer_payment').removeClass('d-none');
                    $('#transferred_amount').prop('required', true)
                    $('#transferred_amount').val({{ $shipment->rider_should_recive }})
                    $('#img').prop('required', true)
                }

                if ($(this).val() == 0) { // split
                    $('#image').removeClass('d-none');
                    $('#transfer_payment').removeClass('d-none');
                    $('#cash_payment').removeClass('d-none');
                    $('#transferred_amount').prop('required', true)
                    $('#delivered_amount').prop('required', true)
                    $('#img').prop('required', true)
                }

            });
        </script>
        <!-- Vendors JS -->
        <script src="{{ asset('build/assets/vendor/libs/select2/select2.js') }}"></script>


        <!-- Page JS -->
        <script src="{{ asset('build/assets/js/forms-selects.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endsection
</x-app-layout>
