<x-app-layout>
    @section('title')
        {{ __('admin.vendors_management') }} | {{ __('admin.vendors_companies_add_company') }}
    @endsection
    @section('VendorsCss')
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/select2/select2.css') }}" />
        {{-- select2 --}}
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @endsection
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light"> {{ __('admin.vendors_management') }} / </span>
            {{ __('admin.vendors_companies_add_company') }}
        </h4>
        <div class="card p-3  mb-4">
            <form method="POST" class=" needs-validation" novalidate
                action="{{ route('admin.vendors_company_store') }}" enctype="multipart/form-data" class="card-body">
                @csrf
                <div class="row pt-3  g-3 ">

                    <div class="col-md-6">
                        <label class="form-label"
                            for="branch_english_name">{{ __('admin.vendors_companies_company_english_name') }}</label>
                        <input required type="text" name="name_en" id="name_en"
                            class="form-control @error('name_en') is-invalid @enderror" value="{{ old('name_en') }}"
                            placeholder="{{ __('admin.vendors_companies_company_english_name') }}" />
                        @error('name_en')
                            <div class="alert alert-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"
                            for="branch_arabic_name">{{ __('admin.vendors_companies_company_arabic_name') }}</label>
                        <input required type="text" name="name_ar" id="name_ar"
                            class="form-control  @error('name_ar') is-invalid @enderror"
                            placeholder="{{ __('admin.vendors_companies_company_arabic_name') }}"
                            value="{{ old('name_ar') }}" />
                        @error('name_ar')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label" for="branch_english_address">{{ __('admin.delivery_fees') }}</label>
                        <input required type="text" name="vendor_rate" id="vendor_rate" class="form-control"
                            placeholder="{{ __('admin.vendors_companies_company_vendor_rate') }}"
                            value="{{ old('vendor_rate') }}" />
                        @error('vendor_rate')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- <div class="col-md-3">
                        <label class="form-label"
                            for="branch_english_address">{{ __('admin.vendors_companies_company_customer_rate') }}</label>
                        <input required type="text" name="customer_rate" id="customer_rate" class="form-control"
                            placeholder="{{ __('admin.vendors_companies_company_customer_rate') }}"
                            value="{{ old('customer_rate') }}" />
                        @error('customer_rate')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div> --}}
                    <div class="col-md-3">
                        <label class="form-label"
                            for="branch_english_address">{{ __('admin.vendors_companies_company_sales') }}</label>

                        <select name="sales_id" id="sales_id" class="js-example-basic-multiple form-control">
                            <option value="" selected>{{ __('admin.please_select') }}</option>
                            @foreach ($sales as $sale)
                                <option value="{{ $sale->id }}">{{ $sale->name }}</option>
                            @endforeach

                        </select>
                        @error('sales_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col">
                        <label class="form-label" for="branch_id">{{ __('admin.branch_branch_name') }}</label>
                        <select class="js-example-basic-single" name="branch_id" id="branch_id" required>
                            <option>{{ __('admin.please_select') }}</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}" {{old('branch_id') == $branch->id ? 'selected' : ''}}>{{ $branch->branch_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr class="my-4 mx-n4" />

                <div class="row  g-3">
                    <div class="col-md-6">
                        <label class="form-label"
                            for="branch_english_address">{{ __('admin.vendors_companies_company_emirate') }}</label>

                        <select name="emirate_id" id="emirate_id" class="js-example-basic-single form-control" required>
                            <option value="{{ old('emirate_id') }}" disabled selected>{{ __('admin.please_select') }}
                            </option>
                            @foreach ($emirates as $emirate)
                                <option value="{{ $emirate->id }}" {{old('emirate_id') == $emirate->id ? 'selected' : ''}}>{{ $emirate->name }}</option>
                            @endforeach
                        </select>
                        @error('emirate_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"
                            for="branch_english_address">{{ __('admin.vendors_companies_company_city') }}</label>

                        <select name="city_id" id="city_id" class="js-example-basic-single form-select" required>
                            <option value="">{{ __('admin.please_select') }}</option>

                        </select>
                        @error('city_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"
                            for="address_en">{{ __('admin.vendors_companies_company_english_address') }}</label>

                        <input required type="text" name="address_en" id="address_en" class="form-control"
                            placeholder="{{ __('admin.vendors_companies_company_english_address') }}"
                            value="{{ old('address_en') }}" required />
                        @error('address_en')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"
                            for="address_ar">{{ __('admin.vendors_companies_company_arabic_address') }}</label>

                        <input required type="text" name="address_ar" id="address_ar" class="form-control" required
                            placeholder="{{ __('admin.vendors_companies_company_arabic_address') }}"
                            value="{{ old('address_ar') }}" />
                        @error('address_ar')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label class="form-label" for="phone_number">{{ __('admin.landline') }}</label>
                        <input type="text" name="phone_number" class="form-control phone" id="phone_number">
                    </div>
                    <div class="col">
                        <label class="form-label" for="mobile_number">{{ __('admin.mobile') }}</label>
                        <input type="text" name="mobile_number" class="form-control phone" id="mobile_number">

                    </div>
                </div>

                <hr class="my-4 mx-n4" />

                <div class="row  g-3">
                    <div class="col-md-6">
                        <div class="row mb-3 g-3">
                            <div class=" col-md-12">
                                <label for="landline"
                                    class="form-label">{{ __('admin.vendors_companies_company_description') }}</label>
                                <input required type="text" id="description" name="description" required
                                    class="form-control  @error('description') is-invalid @enderror"
                                    placeholder="{{ __('admin.vendors_companies_company_description') }}"
                                    value="{{ old('description') }}"
                                    aria-label="{{ __('admin.vendors_companies_company_description') }}" />
                                @error('description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-md-4">
                                <label for="is_main" class="form-label">{{ __('admin.status') }}</label>
                                <select name="status" value="{{ old('status') }}"
                                    class="form-select  @error('status') is-invalid @enderror" id="status"
                                    aria-label="is_main select example">
                                    <option value="1">{{ __('admin.active') }}</option>
                                    <option value="0">{{ __('admin.deactivate') }}</option>
                                </select>
                                @error('status')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="is_main"
                                    class="form-label">{{ __('admin.vendors_companies_company_has_stock') }}</label>
                                <select name="has_stock" value="{{ old('has_stock') }}"
                                    class="form-select  @error('has_stock') is-invalid @enderror" id="has_stock"
                                    aria-label="is_main select example">
                                    <option value="0">{{ __('admin.no') }}</option>
                                    <option value="1">{{ __('admin.yes') }}</option>
                                </select>
                                @error('has_stock')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="is_main"
                                    class="form-label">{{ __('admin.vendors_companies_company_has_api') }}</label>
                                <select name="has_api" value="{{ old('has_api') }}"
                                    class="form-select  @error('has_api') is-invalid @enderror" id="has_api"
                                    aria-label="is_main select example">
                                    <option value="0">{{ __('admin.no') }}</option>
                                    <option value="1">{{ __('admin.yes') }}</option>
                                </select>
                                @error('has_api')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label"
                                    for="map_longitude">{{ __('admin.setting_map_longitude') }}</label>
                                <input required type="text" id="map_longitude" value="{{ old('map_longitude') }}"
                                    class="form-control  @error('map_longitude') is-invalid @enderror"
                                    name="map_longitude" {{-- value="25.405216" --}}
                                    placeholder="{{ __('admin.setting_map_longitude') }}" />
                                @error('map_longitude')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"
                                    for="map_latitude">{{ __('admin.setting_map_latitude') }}</label>
                                <input required type="text" value="{{ old('map_latitude') }}" id="map_latitude"
                                    class="form-control  @error('map_latitude') is-invalid @enderror"
                                    name="map_latitude" {{-- value="55.513641" --}}
                                    placeholder="{{ __('admin.setting_map_latitude') }}" />
                                @error('map_latitude')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 my-4">
                            <div class="avatar avatar-xl mb-3">
                                <img id="avatar" src="{{ asset('build/assets/img/avatars/1.png') }}"
                                    alt="{{ __('admin.user_management_admin_avatar') }}">
                            </div>
                            <label for="logo"
                                class="form-label">{{ __('admin.user_management_admin_avatar') }}</label>
                            <input class="form-control @error('logo') is-invalid @enderror" name="logo"
                                type="file" id="logo"
                                onchange="document.getElementById('avatar').src=window.URL.createObjectURL(this.files[0])">
                            @error('logo')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">

                        <div class="col-12">
                            <label class="form-label" for="multicol-first-name">{{ __('admin.location') }}</label>
                            <div class="card mb-4">
                                {{-- //<div class="card-header"> --}}
                                <input id="pac-input" class="form-control" type="text" placeholder="Search Box"
                                    style="width: 300px; margin-top: 10px" />
                                {{-- //</div> --}}

                                <div class="card-body">
                                    {{-- <input type="hidden" id="map_key" value="{{ $data->server_key }}"/> --}}
                                    <div style="height: 310px !important" id="map"></div>
                                    {{-- <button name="locationButton">aaa</button> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row my-4">
                        <label for="vendor"
                            class="form-label">{{ __('admin.vendors_companies_company_owner_name') }}</label>
                        <select class="js-example-basic-single" name="vendor">
                            <option value="">{{ __('admin.please_select') }}</option>
                            @foreach ($vendors as $vendor)
                                <option value="{{ $vendor->id }}" {{ old('vendor') == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <hr>

                    <div class="row">
                        <h3 class="my-4">{{ __('admin.bank_accounts') }}</h3>
                        <div id="bankFields">
                            <div class="row mb-3 bank-entry">
                                <div class="col-md-5">
                                    <label for="bank_name" class="form-label">{{ __('admin.bank_name') }}</label>
                                    <select name="banks_name[]" id="bank_name" class="js-example-basic-single">
                                        <option value="">{{ __('admin.please_select') }}</option>
                                        @foreach ($banks as $bank)
                                            <option value="{{ $bank->id }}">{{ $bank->name_bank }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label for="bank_name" class="form-label">IBAN</label>
                                    <input type="text" name="ibans[]" class="form-control" placeholder="IBAN">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-success" onclick="addBankField()">Add
                                        Bank</button>
                                </div>
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

                            <a href="{{ route('admin.vendors_company_index') }}"
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
        {{-- Map --}}
        <script type="text/javascript">
            var lng = 55.513641;
            $('#map_latitude').val(lat);
            var lat = 25.405216;
            $('#map_longitude').val(lng);

            var markers = [];
            var map;
            var myLatLng;

            function addAddressBar() {

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

            function addYourLocationButton(map, marker) {
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
                    var animationInterval = setInterval(function() {
                        if (imgX == '-18') imgX = '0';
                        else imgX = '-18';
                        $('#you_location_img').css('background-position', imgX + 'px 0px');
                    }, 500);
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            var latlng = new google.maps.LatLng(position.coords.latitude, position.coords
                                .longitude);
                            marker.setPosition = latlng;
                            addMarker(latlng);
                            map.setCenter(latlng);
                            clearInterval(animationInterval);
                            $('#you_location_img').css('background-position', '-144px 0px');
                        });
                    } else {
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
                    lng: parseFloat(lng),
                    lat: parseFloat(lat)
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
            src="https://maps.googleapis.com/maps/api/js?key={{ $maps->server_key ?? '' }}&callback=initMap&libraries=places&v=weekly"
            defer></script>


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
                        } else if (field.value != passwordField.value) {
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
                        if (errorIcon) {
                            errorIcon.classList.add('hidden')
                        }
                        if (errorMessage) {
                            errorMessage.innerText = ""
                        }
                        successIcon.classList.remove('hidden')
                        field.classList.remove('input-error')
                    }

                    if (status === "error") {
                        if (successIcon) {
                            successIcon.classList.add('hidden')
                        }
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

        <script>
            $(document).ready(function() {
                $('.js-example-basic-multiple').select2();
                $('.js-example-basic-single').select2();
            });
        </script>
        <script>
            $(document).on('change', '#emirate_id', function() {
                var id = $(this).val();
                $('#city_id').empty();
                $.ajax({
                    type: 'GET',
                    url: '{{ route('admin.vendors_company_get_cities') }}',
                    data: {
                        id: id
                    },
                    success: function(res) {
                        console.log(res);
                        $.each(res, function(k, v) {
                            @if (LaravelLocalization::getCurrentLocale() == 'ar')
                                $('#city_id').append("<option value=" + v.id + " >" + v.name.ar +
                                    "<option>");
                            @else
                                $('#city_id').append("<option value=" + v.id + " >" + v.name.en +
                                    "<option>");
                            @endif
                        });
                    },
                    error: function(error) {

                    }
                });
            })
        </script>
        <script>
            function addBankField() {
                const bankFields = document.getElementById('bankFields');
                const newEntry = document.createElement('div');
                newEntry.classList.add('row', 'mb-3', 'bank-entry');
                newEntry.innerHTML = `
        <div class="col-md-5">
            <label for="bank_name" class="form-label">{{ __('admin.bank_name') }}</label>
            <select name="banks_name[]" class="js-example-basic-single">
                <option value="">{{ __('admin.please_select') }}</option>
                @foreach ($banks as $bank)
                    <option value="{{ $bank->id }}">{{ $bank->name_bank }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-5">
            <label for="iban" class="form-label">IBAN</label>
            <input type="text" name="ibans[]" class="form-control" placeholder="IBAN" required>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger" onclick="removeBankField(this)">Remove</button>
        </div>
        `;
                bankFields.appendChild(newEntry);

                // Initialize Select2 only on the newly added select element
                $(newEntry).find('.js-example-basic-single').select2();
            }

            function removeBankField(button) {
                const bankEntry = button.closest('.bank-entry');
                bankEntry.remove();
            }
        </script>
    @endsection
</x-app-layout>
