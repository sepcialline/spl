<x-employee-layout>
    @section('title')
        {{ __('admin.warehouse') }} | {{ __('admin.products_products_add') }}
    @endsection
    @section('VendorsCss')
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/flatpickr/flatpickr.css') }}" />


        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            {{-- <span class="text-muted fw-light"> {{ __('admin.branch_branch_manager') }} / </span> --}}
            {{ __('admin.products_products_add') }}
        </h4>
        <div class="card p-3  mb-4">
            <span
                class="text-danger">{{ __('admin.to_add_product_toany_vendor_company_you_should_to_check_if_company_has_stock_in_company_details') }}</span>
            <form method="POST" class=" needs-validation" novalidate action="{{ route('employee.products_store') }}"
                enctype="multipart/form-data" class="card-body">
                @csrf
                <div class="row pt-3  g-3 ">
                    <div class="col-md-6">
                        <label class="form-label"
                            for="product_name_en">{{ __('admin.products_product_name_en') }}</label>
                        <input required type="text" name="product_name_en" id="product_name_en"
                            class="form-control @error('product_name_en') is-invalid @enderror"
                            value="{{ old('product_name_en') }}"
                            placeholder="{{ __('admin.products_product_name_en') }}" />
                        @error('product_name_en')
                            <div class="alert alert-danger error-message">{{ $message }}</div>
                        @enderror

                    </div>
                    <div class="col-md-6">
                        <label class="form-label"
                            for="product_name_ar">{{ __('admin.products_product_name_ar') }}</label>
                        <input required type="text" name="product_name_ar" id="product_name_ar"
                            class="form-control @error('product_name_ar') is-invalid @enderror"
                            value="{{ old('product_name_ar') }}"
                            placeholder="{{ __('admin.products_product_name_ar') }}" />
                        @error('product_name_ar')
                            <div class="alert alert-danger error-message">{{ $message }}</div>
                        @enderror

                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="product_code">{{ __('admin.products_product_code') }}</label>
                        <input required type="text" name="product_code" id="product_code"
                            class="form-control @error('product_code') is-invalid @enderror"
                            value="{{ old('product_code') }}" placeholder="{{ __('admin.products_product_code') }}" />
                        @error('product_code')
                            <div class="alert alert-danger error-message">{{ $message }}</div>
                        @enderror

                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="client_name">{{ __('admin.price') }}</label>
                        <div class="input-group mb-3">
                            <input type="number" id="price" name="price" value="{{ old('price') }}"
                                value="0" class="form-control @error('price') is-invalid @enderror" required
                                placeholder="" aria-label="" step="0.01" min="0" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="company_id" class="form-label">{{ __('admin.products_product_company') }}</label>
                        <select class="js-example-basic-single form-control" id="company_id" name="company_id" required>
                            <option value=''>{{ __('admin.please_select') }}</option>
                            @foreach ($companies as $company)
                                <option value={{ $company->id }}>{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="avatar avatar-xl mb-3">
                            <img id="image" src="{{ asset('build/assets/img/avatars/1.png') }}"
                                alt="{{ __('admin.user_management_admin_avatar') }}">
                        </div>
                        <label for="image"
                            class="form-label">{{ __('admin.dashboard_expenses_image') }}</label>
                        <input class="form-control" name="image" type="file" id="image"
                            onchange="document.getElementById('image').src=window.URL.createObjectURL(this.files[0])">
                    </div>
                    <div class="row  g-3">

                        <div class="col-md-12 row mb-4">
                            <div class="col-1">
                                <button id='submit' type="submit" class="btn btn-primary">
                                    <span class="spinner-border spinner-border-sm d-none me-2" role="status"
                                        aria-hidden="true">
                                    </span> {{ __('admin.submit') }}
                                </button>
                            </div>
                            <div class="col-1">

                                <a href="{{ route('employee.products_index') }}"
                                    class="btn btn-label-danger">{{ __('admin.back') }}</a>

                            </div>
                        </div>

            </form>
        </div>






    </div>
    <!-- / Content -->
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
