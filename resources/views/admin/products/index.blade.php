<x-app-layout>
    @section('title')
        Dashboard
    @endsection

    @section('VendorsCss')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card my-2">
            <div class="card-body">
                <form action="">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <label for="select2Multiple" class="form-label">{{ __('admin.company_list') }}</label>
                            <select id="select2Multiple1" class="js-example-basic-single form-control" name="company_id">
                                <option value="0" {{ request()->company_id == 0 ? 'selected' : '' }}>
                                    {{ __('admin.all') }}</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}"
                                        {{ request()->company_id == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 mb-4">
                            <label for="select2Multiple" class="form-label">{{ __('admin.branch_branch_name') }}</label>
                            <select id="select2Multiple8" class="js-example-basic-single form-control" name="branch_id">
                                <option value="0" {{ request()->branch_id == 0 ? 'selected' : '' }}>
                                    {{ __('admin.all') }}</option>
                                @foreach ($branchs as $branch)
                                    <option value="{{ $branch->id }}"
                                        {{ request()->branch_id == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->branch_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <hr>
                        <div class="col-md-3 mb-0">

                            <button name="action" value="search_action" type="submit"
                                class="btn btn-label-facebook">{{ __('admin.send') }}</button>
                        </div>

                    </div>
                </form>

            </div>

        </div>
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

                    @can('admin-Product-add')
                        <a href="{{ route('admin.products_create') }}"
                            class="btn btn-secondary">{{ __('admin.products_products_add') }}</a>
                    @endcan

                </div>
                <div class="card-datatable table-responsive text-nowrap px-2 py-2">
                    <!-- Update Password Modal -->

                    <!--/ Update Password Modal -->
                    <table class="dt-scrollableTable table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('admin.products_product_name') }}</th>
                                <th>{{ __('admin.branch_branch_name') }}</th>
                                <th>{{ __('admin.products_product_company') }}</th>
                                <th>{{ __('admin.quantity') }}</th>
                                <th>{{ __('admin.actions') }}</th>
                            </tr>
                        </thead>

                        @foreach ($data as $row)
                            <input type="hidden" class="_token" id="_token" value="{{ csrf_token() }}" />
                            <tr>
                                <td>{{ $row['name'] }}  #{{$row?->code}}</td>
                                {{-- <td>{{ QrCode::size(100)->generate($row['code']); }}</td> --}}
                                <td>{{ $row->branch->branch_name }}</td>
                                <td>{{ $row->vendorCompany->name ?? '-' }}</td>
                                <td>{{App\Models\ProductDetails::where('product_id',$row['id'])->first()->quantity ?? 0}}</td>
                                <td>
                                    @can('admin-Product-edit')
                                        <a href="{{ route('admin.products_edit', $row['id']) }}"
                                            class="btn btn-label-secondary">{{ __('admin.branch_action_edit') }}</a>

                                        {{-- <a class="btn btn-label-success" href="{{route('admin.product_approved',$row['id'])}}">{{__('admin.accept')}}</a> --}}
                                    @endcan

                                    @can('admin-Product-delete')
                                        <a id="delete" class="btn btn-label-danger delete"
                                            data-url="{{ route('admin.products_destroy', $row['id']) }}">{{ __('admin.branch_action_delete') }}</a>
                                    @endcan
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
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            // In your Javascript (external .js resource or <script> tag)
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });
        </script>
    @endsection

</x-app-layout>
