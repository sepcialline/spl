<x-app-layout>

    @section('title')
        {{ __('admin.vendors_companies') }} | {{ __('admin.compensation_request') }}
    @endsection

    @section('VendorsCss')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        {{-- <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
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

        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">
        <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css"> --}}

        <style>
            .table td {
                text-align: center;
            }

            #sig_store {
                width: 250px;
                height: 250px;
            }
        </style>
    @endsection
    <div class="container-xxl flex-grow-1 container-p-y">

        @if (count($errors) > 0)
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            @foreach ($errors->all() as $error)
                                <li><span class="text-danger"> {{ $error }}</span></li>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        @endif

        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">{{ __('admin.vendors_companies') }} / </span>
            {{ __('admin.compensation_request') }} / {{ __('admin.edit') }}
        </h4>

        <div class="card">
            <div class="card-body">
                <form class="was-validated" enctype="multipart/form-data" method="post"
                    action="{{ route('admin.compensation_request_update') }}">
                    @csrf

                    <input type="hidden" value="{{ $request->id }}" name="id">
                    <div class="row">
                        <div class="col-md mb-4">
                            <label for="date" class="form-label">{{ __('admin.date') }}</label>
                            <input type="date" class="form-control"
                                value="{{ \Carbon\Carbon::parse($request?->date)->format('Y-m-d') }}" name="date"
                                required>
                        </div>
                        <div class="col-md col-sm-12 mb-4">
                            <label for="select2Multiple"
                                class="form-label">{{ __('admin.shipments_company_name') }}</label>
                            <select id="select2Multiple1" class="select2 form-select" name="company_id" required>
                                <option disabled selected>{{ __('admin.please_select') }}</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}"
                                        {{ $request->company_id == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        @hasrole('Super Admin|Operation Manager|Admin', 'admin')
                            <div class="col">
                                <label for="store_report" class="form-label">{{ __('admin.store_report') }}</label>
                                <textarea name="store_report" readonly id="store_report" class="form-control" cols="30" rows="7">{{ $request?->store_report }}</textarea>
                            </div>
                        @else
                        @endhasrole
                        <div class="col">
                            <label for="store_report" class="form-label">{{ __('admin.compensation_info') }}</label>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('admin.shipment_no') }}</th>
                                            <th>{{ __('admin.amount') }}</th>
                                            <th>{{ __('admin.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body">
                                        @foreach ($request_infos as $info)
                                            <tr>
                                                <input type="hidden" name="info_id[]" value="{{ $info->id }}">
                                                <td><input type="text" value="{{ $info->shipment }}"
                                                        name="shipment_no[]" class="form-control"
                                                        @if ($request->store_check == 1) readonly @else required @endif>
                                                </td>
                                                <td><input type="text" value="{{ $info->amount }}" name="amount[]"
                                                        class="form-control"
                                                        @if ($request->store_check == 1) readonly @else required @endif>
                                                </td>
                                                <td>
                                                    @if ($request->store_check == 0 || $request->operation_check == 0)
                                                        <div class="d-flex justify-center">
                                                            <button type="button"
                                                                class="btn btn-xs btn-danger delete_row"><i
                                                                    class='bx bx-message-x'></i></button>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if ($request->store_check == 0 || $request->operation_check == 0)
                                    <button type="button" class="btn btn-xs add_row btn-label-facebook"><i
                                            class='bx bx-message-square-add'></i></button>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- <div class="row">
                        <div class="col-md-12">
                            <label class="" for="">{{__('admin.store_kaper_signeture')}}</label>
                            <br/>
                            <div id="sig_store" ></div>
                            <br/>
                            <button id="clear" class="btn btn-danger btn-sm">Clear Signature</button>
                            <textarea id="signature64_store" name="store_kaper_signeture" style="display: none"></textarea>
                        </div>
                    </div> --}}
                    <hr>

                    <div class="row">
                        @hasrole('Admin', 'admin')
                            <div class="col">
                                <label for="store_report" class="form-label">{{ __('admin.operation_report') }}</label>
                                <textarea name="operation_report" readonly id="operation_report" class="form-control" cols="30" rows="7"
                                    required>{{ $request?->operation_report }}</textarea>
                            </div>
                            @endif
                        @hasrole('Super Admin|Operation Manager', 'admin')
                            <div class="col">
                                <label for="store_report" class="form-label">{{ __('admin.operation_report') }}</label>
                                <textarea name="operation_report" id="operation_report" class="form-control" cols="30" rows="7" required>{{ $request?->operation_report }}</textarea>
                            </div>
                        @else
                        @endrole
                    </div>
                    <hr>
                    <div class="row">
                        @hasrole('Super Admin|Admin', 'admin')
                            <div class="col-md-4 col-sm-12">
                                <select name="ceo_check" id="" class="form-select">
                                    <option value="" disabled selected>{{ __('admin.please_select') }}</option>
                                    <option value="1" {{$request->ceo_check == 1 ? 'selected' : ''}}>{{ __('admin.approved') }}</option>
                                    <option value="0" {{$request->declined_check == 1 ? 'selected' : ''}}>{{ __('admin.declined') }}</option>
                                </select>
                            </div>
                            <div class="col-md-8 col-sm-12">
                                <div class="col">
                                    <label for="store_report" class="form-label">{{ __('admin.ceo_report') }}</label>
                                    <textarea name="ceo_report"  id="ceo_report" class="form-control" cols="30" rows="7"
                                        required>{{ $request?->ceo_report }}</textarea>
                                </div>
                            </div>
                        @else
                        @endrole
                    </div>
                    <div class="col-md-3 mb-0 my-2">

                        <button name="action" id="clk" value="search_action" type="submit"
                            class="btn btn-label-facebook">{{ __('admin.send') }}</button>
                    </div>

                </form>
            </div>

        </div>

    </div>
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
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>

        <script>
            // دالة لإضافة صف جديد
            document.querySelector('.add_row').addEventListener('click', function() {
                let tableBody = document.getElementById('table-body');

                // إنشاء سطر جديد
                let newRow = document.createElement('tr');

                // إضافة الأعمدة الجديدة
                newRow.innerHTML = `
                    <td><input type="text" name="shipment_no[]" class="form-control" required></td>
                    <td><input type="text" name="amount[]" class="form-control" required></td>
                    <td>
                        <div class="d-flex justify-center">
                            <button type="button" class="btn btn-xs btn-danger delete_row"><i class='bx bx-message-x'></i></button>
                        </div>
                    </td>
                `;

                // إضافة السطر الجديد إلى الجدول
                tableBody.appendChild(newRow);
            });

            // دالة لحذف السطر
            document.addEventListener('click', function(e) {
                if (e.target && e.target.closest('.delete_row')) {
                    let row = e.target.closest('tr');
                    row.remove();
                }
            });
        </script>
        <script>
            function submitForm() {
                document.getElementById("clk").disabled = true;
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        {{-- <script type="text/javascript">
    var sig = $('#sig_store').signature({syncField: '#signature64_store', syncFormat: 'PNG'});
    $('#clear').click(function(e) {
        e.preventDefault();
        sig.signature('clear');
        $("#signature64_store").val('');
    });
</script> --}}
    @endsection
</x-app-layout>
