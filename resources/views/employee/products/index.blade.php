<x-employee-layout>
    @section('title')
        Dashboard
    @endsection
    @section('VendorsCss')
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/flatpickr/flatpickr.css') }}" />


        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card my-2">
            <div class="card-body">
                <form action="">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <label for="select2Multiple" class="form-label">{{ __('admin.company_list') }}</label>
                            <select id="select2Multiple1" class="select2 form-select" name="company_id">
                                <option value="0" {{ request()->company_id == 0 ? 'selected' : '' }}>
                                    {{ __('admin.all') }}</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}"
                                        {{ request()->company_id == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}</option>
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

                    <a href="{{ route('employee.products_create') }}"
                        class="btn btn-secondary">{{ __('admin.products_products_add') }}</a>

                </div>
                <div class="card-datatable table-responsive text-nowrap px-2 py-2">
                    <!-- Update Password Modal -->

                    <!--/ Update Password Modal -->
                    <table class="dt-scrollableTable table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('admin.products_product_name') }}</th>
                                {{-- <th>{{ __('admin.products_product_code') }}</th> --}}
                                <th>{{ __('admin.products_product_company') }}</th>
                                <th>{{ __('admin.quantity') }}</th>
                                <th>{{ __('admin.actions') }}</th>
                            </tr>
                        </thead>

                        @foreach ($products as $row)
                            <input type="hidden" class="_token" id="_token" value="{{ csrf_token() }}" />
                            <tr>
                                <td>{{ $row['name'] }}  #{{$row?->code}}</td>
                                {{-- <td>{{ QrCode::size(100)->generate($row['code']); }}</td> --}}
                                <td>{{ $row->vendorCompany->name ?? '-' }}</td>
                                <td>{{App\Models\ProductDetails::where('product_id',$row['id'])->first()->quantity ?? 0}}</td>
                                <td>
                                    <a href="{{ route('employee.products_edit', $row['id']) }}"
                                        class="btn btn-label-secondary">{{ __('admin.branch_action_edit') }}</a>

                                    <a id="delete" class="btn btn-label-danger delete"
                                        data-url="{{ route('employee.products_destroy', $row['id']) }}">{{ __('admin.branch_action_delete') }}</a>

                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-dark" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        {{ __('admin.products_import') }}/{{ __('admin.products_export') }}
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                        {{ __('admin.products_import') }}/{{ __('admin.products_export') }}
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('employee.products_import_export') }}"
                                                    method="post" class="row g-3 needs-validation" novalidate>

                                                    <input type="hidden" name='product_id' value="{{$row['id']}}">
                                                    <input type="hidden" name='company_id' value="{{$row['company_id']}}">
                                                    <div class="modal-body">
                                                        @csrf
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col mb-4">
                                                                <label for="select2Multiple" class="form-label">
                                                                    {{ __('admin.products_import') }}/{{ __('admin.products_export') }}</label>
                                                                <select id="import_export" class="select2 form-control"
                                                                    name="import_export" required>
                                                                    <option value="" disabled selected>
                                                                        {{ __('admin.please_select') }}</option>
                                                                    <option value="1">
                                                                        {{ __('admin.products_import') }}</option>
                                                                    <option value="2">
                                                                        {{ __('admin.products_export') }}</option>
                                                                </select>
                                                            </div>
                                                            <div class="col">
                                                                <label
                                                                    for="quantity">{{ __('admin.quantity') }}</label>
                                                                <input type="number" class="form-control"
                                                                    id="quantity" name="quantity" required>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="date">{{ __('admin.date') }}</label>
                                                                <input type="date" name="date" required
                                                                    class="form-control" id="date"
                                                                    value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                            </div>
                                                            <div class="col">
                                                                <label for="products_notes">{{ __('admin.products_notes') }}</label>
                                                                <textarea name="products_notes" class="form-control" required></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    @section('VendorsJS')
        {{-- Form Valid --}}
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
        <!-- Vendors JS -->
        <script src="{{ asset('build/assets/vendor/libs/cleavejs/cleave.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/moment/moment.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>

        <!-- Main JS -->
        <script src="{{ asset('build/assets/js/main.js') }}"></script>

        <!-- Page JS -->
        <script src="{{ asset('build/assets/js/form-layouts.js') }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


        <script>
            $(document).ready(function() {
                $(document).on('submit', 'form', function() {
                    $('button').attr('disabled', 'disabled');
                    $(".spinner-border").removeClass("d-none");
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });
        </script>
    @endsection

</x-employee-layout>
