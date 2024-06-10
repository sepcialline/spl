<x-app-layout>
    @section('title')
        {{ __('admin.user_management_rider_vehicle_type') }}
    @endsection
    @section('VendorsCss')
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/select2/select2.css') }}" />
    @endsection
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light"> {{ __('admin.user_management_rider_vehicle_type') }} / </span>
        </h4>
        <div class="card p-3  mb-4">
            <form method="POST" class=" needs-validation" novalidate action="{{ route('admin.cars_update', $car->id) }}"
                enctype="multipart/form-data" class="card-body">
                @csrf
                <div class="row pt-3  g-3 ">
                    <div class="col-md-6">
                        <label class="form-label"
                            for="city_english_name">{{ __('admin.accounts_english_name') }}</label>
                        <input required type="text" name="car_name_en" id="car_name_en"
                            class="form-control @error('car_name_en') is-invalid @enderror"
                            value="{{ $car->getTranslation('car_name', 'en') }}"
                            placeholder="{{ __('admin.accounts_english_name') }}" />
                        @error('car_name_en')
                            <div class="alert alert-danger error-message">{{ $message }}</div>
                        @enderror
                        {{-- <div class="valid-feedback"> Looks good! </div>
                        <div class="invalid-feedback"> Please enter your name. </div> --}}
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="car_name_ar">{{ __('admin.accounts_arabic_name') }}</label>
                        <input required type="text" name="car_name_ar" id="car_name_ar"
                            class="form-control @error('car_name_ar') is-invalid @enderror"
                            value="{{ $car->getTranslation('car_name', 'ar') }}"
                            placeholder="{{ __('admin.accounts_arabic_name') }}" />
                        @error('car_name_ar')
                            <div class="alert alert-danger error-message">{{ $message }}</div>
                        @enderror
                        {{-- <div class="valid-feedback"> Looks good! </div>
                        <div class="invalid-feedback"> Please enter your name. </div> --}}
                    </div>
                    <div class="col-md-12">
                        <label for="emirates" class="form-label">{{ __('admin.dashboard_expenses_car_plate') }}</label>
                        <input type="text" class="form-control" value="{{ $car->car_plate }}" name="car_plate">
                        @error('emirates')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="row  g-3 mt-4">



                    <div class="col-md-12 row">
                        <div class="col-1">
                            <button id='submit' type="submit" class="btn btn-primary">
                                <span class="spinner-border spinner-border-sm d-none me-2" role="status"
                                    aria-hidden="true">
                                </span> {{ __('admin.submit') }}
                            </button>
                        </div>
                        <div class="col-1">

                            <a href="{{ route('admin.cars_index') }}"
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
            $(document).ready(function() {
                $(document).on('submit', 'form', function() {
                    $('button').attr('disabled', 'disabled');
                    $(".spinner-border").removeClass("d-none");
                });
            });
        </script>

    @endsection
</x-app-layout>
