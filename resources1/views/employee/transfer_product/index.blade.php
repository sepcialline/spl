<x-employee-layout>
    @section('title')
        Dashboard
    @endsection
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="card p-4">
                <div class="d-flex justify-content-sm-between align-items-sm-center">

                    <div class="d-flex align-items-sm-center">
                        <h5 class="card-header"> {{ __('admin.transfer_product') }} </h5>
                        {{-- <span class="">
                            <a href="{{ route('admin.shopify_settings') }}"
                            class="btn btn-success btn-sm ml-2">Refresh</a>
                        </span> --}}
                    </div>


                    {{-- <a href="{{ route('employee.transfer_create') }}"
                        class="btn btn-secondary">{{ __('admin.warehouse_transfer_request') }}</a> --}}

                </div>
                <div class="card-datatable table-responsive text-nowrap px-2 py-2">
                    <!-- Update Password Modal -->

                    <!--/ Update Password Modal -->
                    <table class="dt-scrollableTable table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('admin.products_product_company') }}</th>
                                <th>{{ __('admin.warehouse_transfer_product') }}</th>
                                <th>{{ __('admin.from') }}</th>
                                <th>{{ __('admin.warehouse_transfer_quantity') }}</th>
                                <th>{{ __('admin.delivered') }}?</th>

                            </tr>
                        </thead>

                        @foreach ($data as $row)
                            <input type="hidden" class="_token" id="_token" value="{{ csrf_token() }}" />

                            <tr>
                                <td>{{ $row->product->vendorCompany->name ?? '-'}}</td>
                                <td>{{ $row->product->name ?? '-' }}</td>
                                <td>{{ $row->fromBranch->branch_name }}</td>
                                {{-- <td>{{ $row->toBranch->branch_name }}</td> --}}
                                <td>{{ $row->quantity }}</td>
                                <td>
                                    @if ($row->deliver_status)
                                        <span
                                            class="badge rounded-pill bg-label-success">{{ __('admin.delivered') }}</span>
                                    @else
                                        <div class="modal fade" id="deliver{{ $row->id }}" tabindex="-1"
                                            aria-hidden="true">

                                            <div class="modal-dialog modal-simple modal-lg modal-dialog-centered">
                                                <div class="modal-content p-3 p-md-5">
                                                    <div class="modal-body">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                        <div class="text-center mb-4">
                                                            <h3 class="mb-4">
                                                                {{ __('admin.transfer_product_deliver') }}</h3>
                                                        </div>

                                                        <form id="import_export_product" class="row g-3 mt-3"
                                                            method="POST" novalidate
                                                            action="{{ route('employee.transfer_product_update', $row->id) }}">
                                                            @csrf
                                                            @method('PUT')
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
                                                                            value="{{ $row->product->name }}" />

                                                                    </div>
                                                                </div>

                                                                <div class="col-12">
                                                                    <label class="form-label mt-2"
                                                                        for="modalEnableOTPPhone">{{ __('admin.warehouse_transfer_quantity') }}</label>
                                                                    <div class="input-group input-group-merge ">
                                                                        <input type="number" readonly id="quantity"
                                                                            name="quantity" class="form-control"
                                                                            value={{ $row->quantity }}
                                                                            placeholder="{{ __('admin.warehouse_transfer_quantity') }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <label for="to_branch"
                                                                        class="form-label">{{ __('admin.branch_branch_name') }}</label>
                                                                    <select class="form-select " id="to_branch"
                                                                        aria-label="Default select example"
                                                                        name="to_branch" disabled>
                                                                        @foreach ($branches as $branch)
                                                                            <option value={{ $branch->id }}
                                                                                {{ $branch->id == $row->from_branch ? 'selected' : '' }}>
                                                                                {{ $branch->branch_name }}</option>
                                                                        @endforeach
                                                                    </select>
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
                                        <a data-bs-toggle="modal" data-bs-target="#deliver{{ $row->id }}"
                                            class="btn btn-warning btn-sm">{{ __('admin.deliver') }}</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
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
                        title: 'Delete Warehouse',
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
                                        'Your Warehouse has been deleted.',
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
    @endsection
</x-employee-layout>
