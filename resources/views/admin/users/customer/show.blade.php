<x-app-layout>
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

    <section style="background-color: #eee;">
        <div class="container py-5">

            <input type="hidden" class="_token" id="_token" value="{{ csrf_token() }}" />
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            @if ($data->image)
                                <img src="{{ asset('build/assets/img/uploads/avatars/' . $data->image) }}"
                                    alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                            @else
                                <img src="{{ asset('build/assets/img/uploads/avatars/1.png') }}" alt="avatar"
                                    class="rounded-circle img-fluid" style="width: 150px;">
                            @endif
                            <h5 class="my-3">{{ $data->name }}</h5>
                            <p class="text-muted mb-1">{{ $data->emirate->name }}
                                :{{ $data->city_id ?? __('admin.not_assigned') }} </p>
                            {{-- <span class="badge rounded-pill bg-label-primary">{{ $role[0]->name }}</span> --}}
                        </div>
                        <div class="d-flex justify-content-around mb-4">
                            {{-- <a href="edit/{{ $data['id'] }}"
                        class="btn btn-label-dark">{{ __('admin.branch_action_edit') }}</a>
                    <a  data-url="{{ route('admin.users_rider_destroy', $data['id']) }}"
                        class="btn btn-label-danger delete">{{ __('admin.branch_action_delete') }}</a>
                    <a href="{{ $data['id'] }}" data-bs-toggle="modal" data-bs-target="#update_password"
                        class="btn btn-label-warning">{{ __('admin.change_password') }}</a> --}}
                            <a href="{{ route('admin.users_customer_index') }}"
                                class="btn btn-label-info">{{ __('admin.back') }}</a>
                        </div>
                    </div>
                    <!-- Update Password Modal -->
                    <div class="modal fade" id="update_password" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
                            <div class="modal-content p-3 p-md-5">
                                <div class="modal-body">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                    <div class="text-center mb-4">
                                        <h3 class="mb-4">{{ __('admin.change_password') }}</h3>
                                    </div>

                                    <form id="update_passwordForm" class="row g-3 mt-3" method="POST"
                                        class=" needs-validation" novalidate
                                        action="{{ route('admin.users_rider_update_password') }}">
                                        @csrf
                                        <div class="col-12">
                                            <label class="form-label"
                                                for="modalEnableOTPPhone">{{ __('admin.new_password') }}</label>
                                            <input type="hidden" id="id" name="id"
                                                value="{{ $data['id'] }}" />
                                            <div class="input-group input-group-merge">

                                                <input type="text" id="new_password" name="new_password"
                                                    class="form-control"
                                                    placeholder="{{ __('admin.new_password') }}" />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                                            <button type="reset" class="btn btn-label-secondary"
                                                data-bs-dismiss="modal" aria-label="Close">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Update Password Modal -->

                </div>
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Full Name</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $data->name }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Email</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $data->email }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Phone</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $data->mobile }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Status</p>
                                </div>
                                <div class="col-sm-9">
                                    {{-- <p class="text-muted mb-0">{{ $data->status==1?'Yes':'No'}}</p> --}}
                                    <span
                                        class="badge rounded-pill {{ $data->status == 1 ? 'bg-label-success' : 'bg-label-danger' }}">{{ $data->status == 1 ? __('admin.active') : __('admin.deactivate') }}</span>
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Branch</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $data->branch ?? __('admin.not_assigned') }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Address</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $data->address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
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

        {{-- //sweet alert --}}
        {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script src="sweetalert2.all.min.js"></script>
     <script src="sweetalert2.min.js"></script>
     <link rel="stylesheet" href="sweetalert2.min.css"> --}}
        {{-- sweet alert --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>

        {{-- Ajax --}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#table2').hide();
                // Delete Button
                $('.delete').on('click', function() {
                    var form = $(this).closest("form");
                    event.preventDefault();
                    var token = $('#_token').val();
                    console.log('token: ', token);
                    //sweet alert to ask user if he is sure before delete
                    Swal.fire({
                        title: 'Delete Admin',
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

                                type: 'DELETE',
                                url: deleteURL,
                                data: {
                                    _token: token
                                },
                                dataType: "JSON",
                                success: function() {
                                    Swal.fire(
                                        'Deleted!',
                                        'Your Branch has been deleted.',
                                        'success',
                                    );
                                    setTimeout(function() {
                                        window.location.replace(document.referrer);
                                    }, 2000);

                                    //location.reload();
                                }
                            });

                        }
                    });
                });
            })
        </script>
    @endsection
</x-app-layout>
