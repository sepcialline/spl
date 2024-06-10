<x-app-layout>
    @section('title')
        الطرود المستلمة
    @endsection
    @section('VendorsCss')

    <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/select2/select2.css') }}" />
    @endsection

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <form action="">
                    <div class="row">
                        <div class="col-md mb-4">
                            <label for="" class="form-label">{{ __('admin.rider') }}</label><br>
                            <select id="" class="js-example-basic-single" name="rider_id">
                                <option value="0" {{ request()->company_id == 0 ? 'selected' : '' }}>
                                    {{ __('admin.all') }}</option>
                                @foreach ($riders as $rider)
                                    <option value="{{ $rider->id }}"
                                        {{ request()->rider_id == $rider->id ? 'selected' : '' }}>{{ $rider->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md mb-4">
                            <label for="" class="form-label">{{ __('admin.vendors_companies') }}</label><br>
                            <select id="" class="js-example-basic-single" name="vendor_id">
                                <option value="0" {{ request()->company_id == 0 ? 'selected' : '' }}>
                                    {{ __('admin.all') }}</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}"
                                        {{ request()->vendor_id == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col mb-4">
                            <label for="" class="form-label">{{ __('admin.from') }}</label> <br>
                            <input class='form-control' type="date" name="date_from"
                                value="{{ \Carbon\Carbon::parse(Request()->date_from)->format('Y-m-d') ?? \Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>
                        <div class="col mb-4">
                            <label for="" class="form-label">{{ __('admin.to') }}</label> <br>
                            <input class='form-control' type="date" name="date_to"
                                value="{{ \Carbon\Carbon::parse(Request()->date_to)->format('Y-m-d') ?? \Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>
                    </div>
                    <button class="btn btn-label-dark" type="submit">{{ __('admin.search') }}</button>
                </form>

            </div>
        </div>
        <hr>
        <div class="row">
            <div class="card p-4">
                <div class="d-flex justify-content-sm-between align-items-sm-center">

                    <div class="d-flex align-items-sm-center">
                        <h5 class="card-header"> الاستلامات </h5>
                        {{-- <span class="">
                            <a href="{{ route('admin.shopify_settings') }}"
                            class="btn btn-success btn-sm ml-2">Refresh</a>
                        </span> --}}
                    </div>


                    <a href="{{ route('admin.recived_shipment_create') }}"
                        class="btn btn-secondary">{{ __('admin.accounts_add_new') }}</a>

                </div>
                <div class="card-datatable table-responsive text-nowrap px-2 py-2">

                    <table class="dt-scrollableTable table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('admin.date') }}</th>
                                <th>{{ __('admin.rider') }}</th>
                                <th>{{ __('admin.vendors_companies') }}</th>
                                <th>{{ __('admin.count') }}</th>
                                <th>{{ __('admin.dashboard_expenses_image') }}</th>
                                <th>{{ __('admin.status') }}</th>
                                <th>{{__('admin.actions')}}</th>
                            </tr>
                        </thead>

                        @foreach ($shipments as $shipment)
                            <input type="hidden" class="_token" id="_token" value="{{ csrf_token() }}" />

                            <tr>
                                <td>{{ $shipment->date }}</td>
                                <td>{{ $shipment->rider->name }}</td>
                                <td>{{ $shipment->vendor->name ?? $shipment->vendor_if_not_in_system}} </td>
                                <td>{{ $shipment->count_of_shipments }} </td>
                                <td>
                                    <a href="{{ asset('build/assets/img/uploads/documents/' . $shipment->image) }}"
                                        target="_blank"> <i class="fa fa-eye"></i> </a>
                                </td>
                                <td>
                                    <label class="switch switch-primary">
                                        <input type="checkbox" class="switch-input status"
                                            data-url="{{ route('admin.recived_shipment_status_update',$shipment->id) }}"
                                            name="is_approved" id="is_approved"
                                            {{$shipment->is_approved ? 'checked' : !'checked' }} />
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on">
                                                <i class="bx bx-check"></i>
                                            </span>
                                            <span class="switch-off">
                                                <i class="bx bx-x"></i>
                                            </span>
                                        </span>
                                        {{-- <span class="switch-label">Primary</span> --}}
                                    </label>
                                </td>
                                <td><a class="btn btn-label-success btn-sm"
                                        href="{{ route('admin.recived_shipment_edit', $shipment->id) }}">{{ __('admin.edit') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                {{ $shipments->links() }}
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

        <script>
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });
        </script>
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
                            is_approved: checked ? 1 : 0
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
                            $('.toast-body').html(`${checked?"User Activated!":"User Deactivated!"}`);
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

            <script src="{{ asset('build/assets/vendor/libs/select2/select2.js') }}"></script>


    @endsection
</x-app-layout>
