<x-app-layout>
    @section('title')
        {{ __('admin.user_management') }} | {{ __('admin.user_management_admin_edit') }}
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
            {{ __('admin.user_management_admin_edit') }}
        </h4>
        <div class="card p-3  mb-4">
            <form method="POST" class=" needs-validation" novalidate action="{{ route('admin.users_admin_update') }}"
                enctype="multipart/form-data" class="card-body">
                @csrf
                <input type="hidden" name="admin_id" value={{ $data->id }}>
                <div class="row pt-3  g-3 ">
                    <div class="col-md-6">
                        <label class="form-label"
                            for="admin_name_english">{{ __('admin.user_management_admin_english_name') }}</label>
                        <input required type="text" name="admin_name_english" id="admin_name_english"
                            class="form-control @error('admin_name_english') is-invalid @enderror"
                            value="{{ $data->getTranslation('name', 'en') }}"
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
                            value="{{ $data->getTranslation('name', 'ar') }}" />
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
                            value="{{ $data->mobile }}" />
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"
                            for="admin_email">{{ __('admin.user_management_admin_email') }}</label>
                        <input required type="email" name="admin_email" id="admin_email" class="form-control"
                            placeholder="{{ __('admin.user_management_admin_email') }}" value="{{ $data->email }}" />
                    </div>
                    {{-- <div class="col-md-4">
                        <label class="form-label"
                            for="admin_password">{{ __('admin.user_management_admin_password') }}</label>
                        <input required type="password" name="admin_password" id="admin_password"
                            class="form-control" placeholder="{{ __('admin.user_management_admin_password') }}"
                            value="{{$data->password  }}" />
                    </div> --}}
                    <div class="col-md-4">
                        <label for="user_department"
                            class="form-label">{{ __('admin.user_management_admin_department') }}</label>
                        <select name="user_department" value="{{ old('user_department') }}" required
                            class="form-select  @error('user_department') is-invalid @enderror" id="user_department"
                            aria-label="user_department select example">
                            @foreach ($departments as $department)
                            <option value="{{$department->id}}" {{$department->id == $data->department_id ? 'selected' : ''}}>{{$department->name}}</option>
                        @endforeach
                            {{-- <option selected>Open this select menu</option> --}}
                            {{-- <option value="0">{{ __('admin.no') }}</option>
                            <option value="1">{{ __('admin.yes') }}</option> --}}
                        </select>
                        @error('user_department')
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
                                <option value={{ $branch->id }}
                                    {{ $data->branch_id == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->branch_name }}</option>
                            @endforeach
                        </select>
                        @error('user_branch')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class=" col-md-4">
                        <label for="admin_status" class="form-label">{{ __('admin.status') }}</label>
                        <select name="admin_status" value="{{ old('admin_status') }}" required
                            class="form-select  @error('admin_status') is-invalid @enderror" id="admin_status"
                            aria-label="admin_status select example">
                            {{-- <option selected>Open this select menu</option> --}}
                            <option value="0" {{ $data->status == '0' ? 'selected' : '' }}>{{ __('admin.no') }}
                            </option>
                            <option value="1" {{ $data->status == '1' ? 'selected' : '' }}>{{ __('admin.yes') }}
                            </option>
                        </select>
                        @error('admin_status')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="admin_role" class="form-label">{{ __('admin.user_management_admin_role') }}</label>
                        <select id="admin_role" name="admin_role[]" value="{{ old('admin_role') }}" required
                            class="select2 form-select    @error('admin_role') is-invalid @enderror" multiple
                            data-allow-clear="true" aria-label="admin_role select example">
                            @foreach ($roles as $role)
                                <option {{ in_array($role->name, $values) ? 'selected' : '' }}>{{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('admin_role')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="user_emirate"
                            class="form-label">{{ __('admin.user_management_admin_emirate') }}</label>
                        <select name="user_emirate" value="{{ old('user_emirate') }}" required
                            class="form-select  @error('user_emirate') is-invalid @enderror" id="user_emirate"
                            aria-label="user_emirate select example">
                            @foreach ($emirates as $emirate)
                                <option value="{{ $emirate->id }}"
                                    {{ $data->emirate_id == $emirate->id ? 'selected' : '' }}>{{ $emirate->name }}
                                </option>
                            @endforeach

                        </select>
                        @error('user_emirate')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="user_city"
                            class="form-label">{{ __('admin.user_management_admin_city') }}</label>
                        <select name="user_city" value="{{ old('user_city') }}" required
                            class="form-select  @error('user_city') is-invalid @enderror" id="user_city"
                            aria-label="user_city select example">
                            @foreach ($cities as $city)
                                <option value={{ $city->id }}>{{ $city->name }}</option>
                            @endforeach
                            {{-- <option selected>Open this select menu</option> --}}
                            {{-- <option value="0">{{ __('admin.no') }}</option>
                            <option value="1">{{ __('admin.yes') }}</option> --}}
                        </select>
                        @error('user_city')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class=" col-md-4">
                        <label for="tax_include"
                            class="form-label">{{ __('admin.user_management_admin_is_sales') }}</label>
                        <select name="admin_is_sale" value="{{ $data->admin_is_sales }}" required
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
                    <div class="col-md-12">
                        <label class="form-label"
                            for="admin_address_english">{{ __('admin.user_management_admin_address_english') }}</label>
                        <input required type="text" name="admin_address_english" id="admin_address_english" required
                            class="form-control @error('admin_address_english') is-invalid @enderror"
                            value="{{ $data->address }}"
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
                        <input type="text" name="admin_desc" id="admin_desc" required
                            class="form-control  @error('admin_desc') is-invalid @enderror"
                            placeholder="{{ __('admin.user_management_admin_desc') }}"
                            value="{{ $data->description }}" />
                        @error('admin_desc')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        {{-- <div class="valid-feedback"> Looks good! </div>
                        <div class="invalid-feedback"> Please enter your name. </div> --}}
                    </div>
                    <div class="col-md-4">
                        <div class="avatar avatar-xl mb-3">
                            <img id="avatar" src="{{ asset('build/assets/img/uploads/avatars/' . $data->photo) }}"
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

                        <a href="{{ route('admin.users_admin_index') }}"
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
        {{-- <script
            src="https://maps.googleapis.com/maps/api/js?key={{ $maps->server_key}}&callback=initMap&libraries=places&v=weekly"
            defer>
        </script> --}}
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
        {{-- //sweet alert --}}
        {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script src="sweetalert2.all.min.js"></script>
     <script src="sweetalert2.min.js"></script>
     <link rel="stylesheet" href="sweetalert2.min.css"> --}}
    @endsection
</x-app-layout>
