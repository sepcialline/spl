<x-app-layout>
    @section('title')
        {{ __('admin.user_management') }} | {{ __('admin.user_management_employee_add') }}
    @endsection
    @section('VendorsCss')
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/select2/select2.css') }}" />
    @endsection
    <!-- Content -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light"> {{ __('admin.user_management') }} / </span>
            {{ __('admin.user_management_employee_add') }}
        </h4>

        <div class="card p-3  mb-4">
            <form method="POST" class=" needs-validation" novalidate action="{{ route('admin.users_employee_store') }}"
                enctype="multipart/form-data" class="card-body">
                @csrf
                <div class="row pt-3  g-3 ">
                    <div class="col-md-6">
                        <label class="form-label"
                            for="admin_name_english">{{ __('admin.user_management_admin_english_name') }}</label>
                        <input required type="text" name="admin_name_english" id="admin_name_english"
                            class="form-control @error('admin_name_english') is-invalid @enderror"
                            value="{{ old('admin_name_english') }}"
                            placeholder="{{ __('admin.user_management_admin_english_name') }}" />
                        @error('admin_name_english')
                            <div class="alert alert-danger error-message">{{ $message }}</div>
                        @enderror
                        {{-- <div class="valid-feedback"> Looks good! </div>
                        <div class="invalid-feedback"> Please enter your name. </div> --}}
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"
                            for="admin_name_arabic">{{ __('admin.user_management_admin_arabic_name') }}</label>
                        <input required type="text" name="admin_name_arabic" id="admin_name_arabic"
                            class="form-control  @error('admin_name_arabic') is-invalid @enderror"
                            placeholder="{{ __('admin.user_management_admin_arabic_name') }}"
                            value="{{ old('admin_name_arabic') }}" />
                        @error('admin_name_arabic')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        {{-- <div class="valid-feedback"> Looks good! </div>
                        <div class="invalid-feedback"> Please enter your name. </div> --}}
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"
                            for="admin_mobile">{{ __('admin.user_management_admin_mobile') }}</label>
                        <input required type="text" name="admin_mobile" id="admin_mobile" class="form-control"
                            placeholder="{{ __('admin.user_management_admin_mobile') }}"
                            value="{{ old('admin_mobile') }}" />
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"
                            for="admin_email">{{ __('admin.user_management_admin_email') }}</label>
                        <input required type="email" name="admin_email" id="admin_email" class="form-control"
                            placeholder="{{ __('admin.user_management_admin_email') }}"
                            value="{{ old('admin_email') }}" />
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"
                            for="admin_password">{{ __('admin.user_management_admin_password') }}</label>
                        <input required type="text" name="admin_password" id="admin_password" class="form-control"
                            placeholder="{{ __('admin.user_management_admin_password') }}"
                            value="{{ old('admin_password') }}" />
                    </div>
                    <div class="col-md-4">
                        <label for="user_department"
                            class="form-label">{{ __('admin.user_management_admin_department') }}</label>
                        <select name="user_department" value="{{ old('user_department') }}"
                            class="form-select  @error('user_department') is-invalid @enderror" id="user_department"
                            aria-label="user_department select example">
                            <option disabled selected>{{ __('admin.please_select') }}</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach

                        </select>
                        @error('user_department')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class=" col-md-2">
                        <label for="is_depratment_head"
                            class="form-label">{{ __('admin.user_management_is_department_head') }}</label>
                        <select name="is_depratment_head" value="{{ old('is_depratment_head') }}"
                            class="form-select  @error('is_depratment_head') is-invalid @enderror"
                            id="is_depratment_head" aria-label="is_depratment_head select example">
                            {{-- <option selected>Open this select menu</option> --}}
                            <option value="0">{{ __('admin.no') }}</option>
                            <option value="1">{{ __('admin.yes') }}</option>
                        </select>
                        @error('admin_status')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="user_branch"
                            class="form-label">{{ __('admin.user_management_admin_branch') }}</label>
                        <select name="user_branch" value="{{ old('user_branch') }}" required
                            class="form-select  @error('user_branch') is-invalid @enderror" id="user_branch"
                            aria-label="user_branch select example">
                            @foreach ($branches as $branch)
                                <option value={{ $branch->id }}>{{ $branch->branch_name }}</option>
                            @endforeach
                        </select>
                        @error('user_branch')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class=" col-md-2">
                        <label for="is_branch_manager"
                            class="form-label">{{ __('admin.user_management_is_branch_manager') }}</label>
                        <select name="is_branch_manager" value="{{ old('is_depratment_head') }}"
                            class="form-select  @error('is_branch_manager') is-invalid @enderror"
                            id="is_branch_manager" aria-label="is_branch_manager select example">
                            {{-- <option selected>Open this select menu</option> --}}
                            <option value="0">{{ __('admin.no') }}</option>
                            <option value="1">{{ __('admin.yes') }}</option>
                        </select>
                        @error('admin_status')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class=" col-md-4">
                        <label for="admin_status" class="form-label">{{ __('admin.status') }}</label>
                        <select name="admin_status" value="{{ old('admin_status') }}" required
                            class="form-select  @error('admin_status') is-invalid @enderror" id="admin_status"
                            aria-label="admin_status select example">
                            {{-- <option selected>Open this select menu</option> --}}
                            <option value="0">{{ __('admin.no') }}</option>
                            <option value="1">{{ __('admin.yes') }}</option>
                        </select>
                        @error('admin_status')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="admin_role"
                            class="form-label">{{ __('admin.user_management_admin_role') }}</label>
                        <select id="admin_role" name="employee_role[]" value="{{ old('employee_role') }}" required
                            class="select2 form-select    @error('employee_role') is-invalid @enderror" multiple
                            data-allow-clear="true" aria-label="employee_role select example">
                            @foreach ($roles as $role)
                                <option>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('employee_role')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="user_emirate"
                            class="form-label">{{ __('admin.user_management_admin_emirate') }}</label>
                        <select name="user_emirate" value="{{ old('user_emirate') }}" required
                            class="form-select  @error('user_emirate') is-invalid @enderror" id="user_emirate"
                            aria-label="user_emirate select example">
                            <option selected></option>
                            @foreach ($emirates as $emirate)
                                <option value="{{ $emirate->id }}">{{ $emirate->name }}</option>
                            @endforeach
                            {{-- <option selected>Open this select menu</option> --}}
                            {{-- <option value="0">{{ __('admin.no') }}</option>
                            <option value="1">{{ __('admin.yes') }}</option> --}}
                        </select>
                        @error('user_emirate')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <label for="user_city"
                            class="form-label">{{ __('admin.user_management_admin_city') }}</label>
                        <select name="user_city" value="{{ old('user_city') }}" required
                            class="form-select  @error('user_city') is-invalid @enderror" id="user_city"
                            aria-label="user_city select example">
                            {{-- @foreach ($cities as $city)
                                <option value={{ $city->id }}>{{ $city->name }}</option>
                            @endforeach --}}
                            {{-- <option selected>Open this select menu</option> --}}
                            {{-- <option value="0">{{ __('admin.no') }}</option>
                            <option value="1">{{ __('admin.yes') }}</option> --}}
                        </select>
                        @error('user_city')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class=" col-md-2">
                        <label for="tax_include"
                            class="form-label">{{ __('admin.user_management_admin_is_sales') }}</label>
                        <select name="admin_is_sale" value="{{ old('admin_is_sale') }}"
                            class="form-select  @error('admin_is_sale') is-invalid @enderror" id="admin_is_sale"
                            aria-label="admin_is_sale select example">
                            {{-- <option selected>Open this select menu</option> --}}
                            <option value="0">{{ __('admin.no') }}</option>
                            <option value="1">{{ __('admin.yes') }}</option>
                        </select>
                        @error('admin_is_sale')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-8">
                        <label class="form-label"
                            for="admin_address_english">{{ __('admin.user_management_admin_address_english') }}</label>
                        <input required type="text" name="admin_address_english" id="admin_address_english"
                            class="form-control @error('admin_address_english') is-invalid @enderror"
                            value="{{ old('admin_address_english') }}"
                            placeholder="{{ __('admin.user_management_admin_address_english') }}" />
                        @error('admin_address_english')
                            <div class="alert alert-danger error-message">{{ $message }}</div>
                        @enderror
                        {{-- <div class="valid-feedback"> Looks good! </div>
                        <div class="invalid-feedback"> Please enter your name. </div> --}}
                    </div>
                    {{-- <div class="col-md-6">
                        <label class="form-label"
                            for="admin_address_arabic">{{ __('admin.user_management_admin_address_arabic') }}</label>
                        <input required type="text" name="admin_address_arabic" id="admin_address_arabic"
                            class="form-control  @error('admin_address_arabic') is-invalid @enderror"
                            placeholder="{{ __('admin.user_management_admin_address_arabic') }}"
                            value="{{ old('admin_address_arabic') }}" />
                        @error('admin_address_arabic')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                    </div> --}}
                    <div class="col-md-12">
                        <label class="form-label"
                            for="admin_desc">{{ __('admin.user_management_admin_desc') }}</label>
                        <input type="text" name="admin_desc" id="admin_desc"
                            class="form-control  @error('admin_desc') is-invalid @enderror"
                            placeholder="{{ __('admin.user_management_admin_desc') }}"
                            value="{{ old('admin_desc') }}" />
                        @error('admin_desc')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        {{-- <div class="valid-feedback"> Looks good! </div>
                        <div class="invalid-feedback"> Please enter your name. </div> --}}
                    </div>
                    <div class="col-md-4">
                        <div class="avatar avatar-xl mb-3">
                            <img id="avatar" src="{{ asset('build/assets/img/avatars/1.png') }}"
                                alt="{{ __('admin.user_management_admin_avatar') }}">
                        </div>
                        <label for="admin_image"
                            class="form-label">{{ __('admin.user_management_admin_avatar') }}</label>
                        <input class="form-control" name="admin_image" type="file" id="admin_image" required
                            onchange="document.getElementById('avatar').src=window.URL.createObjectURL(this.files[0])">
                    </div>
                </div>



                <div class="col-md-12 row mt-4">
                    <div class="col-1">
                        <button id='submit' type="submit" class="btn btn-primary">
                            <span class="spinner-border spinner-border-sm d-none me-2" role="status"
                                aria-hidden="true">
                            </span> {{ __('admin.submit') }}
                        </button>
                    </div>
                    <div class="col-1">

                        <a href="{{ route('admin.users_employee_index') }}"
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
        <script src="{{ asset('build/assets/vendor/libs/select2/select2.js') }}"></script>

        <!-- Main JS -->
        <script src="{{ asset('build/assets/js/main.js') }}"></script>

        <!-- Page JS -->
        <script src="{{ asset('build/assets/js/form-layouts.js') }}"></script>


        <script>
            $(document).on('change', '#user_emirate', function() {
                var locale = '{{ config('app.locale') }}';
                $.ajax({
                    type: 'GET',
                    url: "{{ route('admin.shipment_get_cities') }}",
                    data: {
                        emirate_id: $(this).val()
                    },
                    success: function(res) {
                        $('#user_city').empty();
                        $.each(res, function(key, value) {
                            if (locale === "en") {
                                $('#user_city').append("<option value=" + value.id + ">" +
                                    value.name.en + "</option>");
                            } else {
                                $('#user_city').append("<option value=" + value.id + ">" +
                                    value.name.ar + "</option>");
                            }
                        });
                    }
                })
            });
        </script>


        <script>
            $(document).on('submit', 'form', function() {
                $('button').attr('disabled', 'disabled');
                $(".spinner-border").removeClass("d-none");
            });
        </script>


    @endsection
</x-app-layout>
