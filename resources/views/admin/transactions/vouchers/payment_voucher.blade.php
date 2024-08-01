<x-app-layout>

    @section('title')
        {{ __('admin.transactions') }} | {{ __('admin.payment_voucher') }}
    @endsection

    @section('VendorsCss')
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/select2/select2.css') }}" />
    @endsection
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">{{ __('admin.transactions') }} / </span>
            {{ __('admin.payment_voucher') }}
        </h4>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.account.store_payment_voucher') }}" method="post"
                    class="row g-3 needs-validation" novalidate>
                    @csrf
                    <div class="row mt-2">
                        <div class="form-group col-2">
                            <label for="exampleFormControlInput1">{{ __('admin.date') }}</label>
                            <input type="date" name="date" class="form-control"
                                value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>
                        <div class="form-group col-5">
                            <label for="exampleFormControlInput1">{{ __('admin.statment') }}</label>
                            <textarea name="statment" class="form-control" id="statment" cols="" rows="1" required></textarea>
                        </div>
                        <div class="form-group col-2">
                            <label for="exampleFormControlInput1">{{ __('admin.shipment_no') }}</label>
                            <input name="shipment_refrence" class="form-control" id="shipment_refrence"></textarea>
                        </div>
                        <div class="form-group col-3">
                            <label for="exampleFormControlInput1">{{ __('admin.cost_center') }}</label>
                            <select name="cost_center" id="cost_center" class="js-example-basic-single">
                                <option value="" selected disabled>{{ __('admin.please_select') }}</option>
                                @foreach ($cars as $car)
                                    <option value="{{ $car->id }}">{{ $car->car_name }} |{{ $car->car_plate }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="15%">{{ __('admin.account_name') }}</th>
                                <th width="15%">{{ __('admin.credit') }}</th>
                                <th width="15%">{{ __('admin.debit') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="p-0">
                                    <select name="account_id[]" class="js-example-basic-single" required>
                                        <option value="" selected disabled>{{ __('admin.please_select') }}
                                        </option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->account_name }} |
                                                {{ $account->account_code }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="p-0">
                                    <input type="text" name="credit[]" class="form-control credit">
                                </td>
                                <td class="p-0">
                                    <input type="text" name="debit[]" class="form-control debit">
                                </td>
                            </tr>
                            <tr>
                                <td class="p-0">
                                    <select name="account_id[]" class="js-example-basic-single" required>
                                        <option value="" selected disabled>{{ __('admin.please_select') }}
                                        </option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->account_name }} |
                                                {{ $account->account_code }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="p-0">
                                    <input type="text" name="credit[]" class="form-control credit">
                                </td>
                                <td class="p-0">
                                    <input type="text" name="debit[]" class="form-control debit">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="my-2">
                        <button type="submit" class="btn btn-label-secondary">{{ __('admin.save_and_print') }}</button>
                    </div>
                </form>
            </div>
        </div>


    </div>


    @section('VendorsJS')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $(".js-example-basic-single").select2();
            });
        </script>
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
    @endsection
</x-app-layout>
