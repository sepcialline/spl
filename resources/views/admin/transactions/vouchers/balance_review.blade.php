<x-app-layout>

    @section('title')
        {{ __('admin.transactions') }} | {{ __('admin.journals') }}
    @endsection

    @section('VendorsCss')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">{{ __('admin.transactions') }} / </span>
            {{ __('admin.journals') }}
        </h4>

        <div class="card my-2">
            <div class="card-body">
                <form action="">
                    <div class="row">
                        <div class="mb-3 col">
                            <label for="exampleFormControlInput1" class="form-label">{{ __('admin.from') }}</label>
                            <input type="date" class="form-control" id="from" name="from"
                                value="{{ Request()->from ?? Carbon\Carbon::today()->format('Y-m-d') }}">
                        </div>
                        <div class="mb-3 col">
                            <label for="exampleFormControlInput1" class="form-label">{{ __('admin.to') }}</label>
                            <input type="date" class="form-control" id="to" name="to"
                                value="{{ Request()->to ?? Carbon\Carbon::today()->format('Y-m-d') }}">
                        </div>
                        <div class="mb-3 col">
                            <label for="exampleFormControlInput1"
                                class="form-label">{{ __('admin.accounts_accounts') }}</label>
                            <select class="js-example-basic-single form-control" name="account" id="account">
                                <option value="0" {{ 0 == Request()->account ? 'selected' : '' }}>
                                    {{ __('admin.all') }}</option>
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->account_code }}"
                                        {{ $account->account_code == Request()->account ? 'selected' : '' }}>
                                        {{ $account->account_code }} | {{ $account->account_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="">{{ __('admin.number_voucher') }}</label>
                            <input type="text" class="form-control" name="search" value="{{ Request()->search }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-label-dark">{{ __('admin.search') }}</button>
                </form>

            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ __('admin.account_name') }}</th>
                            <th>{{ __('admin.debit') }}</th>
                            <th>{{ __('admin.credit') }}</th>
                            <th>{{ __('admin.total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($account_totals as $account)
                            @if ($account['account_number'] != null)
                                <tr>
                                    <td>{{ $account['account_number']['account_name'] }} {{ $account['account_number']['account_code'] }}</td>
                                    <td>{{ $account['total_debit'] }}</td>
                                    <td>{{ $account['total_credit'] }}</td>
                                    <td>{{ $account['balance'] }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                {{ $entries->links() }}

            </div>
        </div>


    </div>


    @section('VendorsJS')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });
        </script>
    @endsection
</x-app-layout>
{{-- <td class="py-0 my-0">{{ $i++ }}
    @if ($journal?->type?->id == 2)
        <a target="_blank" href="{{route('admin.account.print_recipt_voucher',['number'=>$journal->number])}}"><i class='bx bxs-printer text-danger'></i></a>
    @elseif($journal?->type?->id == 3)
        <a target="_blank" href="{{route('admin.account.print_payment_voucher',['number'=>$journal->number])}}"><i class='bx bxs-printer text-success'></i></a>
    @endif
</td> --}}
