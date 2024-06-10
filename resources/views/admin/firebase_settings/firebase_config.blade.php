<x-setting-layout>
    @section('title')
        {{ __('admin.firebase') }}
    @endsection
    @section('VendorsCss')
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/select2/select2.css') }}" />
    @endsection
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y ">
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">


        <!-- Layout container -->
        <div class="layout-page">
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="py-3 breadcrumb-wrapper mb-4">
                <span class="text-muted fw-light">{{ __('admin.setting_general_setting') }} /</span> {{ __('admin.firebase') }}
              </h4>

              <div class="row">
                <div class="col-md-12">
                  <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item" >
                      <a class="nav-link " style="border-radius: 10px;" href="{{ route('admin.push_notification') }}"
                        > {{ __('admin.firebase_push') }}</a>
                    </li>
                    <li class="nav-item" style="background-color: #4287f5;border-radius: 10px;">
                        <a class="nav-link active" style="border-radius: 10px;" href="{{ route('admin.config_notification') }}"
                          > {{ __('admin.firebase_config') }}</a>
                      </li>

                  </ul>
                  <form method="POST" class=" needs-validation" novalidate action="{{ route('admin.update_config') }}" enctype="multipart/form-data"
                    class="card-body">
                    @csrf
                  <div class="card mb-4">
                    <div class="card-body">
                      <div class="row">
                        {{-- Server Key --}}
                        <div class="col-md-12">
                            <label class="form-label" for="server_key">{{  __('admin.firebase_server_key')
                                }}</label>
                            <textarea required   type="text" name="server_key" id="server_key"
                                class="form-control @error('server_key') is-invalid @enderror"
                                value="{{ $data->server_key??'' }}"
                                placeholder="{{ __('admin.firebase_server_key') }}" >{{ $data->server_key??'' }}</textarea>
                            @error('server_key')
                            <div class="alert alert-danger error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- API Key --}}
                        <div class="col-md-12 mt-2">
                            <label class="form-label" for="api_key">{{  __('admin.firebase_api_key')
                                }}</label>
                            <input required   type="text" name="api_key" id="api_key"
                                class="form-control @error('api_key') is-invalid @enderror"
                                value="{{ $data->api_key??'' }}"
                                placeholder="{{ __('admin.firebase_api_key') }}" />
                            @error('api_key')
                            <div class="alert alert-danger error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Project Id --}}
                        <div class="col-md-4 mt-2">
                            <label class="form-label" for="project_id">{{  __('admin.firebase_project_id')
                                }}</label>
                            <input required   type="text" name="project_id" id="project_id"
                                class="form-control @error('project_id') is-invalid @enderror"
                                value="{{ $data->project_id??'' }}"
                                placeholder="{{ __('admin.firebase_project_id') }}" />
                            @error('project_id')
                            <div class="alert alert-danger error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Auth Domain --}}
                        <div class="col-md-4 mt-2">
                            <label class="form-label" for="auth_domain">{{  __('admin.firebase_auth_domain')
                                }}</label>
                            <input required   type="text" name="auth_domain" id="auth_domain"
                                class="form-control @error('auth_domain') is-invalid @enderror"
                                value="{{ $data->auth_domain??'' }}"
                                placeholder="{{ __('admin.firebase_auth_domain') }}" />
                            @error('auth_domain')
                            <div class="alert alert-danger error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Storage Bucket --}}
                        <div class="col-md-4 mt-2">
                            <label class="form-label" for="storage_bucket">{{  __('admin.firebase_storage_bucket')
                                }}</label>
                            <input required   type="text" name="storage_bucket" id="storage_bucket"
                                class="form-control @error('storage_bucket') is-invalid @enderror"
                                value="{{ $data->storage_bucket??'' }}"
                                placeholder="{{ __('admin.firebase_storage_bucket') }}" />
                            @error('storage_bucket')
                            <div class="alert alert-danger error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Sender Id --}}
                        <div class="col-md-4 mt-2">
                            <label class="form-label" for="messaging_sender_id">{{  __('admin.firebase_messaging_sender_id')
                                }}</label>
                            <input required   type="text" name="messaging_sender_id" id="messaging_sender_id"
                                class="form-control @error('messaging_sender_id') is-invalid @enderror"
                                value="{{ $data->messaging_sender_id??'' }}"
                                placeholder="{{ __('admin.firebase_messaging_sender_id') }}" />
                            @error('messaging_sender_id')
                            <div class="alert alert-danger error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- App Id --}}
                        <div class="col-md-4 mt-2">
                            <label class="form-label" for="app_id">{{  __('admin.firebase_app_id')
                                }}</label>
                            <input required   type="text" name="app_id" id="app_id"
                                class="form-control @error('app_id') is-invalid @enderror"
                                value="{{ $data->app_id??'' }}"
                                placeholder="{{ __('admin.firebase_app_id') }}" />
                            @error('app_id')
                            <div class="alert alert-danger error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- Measurement Id --}}
                        <div class="col-md-4 mt-2">
                            <label class="form-label" for="measurement_id">{{  __('admin.firebase_measurement_id')
                                }}</label>
                            <input required   type="text" name="measurement_id" id="measurement_id"
                                class="form-control @error('measurement_id') is-invalid @enderror"
                                value="{{ $data->measurment_id??'' }}"
                                placeholder="{{ __('admin.firebase_measurement_id') }}" />
                            @error('measurement_id')
                            <div class="alert alert-danger error-message">{{ $message }}</div>
                            @enderror
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 row p-4">
                        <div class="col-1">
                            <button id='submit' type="submit" class="btn btn-primary">
                                <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true">
                                </span> {{ __('admin.submit') }}
                            </button>
                        </div>
                        <div class="col-1">

                            {{-- <a href="{{ route('admin.finance_year_index') }}" class="btn btn-label-danger">{{ __('admin.back')
                                }}</a> --}}

                        </div>
                    </div>
                  </div>
                </form>
                </div>
              </div>


            </div>
            <!-- / Content -->


            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>

      <!-- Drag Target Area To SlideIn Menu On Small Screens -->
      <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->





    </div>





    </div>
    <!-- / Content -->
    @section('VendorsJS')
        <!-- The core Firebase JS SDK is always required and must be listed first -->
        {{-- AIzaSyBI9Dy68H76Ml1AW1D4oIdsR32z0PGE18Y   //////// Google Map API  --}}

        {{-- Form Valid --}}
        <script>
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function () {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
                })
            })()
        </script>
        {{-- Loading --}}
        <script>
            $(document).ready(function() {
                    $(document).on('submit', 'form', function() {
                        $('button').attr('disabled', 'disabled');
                        $(".spinner-border").removeClass("d-none");
                    });
                });
        </script>
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

        {{-- Ajax --}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
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
                        title: 'Delete City',
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

                                type: 'POST',
                                url: deleteURL,
                                data: {
                                    _token: token
                                },
                                dataType: "JSON",
                                success: function() {
                                    Swal.fire(
                                        'Deleted!',
                                        'Your City has been deleted.',
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
        {{-- Map --}}
        <script type="text/javascript">
            //get lat,lng from page
            var lat = $('#map_latitude').val();
            var lng = $('#map_longitude').val();

            //init google map variables
            var markers = [];
            var map;
            var myLatLng;

            //init google map function
            function initMap() {
                //set initial location
                setMapOnAll({
                    lng: parseFloat(lng),
                    lat: parseFloat(lat)
                });
                myLatLng = {
                    lng: parseFloat(lat),
                    lat: parseFloat(lng)
                };

                //create map
                map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 15,
                    center: myLatLng,
                });

                //handle map click to get new location
                map.addListener('click', function(event) {
                    clearMarkers();

                    addMarker(event.latLng);
                    //console.log(event.latLng);
                    document.getElementById("map_latitude").innerHTML = event.latLng
                        .lat(); //+ ',' + event.latLng.lng();
                });
                //add marker
                new google.maps.Marker({
                    position: myLatLng,
                    map,
                    title: "",
                });
            }

            window.initMap = initMap;

            //add marker to map
            function addMarker(location) {
                var marker = new google.maps.Marker({
                    position: location,
                    map: map
                });
                $('#map_latitude').val(location.lat);
                $('#map_longitude').val(location.lng);
                markers.push(marker);
            }

            //clear markers from map
            function clearMarkers() {
                setMapOnAll(null);
            }
            // Sets the map on all markers in the array.
            function setMapOnAll(map) {
                for (var i = 0; i < markers.length; i++) {
                    markers[i].setMap(map);

                }
            }
        </script>
        {{-- google map api key --}}
        <script type="text/javascript"
            src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap"></script>

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
                // console.log(checked);
                var updateStatusURL = $(this).data('url');
                var token = $('#_token').val();
                console.log('updateStatusURL: ', updateStatusURL);

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
                        console.log(`success: ${data}`);
                        // Swal.fire({
                        //     title: "Info",
                        //     text: checked?"Branch Activated!":"Branch Deactivated!",
                        //     icon: "info"
                        // });
                        $('.toast-body').html(`${checked?"Finance Year Activated!":"Finance Year Deactivated!"}`);
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
        <!-- Form Validation -->
        <script src="{{ asset('build/assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
    @endsection
</x-setting-layout>
