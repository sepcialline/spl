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
                        <div class="form-group col-4">
                            <label for="exampleFormControlInput1">{{ __('admin.date') }}</label>
                            <input type="date" name="date" class="form-control"
                                value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>
                        <div class="form-group col-8">
                            <label for="exampleFormControlInput1">{{ __('admin.statment') }}</label>
                            <textarea name="statment" class="form-control" id="statment" cols="" rows="1" required></textarea>
                        </div>
                    </div>



                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="15%">{{ __('admin.account_name') }}</th>
                                {{-- <th width="15%">{{ __('admin.amount') }}</th> --}}
                                <th width="15%">{{ __('admin.credit') }}</th>
                                <th width="15%">{{ __('admin.debit') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="p-0">
                                    <select name="account_id[]" id="" class="js-example-basic-single" required>
                                        <option value="" selected disabled>{{ __('admin.please_select') }}
                                        </option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}">
                                                {{ $account->account_name }} | {{ $account->account_code }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                {{-- <td class="p-0"><input name="amount[]" type="number" class="form-control" required> --}}
                                </td>
                                <td class="p-0">
                                    <input type="text" name="credit[]" id="credit" class="form-control" required>
                                </td>
                                <td class="p-0">
                                    <input type="text" name="debit[]" id="credit" class="form-control" required>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-0">
                                    <select name="account_id[]" id="" class="js-example-basic-single" required>
                                        <option value="" selected disabled>{{ __('admin.please_select') }}
                                        </option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}">
                                                {{ $account->account_name }} | {{ $account->account_code }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                {{-- <td class="p-0"><input name="amount[]" type="number" class="form-control"></td> --}}
                                <td class="p-0">
                                    <input type="text" name="credit[]" id="credit" class="form-control" required>
                                </td>
                                <td class="p-0">
                                    <input type="text" name="debit[]" id="credit" class="form-control" required>
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
    @endsection
</x-app-layout>
