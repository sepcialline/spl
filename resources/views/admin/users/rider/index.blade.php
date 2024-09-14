<x-app-layout>
    @section('title')
        {{ __('admin.user_management_admin') }}
    @endsection
    @section('VendorsCss')
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/select2/select2.css') }}" />
    @endsection
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y ">



        {{--  --}}
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">{{ __('admin.user_management') }} / </span>
            {{ __('admin.user_management_rider') }}
        </h4>


        <!-- Multi Column with Form Separator -->
        {{-- <div class="card mb-4"> --}}
        <div class="card p-4">
            <div class="d-flex justify-content-sm-between align-items-sm-center">
                <h5 class="card-header"> {{ __('admin.user_management_rider_list') }}</h5>
                <div class="d-flex ">
                    <div class="form-outline me-2">
                        <input type="hidden" class="_token" id="_token" value="{{ csrf_token() }}" />
                        <input type="search" id="form1" class="form-control" placeholder="Type query"
                            aria-label="Search" data-url="{{ route('admin.users_rider_search', '') }}" />
                    </div>
                    @can('admin-rider-add')
                        <a href="{{ route('admin.users_rider_create') }}"
                            class="btn btn-label-secondary">{{ __('admin.user_management_rider_add') }}</a>
                    @endcan
                </div>


            </div>

            <div class="table-responsive text-nowrap">
                @if (count($data) > 0)
                    <table id='table1' class="table table-striped">
                        <input type="hidden" class="_token" id="_token" value="{{ csrf_token() }}" />
                        <thead>
                            <tr>
                                {{-- <th></th> --}}
                                <th>{{ __('admin.user_management_rider_name') }}</th>
                                <th>{{ __('admin.user_management_rider_mobile') }}</th>
                                <th>{{ __('admin.user_management_rider_email') }}</th>
                                <th>{{ __('admin.branch_branch_name') }}</th>
                                <th>{{ __('admin.user_management_rider_vehicle_type') }}</th>
                                <th>{{ __('admin.user_management_rider_status') }}</th>
                                <th> {{ __('admin.branch_branch_actions') }}</th>
                            </tr>
                        </thead>

                        <tbody id="original" class="table-body table-border-bottom-0">
                            @foreach ($data as $item)
                                {{-- @php $roles = $item->getRoleNames(); @endphp --}}

                                <tr>
                                    {{-- <td>
                                            <div class="avatar me-2">
                                                <img src="{{ asset('build/assets/img/uploads/avatars/'.$item->image) }}" alt="Avatar"
                                                    class="rounded-circle me-2" />
                                            </div>
                                        </td> --}}
                                    <td>
                                        @if($item->image)
                                        <img src="{{ asset('build/assets/img/uploads/avatars/' . $item->image) }}"
                                            alt="Avatar" class="rounded-circle me-2"
                                            style="width: 50px" />
                                            @else
                                            <img src="{{ asset('build/assets/img/uploads/avatars/1.png') }}"
                                            alt="Avatar" class="rounded-circle me-2"
                                            style="width: 50px" />
                                            @endif
                                            {{ $item->name }}</td>
                                    <td>{{ $item->mobile }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->branch->branch_name }}</td>
                                    <td>{{ $item->vehicleType->name }}</td>
                                    <td>
                                        @can('admin-rider-change-status')
                                            <label class="switch switch-primary">
                                                <input type="checkbox" class="switch-input status"
                                                    data-url="{{ route('admin.users_rider_update_status', $item['id']) }}"
                                                    name="status" id="status"
                                                    {{ $item['status'] ? 'checked' : !'checked' }} />
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on">
                                                        <i class="bx bx-check"></i>
                                                    </span>
                                                    <span class="switch-off">
                                                        <i class="bx bx-x"></i>
                                                    </span>
                                                </span>
                                                {{-- <span class="switch-label">Primary</span> --}}
                                            </label>
                                            {{-- {{ $item->status }} --}}
                                        @endcan
                                    </td>

                                    <td>
                                        @can('admin-rider-show')
                                            <a href="{{ $item['id'] }}"
                                                class="btn btn-label-dark">{{ __('admin.branch_action_show') }}</a>
                                        @endcan
                                        @can('admin-rider-edit')
                                            <a href="edit/{{ $item['id'] }}"
                                                class="btn btn-label-secondary">{{ __('admin.branch_action_edit') }}</a>
                                        @endcan
                                        @can('admin-rider-delete')
                                            <a id="delete" class="btn btn-label-danger delete"
                                                data-url="{{ route('admin.users_rider_destroy', $item['id']) }}">{{ __('admin.branch_action_delete') }}</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>



                    </table>
                @else
                    <img src="{{ asset('build/assets/img/pages/nodata') }}.jpg"
                        class="img-fluid rounded mx-auto d-block" style=" height: 500px;" />
                    <h3 style="text-align: center">No Data</h3>
                @endif
                <table id='table2' class="table table-striped">
                    <input type="hidden" class="_token" id="_token" value="{{ csrf_token() }}" />
                    <thead>
                        <tr>
                            {{-- <th></th> --}}
                            <th>{{ __('admin.user_management_rider_name') }}</th>
                            <th>{{ __('admin.user_management_rider_mobile') }}</th>
                            <th>{{ __('admin.user_management_rider_email') }}</th>
                            {{-- <th>{{ __('admin.user_management_rider_type_of_employment') }}</th> --}}
                            <th>{{ __('admin.user_management_rider_vehicle_type') }}</th>
                            <th>{{ __('admin.user_management_rider_status') }}</th>
                            <th> {{ __('admin.branch_branch_actions') }}</th>
                        </tr>
                    </thead>

                    <tbody id="search" class="table-body table-border-bottom-0">


                    </tbody>

                </table>

            </div>
            <div class="mt-4">
                {{ $data->links() }}
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

        {{-- search table --}}
        <script>
            $('#form1').keyup(function(event) {

                if (event.target.value.length >= 3) {
                    console.log('changed');
                    var searchURL = $(this).data('url');
                    var token = $('#_token').val();
                    console.log(searchURL);
                    $('#table1').hide();
                    $('#table2').show();
                    $.ajax({

                        type: 'POST',
                        url: searchURL,
                        data: {
                            _token: token,
                            search: event.target.value,
                        },
                        dataType: "JSON",
                        success: function(data) {
                            let output = '';
                            console.log(data.results);
                            data.results.forEach(function(item, index) {
                                console.log(item);
                                output = output +
                                    '<tr>' +
                                    '<td>' +

                                    '<img src="{{ asset('build/assets/img/uploads/avatars/' . '+item->image+') }}" alt="Avatar"' +
                                    'class="rounded-circle me-2" style="width:50px"/>' +


                                    item.name.en + '</td>' +
                                    '<td>' + item.mobile + '</td>' +
                                    '<td>' + item.email + '</td>' +
                                    '<td>' + item.vehicle_type.name.en + '</td>' +
                                    '<td>' +
                                    '<a href=' + item.id + ' ' +
                                    'class="btn btn-label-dark">{{ __('admin.branch_action_show') }}</a>' +
                                    '<a href="edit/' + item.id +
                                    '" class="btn btn-label-secondary">{{ __('admin.branch_action_edit') }}</a>' +
                                    '<a id="delete" class="btn btn-label-danger delete" data-url="{{ route('admin.users_rider_destroy', '+ item.id+') }}">{{ __('admin.branch_action_delete') }}</a>' +
                                    '</td>' +
                                    '</tr>'
                            });
                            // $('.table-body2').html(data);
                            $('#search').html(output);
                            // Swal.fire(
                            //     'Deleted!',
                            //     'Your Branch has been deleted.',
                            //     'success',
                            // );
                            // location.reload();
                        }
                    });
                } else {
                    $('#table2').hide();
                    $('#table1').show();

                }

            });
        </script>
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
                        title: 'Delete Rider',
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
                                        'Rider has been deleted.',
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
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>
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

                        if (checked) {
                            toastr.success("{{ __('admin.msg_success_active') }}")

                        } else {
                            toastr.error("{{ __('admin.msg_success_deactive') }}")

                        }

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
