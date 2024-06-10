<x-setting-layout>
    @section('title')
    {{ __('admin.branch_branch_manager') }} / {{ __('admin.branch_add_branch') }}
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
            {{ __('admin.branch_branch_edit') }}
        </h4>
        <div class="card p-3  mb-4">
            <form method="POST"  action="{{ route('admin.branch_update') }}"   enctype="multipart/form-data"
                class="card-body needs-validation" novalidate>
                @csrf
                <input type="hidden" value="{{ $data->id }}" name="id">
                <div class="row pt-3  g-3 ">
                    <div class="col-md-6">
                        <label class="form-label" for="branch_english_name">{{ __('admin.branch_branch_english_name')
                            }}</label>
                        <input required  type="text" name="branch_english_name" id="branch_english_name"
                            class="form-control @error('branch_english_name') is-invalid @enderror"
                            value="{{ $data->getTranslation('branch_name', 'en')  }}"
                            placeholder="{{ __('admin.branch_branch_english_name') }}" />
                        @error('branch_english_name')
                        <div class="alert alert-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="branch_arabic_name">{{ __('admin.branch_branch_arabic_name')
                            }}</label>
                        <input  type="text" name="branch_arabic_name" id="branch_arabic_name"
                            class="form-control  @error('branch_arabic_name') is-invalid @enderror"
                            placeholder="{{ __('admin.branch_branch_arabic_name') }}"
                            value="{{$data->getTranslation('branch_name', 'ar') }}" />
                        @error('branch_arabic_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label class="form-label" for="branch_english_address">{{ __('admin.branch_english_address')
                            }}</label>
                        <input  type="text" name="branch_english_address" id="branch_english_address"
                            class="form-control" placeholder="{{ __('admin.branch_english_address') }}"
                            value="{{ $data->getTranslation('branch_address', 'en') }}" />
                    </div>
                    <div class="col-md-12">
                        <label class="form-label" for="branch_arabic_address">{{ __('admin.branch_arabic_address')
                            }}</label>
                        <input  type="text" name="branch_arabic_address" id="branch_arabic_address" class="form-control"
                            placeholder="{{ __('admin.branch_arabic_address') }}"
                            value="{{ $data->getTranslation('branch_address', 'ar')  }}" />
                    </div>
                </div>
                <hr class="my-4 mx-n4" />
                <div class="row  g-3">
                    <div class="col-md-6">
                        <div class="row mb-3 g-3">
                            <div class=" col-md-6">
                                <label for="landline" class="form-label">{{ __('admin.landline') }}</label>
                                <input  type="text" id="landline" name="landline"
                                    class="form-control  @error('landline') is-invalid @enderror"
                                    placeholder="{{ __('admin.landline') }}" value="{{ $data->branch_landline  }}"
                                    aria-label="{{ __('admin.landline') }}" />
                                @error('landline')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class=" col-md-6">
                                <label for="mobile" class="form-label">{{ __('admin.mobile') }}</label>
                                <input  type="text" id="mobile" name="mobile"
                                    class="form-control  @error('mobile') is-invalid @enderror"
                                    value="{{ $data->branch_mobile  }}" placeholder="{{ __('admin.setting_mobile') }}"
                                    aria-label="{{ __('admin.setting_mobile') }}" />
                                @error('mobile')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class=" col-md-6">
                                <label for="email" class="form-label">{{ __('admin.email') }}</label>
                                <input  type="email" value="{{ $data->branch_email  }}" id="email" name="email"
                                    class="form-control  @error('email') is-invalid @enderror"
                                    placeholder="{{ __('admin.email') }}" aria-label="{{ __('admin.email') }}" />
                                @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="postal_code" class="form-label">{{ __('admin.postal_code') }}</label>
                                <input  type="number" id="postal_code" value="{{ $data->branch_postal_code  }}"
                                    name="postal_code" class="form-control  @error('postal_code') is-invalid @enderror"
                                    placeholder="{{ __('admin.postal_code') }}"
                                    aria-label="{{ __('admin.postal_code') }}" />
                                @error('postal_code')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="  col-md-6">
                                <label for="emirates" class="form-label">{{ __('admin.emirates_list') }}</label>
                                <select class="form-select   @error('emirates') is-invalid @enderror"
                                    value="{{ $data->emirates_id }}" id="emirates" name="emirates" class="custom-select ">
                                    @foreach ($data->emirates as $emirate)
                                    <option value="{{ $emirate->id }}">{{ $emirate->name }}</option>
                                    @endforeach
                                </select>
                                @error('emirates')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class=" col-md-6">
                                <label for="branch_percentage" class="form-label">{{ __('admin.branch_percentage')
                                    }}</label>
                                <select name="branch_percentage" value="{{ $data->percentage }}"
                                    class="form-select  @error('branch_percentage') is-invalid @enderror"
                                    id="branch_percentage" aria-label="branch_percentage select example">
                                    {{-- <option selected>Open this select menu</option> --}}
                                    <option value="0">{{ __('admin.no') }}</option>
                                    <option value="1">{{ __('admin.yes') }}</option>
                                </select>
                                @error('branch_percentage')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="branch_status" class="form-label">{{ __('admin.status') }}</label>
                                <select name="branch_status" value="{{ $data->status }}"
                                    class="form-select  @error('branch_status') is-invalid @enderror" id="branch_status"
                                    aria-label="branch_status select example">
                                    {{-- <option selected>Open this select menu</option> --}}
                                    <option value="0">{{ __('admin.active') }}</option>
                                    <option value="1">{{ __('admin.deactivate') }}</option>
                                </select>
                                @error('branch_status')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class=" col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="tax_include" class="form-label">{{ __('admin.in') }}</label>
                                        <input  type="number" value="{{ $data->percentage_in }}" id="percentage_in"
                                            name="percentage_in"
                                            class="form-control  @error('percentage_in') is-invalid @enderror"
                                            placeholder="{{ __('admin.in') }}" aria-label="{{ __('admin.in') }}" />
                                        @error('percentage_in')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class=" col-md-6">
                                        <label for="tax_include" class="form-label">{{ __('admin.out') }}</label>
                                        <input  type="number" value="{{ $data->percentage_out}}" id="percentage_out"
                                            name="percentage_out"
                                            class="form-control  @error('percentage_out') is-invalid @enderror"
                                            placeholder="{{ __('admin.out') }}" aria-label="{{ __('admin.out') }}" />
                                        @error('percentage_out')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label" for="map_longitude">{{ __('admin.setting_map_longitude')
                                    }}</label>
                                <input  type="text" id="map_longitude" value="{{ $data->longitude }}"
                                    class="form-control  @error('map_longitude') is-invalid @enderror"
                                    name="map_longitude"
                                    {{-- value="25.405216" --}}
                                    placeholder="{{ __('admin.setting_map_longitude') }}" />
                                @error('map_longitude')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="map_latitude">{{ __('admin.setting_map_latitude')
                                    }}</label>
                                <input  type="text" value="{{ $data->latitude  }}" id="map_latitude"
                                    class="form-control  @error('map_latitude') is-invalid @enderror"
                                    name="map_latitude"
                                    {{-- value="55.513641" --}}
                                    placeholder="{{ __('admin.setting_map_latitude') }}" />
                                @error('map_latitude')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="is_main" class="form-label">{{ __('admin.branch_branch_is_main') }}</label>
                                <select name="is_main" value="{{ old('is_main') }}"
                                    class="form-select  @error('is_main') is-invalid @enderror" id="is_main"
                                    aria-label="is_main select example">
                                    {{-- <option selected>Open this select menu</option> --}}
                                    <option value="0">{{ __('admin.no') }}</option>
                                    <option value="1">{{ __('admin.yes') }}</option>
                                </select>
                                @error('is_main')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">

                        <div class="col-12">
                            <label class="form-label" for="multicol-first-name">{{ __('admin.location') }}</label>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <input
                                        id="pac-input"
                                        class="form-control"
                                        type="text"
                                        placeholder="Search Box"
                                        style="width: 300px; margin-top: 10px"
                                    />
                                    <div style="height: 310px !important" id="map"></div>
                                    {{-- <button name="locationButton">aaa</button> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 row">
                        <div class="col-1">
                            <button  id='submit' type="submit" class="btn btn-primary d-flex justify-content-between">
                                <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true">
                                </span> <div class="ml-2">{{ __('admin.submit') }}</div>
                            </button>
                        </div>
                        <div class="col-1">

                            <a href="{{ route('admin.branch_index') }}" class="btn btn-label-danger">{{ __('admin.back')
                                }}</a>

                        </div>
                    </div>

            </form>
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
                //event.preventDefault()
                event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
            })
        })()
    </script>
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

            function addAddressBar(){

                // Create the search box and link it to the UI element.
                const input = document.getElementById("pac-input");
                const searchBox = new google.maps.places.SearchBox(input);

                map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                // Bias the SearchBox results towards current map's viewport.
                map.addListener("bounds_changed", () => {
                    console.log('noooo');
                   // event.preventDefault();
                    searchBox.setBounds(map.getBounds());
                });

                let markers = [];
                // Listen for the event fired when the user selects a prediction and retrieve
                // more details for that place.
                searchBox.addListener("places_changed", () => {
                    console.log('noooo2');
                    const places = searchBox.getPlaces();

                    if (places.length == 0) {
                    return;
                    }

                    // Clear out the old markers.
                    markers.forEach((marker) => {
                    marker.setMap(null);
                    });
                    markers = [];

                    // For each place, get the icon, name and location.
                    const bounds = new google.maps.LatLngBounds();

                    places.forEach((place) => {
                    if (!place.geometry || !place.geometry.location) {
                        console.log("Returned place contains no geometry");
                        return;
                    }

                    const icon = {
                        //url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25),
                    };

                    // Create a marker for each place.
                    markers.push(
                        new google.maps.Marker({
                        map,
                        icon,
                        title: place.name,
                        position: place.geometry.location,
                        }),
                    );
                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                    });
                    map.fitBounds(bounds);
                });
            }

            function addYourLocationButton(map, marker)
            {
                var controlDiv = document.createElement('div');

                var firstChild = document.createElement('button');
                firstChild.style.backgroundColor = '#fff';
                firstChild.style.border = 'none';
                firstChild.style.outline = 'none';
                firstChild.style.width = '28px';
                firstChild.style.height = '28px';
                firstChild.style.borderRadius = '2px';
                firstChild.style.boxShadow = '0 1px 4px rgba(0,0,0,0.3)';
                firstChild.style.cursor = 'pointer';
                firstChild.style.marginRight = '10px';
                firstChild.style.padding = '0px';
                firstChild.title = 'Your Location';
                controlDiv.appendChild(firstChild);

                var secondChild = document.createElement('div');
                secondChild.style.margin = '5px';
                secondChild.style.width = '18px';
                secondChild.style.height = '18px';
                secondChild.style.backgroundImage = 'url(https://maps.gstatic.com/tactile/mylocation/mylocation-sprite-1x.png)';
                secondChild.style.backgroundSize = '180px 18px';
                secondChild.style.backgroundPosition = '0px 0px';
                secondChild.style.backgroundRepeat = 'no-repeat';
                secondChild.id = 'you_location_img';
                firstChild.appendChild(secondChild);

                google.maps.event.addListener(map, 'dragend', function() {
                    $('#you_location_img').css('background-position', '0px 0px');
                });

                firstChild.addEventListener('click', function() {
                    event.preventDefault();
                    var imgX = '0';
                    var animationInterval = setInterval(function(){
                        if(imgX == '-18') imgX = '0';
                        else imgX = '-18';
                        $('#you_location_img').css('background-position', imgX+'px 0px');
                    }, 500);
                    if(navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                            marker.setPosition=latlng;
                            map.setCenter(latlng);
                            clearInterval(animationInterval);
                            $('#you_location_img').css('background-position', '-144px 0px');
                        });
                    }
                    else{
                        clearInterval(animationInterval);
                        $('#you_location_img').css('background-position', '0px 0px');
                    }
                });

                controlDiv.index = 1;
                map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(controlDiv);
            }
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
                 map.addListener('click', function(event) {
                    clearMarkers();
                    addMarker(event.latLng);
                    console.log(event.latLng);
                    document.getElementById("map_latitude").innerHTML = event.latLng
                        .lat(); //+ ',' + event.latLng.lng();
                });
                new google.maps.Marker({
                    position: myLatLng,
                    map,
                    title: "",
                });
                addYourLocationButton(map, myLatLng);
                addAddressBar();

            }

            window.initMap = initMap;

            function addMarker(location) {
                var marker = new google.maps.Marker({
                    position: location,
                    map: map
                });

                $('#map_latitude').val(location.lat().toFixed(6));
                $('#map_longitude').val(location.lng().toFixed(6));
                //console.log(location.lat().toFixed(6));
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
    {{-- <script type="text/javascript"
        src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap"></script> --}}
        <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap&libraries=places&v=weekly"
        defer
      ></script>
    <script type="text/javascript"
        src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap"></script>


    <script>
        $(document).ready(function() {
                $(document).on('submit', 'form', function() {
                    $('button').attr('disabled', 'disabled');
                    $(".spinner-border").removeClass("d-none").addClass('mr-2');
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
