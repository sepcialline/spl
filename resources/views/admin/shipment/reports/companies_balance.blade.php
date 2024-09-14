<x-app-layout>

    @section('title')
        {{ __('admin.reports') }} | {{ __('admin.payments') }}
    @endsection

    @section('VendorsCss')
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/select2/select2.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/tagify/tagify.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
        <link rel="stylesheet"
            href="{{ asset('build/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}" />
        <link rel="stylesheet"
            href="{{ asset('build/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/pickr/pickr-themes.css') }}" />
        <style>
            .table td {
                text-align: center;
            }

            .table {
                font-size: 12px
            }

            .table th {
                font-size: 12px
            }
        </style>
    @endsection
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">{{ __('admin.reports') }} / </span>
            {{ __('admin.payments') }}
        </h4>

        <div class="card">
            <div class="card-body">
                <form action="" target="">
                    <div class="row">
                        {{-- <div class="col-md-3 mb-4">
                            <label for="select2Multiple" class="form-label">{{ __('admin.company_list') }}</label>
                            <select id="select2Multiple1" class="select2 form-select" name="company_id">
                                <option value="0" {{ request()->company_id == 0 ? 'selected' : '' }}>
                                    {{ __('admin.all') }}</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}"
                                        {{ request()->company_id == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div> --}}



                        <div class="col-md-6 col-12 mb-4">
                            <label for="dateRangePicker" class="form-label">{{ __('admin.date') }}</label>
                            <div class="input-group input-daterange" id="bs-datepicker-daterange">
                                <span class="input-group-text">{{ __('admin.from') }}</span>
                                <input type="date" name="date_from" id="dateRangePicker" placeholder="MM/DD/YYYY"
                                    class="form-control" value="{{ \Carbon\Carbon::parse($from)->format('Y-m-d') }}" />
                                <span class="input-group-text">{{ __('admin.to') }}</span>
                                <input type="date" name="date_to" placeholder="MM/DD/YYYY" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($to)->format('Y-m-d') }}" />
                            </div>
                        </div>

                        <hr>
                        <div class="col-md-3 mb-0">

                            <button name="action" value="search_action" type="submit"
                                class="btn btn-label-facebook">{{ __('admin.send') }}</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <hr>

        @if (isset($balances) && count($balances) > 0)

            <div class="card" id="content_table">
                <div class="card">

                    <div class="card-body">


                        <div class="table-responsive">
                            <table class="table table-striped table-bordered my-2">
                                <thead>


                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('admin.company_list') }}</th>
                                        <th>{{ __('admin.amount') }}</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach ($balances as $balance)
                                        <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$balance->vendor_name_en}} - {{$balance->vendor_name_ar}}</td>
                                        <td>{{$balance->due_amount}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- {{ $payments->appends(request()->query())->links() }} --}}

                    </div>
                </div>
            </div>
        @else
            <div class="row justify-center">
                <div class="col-md">
                    <img src="{{ asset('build/assets/img/pages/nodata.jpg') }}" width="100%" alt="">

                </div>
            </div>
        @endif



        @section('VendorsJS')
            <!-- Vendors JS -->
            <script src="{{ asset('build/assets/vendor/libs/select2/select2.js') }}"></script>
            <script src="{{ asset('build/assets/vendor/libs/tagify/tagify.js') }}"></script>
            <script src="{{ asset('build/assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
            <script src="{{ asset('build/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
            <script src="{{ asset('build/assets/vendor/libs/bloodhound/bloodhound.js') }}"></script>
            <script src="{{ asset('build/assets/vendor/libs/moment/moment.js') }}"></script>
            <script src="{{ asset('build/assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
            <script src="{{ asset('build/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
            <script src="{{ asset('build/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>
            <script src="{{ asset('build/assets/vendor/libs/jquery-timepicker/jquery-timepicker.js') }}"></script>
            <script src="{{ asset('build/assets/vendor/libs/pickr/pickr.js') }}"></script>



            <!-- Page JS -->
            <script src="{{ asset('build/assets/js/forms-selects.js') }}"></script>
            <script src="{{ asset('build/assets/js/forms-tagify.js') }}"></script>
            <script src="{{ asset('build/assets/js/forms-typeahead.js') }}"></script>
            <script src="{{ asset('build/assets/js/forms-pickers.js') }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script>
                $(document).on('click', '#delete_shipment', function() {
                    var id = $(this).closest('tr').find('#id').val();
                    Swal.fire({
                        title: "{{ __('admin.msg_are_you_sure_for_delete') }}",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "{{ __('admin.yes') }}"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                method: 'GET',
                                url: "{{ route('admin.shipments_delete') }}",
                                data: {
                                    id: id
                                },
                                success: function(res) {
                                    console.log(res);
                                    if (res.code == 200) {
                                        Swal.fire({
                                            title: "{{ __('admin.deleted') }}",
                                            text: "{{ __('admin.msg_success_delete') }}",
                                            icon: "success"
                                        });
                                        $("#content_table").load(location.href + " #content_table");
                                    }

                                }

                            })

                        }
                    });
                });
            </script>
        @endsection
</x-app-layout>
