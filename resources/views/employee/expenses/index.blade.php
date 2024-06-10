<x-employee-layout>
    @section('title')
        {{ __('admin.accounts_list_expense') }}
    @endsection
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="card p-4">
                <div class="d-flex justify-content-sm-between align-items-sm-center">

                    <div class="d-flex align-items-sm-center">
                        <h5 class="card-header"> {{ __('admin.dashboard_expenses_list') }} </h5>
                        {{-- <span class="">
                            <a href="{{ route('admin.shopify_settings') }}"
                            class="btn btn-success btn-sm ml-2">Refresh</a>
                        </span> --}}
                    </div>


                    {{-- <a href="{{ route('admin.warehouse_create') }}"
                        class="btn btn-secondary">{{ __('admin.warehouse_warehouse_add') }}</a> --}}

                </div>
                <div class="card-datatable table-responsive text-nowrap px-2 py-2">
                    <!-- Update Password Modal -->

                    <!--/ Update Password Modal -->
                    <table class="dt-scrollableTable table table-bordered">
                        <thead>
                            <tr>
                                {{-- <th>{{ __('admin.dashboard_expenses_list') }}</th> --}}
                                <th>{{ __('admin.dashboard_expenses_rider') }}</th>
                                <th>{{ __('admin.dashboard_expenses_expense_type') }}</th>
                                <th>{{ __('admin.dashboard_expenses_car_plate') }}?</th>
                                <th>{{ __('admin.dashboard_expenses_value') }}</th>
                                <th>{{ __('admin.dashboard_expenses_payment_type') }}?</th>
                                <th>{{ __('admin.dashboard_expenses_date') }}</th>
                                <th>{{ __('admin.dashboard_expenses_image') }}</th>
                                {{-- <th>Actions</th> --}}
                            </tr>
                        </thead>

                        @foreach ($data as $row)
                            <input type="hidden" class="_token" id="_token" value="{{ csrf_token() }}" />

                            <tr>
                                <td>{{ $row->rider->name ?? ''}}</td>
                                <td>{{ $row->expense->name ?? ''}}</td>
                                <td>
                                    {{-- {{ $row->plate }} --}}
                                    {{ $row->plate->car_name ?? ''}} | {{ $row->plate->car_plate ?? ''}}
                                </td>
                                <td>{{ $row->value ?? ''}} {{ __('admin.currency') }}</td>
                                <td>{{ $row->paymentType->name ?? ''}}</td>
                                <td>{{ $row->date ?? ''}}</td>
                                <td> <img width="150" height="250"
                                        src="{{ asset('build/assets/img/uploads/documents/' . $row->photo) }}"
                                        alt=""> </td>
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
