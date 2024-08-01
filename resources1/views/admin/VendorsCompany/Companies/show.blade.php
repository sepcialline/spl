<x-setting-layout>
    @section('title')
    {{ __('admin.branch_branch_manager') }} / {{ __('admin.branch_branch_show') }}
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
            <span class="text-muted fw-light"> {{ __('admin.branch_branch_manager') }} / </span>
            {{ __('admin.branch_branch_show') }}
            <span class="badge rounded-pill bg-label-primary">{{ $data->is_main?'Main Branch':'' }}</span>
        </h4>
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">


              <!-- Layout container -->
              <div class="layout-page">
                <!-- Navbar -->





                <!-- Content wrapper -->
                <div class="content-wrapper">
                  <!-- Content -->

                  <div class="container-xxl flex-grow-1 container-p-y">






                    <!-- User Profile Content -->
                    <div class="row">
                      <div class="col-xl-4 col-lg-5 col-md-5">
                        <!-- About User -->
                        <div class="card mb-4">
                          <div class="card-body">
                            <small class="text-muted text-uppercase">{{ __('admin.branch_show_about') }}</small>
                            <ul class="list-unstyled mb-4 mt-3">
                              <li class="d-flex align-items-center mb-3">
                                <span class="fw-semibold mx-2">{{ __('admin.branch_branch_english_name') }}:</span>
                                <span>{{ $data->getTranslation('branch_name','en') }}</span>
                              </li>
                              <li class="d-flex align-items-center mb-3">
                                <span class="fw-semibold mx-2">{{ __('admin.branch_branch_arabic_name') }}:</span>
                                <span>{{ $data->getTranslation('branch_name','ar') }}</span>
                              </li>
                              <li class="d-flex align-items-center mb-3">
                                <span class="fw-semibold mx-2">{{ __('admin.branch_branch_status') }}:</span> <span class="{{ !$data->status ? 'badge rounded-pill bg-label-danger' : 'badge rounded-pill bg-label-success' }}">{{ $data->status?'Active':'Not Active' }}</span>
                              </li>
                              <li class="d-flex align-items-center mb-3">
                                <span class="fw-semibold mx-2">{{ __('admin.branch_english_address') }}:</span> <span>{{ $data->getTranslation('branch_address','en') }}</span>
                              </li>
                              <li class="d-flex align-items-center mb-3">
                                <span class="fw-semibold mx-2">{{ __('admin.branch_arabic_address') }}:</span> <span>{{ $data->getTranslation('branch_address','ar') }}</span>
                              </li>

                            </ul>
                            <small class="text-muted text-uppercase">Contacts</small>
                            <ul class="list-unstyled mb-4 mt-3">
                              <li class="d-flex align-items-center mb-3">
                                <span class="fw-semibold mx-2">{{ __('admin.landline') }}:</span>
                                <span>{{ $data->branch_landline }}</span>
                              </li>
                              <li class="d-flex align-items-center mb-3">
                                <span class="fw-semibold mx-2">{{ __('admin.mobile') }}:</span> <span>{{ $data->branch_mobile }}</span>
                              </li>
                              <li class="d-flex align-items-center mb-3">
                                <span class="fw-semibold mx-2">{{ __('admin.email') }}:</span>
                                <span>{{ $data->branch_email }}</span>
                              </li>
                            </ul>

                          </div>
                        </div>
                        <!--/ About User -->
                        <!-- Profile Overview -->
                        <div class="card mb-4">
                          <div class="card-body">
                            <small class="text-muted text-uppercase">{{ __('admin.branch_branch_percentage') }} %</small>
                            <ul class="list-unstyled mt-3 mb-0">
                              <li class="d-flex align-items-center mb-3">
                               <span class="fw-semibold mx-2">{{ __('admin.branch_branch_status') }}:</span>
                                <span class="{{ !$data->percentage ? 'badge rounded-pill bg-label-danger' : 'badge rounded-pill bg-label-success' }}">{{ $data->percentage?__('admin.yes') :__('admin.no') }}</span>
                              </li>
                              <li class="d-flex align-items-center mb-3">
                                <span class="fw-semibold mx-2">{{ __('admin.branch_branch_percentage_in') }}:</span>
                                <span>{{ $data ->percentage_in }}%</span>
                              </li>
                              <li class="d-flex align-items-center">
                                <span class="fw-semibold mx-2">{{ __('admin.branch_branch_percentage_out') }}:</span> <span>{{ $data ->percentage_out }}%</span>
                              </li>
                            </ul>
                          </div>
                        </div>
                        <!--/ Profile Overview -->
                      </div>

                    </div>
                    <!--/ User Profile Content -->
                  </div>
                  <!-- / Content -->



                  <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
              </div>
              <!-- / Layout page -->
            </div>


          </div>




    </div>
    <!-- / Content -->
    @section('VendorsJS')
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
    {{-- Map --}}
    <script type="text/javascript">
        var lat = 55.513641;
            $('#map_latitude').val(lat);
            var lng = 25.405216;
            $('#map_longitude').val(lng);

            var markers = [];
            var map;
            var myLatLng;

            function initMap() {

                //setMapOnAll({lng:parseFloat(lng), lat:parseFloat(lat)});
                console.log(lat);
                console.log(lng);
                //console.log(lng)

                myLatLng = {
                    lng: parseFloat(lat),
                    lat: parseFloat(lng)
                };
                //console.log(myLatLng)
                map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 15,
                    center: myLatLng,
                });
                var locationButton = document.createElement("button");

                    // locationButton.textContent = "Pan to Current Location";
                    //  locationButton.classList.add("custom-map-control-button");
                    // map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);
                // map.addListener('click', function(event) {
                //     clearMarkers();
                //     addMarker(event.latLng);
                //     //console.log(event.latLng);
                //     document.getElementById("map_latitude").innerHTML = event.latLng
                //         .lat(); //+ ',' + event.latLng.lng();
                // });
                new google.maps.Marker({
                    position: myLatLng,
                    map,
                    title: "",
                });
                // locationButton.addEventListener("click", () => {
                // // Try HTML5 geolocation.
                // if (navigator.geolocation) {
                //     navigator.geolocation.getCurrentPosition(
                //         (position) => {
                //         const pos = {
                //             lat: position.coords.latitude,
                //             lng: position.coords.longitude,
                //         };

                //         // infoWindow.setPosition(pos);
                //         // infoWindow.setContent("Location found.");
                //         // infoWindow.open(map);
                //         map.setCenter(pos);
                //         },
                //         () => {
                //         handleLocationError(true, infoWindow, map.getCenter());
                //         },
                //     );
                // } else {
                //     // Browser doesn't support Geolocation
                //     handleLocationError(false, infoWindow, map.getCenter());
                // }
                // });

            }

            window.initMap = initMap;

            function addMarker(location) {
                var marker = new google.maps.Marker({
                    position: location,
                    map: map
                });

                $('#map_latitude').val(location.lat().toFixed(6));
                $('#map_longitude').val(location.lng().toFixed(6));
                console.log(location.lat().toFixed(6));
                markers.push(marker);
            }

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
    <script type="text/javascript"
        src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap"></script>


    <script>
        $(document).ready(function() {
                $(document).on('submit', 'form', function() {
                    $('button').attr('disabled', 'disabled');
                    $(".spinner-border").removeClass("d-none");
                });
            });
    </script>
    <script>
        class FormValidator {
  constructor(form, fields) {
    this.form = form
    this.fields = fields
  }

  initialize() {
    this.validateOnEntry()
    this.validateOnSubmit()
  }

  validateOnSubmit() {
    let self = this

    this.form.addEventListener('submit', e => {
	    e.preventDefault()
	    self.fields.forEach(field => {
        const input = document.querySelector(`#${field}`)
        self.validateFields(input)
      })
    })
  }

  validateOnEntry() {
    let self = this
    this.fields.forEach(field => {
      const input = document.querySelector(`#${field}`)

      input.addEventListener('input', event => {
        self.validateFields(input)
      })
    })
  }

  validateFields(field) {

    // Check presence of values
    if (field.value.trim() === "") {
      this.setStatus(field, `${field.previousElementSibling.innerText} cannot be blank`, "error")
    } else {
      this.setStatus(field, null, "success")
    }

    // check for a valid email address
    if (field.type === "email") {
      const re = /\S+@\S+\.\S+/
      if (re.test(field.value)) {
        this.setStatus(field, null, "success")
      } else {
        this.setStatus(field, "Please enter valid email address", "error")
      }
    }

    // Password confirmation edge case
    if (field.id === "password_confirmation") {
      const passwordField = this.form.querySelector('#password')

      if (field.value.trim() == "") {
        this.setStatus(field, "Password confirmation required", "error")
      } else if (field.value != passwordField.value)  {
        this.setStatus(field, "Password does not match", "error")
      } else {
        this.setStatus(field, null, "success")
      }
    }
  }

  setStatus(field, message, status) {
    const successIcon = field.parentElement.querySelector('.icon-success')
    const errorIcon = field.parentElement.querySelector('.icon-error')
    const errorMessage = field.parentElement.querySelector('.error-message')

    if (status === "success") {
      if (errorIcon) { errorIcon.classList.add('hidden') }
      if (errorMessage) { errorMessage.innerText = "" }
      successIcon.classList.remove('hidden')
      field.classList.remove('input-error')
    }

    if (status === "error") {
      if (successIcon) { successIcon.classList.add('hidden') }
      field.parentElement.querySelector('.error-message').innerText = message
      errorIcon.classList.remove('hidden')
      field.classList.add('input-error')
    }
  }
}

const form = document.querySelector('.form')
const fields = ["username", "email", "password", "password_confirmation"]

const validator = new FormValidator(form, fields)
validator.initialize()
    </script>
     {{-- //sweet alert --}}
     {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script src="sweetalert2.all.min.js"></script>
     <script src="sweetalert2.min.js"></script>
     <link rel="stylesheet" href="sweetalert2.min.css"> --}}

    @endsection
</x-setting-layout>
