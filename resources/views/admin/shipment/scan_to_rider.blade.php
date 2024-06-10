<x-app-layout>

    @section('title')
        {{ __('admin.shipments') }} | {{ __('admin.assign_shipments_to_rider') }}
    @endsection

    @section('VendorsCss')
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/select2/select2.css') }}" />

        <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">{{ __('admin.shipments') }} / </span>
            {{ __('admin.assign_shipments_to_rider') }}
        </h4>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <form action="" class="row g-3 needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="" class="form-label">{{ __('admin.rider') }}</label>
                                <select name="rider_id" id="rider_id" class="js-example-basic-single" onchange="this.form.submit()" required>
                                    <option value="">{{ __('admin.please_select') }}</option>
                                    {{-- <option value="0">{{ __('admin.remove_rider') }}</option> --}}
                                    @foreach ($riders as $rider)
                                        <option value="{{ $rider->id }}" {{$rider->id == Request()->rider_id ? 'selected' : ''}}>{{ $rider->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="rider_error"></span>
                            </div>
                        </form>

                    </div>

                    <form action="{{route('admin.shipments_assign_to_rider_by_scan_qr')}}" method="post">
                        @csrf
                        <input type="hidden" name="rider_id" value="{{ Request()->rider_id }}">
                        <div class="col">
                            <div class="mb-3">
                                <label for="" class="form-label">{{ __('admin.shipment_no') }}</label>
                                <input type="text" name="shipment_no" id="shipment_no" class="form-control"  onchange="this.form.submit()" autofocus>
                            </div>
                        </div>
                    </form>

                </div>

            </div>
        </div>

        <table class="table table-striped table-bordered my-2" id="assigned_table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('admin.shipments_delivered_Date') }}</th>
                    <th>{{ __('admin.shipment_no') }}/<br>{{ __('admin.shipment_refrence') }}</th>
                    <th>{{ __('admin.client') }}</th>
                    <th>{{ __('admin.shipments_client_address') }}</th>
                    <th>{{ __('admin.vendors_companies') }}</th>
                    <th>{{ __('admin.payment_method') }}</th>
                    <th>{{ __('admin.status') }}</th>
                    <th>{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <body>
                @php $i =1; @endphp
                @foreach ($shipments as $shipment)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{ $shipment->delivered_date ?? '' }}</td>
                    <td>{{ $shipment->shipment_no ?? '' }} <br>
                        #{{ $shipment->shipment_refrence ?? '' }}</td>
                    <td>{{ $shipment->Client->name ?? '' }} <br>
                        {{ $shipment->Client?->mobile ?? '' }}</td>
                    <td>{{ $shipment->Client?->emirate->name ?? '' }} <br>
                        {{ $shipment->Client?->city->name ?? '' }} <br>
                        {{ $shipment->Client?->address ?? '' }}</td>
                    <td>{{ $shipment->Company->name ?? '' }}</td>
                    <td>{{ $shipment->paymentMethod->name ?? '' }}</td>
                    <td><span
                            class="{{ $shipment->Status->html_code }}">{{ $shipment->Status->name }}</span>
                    </td>
                    <td>
                        <form action="{{route('admin.shipments_remove_rider')}}" method="post">
                            @csrf
                            <input type="hidden" name="shipment_no" value="{{$shipment->shipment_no}}">

                            <button type="submit" class="btn btn-sm btn-label-danger">{{__('admin.remove_rider')}}</a>
                        </form>
                    </td>
                </tr>
            @endforeach
            </body>
        </table>


    </div>



    @section('VendorsJS')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });
        </script>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        {{-- <script>
            $(document).on('change', '#shipment_no', function() {
                $('#rider_error').text('');
                // $('#status_error').text('');
                var shipment_no = $(this).val();
                var rider_id = $('#rider_id').val();
                // var status_id = $('#status_id').val();
                var table = $('#assigned_table');



                console.log(table);
                console.log(shipment_no);
                console.log(rider_id);
                // console.log(status_id);

                if (rider_id == "null") {
                    $('#rider_error').text('this field is required');
                } else {
                    $('#rider_error').text('');
                }

                // if (status_id == "null") {
                //     $('#status_error').text('this field is required');
                // } else {
                //     $('#status_error').text('');
                // }

                if (rider_id != "null") {

                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.shipments_assign_to_rider_by_scan_qr') }}",
                        data: {
                            rider_id: rider_id,
                            // status_id: status_id,
                            shipment_no: shipment_no,
                        },
                        success: function(res) {
                            console.log(res);
                            if (res.code == 200) {
                                console.log(res)
                                // var content = `<tr>
                                //         <input type="hidden" id="id" value=`+ res.shipment.id +`>
                                //         <td>` + res.shipment.delivered_date +`</td>
                                //         <td>` +  res.shipment.shipment_no + `<br># ` + res.shipment.shipment_refrence + `</td><td> ` + res.shipment.Client->name +`<br>`+ res.shipment.Client.mobile+`</td>
                                //         <td>` +  res.shipment.Client.emirate.name + `<br>` +res.shipment.Client.city.name +`<br>`+ res.shipment.Client.address + `</td>
                                //         <td>` + res.shipment.Company.name + `</td>
                                //         <td>` + $shipment.paymentMethod.name + `</td>
                                //         <td><span class=`+ res.shipment.Status.html_code + `>`+ $shipment->Status->name +`</span></td> payment_method
                                //         <td>x</td>
                                //         </tr>`;

                                table.append("<tr><td>" + res.shipment.delivered_date + "</td><td>"+ res.shipment.shipment_no+"<br>"+res.shipment.shipment_refrence+"</td><td>"+res.shipment.client.name.ar+"<br>"+res.shipment.client.mobile+"</td><td>"+res.shipment.emirate.name.ar+"<br>"+res.shipment.city.name.ar+"<br>"+res.shipment.delivered_address+"</td><td>"+res.shipment.company.name.ar+"</td><tr>");
                                toastr.success("done");
                                $('#shipment_no').val('');
                            }else{
                                $('#shipment_no').val('');
                            }
                        },
                    });
                }

            });
        </script> --}}
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
    @endsection
</x-app-layout>
