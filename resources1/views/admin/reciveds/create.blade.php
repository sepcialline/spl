<x-app-layout>
    @section('title')
    استلامات
    @endsection
    @section('VendorsCss')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/select2/select2.css') }}" />
    @endsection
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            {{-- <span class="text-muted fw-light"> {{ __('admin.branch_branch_manager') }} / </span> --}}
            {{ __('admin.accounts_add_expense') }}
        </h4>
        <div class="card p-3  mb-4">
            <form method="POST" class=" was-validated" action="{{ route('admin.recived_shipment_store') }}"
                enctype="multipart/form-data" class="card-body">
                @csrf
                <div class="row pt-3  g-3 ">

                    <div class="mb-3 col-md-4">
                        <label for="rider_id" class="form-label">{{ __('admin.rider') }}</label>
                        <select class="form-select js-example-basic-single" id="rider_id" required
                            aria-label="Default select example" name="rider_id">
                            <option ></option>
                            @foreach ($riders as $rider)
                                <option value={{ $rider->id }}>{{ $rider->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="vendor_id" class="form-label">{{ __('admin.vendors_companies') }}</label>
                        <select class="form-select js-example-basic-single" id="vendor_id"
                            aria-label="Default select example" name="vendor_id">
                            <option ></option>
                            @foreach ($vendors as $vendor)
                                <option value={{ $vendor->id }}>{{ $vendor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-md-4">
                            <label for="vendor_id" class="form-label">تاجر اخر</label>
                        <input type="text" class="form-control" name="vendor_if_not_in_system" id="vendor_if_not_in_system">
                    </div>



                    <div class="col-md-6">
                        <label class="form-label" for="date">{{ __('admin.date') }}</label>
                        <input required type="date" name="date" id="date" class="form-control"
                            placeholder="{{ __('admin.date') }}" />

                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="count_of_shipments">{{ __('admin.count') }}</label>
                        <input required type="text" name="count_of_shipments" id="count_of_shipments" class="form-control"
                            value="{{ old('count') }}" />
                    </div>
                    <div class="col-md-12">
                        <div class="avatar avatar-xl mb-3">
                            <img id="avatar" src="{{ asset('build/assets/img/avatars/1.png') }}"
                                alt="{{ __('admin.user_management_admin_avatar') }}">
                        </div>
                        {{-- <label for="admin_image"
                            class="form-label">{{ __('admin.user_management_admin_avatar') }}</label> --}}
                        <input class="form-control" name="file" type="file" id="file" required
                            onchange="document.getElementById('avatar').src=window.URL.createObjectURL(this.files[0])">
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

                                <a href="{{ route('admin.recived_shipment_index') }}"
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
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });
        </script>
    @endsection
</x-app-layout>
