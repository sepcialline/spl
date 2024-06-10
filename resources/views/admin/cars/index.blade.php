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

    <div class="container-xxl flex-grow-1 container-p-y ">



        {{-- <div class="bs-toast toast fade show d-none" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; bottom: 3rem; right: 0;">
            <div class="toast-header">

                <div class="me-auto fw-semibold">{{ __('admin.branch_toast_alert') }}</div>

                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body"></div>
        </div> --}}
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">{{ __('admin.setting_general_setting') }} / </span>
            {{ __('admin.user_management_rider_vehicle_type') }}
        </h4>


        <!-- Multi Column with Form Separator -->
        {{-- <div class="card mb-4"> --}}
        <div class="card p-4">
            <div class="d-flex justify-content-sm-between align-items-sm-center">
                <h5 class="card-header"> {{ __('admin.user_management_rider_vehicle_type') }}</h5>

                    <a href="{{ route('admin.cars_create') }}"
                        class="btn btn-label-secondary">add</a>

            </div>
            <div class="card-datatable table-responsive text-nowrap px-2 py-2">
                <table class="dt-scrollableTable table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('admin.name') }}</th>
                            <th>{{ __('admin.dashboard_expenses_car_plate') }}</th>

                            <th> {{ __('admin.branch_branch_actions') }}</th>
                        </tr>
                    </thead>
                    @php $i=1; @endphp
                    @foreach ($cars as $car)
                    <input type="hidden" class="_token" id="_token" value="{{ csrf_token() }}" />

                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$car->car_name}}</td>
                            <td>{{$car->car_plate}}</td>
                            <td>
                                <a href="{{route('admin.cars_edit',$car->id)}}" class="btn btn-success btn-sm">{{__('admin.edit')}}</a>
                                <a id="delete" class="btn btn-sm btn-label-danger delete"
                                data-url="{{ route('admin.cars_delete', $car->id) }}">{{ __('admin.delete') }}</a>
                            </td>
                        </tr>
                    @endforeach


                </table>
            </div>
        </div>

    </div>





    </div>
    <!-- / Content -->
    @section('VendorsJS')
        <!-- The core Firebase JS SDK is always required and must be listed first -->
        {{-- AIzaSyBI9Dy68H76Ml1AW1D4oIdsR32z0PGE18Y   //////// Google Map API  --}}


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
                        title: 'Delete Car',
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
                //console.log('token: ', token);

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
                        $('.toast-body').html(`${checked?"Branch Activated!":"Branch Deactivated!"}`);
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
</x-app-layout>