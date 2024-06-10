<x-setting-layout>
    @section('title')
    Dashboard
    @endsection
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="card p-4">
                <div class="d-flex justify-content-sm-between align-items-sm-center">

                    <div class="d-flex align-items-sm-center">
                        <h5 class="card-header"> Pending Orders List </h5>
                        {{-- <span class="">
                            <a href="{{ route('admin.shopify_settings') }}"
                            class="btn btn-success btn-sm ml-2">Refresh</a>
                        </span> --}}
                    </div>


                    {{-- <a href="{{ route('admin.shopify_create') }}"
                        class="btn btn-secondary">Add Merchant</a> --}}

                </div>
                <div class="card-datatable table-responsive text-nowrap px-2 py-2">
                    <!-- Update Password Modal -->

                    <!--/ Update Password Modal -->
                    <table class="dt-scrollableTable table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">Order Number</th>
                                <th width="15%">Customer Name</th>
                                <th width="15%">Phone No</th>
                                <th width="15%">Address</th>
                                <th width="5%">City</th>
                                <th width="5%">Emirate</th>
                                <th width="5%">Total Price</th>
                                {{-- <th width="5%">Status</th> --}}
                                <th width="45%">Actions</th>
                            </tr>
                        </thead>


                        <input type="hidden" class="_token" id="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" class="company_id" id="company_id" value="{{ $data->company_id }}" />
                        @foreach ($data as $order)


                            <tr>
                                {{-- <td>{{ $order->id }}</td> --}}
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->phone_no }}</td>
                                <td>{{ $order->address }}</td>
                                <td>{{ $order->city }}</td>
                                <td>{{ $order->emirate }}</td>
                                <td>{{ $order->total_price}}</td>
                                <td>
                                    <a id="close" class="btn btn-label-info close"
                                        data-url="{{ route('employee.shopify_order_update', [$order->order_id,$order->order_number]) }}">Close</a>
                                </td>
                            </tr>


                        @endforeach
                    </table>
                </div>
            </div>
        </div>
      </div>
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
              $('.close').on('click', function() {
                  var form = $(this).closest("form");
                  event.preventDefault();
                  var token = $('#_token').val();
                  var company_id = $('#company_id').val();
                  console.log('token: ', token);
                  //sweet alert to ask user if he is sure before delete
                  Swal.fire({
                      title: 'Close Order',
                      text: 'Do you want to continue?',
                      icon: 'info',
                      confirmButtonText: 'Yes, close it!',
                      cancelButtonText: "No, cancel please!",
                      showCancelButton: true,
                      //iconColor: "#DD6B55",
                      ///cancelButtonColor: "#fce3e1",
                      //confirmButtonColor: "#DD6B55",


                  }).then((result) => {
                      if (result.isConfirmed) {
                          var closeUrl = $(this).data('url');
                          var trObj = $(this);
                          console.log(closeUrl);
                          //console.log(trObj);
                          $.ajax({

                              type: 'PUT',
                              url: closeUrl,
                              data: {
                                  _token: token,
                                  company_id:company_id
                              },
                              dataType: "JSON",
                              success: function() {
                                  Swal.fire(
                                      'Closed!',
                                      'Your Order has been closed.',
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
</x-setting-layout>
