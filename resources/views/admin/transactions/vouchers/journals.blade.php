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
                            <input type="date" class="form-control" id="from" name="from" value="{{Request()->from ?? Carbon\Carbon::today()->format('Y-m-d')}}">
                        </div>
                        <div class="mb-3 col">
                            <label for="exampleFormControlInput1" class="form-label">{{ __('admin.from') }}</label>
                            <input type="date" class="form-control" id="to" name="to" value="{{Request()->to ?? Carbon\Carbon::today()->format('Y-m-d')}}">
                        </div>
                        <div class="mb-3 col">
                            <label for="exampleFormControlInput1"
                                class="form-label">{{ __('admin.accounts_accounts') }}</label>
                                <select class="js-example-basic-single form-control" name="account" id="account">
                                    <option value="0" {{0 == Request()->account ? 'selected' : ''}}>{{__('admin.all')}}</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{$account->account_code}}" {{$account->account_code == Request()->account ? 'selected' : ''}}>{{$account->account_code}} | {{$account->account_name}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-label-dark">{{__('admin.search')}}</button>
                </form>

            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('admin.number_voucher') }}</th>
                            <th>{{ __('admin.type_voucher') }}</th>
                            <th>{{ __('admin.debit') }}</th>
                            <th>{{ __('admin.credit') }}</th>
                            <th>{{ __('admin.statment') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach ($journals as $journal)
                            <tr class="py-0 my-0">
                                <td class="py-0 my-0">{{ $i++ }}</td>
                                <td class="py-0 my-0">{{ $journal['number'] }}</td>
                                <td class="py-0 my-0">{{ $journal['type']->name }}
                                    @if ($journal['type']->id == 2)
                                        {{-- recipt Voucher  --}}
                                        <a target="_blank" href="{{route('admin.account.print_recipt_voucher',['number'=>$journal['number']])}}"><i class='bx bxs-printer text-danger'></i></a>
                                    @elseif($journal['type']->id == 3)
                                        {{-- payment  Voucher  --}}
                                        <a target="_blank" href="{{route('admin.account.print_payment_voucher',['number'=>$journal['number']])}}"><i class='bx bxs-printer text-success'></i></a>
                                    @endif
                                </td>
                                <td class="py-0 my-0"><span class="text-danger">{{ __('admin.from') }}</span>
                                    <strong>{{ $journal['debit'] }}</strong>
                                </td>
                                <td class="py-0 my-0"><br><br><span class="text-danger">{{ __('admin.to') }}</span>
                                    <strong>{{ $journal['credit'] }}</strong>
                                </td>
                                <td class="py-0 my-0">{{ $journal['statment'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <table class="table table-active">
                    <tr>
                        <th>{{ __('admin.debit') }}</th>
                        <td>{{ $sum_debit }} {{ __('admin.currency') }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('admin.credit') }}</th>
                        <td>{{ $sum_credit }} {{ __('admin.currency') }}</td>
                    </tr>
                    <tr>
                        <th class="text-danger">{{ __('admin.difference') }}</th>
                        <td>{{ $sum_debit - $sum_credit }} {{ __('admin.currency') }}</td>
                    </tr>

                </table>
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
