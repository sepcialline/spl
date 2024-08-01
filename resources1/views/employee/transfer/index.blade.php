<x-employee-layout>
    @section('title')
    Dashboard
    @endsection
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="card p-4">
                <div class="d-flex justify-content-sm-between align-items-sm-center">

                    <div class="d-flex align-items-sm-center">
                        <h5 class="card-header"> {{ __('admin.warehouse_transfer_request') }} </h5>
                        {{-- <span class="">
                            <a href="{{ route('admin.shopify_settings') }}"
                            class="btn btn-success btn-sm ml-2">Refresh</a>
                        </span> --}}
                    </div>


                    <a href="{{ route('employee.transfer_create') }}"
                        class="btn btn-secondary">{{ __('admin.warehouse_transfer_request') }}</a>

                </div>
                <div class="card-datatable table-responsive text-nowrap px-2 py-2">
                    <!-- Update Password Modal -->

                    <!--/ Update Password Modal -->
                    <table class="dt-scrollableTable table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('admin.warehouse_transfer_branch') }}</th>
                                <th>{{ __('admin.warehouse_transfer_product') }}</th>
                                <th>{{ __('admin.warehouse_transfer_product_company') }}</th>
                                <th>{{ __('admin.warehouse_transfer_admin_accept') }}</th>
                                <th>{{ __('admin.warehouse_transfer_branch_accept') }}</th>
                                <th>{{ __('admin.warehouse_transfer_quantity') }}</th>
                                {{-- <th>{{ __('admin.warehouse_warehouse_status') }}</th> --}}
                                {{-- <th>Actions</th> --}}
                            </tr>
                        </thead>

                        @foreach ($data as $row)

                            <input type="hidden" class="_token" id="_token" value="{{ csrf_token() }}" />

                            <tr>
                                <td>{{ $row->branch->branch_name }}</td>
                                <td>{{ $row->product->name }}</td>
                                <td>{{ $row->vendorCompany->name }}</td>
                                <td><span
                                    class="{{ $row->is_admin_accept == 0 ? 'badge rounded-pill bg-label-danger' : 'badge rounded-pill bg-label-success' }}">{{ $row->is_admin_accept == 0 ? 'No' : 'Yes' }}</span></td>
                                <td><span
                                    class="{{ $row->is_branch_accept == 0 ? 'badge rounded-pill bg-label-danger' : 'badge rounded-pill bg-label-success' }}">{{ $row->is_branch_accept == 0 ? 'No' : 'Yes' }}</span></td>
                                <td>{{ $row->quantity}}</td>
                                {{-- <td>

                                    <a href="{{ route('admin.transfer_show',$row['id']) }}"
                                        class="btn btn-label-dark">{{ __('admin.branch_action_show') }}</a>

                                </td> --}}
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
                            success: function({data}) {
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
                            text: checked?"Warehouse Activated!":"Warehouse Deactivated!",
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
