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
                    <li class="nav-item" style="background-color: #4287f5;border-radius: 10px;">
                      <a class="nav-link active" style="border-radius: 10px;" href="{{ route('admin.push_notification') }}"
                        > {{ __('admin.firebase_push') }}</a>
                    </li>
                    <li class="nav-item" >
                        <a class="nav-link " style="border-radius: 10px;" href="{{ route('admin.config_notification') }}"
                          > {{ __('admin.firebase_config') }}</a>
                      </li>

                  </ul>

                  <div class="card mb-4">
                    <form method="POST" class=" needs-validation" novalidate action="{{ route('admin.update_push_notification') }}" enctype="multipart/form-data"
                    class="card-body">
                    @csrf
                    <!-- Current Plan -->
                    <div class="col-xl-12">
                        {{-- <h6 class="text-muted">Basic</h6> --}}
                        <div class="nav-align-top mb-4">
                          <ul class="nav nav-tabs tabs-line" role="tablist">

                            <li class="nav-item">
                              <button
                                type="button"
                                class="nav-link active"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-tabs-line-top-profile"
                                aria-controls="navs-tabs-line-top-profile"
                                aria-selected="false">
                                {{ __('admin.firebase_push_english') }}
                              </button>
                            </li>
                            <li class="nav-item">
                              <button
                                type="button"
                                class="nav-link"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-tabs-line-top-messages"
                                aria-controls="navs-tabs-line-top-messages"
                                aria-selected="false">
                                {{ __('admin.firebase_push_arabic') }}
                              </button>
                            </li>
                          </ul>
                          <div class="tab-content shadow-none">



                            {{-- English --}}
                            <div class="tab-pane fade show active" id="navs-tabs-line-top-profile" role="tabpanel">
                                <div class="tab-pane fade show active" id="navs-tabs-line-top-home" role="tabpanel">
                                    <div class="row pt-3  g-3 ">
                                        <div class="col-md-4">
                                            <div class="d-flex gap-8 align-items-center">
                                                <span class="me-4">{{ __('admin.firebase_pending_approval') }} </span>


                                            </div>
                                            <textarea name='pending_english' class="form-control mt-2" id="exampleFormControlTextarea1" placeholder="Ex: Type your message here" rows="2"></textarea>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex   align-items-center">
                                                <span class="me-4">{{ __('admin.firebase_in_progress') }} </span>


                                            </div>
                                            <textarea name="confirm_english" class="form-control mt-2" id="exampleFormControlTextarea1" placeholder="Ex: Type your message here" rows="2"></textarea>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex   align-items-center">
                                                <span class="me-4">{{ __('admin.firebase_delivered') }} </span>


                                            </div>
                                            <textarea name="delivere_english" class="form-control mt-2" id="exampleFormControlTextarea1" placeholder="Ex: Type your message here" rows="2"></textarea>

                                        </div>

                                    </div>
                                    <div class="row pt-3  g-3 ">
                                        <div class="col-md-4">
                                            <div class="d-flex gap-8 align-items-center">
                                                <span class="me-4">{{ __('admin.firebase_delayed') }} </span>


                                            </div>
                                            <textarea name="delay_english" class="form-control mt-2" id="exampleFormControlTextarea1" placeholder="Ex: Type your message here" rows="2"></textarea>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex   align-items-center">
                                                <span class="me-4">{{ __('admin.firebase_transferred') }} </span>


                                            </div>
                                            <textarea name="transfer_english" class="form-control mt-2" id="exampleFormControlTextarea1" placeholder="Ex: Type your message here" rows="2"></textarea>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex   align-items-center">
                                                <span class="me-4">{{ __('admin.firebase_canceled') }} </span>


                                            </div>
                                            <textarea name="cancel_english" class="form-control mt-2" id="exampleFormControlTextarea1" placeholder="Ex: Type your message here" rows="2"></textarea>

                                        </div>

                                    </div>
                                    <div class="row pt-3  g-3 ">
                                        <div class="col-md-4">
                                            <div class="d-flex gap-8 align-items-center">
                                                <span class="me-4">{{ __('admin.firebase_damaged') }} </span>

                                            </div>
                                            <textarea name="damage_english" class="form-control mt-2" id="exampleFormControlTextarea1" placeholder="Ex: Type your message here" rows="2"></textarea>

                                        </div>


                                    </div>
                                </div>
                            </div>

                            {{-- Arabic --}}
                            <div class="tab-pane fade" id="navs-tabs-line-top-messages" role="tabpanel">
                                <div class="tab-pane fade show active" id="navs-tabs-line-top-home" role="tabpanel">
                                    <div class="row pt-3  g-3 ">
                                        <div class="col-md-4">
                                            <div class="d-flex gap-8 align-items-center">
                                                <span class="me-4">{{ __('admin.firebase_pending_approval') }} </span>


                                            </div>
                                            <textarea name="pending_arabic" class="form-control mt-2" id="exampleFormControlTextarea1" placeholder="Ex: Type your message here" rows="2"></textarea>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex   align-items-center">
                                                <span class="me-4">{{ __('admin.firebase_in_progress') }} </span>


                                            </div>
                                            <textarea name="confirm_arabic" class="form-control mt-2" id="exampleFormControlTextarea1" placeholder="Ex: Type your message here" rows="2"></textarea>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex   align-items-center">
                                                <span class="me-4">{{ __('admin.firebase_delivered') }} </span>


                                            </div>
                                            <textarea name="delivere_arabic" class="form-control mt-2" id="exampleFormControlTextarea1" placeholder="Ex: Type your message here" rows="2"></textarea>

                                        </div>

                                    </div>
                                    <div class="row pt-3  g-3 ">
                                        <div class="col-md-4">
                                            <div class="d-flex gap-8 align-items-center">
                                                <span class="me-4">{{ __('admin.firebase_delayed') }} </span>


                                            </div>
                                            <textarea name="delay_arabic" class="form-control mt-2" id="exampleFormControlTextarea1" placeholder="Ex: Type your message here" rows="2"></textarea>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex   align-items-center">
                                                <span class="me-4">{{ __('admin.firebase_transferred') }} </span>


                                            </div>
                                            <textarea name="transfer_arabic" class="form-control mt-2" id="exampleFormControlTextarea1" placeholder="Ex: Type your message here" rows="2"></textarea>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex   align-items-center">
                                                <span class="me-4">{{ __('admin.firebase_canceled') }} </span>


                                            </div>
                                            <textarea name="cancel_arabic" class="form-control mt-2" id="exampleFormControlTextarea1" placeholder="Ex: Type your message here" rows="2"></textarea>

                                        </div>

                                    </div>
                                    <div class="row pt-3  g-3 ">
                                        <div class="col-md-4">
                                            <div class="d-flex gap-8 align-items-center">
                                                <span class="me-4">{{ __('admin.firebase_damaged') }} </span>

                                            </div>
                                            <textarea name="damage_arabic" class="form-control mt-2" id="exampleFormControlTextarea1" placeholder="Ex: Type your message here" rows="2"></textarea>

                                        </div>


                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>


                    <!-- /Current Plan -->
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
                </form>
                </div>


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
