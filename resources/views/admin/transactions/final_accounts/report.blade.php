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
            </span> {{ __('admin.account_final') }} / {{ __('admin.balance_review') }}</h4>

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
                            <label for="to" class="form-label">{{ __('admin.account_final') }}</label>
                            <select name="account_final_type" id="account_final_type" class="form-control">
                                <option value="0" {{ Request()->account_final_type == 0 ? 'selected' : '' }}>
                                    {{ __('admin.all') }}</option>
                                <option value="1" {{ Request()->account_final_type == 1 ? 'selected' : '' }}>
                                    {{ __('admin.budget') }}</option>
                                <option value="2" {{ Request()->account_final_type == 2 ? 'selected' : '' }}>
                                    {{ __('admin.profits_and_losses') }}</option>
                            </select>
                        </div>
                        <div class="mb-3 col">
                            <label for="to" class="form-label">{{ __('admin.level') }}</label>
                            <select name="level" id="level" class="form-control">
                                @for ($i = 1; $i < 6; $i++)
                                    <option value="{{ $i }}"
                                        {{ Request()->level == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
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
                @if (count($accounts) > 0)
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <th>اسم الحساب</th>
                                        <th>مجموع المدين</th>
                                        <th>مجموع الدائن</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i =1; @endphp
                                    @foreach ($accounts as $account)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>
                                                {{ $account['account_number'] }}
                                                @if ($account['has_children'])
                                                    <strong>{{ $account['account_name'] }}</strong>
                                                @else
                                                    {{ $account['account_name'] }}
                                                @endif
                                            </td>
                                            <td>{{ number_format($account['total_debit'], 2) }}</td>
                                            <td>{{ number_format($account['total_credit'], 2) }}</td>
                                        </tr>
                                        {{-- @if ($account['has_children'])
                                <tr>
                                    <td colspan="3" style="padding-left: 30px;">
                                        <strong>مجموع الأبناء:</strong> 
                                        المدين: {{ number_format($account['children_debit_sum'], 2) }} |
                                        الدائن: {{ number_format($account['children_credit_sum'], 2) }}
                                    </td>
                                </tr>
                                @endif --}}
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2">المجموع الكلي</th>
                                        <th>{{ number_format($total_debit, 2) }}</th>
                                        <th>{{ number_format($total_credit, 2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    @if (Request()->account_final_type == 1)
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <table class="table table-active">
                                    <thead>
                                        <tr>
                                            <th>{{ __('admin.debit') }}</th>
                                            <th>{{ __('admin.credit') }}</th>
                                            <th>{{ __('admin.result') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{$total_credit > $total_debit ? ($total_credit - $total_debit) : 0 }}</td>
                                            <td>{{$total_debit  > $total_credit ? ($total_debit - $total_credit) : 0 }} </td>
                                            <td>{!! $profit_losses !!} </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif


                    @if (Request()->account_final_type == 2)
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <table class="table table-active">
                                    <thead>
                                        <tr>
                                            <th>{{ __('admin.debit') }}</th>
                                            <th>{{ __('admin.credit') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $total_debit }}</td>
                                            <td>{{ $total_credit }} </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="alert alert-warning">لا توجد بيانات لعرضها.</div>
                @endif
            </div>
        </div>
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
