<x-app-layout>
    @section('title')
        Dashboard
    @endsection
    @section('VendorsCss')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <form action="">
                    <div class="row">
                        <div class="col-md mb-4">
                            <label for="" class="form-label">{{ __('admin.rider') }}</label><br>
                            <select id="" class="js-example-basic-single" name="rider_id">
                                <option value="0" {{ request()->company_id == 0 ? 'selected' : '' }}>
                                    {{ __('admin.all') }}</option>
                                @foreach ($riders as $rider)
                                    <option value="{{ $rider->id }}"
                                        {{ request()->rider_id == $rider->id ? 'selected' : '' }}>{{ $rider->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md mb-4">
                            <label for="" class="form-label">{{ __('admin.payment_method') }}</label> <br>
                            <select id="" class="js-example-basic-single" name="payment_type_id">
                                <option value="0" {{ request()->company_id == 0 ? 'selected' : '' }}>
                                    {{ __('admin.all') }}</option>
                                @foreach ($payment_types as $payment_type)
                                    <option value="{{ $payment_type->id }}"
                                        {{ request()->payment_type_id == $payment_type->id ? 'selected' : '' }}>{{ $payment_type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md mb-4">
                            <label for="" class="form-label">{{ __('admin.dashboard_expenses_expense_type') }}</label> <br>
                            <select id="" class="js-example-basic-single" name="expense_type_id">
                                <option value="0" {{ request()->company_id == 0 ? 'selected' : '' }}>
                                    {{ __('admin.all') }}</option>
                                @foreach ($expense_types as $expense_type)
                                    <option value="{{ $expense_type->id }}"
                                        {{ request()->expense_type_id == $expense_type->id ? 'selected' : '' }}>{{ $expense_type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col mb-4">
                            <label for="" class="form-label">{{ __('admin.from') }}</label> <br>
                            <input  class='form-control' type="date" name="date_from" value="{{\Carbon\Carbon::parse(Request()->date_from)->format('Y-m-d') ?? \Carbon\Carbon::now()->format('Y-m-d')}}">
                        </div>
                        <div class="col mb-4">
                            <label for="" class="form-label">{{ __('admin.to') }}</label> <br>
                            <input  class='form-control' type="date" name="date_to" value="{{\Carbon\Carbon::parse(Request()->date_to)->format('Y-m-d') ?? \Carbon\Carbon::now()->format('Y-m-d')}}">
                        </div>
                    </div>
                    <button class="btn btn-label-dark" type="submit">{{__('admin.search')}}</button>
                </form>

            </div>
        </div>
        <hr>
        <div class="row">
            <div class="card p-4">
                <div class="d-flex justify-content-sm-between align-items-sm-center">

                    <div class="d-flex align-items-sm-center">
                        <h5 class="card-header"> {{ __('admin.dashboard_expenses_list') }} </h5>
                        {{-- <span class="">
                            <a href="{{ route('admin.shopify_settings') }}"
                            class="btn btn-success btn-sm ml-2">Refresh</a>
                        </span> --}}
                    </div>


                    <a href="{{ route('admin.expenses_create') }}"
                        class="btn btn-secondary">{{ __('admin.accounts_add_expense') }}</a>

                </div>
                <div class="card-datatable table-responsive text-nowrap px-2 py-2">
                    <!-- Update Password Modal -->

                    <!--/ Update Password Modal -->
                    <table class="dt-scrollableTable table table-bordered">
                        <thead>
                            <tr>
                                {{-- <th>{{ __('admin.dashboard_expenses_list') }}</th> --}}
                                <th>{{ __('admin.dashboard_expenses_rider') }}</th>
                                <th>{{ __('admin.dashboard_expenses_expense_type') }}</th>
                                <th>{{ __('admin.dashboard_expenses_car_plate') }}?</th>
                                <th>{{ __('admin.dashboard_expenses_value') }}</th>
                                <th>{{ __('admin.dashboard_expenses_payment_type') }}?</th>
                                <th>{{ __('admin.dashboard_expenses_date') }}</th>
                                <th>{{ __('admin.dashboard_expenses_image') }}</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        @foreach ($data as $row)
                            <input type="hidden" class="_token" id="_token" value="{{ csrf_token() }}" />

                            <tr>
                                <td>{{ $row->rider->name }}</td>
                                <td>{{ $row->expense->name }} <br><span class="text-danger">{{ $row->notes }}</span>
                                </td>
                                <td>{{ $row->plate->car_name }} | {{ $row->plate->car_plate }}</td>
                                <td>{{ $row->value }} {{ __('admin.currency') }}</td>
                                <td>{{ $row->paymentType->name }}</td>
                                <td>{{ $row->date }}</td>
                                <td>
                                    <a href="{{ asset('build/assets/img/uploads/documents/' . $row->photo) }}" target="_blank"> <i class="fa fa-eye"></i> </a>
                                    {{-- <img width="100" height="100px"
                                        src="{{ asset('build/assets/img/uploads/documents/' . $row->photo) }}"
                                        alt=""> --}}
                                    </td>
                                <td><a href="{{ route('admin.expenses_edit', $row->id) }}">{{ __('admin.edit') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                {{ $data->links() }}
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
