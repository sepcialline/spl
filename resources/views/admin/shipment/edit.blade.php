<x-app-layout>

    @section('title')
        {{ __('admin.shipments') }} | {{ __('admin.shipments_edit_shipment') }}
    @endsection

    @section('VendorsCss')
        <!-- Vendors CSS -->
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/flatpickr/flatpickr.css') }}" />

        <!-- Page CSS -->

        <link rel="stylesheet" href="{{ asset('build/assets/vendor/css/pages/app-invoice.css') }}" />

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection

    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">{{ __('admin.shipments') }} / </span>
            {{ __('admin.shipments_edit_shipment') }}
        </h4>
        <form action="{{ route('admin.shipments_update') }}" method="POST" class="row g-3 needs-validation" novalidate>
            @csrf
            <input type="hidden" value="{{ $shipment->id }}" name='shipment_id' id='shipment_id'>

            @if ($shipment->status_id == 3)
                <fieldset disabled="disabled">
            @endif
            <div class="row invoice-add">
                <!-- Invoice Add-->
                <div class="col-md-9 col-sm-12">
                    <div class="card invoice-preview-card">
                        <div class="card-body">
                            <div class="row p-sm-3 p-0">
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
                                            <span
                                                class="h4 text-capitalize mb-0 text-nowrap">{{ __('admin.shipment_refrence') }}
                                                #<span>
                                        </dt>
                                        <dd class="col-sm-6 d-flex justify-content-md-end">
                                            <div class="w-px-150">
                                                <input type="text"
                                                    class="form-control @error('shipment_refrence') is-invalid  @enderror"
                                                    name="shipment_refrence" placeholder="1234"
                                                    value="{{ $shipment->shipment_refrence }}"
                                                    id="shipment_refrence" />
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
                                                <input type="text" class="form-control date-picker"
                                                    name="created_date"
                                                    value="{{ \Carbon\Carbon::parse($shipment->created_date) }}"
                                                    placeholder="YYYY-MM-DD" disabled />
                                            </div>
                                        </dd>
                                        <dt class="col-sm-6 mb-2 mb-sm-0 text-md-end">
                                            <span class="fw-normal">{{ __('admin.shipments_delivered_Date') }}</span>
                                        </dt>
                                        <dd class="col-sm-6 d-flex justify-content-md-end">
                                            <div class="w-px-150">
                                                <input type="text" class="form-control date-picker"
                                                    name="delivered_date"
                                                    value="{{ \Carbon\Carbon::parse($shipment->delivered_date) }}"
                                                    placeholder="YYYY-MM-DD" />
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>

                            <hr class="my-2 mx-n4" />
                            {{-- /////////////////   Client Details    //////////// --}}
                            <div class="row p-sm-3 p-0">
                                <div class="col-md-12 col-sm-12 col-12 mb-sm-0 mb-4">

                                    <h5 class="">{{ __('admin.shipments_client_details') }}</h5>

                                    <div class="row">
                                        <div class="mb-3 col">
                                            <label class="form-label"
                                                for="client_email">{{ __('admin.shipments_client_phone') }}</label>
                                            <div class="input-group">
                                                {{-- <span class="input-group-text" id="basic-addon1">971</span> --}}
                                                <input type="number" id="client_phone" name="client_phone"
                                                    value="{{ $user->mobile }}" maxlength = "12"
                                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                    class="form-control @error('client_phone')
is-invalid
@enderror"
                                                    required placeholder="9715xxxxxxxx" aria-label="" />
                                                <div class="invalid-feedback">{{ __('admin.this_field_is_required') }}
                                                    @error('client_phone')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                        <div class="mb-3 col">
                                            <label class="form-label"
                                                for="client_name">{{ __('admin.shipments_client_name') }}</label>
                                            <input type="text" class="form-control" id="client_name"
                                                name="client_name" placeholder="" value="{{ $user->name }}"
                                                required />
                                            <div class="invalid-feedback">{{ __('admin.this_field_is_required') }}
                                            </div>
                                            @error('client_name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col">
                                            <label class="form-label"
                                                for="client_email">{{ __('admin.shipments_client_email') }} /
                                                {{ __('admin.another_number') }}</label>
                                            <input type="text" id="client_email" name="client_email"
                                                value="{{ $user->email }}"
                                                class="form-control @error('client_email') is-invalid @enderror"
                                                placeholder="" aria-label="" />
                                            @error('client_email')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="mb-3 col">
                                            <label class="form-label"
                                                for="client_name">{{ __('admin.shipments_client_emirate') }}</label>
                                            <select
                                                class="js-example-basic-single form-select @error('client_emirate_id') is-invalid @enderror"
                                                name="client_emirate_id" id="client_emirate_id" required>

                                                @foreach ($emirates as $emirate)
                                                    <option value="{{ $emirate->id }}"
                                                        {{ $shipment->delivered_emirate_id == $emirate->id ? 'selected' : '' }}>
                                                        {{ $emirate->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">{{ __('admin.this_field_is_required') }}
                                            </div>
                                            @error('client_emirate_id')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col">
                                            <label class="form-label"
                                                for="client_name">{{ __('admin.shipments_client_city') }}</label>
                                            <select
                                                class="js-example-basic-single form-select @error('client_city_id') is-invalid @enderror"
                                                name="client_city_id" required id="client_city_id">

                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}"
                                                        {{ $city->id == $shipment->delivered_city_id ? 'selected' : '' }}>
                                                        {{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">{{ __('admin.this_field_is_required') }}
                                            </div>
                                            @error('client_city_id')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col mb-3">
                                            <label class="form-label"
                                                for="client_name">{{ __('admin.shipments_client_address') }}</label>
                                            <input type="text" id="client_address" name='client_address'
                                                value="{{ $shipment->delivered_address }}"
                                                class="form-control @error('client_address') is-invalid @enderror"
                                                required placeholder="" aria-label="" />
                                            <div class="invalid-feedback">{{ __('admin.this_field_is_required') }}
                                                @error('client_address')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <hr class="mx-n4" />
                            {{-- /////////////////   Shipment Details       //////////// --}}
                            <div class="row p-sm-3 p-0">
                                <div class="col-md-12 col-sm-12 col-12 mb-sm-0 mb-4">

                                    <h5 class="">{{ __('admin.shipments_shipment_details') }}</h5>

                                    <div class="row">
                                        <div class="mb-3 col">
                                            <label class="form-label"
                                                for="client_name">{{ __('admin.shipments_company_name') }}</label>
                                            <select
                                                class="js-example-basic-single form-select @error('company_id') is-invalid @enderror"
                                                name="company_id" id="company_id" required>
                                                @foreach ($companies as $company)
                                                    <option value="{{ $company->id }}"
                                                        {{ $shipment->company_id == $company->id ? 'selected' : '' }}>
                                                        {{ $company->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">{{ __('admin.this_field_is_required') }}
                                            </div>
                                            @error('company_id')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col mb-3">
                                            <div class="mb-3 col">
                                                <label class="form-label"
                                                    for="client_name">{{ __('admin.payment_method') }}</label>
                                                <select
                                                    class="js-example-basic-single form-select @error('payment_method_id') is-invalid @enderror"
                                                    name="payment_method_id" required>
                                                    @foreach ($payment_methods as $payment_method)
                                                        <option value="{{ $payment_method->id }}"
                                                            {{ $shipment->payment_method_id == $payment_method->id ? 'selected' : '' }}>
                                                            {{ $payment_method->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{ __('admin.this_field_is_required') }}
                                                </div>
                                                @error('payment_method_id')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col mb-3">
                                            <div class="mb-3 col">
                                                <label class="form-label"
                                                    for="client_name">{{ __('admin.fees_type') }}</label>
                                                <select
                                                    class="js-example-basic-single form-select @error('fees_type_id') is-invalid @enderror"
                                                    name="fees_type_id" id="fees_type_id" required>
                                                    @foreach ($fees_types as $fees_type)
                                                        <option value="{{ $fees_type->id }}"
                                                            {{ $shipment->fees_type_id == $fees_type->id ? 'selected' : '' }}>
                                                            {{ $fees_type->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{ __('admin.this_field_is_required') }}
                                                </div>
                                                @error('fees_type_id')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col mb-3">
                                            <label class="form-label"
                                                for="client_name">{{ __('admin.shipment_amount') }}</label>
                                            <div class="input-group mb-3">
                                                <input type="number" id="shipment_amount" name='shipment_amount'
                                                    value="{{ $shipment->shipment_amount }}"
                                                    class="form-control @error('shipment_amount') is-invalid @enderror"
                                                    required placeholder="" aria-label="" />
                                                <label class="input-group-text"
                                                    for="inputGroupSelect02">{{ __('admin.currency') }}</label>

                                            </div>
                                            <div class="invalid-feedback">{{ __('admin.this_field_is_required') }}
                                                @error('shipment_amount')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col mb-3">
                                            <label class="form-label"
                                                for="client_name">{{ __('admin.delivery_fees') }}</label>
                                            <div class="input-group mb-3">
                                                <input type="number" id="delivery_fees" name='delivery_fees'
                                                    value="{{ $shipment->delivery_fees }}"
                                                    class="form-control @error('delivery_fees') is-invalid @enderror"
                                                    required placeholder="" aria-label="" />
                                                <label class="input-group-text"
                                                    for="inputGroupSelect02">{{ __('admin.currency') }}</label>

                                            </div>
                                            <div class="invalid-feedback">{{ __('admin.this_field_is_required') }}
                                                @error('delivery_fees')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col mb-3">
                                            <label class="form-label"
                                                for="client_name">{{ __('admin.delivery_extra_fees') }}</label>
                                            <div class="input-group mb-3">
                                                <input type="number" id="delivery_extra_fees"
                                                    value="{{ $shipment->delivery_extra_fees }}"
                                                    name='delivery_extra_fees'
                                                    class="form-control @error('delivery_extra_fees') is-invalid @enderror"
                                                    required placeholder="" aria-label="" />
                                                <label class="input-group-text"
                                                    for="inputGroupSelect02">{{ __('admin.currency') }}</label>

                                            </div>
                                            <div class="invalid-feedback">{{ __('admin.this_field_is_required') }}
                                                @error('delivery_extra_fees')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="mb-3 col">
                                            <label class="form-label"
                                                for="client_name">{{ __('admin.branch_created') }}</label>
                                            <select
                                                class="js-example-basic-single form-select @error('branch_created_id') is-invalid @enderror"
                                                name="branch_created_id" id="branch_created_id" required>
                                                @foreach ($branches as $branche)
                                                    <option value="{{ $branche->id }}"
                                                        {{ $shipment->branch_created == $branche->id ? 'selected' : '' }}>
                                                        {{ $branche->branch_name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                {{ __('admin.this_field_is_required') }}
                                            </div>
                                            @error('branch_created_id')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col">
                                            <label class="form-label"
                                                for="client_name">{{ __('admin.branch_destination') }}</label>
                                            <select
                                                class="js-example-basic-single form-select @error('branch_destination_id') is-invalid @enderror"
                                                name="branch_destination_id" required>

                                                @foreach ($branches as $branche)
                                                    <option value="{{ $branche->id }}"
                                                        {{ $shipment->branch_destination == $branche->id ? 'selected' : '' }}>
                                                        {{ $branche->branch_name }}</option>
                                                @endforeach


                                            </select>
                                            <div class="invalid-feedback">
                                                {{ __('admin.this_field_is_required') }}
                                            </div>
                                            @error('branch_destination_id')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="note"
                                            class="form-label fw-semibold">{{ __('admin.shipment_notes') }}</label>
                                        <textarea class="form-control" name="shipment_notes" rows="2" id="shipment_notes" placeholder="">{{ $shipment->shipment_notes }}</textarea>
                                    </div>
                                </div>
                                <div class="col {{ $has_stock == 0 ? 'd-block' : 'd-none' }}"
                                    id="shipment_content_text_div">
                                    <div class="mb-3">
                                        <label for="note"
                                            class="form-label fw-semibold">{{ __('admin.shipment_content_text') }}</label>
                                        @if ($has_stock == 0)
                                            <textarea class="form-control" name="content_text" rows="2" id="content_text" placeholder="">{{ $shipment_content->content_text ?? '' }}</textarea>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="mb-3 col">
                                    <h4>{{ __('admin.is_external_order') }}</h4>
                                    <label class="switch switch-primary">
                                        <input type="checkbox" class="switch-input is_external_order" data-url=""
                                            name="is_external_order" id="is_external_order"
                                            {{ $shipment->is_external_order == 1 ? 'checked' : '' }} />
                                        <span class="switch-toggle-slider" style="width: 150px">
                                            <span class="switch-on">
                                                <h5>{{ __('admin.external') }}</h5>
                                                {{-- <i class="bx bx-check"></i> --}}
                                            </span>
                                            <span class="switch-off">
                                                {{-- <i class="bx bx-x"></i> --}}
                                                <h5>{{ __('admin.internal') }}</h5>
                                            </span>
                                        </span>
                                        {{-- <span class="switch-label">Primary</span> --}}
                                    </label>
                                </div>
                                <div class="mb-3 col">
                                    <h4>{{ __('admin.Including_vat') }}</h4>
                                    <label class="switch switch-primary">
                                        <input type="checkbox" class="switch-input Including_vat" data-url=""
                                            name="Including_vat" id="Including_vat" readonly
                                            {{ $shipment->including_vat == 1 ? 'checked' : '' }} />
                                        <span class="switch-toggle-slider" style="width: 150px">
                                            <span class="switch-on">
                                                <h5>{{ __('admin.Including_vat') }}</h5>
                                            </span>
                                            <span class="switch-off">
                                                <h5>{{ __('admin.vat_not_included') }}</h5>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <hr class="mx-n4" />

                            {{-- Shipment Contents  --}}
                            <div class="row py-2 mx-2{{ $has_stock == 1 ? 'd-block' : 'd-none' }}"
                                id="shipment_Content_div">
                                <h5 class="">{{ __('admin.shipments_shipment_Content') }}</h5>

                                <div class="row">


                                    <div class="mb-3 col">
                                        <label class="form-label"
                                            for="client_name">{{ __('admin.shipment_product') }}</label>
                                        <br>

                                        <select class="js-example-basic-single form-select" name=""
                                            id="shipment_product">

                                            @if ($has_stock == 1)
                                                <option value="" disabled selected>
                                                    {{ __('admin.please_select') }}</option>
                                                @foreach ($shipment_company->products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select><br>
                                        <span class='text-danger' id="vendor_products_warning"></span>

                                    </div>

                                    <div class="mb-3 col">
                                        <label for="in_stock"
                                            class="form-control-label">{{ __('admin.in_stock') }}</label>
                                        <input type="text" disabled class="form-control" id="in_stock">
                                    </div>


                                    <div class="mb-3 col">
                                        <label for="qty"
                                            class="form-control-label">{{ __('admin.quantity') }}</label>
                                        <input type="number" class="form-control" id="qty" min="0">
                                        <span class="text-danger" id="qty_warning"></span>
                                    </div>

                                    <div class="col">
                                        <a href="javascript:void(0)" class="btn btn-label-facebook mt-2"
                                            id="add_item">{{ __('admin.add_product') }}</a>
                                    </div>
                                </div>
                                <div id="content_table">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('admin.shipment_product') }}</th>
                                                <th>{{ __('admin.quantity') }}</th>
                                                <th>{{ __('admin.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="products_table">
                                            @if ($has_stock == 1)
                                                @foreach ($shipment_content as $content)
                                                    <tr>
                                                        <input type="hidden" id="product_id"
                                                            value="{{ $content->id }}">
                                                        <td>{{ $content->product->name ?? '' }}</td>
                                                        <td>{{ $content->quantity ?? '' }}</td>
                                                        <td>
                                                            <a
                                                                class="btn btn-label-danger btn-sm return_product">{{ __('admin.return_product_to_stock') }}</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Invoice Add-->

                <!-- Invoice Actions -->
                <div class="col-md-3 col-sm-12 invoice-actions">
                    <div class="card mb-4">
                        <div class="card-body">
                            <button type="submit" name="action" value="just_save"
                                class="btn btn-label-secondary d-grid w-100">{{ __('admin.just_save') }}</button>
                            {{-- <button class="btn btn-primary d-grid w-100 mb-3" data-bs-toggle="offcanvas"
                                data-bs-target="#sendInvoiceOffcanvas">
                                <span class="d-flex align-items-center justify-content-center text-nowrap"><i
                                        class="bx bx-paper-plane bx-xs me-1"></i>{{ __('admin.save_and_send_invoice') }}</span>
                            </button>
                            <button name ="action" type="submit" value="save_and_print_invoice"
                                class="btn btn-label-secondary d-grid w-100 mb-3">{{ __('admin.save_and_print_invoice') }}</a> --}}
                        </div>
                    </div>

                </div>
                <!-- /Invoice Actions -->
            </div>

            <!-- Offcanvas -->
            <!-- Send Invoice Sidebar -->
            <div class="offcanvas offcanvas-end" id="sendInvoiceOffcanvas" aria-hidden="true">
                <div class="offcanvas-header border-bottom">
                    <h6 class="offcanvas-title">Send Invoice</h6>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body flex-grow-1">
                    <form>
                        <div class="mb-3">
                            <label for="invoice-from" class="form-label">From</label>
                            <input type="text" class="form-control" id="invoice-from"
                                value="shelbyComapny@email.com" placeholder="company@email.com" />
                        </div>
                        <div class="mb-3">
                            <label for="invoice-to" class="form-label">To</label>
                            <input type="text" class="form-control" id="invoice-to"
                                value="qConsolidated@email.com" placeholder="company@email.com" />
                        </div>
                        <div class="mb-3">
                            <label for="invoice-subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="invoice-subject"
                                value="Invoice of purchased Admin Templates" placeholder="Invoice regarding goods" />
                        </div>
                        <div class="mb-3">
                            <label for="invoice-message" class="form-label">Message</label>
                            <textarea class="form-control" name="invoice-message" id="invoice-message" cols="3" rows="8">
             Dear Queen Consolidated,
                Thank you for your business, always a pleasure to work with you!
                We have generated a new invoice in the amount of $95.59
                We would appreciate payment of this invoice by 05/11/2021</textarea>
                        </div>
                        <div class="mb-4">
                            <span class="badge bg-label-primary">
                                <i class="bx bx-link bx-xs"></i>
                                <span class="align-middle">Invoice Attached</span>
                            </span>
                        </div>
                        <div class="mb-3 d-flex flex-wrap">
                            <button type="submit" name="action" value="save_and_send_invoice"
                                class="btn btn-primary me-3" data-bs-dismiss="offcanvas">Send</button>
                            <button type="button" class="btn btn-label-secondary"
                                data-bs-dismiss="offcanvas">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Send Invoice Sidebar -->

            <!-- /Offcanvas -->
    </div>
    <!-- / Content -->
    @if ($shipment->status_id == 3)
        </fieldset>
    @endif
    </form>

    @section('VendorsJS')
        <!-- Vendors JS -->
        <script src="{{ asset('build/assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/cleavejs/cleave.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>


        <!-- Page JS -->
        <script src="{{ asset('build/assets/js/offcanvas-send-invoice.js') }}"></script>
        <script src="{{ asset('build/assets/js/app-invoice-add.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function() {
                $('.js-example-basic-single').select2({
                    width: 370
                });
            });
            $(document).on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
            });
        </script>

        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        <script>
            $(document).on('change', '#company_id', function() {
                var locale = '{{ config('app.locale') }}';
                var company_id = $(this).val();
                var fees_type_id = $('#fees_type_id').val();
                $('#shipment_Content_div').addClass('d-none');
                $('#shipment_content_text_div').addClass('d-none');
                $.ajax({
                    method: "get",
                    url: "{{ route('admin.shipment_company_has_stock') }}",
                    data: {
                        company_id: company_id,
                        fees_type_id: fees_type_id
                    },
                    success: function(res) {
                        console.log(res)
                        $('#delivery_fees').val(res.vendor_rate);
                        if (res.code == 200) {
                            // show stock sectioon content
                            $('#shipment_Content_div').removeClass('d-none');
                            console.log(res);
                            if (res.data.length > 0) {
                                $('#shipment_product').empty()
                                $('#shipment_product').append(
                                    "<option selected disabled > select product </option>");
                                $.each(res.data, function(key, value) {
                                    if (locale === "en") {
                                        $('#shipment_product').append("<option value=" +
                                            value.id +
                                            ">" + value.name.en + "</option>")
                                    } else {
                                        $('#shipment_product').append("<option value=" +
                                            value.id +
                                            ">" + value.name.ar + "</option>")
                                    }

                                    console.log(value);
                                });
                            } else {
                                $('#shipment_product').empty();
                            }
                        } else {
                            //show text content
                            $('#shipment_content_text_div').removeClass('d-none');
                        }
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });
            });
        </script>

        <script>
            $(document).on('change', '#fees_type_id', function() {
                var locale = '{{ config('app.locale') }}';
                var company_id = $('#company_id').val();

                var fees_type_id = $(this).val();

                console.log('company_id :' + company_id + ' payment_method_id : ' + fees_type_id)

                $.ajax({
                    method: "get",
                    url: "{{ route('admin.shipment_company_has_stock') }}",
                    data: {
                        company_id: company_id,
                        fees_type_id: fees_type_id
                    },
                    success: function(res) {
                        console.log(res)
                        $('#delivery_fees').val(res.vendor_rate);
                        if (res.code == 200) {}
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });
            });
        </script>

        <script>
            $(document).on('change', '#branch_created_id', function() {
                var locale = '{{ config('app.locale') }}';
                var id = $('#company_id').val();
                $('#shipment_Content_div').addClass('d-none');
                $('#shipment_content_text_div').addClass('d-none');
                $.ajax({
                    "type": "POST",
                    "url": "{{ route('admin.shipment_company_has_stock') }}",
                    "data": {
                        'id': id
                    },
                    success: function(res) {

                        if (res.code == 200) {
                            // show stock sectioon content
                            $('#shipment_Content_div').removeClass('d-none');
                            console.log(res);
                            if (res.data.length > 0) {
                                $('#shipment_product').empty()
                                $('#shipment_product').append(
                                    "<option selected disabled > select product </option>");
                                $.each(res.data, function(key, value) {
                                    if (locale === "en") {
                                        $('#shipment_product').append("<option value=" + value.id +
                                            ">" + value.name.en + "</option>")
                                    } else {
                                        $('#shipment_product').append("<option value=" + value.id +
                                            ">" + value.name.ar + "</option>")
                                    }

                                    console.log(value);
                                });
                            } else {
                                $('#shipment_product').empty();
                            }
                        } else {
                            //show text content
                            $('#shipment_content_text_div').removeClass('d-none');
                        }
                    },
                    error: function(error) {

                    }
                })
            });
        </script>


        <script>
            $(document).on('change', '#shipment_product', function() {
                $('#vendor_products_warning').empty();
                $('#qty').val(0)
                var product_id = $(this).val();
                var branch_created_id = $('#branch_created_id').val();
                $.ajax({
                    url: "{{ route('admin.shipment_prodcut_details') }}",
                    type: "GET",
                    data: {
                        product_id: product_id,
                        branch_created_id: branch_created_id
                    },
                    success: function(res) {
                        console.log(res)
                        if (res.code == 200) {
                            $('#in_stock').val(res.data)
                        } else {
                            $('#in_stock').val(0)
                        }
                    }
                })
            });
        </script>

        <script>
            var $i = 0;
            $(document).on('click', '#add_item', function() {
                $('#qty_warning').empty();
                $('#vendor_products_warning').empty();

                var product = $('#shipment_product').val();
                var product_name = $('#shipment_product option:selected').text();
                var qty = $('#qty').val();
                var in_stock = $('#in_stock').val();

                console.log(product_name);
                if (!product) {
                    $('#vendor_products_warning').text("{{ __('admin.this_field_is_required') }}")
                } else {
                    if (!qty) {
                        $('#qty_warning').text("{{ __('admin.this_field_is_required') }}")
                    } else {
                        if (parseInt(qty) > parseInt(in_stock) || parseInt(qty) == 0) {
                            $('#qty_warning').text(
                                "{{ __('admin.The_quantity_entered_is_greater_than_what_is_in_the_stock') }}")
                        } else {
                            $i++;
                            $('#products_table').append(`<tr data-tr='` + $i + `'>
                        <td>
                            <input type='hidden' class='form-control' id='product_id' value=` + product + ` name='product_ids[]'>
                            <input type='hidden' class='form-control' value=` + qty + ` name='qtys[]'>
                            <input type='text' class='form-control' disabled value=` + product_name + `>
                            </td>
                        <td><input type='number' class='form-control' id='disabled_qty' readonly value=` + qty + ` name=''></td>
                        <td><a href='javascript:void(0)'  class='btn btn-danger btn-sm delete_tr' data-delete='` + $i + `'>delete<td/>
                            </tr>`);
                            $('#in_stock').val(in_stock - qty)
                        }
                    }
                }

            })
        </script>


        <script>
            $(document).on('click', '.delete_tr', function() {
                // var disable_qty = 0;
                // $(this).closest('tr').find("input#disabled_qty").each(function() {
                //     var in_stock =  $('#in_stock').val();
                //     var quantitiy = this.value
                //     $('#in_stock').val(parseInt(in_stock)  + parseInt(quantitiy)) ;
                // });
                $(this).closest('tr').remove();
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

        <script>
            $(document).on('click', '.return_product', function() {
                var id = $(this).closest('tr').find("#product_id").val();
                var branch_id = {{ $shipment->branch_created }};
                Swal.fire({
                    title: "{{ __('admin.msg_are_you_sure_for_delete') }}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "{{ __('admin.yes') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'get',
                            url: "{{ route('admin.return_product_to_stock') }}",
                            data: {
                                id: id,
                                branch_id: branch_id
                            },
                            success: function(res) {
                                console.log(res);
                                if (res.code == 200) {
                                    Swal.fire({
                                        title: "{{ __('admin.delete') }}",
                                        text: "{{ __('admin.msg_success_delete') }}",
                                        icon: "success"
                                    });
                                    $("#content_table").load(location.href + " #content_table");
                                }
                            }
                        });


                    }
                });
            });
        </script>

        {{-- <script>
            $(document).on('focusout', '#client_phone', function() {
                var mobile = $(this).val();
                $.ajax({
                    method: "GET",
                    url: "{{ route('admin.getShipmentClient') }}",
                    data: {
                        mobile: mobile
                    },
                    success: function(res) {

                        if (res.code == 200) {
                            $('#client_name').val(res.user.name.ar);
                            $('#client_email').val(res.user.email);
                            $("#client_emirate_id option[value=" + res.user.emirate_id + "]").attr(
                                'selected', true).change();
                            $("#client_city_id option[value=" + res.user.city_id + "]").attr('selected',
                                true).change();
                            $('#client_address').val(res.user.address);
                        } else {
                            $('#client_name').val('');
                            $('#client_email').val('');
                            $("#client_emirate_id option[value='']").attr('selected', true).change();
                            $("#client_city_id option[value='']").attr('selected', true).change();
                        }
                    }
                });
            });
        </script> --}}

        {{-- <script>
            $(document).on('select2:open', e => {
                const select2 = $(e.target).data('select2');
                if (!select2.options.get('multiple')) {
                    select2.dropdown.$search.get(0).focus();
                }
            });
        </script> --}}
    @endsection

</x-app-layout>
