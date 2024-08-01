<x-employee-layout>
    @section('title')
        Dashboard
    @endsection
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="card p-4">
                <div class="d-flex justify-content-sm-between align-items-sm-center">

                    <div class="d-flex align-items-sm-center">
                        <h5 class="card-header"> {{ __('admin.products_products_list') }} </h5>
                        {{-- <span class="">
                            <a href="{{ route('admin.shopify_settings') }}"
                            class="btn btn-success btn-sm ml-2">Refresh</a>
                        </span> --}}
                    </div>

                    {{-- <div class="form-outline me-2">
                        <input type="hidden" class="_token" id="_token" value="{{ csrf_token() }}" />
                        <input type="search" id="form1" class="form-control" placeholder="Type query" aria-label="Search"
                            data-url="{{ route('admin.product_details_search') }}" />
                    </div> --}}
                    {{-- <a href="{{ route('admin.products_create') }}"
                        class="btn btn-secondary">{{ __('admin.products_products_add') }}</a> --}}

                </div>
                <div class="card-datatable table-responsive text-nowrap px-2 py-2">
                    <!-- Update Password Modal -->

                    <!--/ Update Password Modal -->
                    <table class="dt-scrollableTable table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('admin.products_product_company') }}</th>
                                <th>{{ __('admin.vendors_company') }}</th>
                                <th>{{ __('admin.products_product_name') }}</th>
                                <th>{{ __('admin.branch_branch_name') }}</th>
                                <th>{{ __('admin.warehouse_transfer_quantity') }}</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        @foreach ($data as $row)
                            @if ($row->product || $row->company)
                                <input type="hidden" class="_token" id="_token" value="{{ csrf_token() }}" />
                                <div class="modal fade" id="config_shopify" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
                                        <div class="modal-content p-3 p-md-5">
                                            <div class="modal-body">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                                <div class="text-center mb-4">
                                                    <h3 class="mb-4">Config Shopify</h3>
                                                </div>

                                                {{-- <form id="config_shopifyForm" class="row g-3 mt-3" method="POST"
                                                class=" needs-validation" novalidate
                                                action="{{ route('employee.shopify_config') }}">
                                                @csrf
                                                <input type="hidden" id="company_id" name="company_id"
                                                    value="{{ $row['id'] ?? '' }}" />
                                                <div class="col-12">
                                                    <label class="form-label" for="modalEnableOTPPhone">Store
                                                        Name</label>

                                                    <div class="input-group input-group-merge">
                                                        <input type="text" id="store_name" name="store_name"
                                                            value="{{ $row->config->store_name ?? '' }}"
                                                            class="form-control" placeholder="Store Name" />
                                                    </div>

                                                </div>

                                                <div class="col-12">
                                                    <label class="form-label" for="modalEnableOTPPhone">Access
                                                        Token</label>
                                                    <div class="input-group input-group-merge">
                                                        <input type="text" id="access_token" name="access_token"
                                                            class="form-control"
                                                            value="{{ $row->config->access_token ?? '' }}"
                                                            placeholder="Access Token" />
                                                    </div>

                                                </div>
                                                <div class="col-12 mt-2">
                                                    <button type="submit"
                                                        class="btn btn-primary me-sm-3 me-1">Submit</button>
                                                    <button type="reset" class="btn btn-label-secondary"
                                                        data-bs-dismiss="modal" aria-label="Close">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </form> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <tr>
                                    <td>{{ $row->company->name }}</td>
                                    <td>{{ $row->product->vendorCompany->name ?? '-' }}</td>
                                    <td>{{ $row->product->name ?? '-' }}</td>
                                    <td>{{ $row->branch->branch_name }}</td>
                                    <td>{{ $row['quantity'] }}</td>

                                    <td>
                                        <div class="modal fade" id="import{{ $row->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-simple modal-lg modal-dialog-centered">
                                                <div class="modal-content p-3 p-md-5">
                                                    <div class="modal-body">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                        <div class="text-center mb-4">
                                                            <h3 class="mb-4">{{ __('admin.products_import') }}</h3>
                                                        </div>

                                                        <form id="import_product" class="row g-3 mt-3 needs-validation" novalidate method="POST"
                                                            novalidate
                                                            action="{{ route('employee.product_details_store') }}">
                                                            @csrf
                                                            <div class="col-12 row">
                                                                <div class="col-12">
                                                                    <label class="form-label mt-2"
                                                                        for="product_name">{{ __('admin.products_product_name') }}</label>
                                                                    <div class="input-group input-group-merge ">
                                                                        <input type="text" id="product_id"
                                                                            name="product_id" class="form-control"
                                                                            hidden value="{{ $row->product_id }}"
                                                                            {{-- placeholder="{{ __('admin.warehouse_transfer_quantity') }}"  --}} />
                                                                        <input type="text" id="branch_id"
                                                                            name="branch_id" class="form-control" hidden
                                                                            value="{{ $row->branch_id }}"
                                                                            {{-- placeholder="{{ __('admin.warehouse_transfer_quantity') }}"  --}} />
                                                                        <input type="text" id="operation_id"
                                                                            name="operation_id" class="form-control"
                                                                            hidden value="1"
                                                                            {{-- placeholder="{{ __('admin.warehouse_transfer_quantity') }}"  --}} />
                                                                        <input type="text" id="prod_name"
                                                                            name="prod_name" class="form-control"
                                                                            readonly
                                                                            value="{{ $row->product->name ?? '' }}"
                                                                            {{-- placeholder="{{ __('admin.warehouse_transfer_quantity') }}"  --}} />
                                                                    </div>
                                                                </div>
                                                                {{-- <div class="col-12">
                                                                <label for="operation_id" class="form-label">{{ __('admin.warehouse_products') }}</label>
                                                                <select class="form-select " id="operation_id"   aria-label="Default select example" name="operation_id">

                                                                    @foreach ($operations as $operation)
                                                                        <option value={{ $operation->id }}>{{ $operation->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div> --}}
                                                                <div class="col-6">
                                                                    <label class="form-label mt-2"
                                                                        for="modalEnableOTPPhone">{{ __('admin.warehouse_transfer_current_quantity') }}</label>
                                                                    <div class="input-group input-group-merge ">
                                                                        <input type="number" readonly id="quantity"
                                                                            name="quantity" class="form-control"
                                                                            value={{ $row->quantity }}
                                                                            placeholder="{{ __('admin.warehouse_transfer_current_quantity') }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label mt-2"
                                                                        for="modalEnableOTPPhone">{{ __('admin.products_total_import') }}</label>
                                                                    <div class="input-group input-group-merge ">
                                                                        <input type="number" id="total_import_export"
                                                                            name="total_import_export"
                                                                            class="form-control" {{-- //value={{ $row->quantity }} --}}
                                                                            placeholder="{{ __('admin.products_total_import') }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label mt-2"
                                                                        for="modalEnableOTPPhone">{{ __('admin.products_dispatch_ref_no') }}</label>
                                                                    <div class="input-group input-group-merge ">
                                                                        <input type="text" id="dispatch_ref_no"
                                                                            name="dispatch_ref_no" class="form-control"
                                                                            {{-- //value={{ $row->quantity }} --}}
                                                                            placeholder="{{ __('admin.products_dispatch_ref_no') }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label mt-2"
                                                                        for="modalEnableOTPPhone">{{ __('admin.products_import_date') }}</label>
                                                                    <div class="input-group input-group-merge ">
                                                                        <input type="date" id="date_import_export"
                                                                            name="date_import_export"
                                                                            class="form-control" {{-- //value={{ $row->quantity }} --}}
                                                                            placeholder="{{ __('admin.products_import_date') }}" />
                                                                    </div>
                                                                </div>

                                                                <div class="col-12">
                                                                    <label class="form-label mt-2"
                                                                        for="notes">{{ __('admin.products_notes') }}</label>
                                                                    <textarea id="autosize-demo" rows="3" name="notes" class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <button type="submit"
                                                                    class="btn btn-primary me-sm-3 me-1">Submit</button>
                                                                <button type="reset" class="btn btn-label-secondary"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    Cancel
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="export{{ $row->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-simple modal-lg modal-dialog-centered">
                                                <div class="modal-content p-3 p-md-5">
                                                    <div class="modal-body">
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                        <div class="text-center mb-4">
                                                            <h3 class="mb-4">{{ __('admin.products_export') }}</h3>
                                                        </div>

                                                        <form id="export_product" class="row g-3 mt-3 needs-validation" novalidate method="POST"

                                                            action="{{ route('employee.product_details_store') }}">
                                                            @csrf
                                                            <div class="col-12 row">
                                                                <div class="col-12">
                                                                    <label class="form-label mt-2"
                                                                        for="product_name">{{ __('admin.products_product_name') }}</label>
                                                                    <div class="input-group input-group-merge ">
                                                                        <input type="text" id="product_id"
                                                                            name="product_id" class="form-control"
                                                                            hidden value="{{ $row->product_id }}"
                                                                            {{-- placeholder="{{ __('admin.warehouse_transfer_quantity') }}"  --}} />
                                                                        <input type="text" id="branch_id"
                                                                            name="branch_id" class="form-control"
                                                                            hidden value="{{ $row->branch_id }}"
                                                                            {{-- placeholder="{{ __('admin.warehouse_transfer_quantity') }}"  --}} />
                                                                        <input type="text" id="operation_id"
                                                                            name="operation_id" class="form-control"
                                                                            hidden value="2"
                                                                            {{-- placeholder="{{ __('admin.warehouse_transfer_quantity') }}"  --}} />
                                                                        <input type="text" id="prod_name"
                                                                            name="prod_name" class="form-control"
                                                                            readonly
                                                                            value="{{ $row->product->name ?? '-' }}"
                                                                            {{-- placeholder="{{ __('admin.warehouse_transfer_quantity') }}"  --}} />
                                                                    </div>
                                                                </div>

                                                                <div class="col-6">
                                                                    <label class="form-label mt-2"
                                                                        for="modalEnableOTPPhone">{{ __('admin.warehouse_transfer_current_quantity') }}</label>
                                                                    <div class="input-group input-group-merge ">
                                                                        <input type="number" readonly id="quantity"
                                                                            name="quantity" class="form-control"
                                                                            value={{ $row->quantity }}
                                                                            placeholder="{{ __('admin.warehouse_transfer_current_quantity') }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label mt-2"
                                                                        for="modalEnableOTPPhone">{{ __('admin.products_total_export') }}</label>
                                                                    <div class="input-group input-group-merge ">
                                                                        <input type="number" id="total_import_export"
                                                                            name="total_import_export"
                                                                            class="form-control" {{-- //value={{ $row->quantity }} --}}
                                                                            placeholder="{{ __('admin.products_total_export') }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label mt-2"
                                                                        for="modalEnableOTPPhone">{{ __('admin.products_dispatch_ref_no') }}</label>
                                                                    <div class="input-group input-group-merge ">
                                                                        <input type="text" id="dispatch_ref_no"
                                                                            name="dispatch_ref_no"
                                                                            class="form-control" {{-- //value={{ $row->quantity }} --}}
                                                                            placeholder="{{ __('admin.products_dispatch_ref_no') }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label mt-2"
                                                                        for="modalEnableOTPPhone">{{ __('admin.products_export_date') }}</label>
                                                                    <div class="input-group input-group-merge ">
                                                                        <input type="date" id="date_import_export"
                                                                            name="date_import_export"
                                                                            class="form-control" {{-- //value={{ $row->quantity }} --}}
                                                                            placeholder="{{ __('admin.products_export_date') }}" />
                                                                    </div>
                                                                </div>

                                                                <div class="col-12">
                                                                    <label class="form-label mt-2"
                                                                        for="notes">{{ __('admin.products_notes') }}</label>
                                                                    <textarea id="autosize-demo" rows="3" name="notes" class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <button type="submit"
                                                                    class="btn btn-primary me-sm-3 me-1">Submit</button>
                                                                <button type="reset" class="btn btn-label-secondary"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    Cancel
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="adjust{{ $row->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-simple modal-lg modal-dialog-centered">
                                                <div class="modal-content p-3 p-md-5">
                                                    <div class="modal-body">
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                        <div class="text-center mb-4">
                                                            <h3 class="mb-4">{{ __('admin.products_adjust') }}</h3>
                                                        </div>

                                                        <form id="import_export_product" class="row g-3 mt-3"
                                                            method="POST" novalidate
                                                            action="{{ route('employee.product_details_store') }}">
                                                            @csrf
                                                            <div class="col-12 row">
                                                                <div class="col-12">
                                                                    <label class="form-label mt-2"
                                                                        for="product_name">{{ __('admin.products_product_name') }}</label>
                                                                    <div class="input-group input-group-merge ">
                                                                        <input type="text" id="product_id"
                                                                            name="product_id" class="form-control"
                                                                            hidden value={{ $row->product_id }}
                                                                            {{-- placeholder="{{ __('admin.warehouse_transfer_quantity') }}"  --}} />
                                                                        <input type="text" id="branch_id"
                                                                            name="branch_id" class="form-control"
                                                                            hidden value="{{ $row->branch_id }}"
                                                                            {{-- placeholder="{{ __('admin.warehouse_transfer_quantity') }}"  --}} />
                                                                        <input type="text" id="operation_id"
                                                                            name="operation_id" class="form-control"
                                                                            hidden value="3"
                                                                            {{-- placeholder="{{ __('admin.warehouse_transfer_quantity') }}"  --}} />
                                                                        <input type="text" id="prod_name"
                                                                            name="prod_name" class="form-control"
                                                                            readonly
                                                                            value="{{ $row->product->name ?? '-' }}"
                                                                            {{-- placeholder="{{ __('admin.warehouse_transfer_quantity') }}"  --}} />

                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label mt-2"
                                                                        for="modalEnableOTPPhone">{{ __('admin.warehouse_transfer_current_quantity') }}</label>
                                                                    <div class="input-group input-group-merge ">
                                                                        <input type="number" readonly
                                                                            id="current_quantity"
                                                                            name="current_quantity"
                                                                            class="form-control"
                                                                            value={{ $row->quantity }}
                                                                            placeholder="{{ __('admin.warehouse_transfer_current_quantity') }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label mt-2"
                                                                        for="modalEnableOTPPhone">{{ __('admin.warehouse_transfer_quantity') }}</label>
                                                                    <div class="input-group input-group-merge ">
                                                                        <input type="number" id="quantity"
                                                                            name="quantity" class="form-control"
                                                                            {{-- //value={{ $row->quantity }} --}}
                                                                            placeholder="{{ __('admin.warehouse_transfer_quantity') }}" />
                                                                    </div>
                                                                </div>





                                                                <div class="col-12">
                                                                    <label class="form-label mt-2"
                                                                        for="notes">{{ __('admin.products_notes') }}</label>
                                                                    <textarea id="autosize-demo" rows="3" name="notes" class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <button type="submit"
                                                                    class="btn btn-primary me-sm-3 me-1">Submit</button>
                                                                <button type="reset" class="btn btn-label-secondary"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    Cancel
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="transfer{{ $row->id }}" tabindex="-1"
                                            aria-hidden="true">

                                            <div class="modal-dialog modal-simple modal-lg modal-dialog-centered">
                                                <div class="modal-content p-3 p-md-5">
                                                    <div class="modal-body">
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                        <div class="text-center mb-4">
                                                            <h3 class="mb-4">{{ __('admin.warehouse_transfer') }}
                                                            </h3>
                                                        </div>
                                                        <div class="alert alert-danger" role="alert"
                                                            {{ $row->quantity == 0 ? '' : 'hidden' }}>
                                                            {{ __('admin.warehouse_warehouse_empty') }}
                                                        </div>
                                                        <form id="import_export_product needs-validation" novalidate class="row g-3 mt-3"
                                                            method="POST"
                                                            action="{{ route('employee.transfer_product_store') }}">
                                                            @csrf

                                                            <div class="col-12 row">
                                                                <div class="col-12">
                                                                    <label class="form-label mt-2"
                                                                        for="product_name">{{ __('admin.products_product_name') }}</label>
                                                                    <div class="input-group input-group-merge ">
                                                                        <input type="text" id="product_id"
                                                                            name="product_id" class="form-control"
                                                                            hidden value={{ $row->product_id }} />
                                                                        <input type="text" id="operation_id"
                                                                            name="operation_id" class="form-control"
                                                                            hidden value="4" />
                                                                        <input type="text" id="from_branch"
                                                                            name="from_branch" class="form-control"
                                                                            hidden value="{{ $row->branch_id }}" />
                                                                        <input type="text" id="prod_name"
                                                                            name="prod_name" class="form-control"
                                                                            readonly
                                                                            value="{{ $row->product->name ?? '-' }}" />

                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label mt-2"
                                                                        for="modalEnableOTPPhone">{{ __('admin.warehouse_transfer_current_quantity') }}</label>
                                                                    <div class="input-group input-group-merge ">
                                                                        <input type="number" readonly
                                                                            id="current_quantity"
                                                                            name="current_quantity"
                                                                            class="form-control"
                                                                            value={{ $row->quantity }}
                                                                            placeholder="{{ __('admin.warehouse_transfer_current_quantity') }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label mt-2"
                                                                        for="modalEnableOTPPhone">{{ __('admin.warehouse_transfer_quantity') }}</label>
                                                                    <div class="input-group input-group-merge ">
                                                                        <input type="number" id="quantity"
                                                                            name="quantity" class="form-control"
                                                                            value="0" min="{{ 0 }}"
                                                                            max="{{ $row->quantity }}"
                                                                            {{-- //value={{ $row->quantity }} --}}
                                                                            placeholder="{{ __('admin.warehouse_transfer_quantity') }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <label for="to_branch"
                                                                        class="form-label">{{ __('admin.branch_branch_name') }}</label>
                                                                    <select class="form-select " id="to_branch"
                                                                        aria-label="Default select example"
                                                                        name="to_branch">
                                                                        @foreach ($branches as $branch)
                                                                            <option value={{ $branch->id }}>
                                                                                {{ $branch->branch_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                {{-- <div class="col-6">
                                                        <label for="warehouse_id" class="form-label">{{ __('admin.warehouse_warehouse') }}</label>
                                                        <select class="form-select " id="warehouse_id"   aria-label="Default select example" name="warehouse_id">
                                                            @foreach ($warehouses as $warehouse)
                                                                <option value={{ $warehouse->id }}>{{ $warehouse->warehouse_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div> --}}



                                                                <div class="col-12">
                                                                    <label class="form-label mt-2"
                                                                        for="notes">{{ __('admin.products_notes') }}</label>
                                                                    <textarea id="autosize-demo" rows="3" name="notes" class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <button type="submit"
                                                                    class="btn btn-primary me-sm-3 me-1"
                                                                    {{ $row->quantity == 0 ? 'disabled' : '' }}>Submit</button>
                                                                <button type="reset" class="btn btn-label-secondary"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    Cancel
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <a data-bs-toggle="modal" data-bs-target="#import{{ $row->id }}"
                                            class="btn btn-label-secondary">{{ __('admin.products_import') }}</a>
                                        <a data-bs-toggle="modal" data-bs-target="#export{{ $row->id }}"
                                            class="btn btn-label-warning">{{ __('admin.products_export') }}</a>
                                        <a data-bs-toggle="modal" data-bs-target="#adjust{{ $row->id }}"
                                            class="btn btn-label-info">{{ __('admin.products_adjust') }}</a>
                                        <a data-bs-toggle="modal" data-bs-target="#transfer{{ $row->id }}"
                                            class="btn btn-label-success">{{ __('admin.warehouse_transfer') }}</a>

                                    </td>
                                </tr>
                            @else
                            @endif
                        @endforeach

                    </table>

                </div>
                {{ $data->links() }}
            </div>
        </div>
    </div>
    @section('VendorsJS')
        {{-- sweet alert --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
        <script>
            $(document).ready(function() {

                // Delete Button
                $('.delete').on('click', function() {
                    var form = $(this).closest("form");
                    event.preventDefault();
                    var token = $('#_token').val();
                    console.log('token: ', token);
                    //sweet alert to ask user if he is sure before delete
                    Swal.fire({
                        title: 'Delete Product',
                        text: 'Do you want to continue?',
                        icon: 'warning',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: "No, cancel please!",
                        showCancelButton: true,
                        iconColor: "#DD6B55",
                        cancelButtonColor: "#fce3e1",
                        confirmButtonColor: "#DD6B55",


                    }).then((result) => {
                        if (result.isConfirmed) {
                            var deleteURL = $(this).data('url');
                            var trObj = $(this);
                            console.log(deleteURL);
                            //console.log(trObj);
                            $.ajax({

                                type: 'DELETE',
                                url: deleteURL,
                                data: {
                                    _token: token
                                },
                                dataType: "JSON",
                                success: function({
                                    data
                                }) {
                                    console.log(data);
                                    Swal.fire(
                                        'Deleted!',
                                        'Your Product has been deleted.',
                                        'success',
                                    );
                                    location.reload();
                                }
                            });

                        }
                    });
                });
            })
        </script>
        <!-- Vendors JS -->
        <script src="{{ asset('build/assets/vendor/libs/cleavejs/cleave.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/moment/moment.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/select2/select2.js') }}"></script>

        <!-- Main JS -->
        <script src="{{ asset('build/assets/js/main.js') }}"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
            integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
            crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
            integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
            crossorigin="anonymous" />
        {{-- sweet alert --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
        {{-- search table --}}
        <script>
            $('#form1').keyup(function(event) {

                if (event.target.value.length >= 3) {
                    console.log('changed');
                    var searchURL = $(this).data('url');
                    var token = $('#_token').val();
                    console.log(searchURL);
                    console.log(event.target.value);
                    $('#table1').hide();
                    $('#table2').show();
                    $.ajax({

                        type: 'POST',
                        url: searchURL,
                        data: {
                            _token: token,
                            search: event.target.value,
                        },
                        dataType: "JSON",
                        success: function(data) {
                            let output = '';
                            console.log(data.results);

                            // $('.table-body2').html(data);
                            //  $('#search').html( output);
                            // Swal.fire(
                            //     'Deleted!',
                            //     'Your Branch has been deleted.',
                            //     'success',
                            // );
                            // location.reload();
                        }
                    });


                } else {
                    $('#table2').hide();
                    $('#table1').show();

                }

            });
        </script>
        <!-- Page JS -->
        <script src="{{ asset('build/assets/js/form-layouts.js') }}"></script>
        {{-- handle toggle switch for branch status --}}
        <script type="text/javascript">
            $(document).on('click', '.switch-input', function() {
                //event.preventDefault();

                var checked = $(this).is(':checked');

                var updateStatusURL = $(this).data('url');
                console.log(updateStatusURL);
                var token = $('#_token').val();
                console.log('token: ', token);

                $.ajax({
                    type: 'POST',
                    url: updateStatusURL,
                    data: {
                        _token: token,
                        status: checked ? 1 : 0
                    },
                    dataType: "JSON",
                    success: function(data) {
                        //if success show success alert
                        console.log(`success: ${data.id}`);

                        Swal.fire({
                            title: "Info",
                            text: checked ? "Warehouse Activated!" : "Warehouse Deactivated!",
                            icon: "info"
                        });
                        setTimeout(function() {
                            //your code to be executed after 1 second
                            location.reload();
                        }, 3000);
                        // $('.toast-body').html(`${checked?"Branch Activated!":"Branch Deactivated!"}`);
                        // $('.toast').removeClass("d-none");
                        // if (checked) {

                        //     $('.toast-header').removeClass("bg-danger d-none");
                        //     $('.toast-header').addClass("bg-success");
                        // } else {
                        //     $('.toast-header').removeClass("bg-success d-none");
                        //     $('.toast-header').addClass("bg-danger");
                        // }

                        // $('.toast').toast('show');


                    },
                    error: function(err) {
                        //if error show error alert
                        Swal.fire({
                            title: "Error",
                            text: "Error Occured",
                            icon: "error"
                        });

                    }

                });
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
    @endsection

</x-employee-layout>
