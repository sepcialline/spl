<x-employee-layout>
    @section('title')
        {{ __('admin.accounts_expenses') }}
    @endsection
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="card mb-4">
                <div class="card-body">
                    <small class="text-muted text-uppercase">{{ __('admin.warehouse_transfer_request') }}</small>
                    <ul class="list-unstyled mt-3 mb-0">
                        <li class="d-flex align-items-center mb-3">
                            <span class="fw-semibold mx-2">{{ __('admin.warehouse_transfer_branch') }}:</span>
                            <span>{{ $transfer->fromBranch->branch_name }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <span class="fw-semibold mx-2">{{ __('admin.warehouse_products') }}:</span>
                            <span>{{ $transfer->product->name }}</span>
                        </li>
                        <li class="d-flex align-items-center">
                            <span class="fw-semibold mx-2">{{ __('admin.warehouse_transfer_quantity') }}:</span>
                            <span>{{ $transfer->quantity }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card p-4">
                <div class="d-flex justify-content-sm-between align-items-sm-center">

                    <div class="d-flex align-items-sm-center">
                        <h5 class="card-header"> {{ __('admin.warehouse_transfer_branches_status') }} </h5>

                    </div>




                </div>
                <div class="card-datatable table-responsive text-nowrap px-2 py-2">
                    <!-- Update Password Modal -->

                    <!--/ Update Password Modal -->
                    <table class="dt-scrollableTable table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('admin.warehouse_transfer_branch') }}</th>
                                <th>{{ __('admin.warehouse_transfer_product') }}</th>
                                <th>{{ __('admin.warehouse_transfer_quantity') }}</th>
                                {{-- <th >Status</th> --}}
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <input type="hidden" class="_token" id="_token" value="{{ csrf_token() }}" />
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->branch->branch_name }}</td>
                                <td>{{ $product->product->name }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>
                                    <div class="modal fade" id="transfer{{ $product->id }}" tabindex="-1"
                                        aria-hidden="true">

                                        <div class="modal-dialog modal-simple modal-lg modal-dialog-centered">
                                            <div class="modal-content p-3 p-md-5">
                                                <div class="modal-body">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                    <div class="text-center mb-4">
                                                        <h3 class="mb-4">{{ __('admin.warehouse_transfer') }}</h3>
                                                    </div>

                                                    <form id="import_export_product" class="row g-3 mt-3" method="POST"
                                                        novalidate
                                                        action="{{ route('employee.transfer_product_store') }}">
                                                        @csrf

                                                        <div class="col-12 row">
                                                            <div class="col-12">
                                                                <label class="form-label mt-2"
                                                                    for="product_name">{{ __('admin.products_product_name') }}</label>
                                                                <div class="input-group input-group-merge ">
                                                                    <input type="text" id="product_id"
                                                                        name="product_id" class="form-control" hidden
                                                                        value={{ $product->id }} />
                                                                    <input type="text" id="operation_id"
                                                                        name="operation_id" class="form-control" hidden
                                                                        value="4" />
                                                                    <input type="text" id="from_branch"
                                                                        name="from_branch" class="form-control" hidden
                                                                        value="{{ $product->branch_id }}" />
                                                                    <input type="text" id="prod_name"
                                                                        name="prod_name" class="form-control" readonly
                                                                        value="{{ $product->product->name }}" />

                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <label class="form-label mt-2"
                                                                    for="modalEnableOTPPhone">{{ __('admin.warehouse_transfer_current_quantity') }}</label>
                                                                <div class="input-group input-group-merge ">
                                                                    <input type="number" readonly id="current_quantity"
                                                                        name="current_quantity" class="form-control"
                                                                        value={{ $product->quantity }}
                                                                        placeholder="{{ __('admin.warehouse_transfer_current_quantity') }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <label class="form-label mt-2"
                                                                    for="modalEnableOTPPhone">{{ __('admin.warehouse_transfer_quantity') }}</label>
                                                                <div class="input-group input-group-merge ">
                                                                    <input type="number" id="quantity" name="quantity"
                                                                        class="form-control" {{-- //value={{ $product->quantity }} --}}
                                                                        placeholder="{{ __('admin.warehouse_transfer_quantity') }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <label for="from_branch"
                                                                    class="form-label">{{ __('admin.from') }}</label>
                                                                <select class="form-select " id="from_branch"
                                                                    aria-label="Default select example"
                                                                    name="from_branch">
                                                                    @foreach ($branches as $branch)
                                                                        <option value={{ $branch->id }}>
                                                                            {{ $branch->branch_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-12">
                                                                <label for="to_branch"
                                                                    class="form-label">{{ __('admin.to') }}</label>
                                                                <select class="form-select " id="to_branch"
                                                                    aria-label="Default select example"
                                                                    name="to_branch">
                                                                    @foreach ($branches as $branch)
                                                                        <option value={{ $branch->id }}>
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
                                    <a data-bs-toggle="modal" data-bs-target="#transfer{{ $product->id }}"
                                        class="btn btn-label-info"
                                        data-url="{{ route('employee.transfer_update', $product->product_id) }}">{{ __('admin.warehouse_transfer') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    @section('VendorsJS')
        <!-- The core Firebase JS SDK is always required and must be listed first -->
        {{-- AIzaSyBI9Dy68H76Ml1AW1D4oIdsR32z0PGE18Y   //////// Google Map API  --}}
        {{-- Toaster --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
            integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
            crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
            integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
            crossorigin="anonymous" />
        {{-- sweet alert --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>

        {{-- Ajax --}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script>
            $(document).ready(function() {

                // Delete Button
                $('.close').on('click', function() {
                    var form = $(this).closest("form");
                    event.preventDefault();
                    var token = $('#_token').val();
                    var company_id = $('#company_id').val();
                    console.log('token: ', token);
                    //sweet alert to ask user if he is sure before delete
                    Swal.fire({
                        title: 'Accept Transfer Requset?',
                        text: 'Do you want to continue?',
                        icon: 'info',
                        confirmButtonText: 'Yes, accept it!',
                        cancelButtonText: "No, cancel please!",
                        showCancelButton: true,
                        //iconColor: "#DD6B55",
                        ///cancelButtonColor: "#fce3e1",
                        //confirmButtonColor: "#DD6B55",


                    }).then((result) => {
                        if (result.isConfirmed) {
                            var closeUrl = $(this).data('url');
                            var trObj = $(this);
                            console.log(closeUrl);
                            //console.log(trObj);
                            $.ajax({

                                type: 'PUT',
                                url: closeUrl,
                                data: {
                                    _token: token,
                                    is_admin_accept: 1,
                                    is_branch_accept: 0
                                },
                                dataType: "JSON",
                                success: function() {
                                    Swal.fire(
                                        'Closed!',
                                        'Your Order has been closed.',
                                        'success',
                                    );
                                    //location.reload();
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
                // console.log(checked);
                var updateStatusURL = $(this).data('url');
                var token = $('#_token').val();
                //console.log('token: ', token);

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
                        console.log(`success: ${data}`);
                        // Swal.fire({
                        //     title: "Info",
                        //     text: checked?"Branch Activated!":"Branch Deactivated!",
                        //     icon: "info"
                        // });
                        $('.toast-body').html(`${checked?"Branch Activated!":"Branch Deactivated!"}`);
                        $('.toast').removeClass("d-none");
                        if (checked) {

                            $('.toast-header').removeClass("bg-danger d-none");
                            $('.toast-header').addClass("bg-success");
                        } else {
                            $('.toast-header').removeClass("bg-success d-none");
                            $('.toast-header').addClass("bg-danger");
                        }

                        $('.toast').toast('show');

                        // location.reload();
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
        <!-- Form Validation -->
        <script src="{{ asset('build/assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
    @endsection
</x-employee-layout>
