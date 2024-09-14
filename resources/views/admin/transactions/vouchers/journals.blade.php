<x-app-layout>
    @section('title')
        {{ __('admin.transactions') }} | {{ __('admin.journals') }}
    @endsection

    @section('VendorsCss')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .table-custom {
                font-size: 0.875rem;
                /* تغيير حجم الخط */
            }

            .table-custom th,
            .table-custom td {
                vertical-align: middle;
            }

            .table-custom thead th {
                background-color: #f8f9fa;
                /* لون خلفية الهيدر */
            }

            .totals-container {
                margin-top: 20px;
            }

            .totals-container h3 {
                font-size: 1.25rem;
                /* حجم الخط للعناوين */
            }

            .totals-container p {
                font-size: 1rem;
                /* حجم الخط للنصوص */
            }
        </style>
    @endsection

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4"> <span class="text-muted fw-light">{{ __('admin.transactions') }} /
            </span> {{ __('admin.journals') }} </h4>

        <div class="card my-2">
            <div class="card-body">
                <form action="">
                    <div class="row">
                        <div class="mb-3 col">
                            <label for="from" class="form-label">{{ __('admin.from') }}</label>
                            <input type="date" class="form-control" id="from" name="from"
                                value="{{ Request()->from ?? Carbon\Carbon::today()->format('Y-m-d') }}">
                        </div>
                        <div class="mb-3 col">
                            <label for="to" class="form-label">{{ __('admin.to') }}</label>
                            <input type="date" class="form-control" id="to" name="to"
                                value="{{ Request()->to ?? Carbon\Carbon::today()->format('Y-m-d') }}">
                        </div>
                        <div class="mb-3 col">
                            <label for="account" class="form-label">{{ __('admin.accounts_accounts') }}</label>
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
                        <div class="mb-3 col">
                            <label for="account" class="form-label">{{ __('admin.in_branch') }}</label>
                            <select class="js-example-basic-single form-control" name="branch_id" id="branch_id">
                                <option value="0" {{ 0 == Request()->account ? 'selected' : '' }}>
                                    {{ __('admin.all') }}</option>
                                @foreach ($branches as $branche)
                                    <option value="{{ $branche->id }}"
                                        {{ $branche->id == Request()->branch_id ? 'selected' : '' }}>
                                        {{ $branche->branch_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col">
                            <label for="account" class="form-label">{{ __('admin.cost_center') }}</label>
                            <select class="js-example-basic-single form-control" name="cost_center" id="cost_center">
                                <option value="0" {{ 0 == Request()->cost_center ? 'selected' : '' }}>
                                    {{ __('admin.all') }}</option>
                                @foreach ($cost_centers as $cost_center)
                                    <option value="{{ $cost_center->id }}"
                                        {{ $cost_center->id == Request()->cost_center ? 'selected' : '' }}>
                                        {{ $cost_center->car_name }} {{ $cost_center->car_plate }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col">
                            <label for="final_accounts" class="form-label">الحسابات الختامية</label>
                            <select class="js-example-basic-single form-control" name="final_accounts"
                                id="final_accounts">
                                <option value="0" {{ 0 == Request()->cost_center ? 'selected' : '' }}>
                                    {{ __('admin.all') }}</option>
                                @foreach ($final_accounts as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ $key == Request()->final_accounts ? 'selected' : '' }}>
                                        {{ $value }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" name="action" value="search"
                        class="btn btn-label-dark">{{ __('admin.search') }}</button>
                    <button type="submit" name="action" value="export"
                        class="btn btn-label-success">{{ __('admin.export') }}</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-custom text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('admin.number_voucher') }}</th>
                                <th>{{ __('admin.debit') }}</th>
                                <th>{{ __('admin.credit') }}</th>
                                <th>{{ __('admin.statment') }}</th>
                                <th>{{ __('admin.account_name') }}</th>
                                <th>{{ __('admin.shipment_no') }}/{{ __('admin.cost_center') }}</th>
                                <th>{{ __('admin.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($journals as $journal)
                            @php $entries = App\Models\AccountingEntries::where('number',$journal)->get(); @endphp --}}
                            @php $i = 1; @endphp
                            @foreach ($entries as $index => $entry)
                                <tr>
                                    <td>{{ $i++ }} </td>
                                    {{-- @if ($index == 0) --}}
                                    <td rowspan="">
                                        <br>
                                        @if ($entry->journal_type_id == 1)
                                            <a target="_blank"
                                                href="{{ route('admin.account.print_journal_voucher', ['number' => $entry->number]) }}"><i
                                                    class='bx bxs-printer text-warning'></i></a>
                                            JV-{{ $entry->number }}
                                        @elseif ($entry->journal_type_id == 2)
                                            {{-- recipt Voucher  --}}
                                            <a target="_blank"
                                                href="{{ route('admin.account.print_recipt_voucher', ['number' => $entry->number]) }}"><i
                                                    class='bx bxs-printer text-danger'></i></a>
                                            CR-{{ $entry->number }}
                                        @elseif($entry->journal_type_id == 3)
                                            {{-- payment  Voucher  --}}
                                            <a target="_blank"
                                                href="{{ route('admin.account.print_payment_voucher', ['number' => $entry->number]) }}"><i
                                                    class='bx bxs-printer text-success'></i></a>
                                            CP-{{ $entry->number }}
                                        @else
                                            JS-{{ $entry->number }}
                                        @endif

                                    </td>
                                    {{-- @endif --}}
                                    <td>{{ $entry->amount_debit ?? '' }}</td>
                                    <td>{{ $entry->amount_credit ?? '' }}</td>
                                    {{-- @if ($index == 0) --}}
                                    <td rowspan="">
                                        {{ $entry->statment ? ' بيان الصرف' . ' : ' . $entry->statment : '' }}
                                        <span class='text-danger'>{{ $entry->shipment?->company->name ?? '' }}</span>
                                        <br>
                                        {{ $entry->statment_for_journal ? ' بيان القيد' . ' : ' . $entry->statment_for_journal : '' }}
                                    </td>
                                    {{-- @endif --}}
                                    <td>{{ $entry?->debit_account_number }} {{ $entry?->debit_account_name }}
                                        {{ $entry?->credit_account_number }} {{ $entry?->credit_account_name }} </td>
                                    {{-- @if ($index == 0) --}}
                                    <td rowspan="">
                                        {{ $entry->shipment ? 'ship#' . $entry?->shipment->shipment_refrence : '' }}
                                        {{ $entry?->costCenter?->car_name }}
                                        {{ $entry?->costCenter?->car_plate }}

                                        <br>
                                        {{ $entry?->branch?->branch_name }}
                                    </td>
                                    {{-- @endif --}}
                                    <td>
                                        {{-- <form action="{{ route('admin.account.post_voucher') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="number" value="{{ $entry->number }}">
                                            <input type="hidden" name="type" value="{{ $entry->journal_type_id }}">
                                            @if ($entry->is_posted == 0)
                                                <input type="hidden" name="post_value" value="1">
                                                <button type="submit" class="btn btn-xs btn-label-danger">post</button>
                                            @else
                                                <input type="hidden" name="post_value" value="0">
                                                <button type="submit" class="btn btn-xs btn-label-gray">unpost</button>
                                            @endif
                                        </form> --}}
                                        {{-- <a href="#" class="btn btn-xs btn-label-success">edit</a> --}}
                                        {{-- <a href="" class="btn btn-xs btn-label-dark">view</a> --}}
                                        <form action="{{ route('admin.account.journal.delete') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="number" value="{{ $entry->number }}">
                                            <input type="hidden" name="type" value="{{$entry->journal_type_id}}">
                                            <button type="submit" class="btn btn-xs btn-label-danger"><i
                                                    class='bx bx-trash'></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            {{-- @endforeach --}}
                        </tbody>
                    </table>
                </div>
                <hr>
                <table class="table table-active">
                    <tr>
                        <th>الرصيد السابق</th>
                        <td>{{ $totals['total_last_balande'] ?? 0 }}</td>
                    </tr>
                    <tr>
                        <th>الرصيد المدين</th>
                        <td>{{ $totals['total_debit'] ?? 0 }}</td>
                    </tr>
                    <tr>
                        <th>الرصيد الدائن</th>
                        <td>{{ $totals['total_credit'] ?? 0 }}</td>
                    </tr>
                    <tr>
                        <th>الرصيد </th>
                        <td>{{ $totals['total_last_balande'] + $totals['total_debit'] - $totals['total_credit'] }}
                        </td>
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
