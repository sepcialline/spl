<x-app-layout>
    @section('title')
        {{ __('admin.vendors_management') }} | {{ __('admin.vendor_account') }}
    @endsection
    @section('VendorsCss')
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/select2/select2.css') }}" />
        {{-- select2 --}}
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light"> {{ __('admin.vendors_management') }} / </span>
            {{ __('admin.vendor_account') }}
        </h4>
        <div class="card p-3  mb-4">
            <form method="POST" class=" needs-validation" novalidate action="{{ route('admin.vendors_update') }}"
                enctype="multipart/form-data" class="card-body">
                @csrf
                <input type="hidden" value="{{ $vendor->id }}" name="vendor_id">

                <div class="row  g-3">

                    <div class="row py-2">
                        <div class="col-md-6">
                            <label class="form-label"
                                for="vendor_name_ar">{{ __('admin.vendors_companies_vendor_name_ar') }}</label>
                            <input required type="text" id="vendor_name_ar"
                                value="{{ $vendor->getTranslation('name', 'ar') }}" class="form-control"
                                name="vendor_name_ar"
                                placeholder="{{ __('admin.vendors_companies_vendor_name_ar') }}" />
                            <div class="invalid-feedback">
                                {{ __('admin.this_field_is_required') }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"
                                for="vendor_name_en">{{ __('admin.vendors_companies_vendor_name_en') }}</label>
                            <input required type="text" value="{{ $vendor->getTranslation('name', 'en') }}"
                                id="vendor_name_en" class="form-control" name="vendor_name_en"
                                placeholder="{{ __('admin.vendors_companies_vendor_name_en') }}" />
                            <div class="invalid-feedback">
                                {{ __('admin.this_field_is_required') }}
                            </div>
                        </div>
                    </div>

                    <div class="row py-2">
                        <div class="col-md-6">
                            <label class="form-label"
                                for="vendor_mobile">{{ __('admin.vendors_companies_vendor_mobile') }}</label>
                            <input required type="text" id="vendor_mobile" value="{{ $vendor->mobile }}"
                                class="form-control" name="vendor_mobile"
                                placeholder="{{ __('admin.vendors_companies_vendor_mobile') }}" />
                            <div class="invalid-feedback">
                                {{ __('admin.this_field_is_required') }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"
                                for="vendor_email">{{ __('admin.vendors_companies_vendor_email') }}</label>
                            <input required type="vendor_email" value="{{ $vendor->email }}" id="vendor_email"
                                class="form-control" name="vendor_email"
                                placeholder="{{ __('admin.vendors_companies_vendor_email') }}" />
                            <div class="invalid-feedback">
                                {{ __('admin.this_field_is_required') }}
                            </div>
                        </div>
                    </div>

                    <div class="row py-2">
                        <div class="col-md-6">
                            {{-- <label class="form-label"
                                for="password">{{ __('admin.vendors_companies_vendor_password') }}</label>
                            <input required type="hidden" id="password" value="{{ old('password') }}"
                                class="form-control" name="password"
                                placeholder="{{ __('admin.user_management_admin_password') }}" />
                            <div class="invalid-feedback">
                                {{ __('admin.this_field_is_required') }}
                            </div> --}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 py-4">
                            <div class="avatar avatar-xl mb-3">
                                <img id="vendor_avatar"
                                    src="{{ asset('build/assets/img/uploads/vendors/' . $vendor->avatar) }}"
                                    alt="{{ __('admin.user_management_admin_avatar') }}">
                            </div>
                            <label for="logo"
                                class="form-label">{{ __('admin.vendors_companies_vendor_avatar') }}</label>
                            <input class="form-control" name="avatar" type="file" id="vendor_avatar"
                                onchange="document.getElementById('vendor_avatar').src=window.URL.createObjectURL(this.files[0])">
                            <div class="invalid-feedback">
                                {{ __('admin.this_field_is_required') }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label" for="password">{{ __('admin.nationality') }}</label>
                            <select name="nationality_id" id="nationality_id" class="js-example-basic-single">
                                <option value="" selected disabled>{{ __('admin.please_select') }}</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}"
                                        {{ $country->id == $vendor->nationality_id ? 'selected' : '' }}>
                                        {{ $country->name_en }} - {{ $country->name_ar }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                {{ __('admin.this_field_is_required') }}
                            </div>
                        </div>
                        <div class="col">
                            <label class="form-label" for="birth_date">{{ __('admin.birth_date') }}</label>
                            <input  type="date" id="birth_date"
                                value="{{ \Carbon\Carbon::parse($vendor?->birthdate)->format('Y-m-d') }}"
                                class="form-control" name="birth_date" placeholder="{{ __('admin.birth_date') }}" />
                            <div class="invalid-feedback">
                                {{ __('admin.this_field_is_required') }}
                            </div>
                        </div>
                        <div class="col">
                            <label class="form-label" for="password">{{ __('admin.gender') }}</label>
                            <select name="gender" id="gender" class="js-example-basic-single" required>
                                <option value="" selected disabled>{{ __('admin.please_select') }}</option>
                                <option value="1" {{ $vendor->gender == 1 ? 'selected' : '' }}>
                                    {{ __('admin.male') }}</option>
                                <option value="2" {{ $vendor->gender == 2 ? 'selected' : '' }}>
                                    {{ __('admin.female') }}</option>
                            </select>
                            <div class="invalid-feedback">
                                {{ __('admin.this_field_is_required') }}
                            </div>
                        </div>
                    </div>
                    <div class="row my-4">
                        <div class="col">
                            <h5 class="form-label" for="password">{{ __('admin.company_list') }}</h5>
                            <select name="companies[]" id="companies" class="js-example-basic-multiple"
                                multiple="multiple">
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}"
                                        {{ in_array($company->id, $vendor->companies->pluck('id')->toArray()) ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                {{ __('admin.this_field_is_required') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 pt-4 row">
                        <div class="col-1">
                            <button id='submit' type="submit" class="btn btn-primary">
                                <span class="spinner-border spinner-border-sm d-none me-2" role="status"
                                    aria-hidden="true">
                                </span> {{ __('admin.submit') }}
                            </button>
                        </div>
                        <div class="col-1">

                            <a href="{{ route('admin.vendors_index') }}"
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
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
                $('.js-example-basic-multiple').select2();
            });
        </script>
    @endsection

</x-app-layout>
