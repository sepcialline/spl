<x-app-layout>

    @section('title')
        {{ __('admin.transactions') }} | {{ __('admin.balance_review') }}
    @endsection

    @section('VendorsCss')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">{{ __('admin.transactions') }} / </span>
            {{ __('admin.balance_review') }}
        </h4>

        <div class="card my-2">
            <div class="card-body">
                <form action="">
                    <div class="row">
                        {{-- <div class="mb-3 col">
                            <label for="exampleFormControlInput1" class="form-label">{{ __('admin.from') }}</label>
                            <input type="date" class="form-control" id="from" name="from"
                                value="{{ Request()->from ?? Carbon\Carbon::today()->format('Y-m-d') }}">
                        </div>
                        <div class="mb-3 col">
                            <label for="exampleFormControlInput1" class="form-label">{{ __('admin.to') }}</label>
                            <input type="date" class="form-control" id="to" name="to"
                                value="{{ Request()->to ?? Carbon\Carbon::today()->format('Y-m-d') }}">
                        </div> --}}
                        <div class="mb-3 col">
                            <label for="exampleFormControlInput1"
                                class="form-label">{{ __('admin.report_source') }}</label>
                            <select class="js-example-basic-multiple form-control" name="report_source[]"
                                id="report_source" multiple="multiple" required>
                                @foreach ($report_sources as $report_source)
                                    <option value="{{ $report_source->id }}">{{ $report_source->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col">
                            <label for="exampleFormControlInput1"
                                class="form-label">{{ __('admin.show_options') }}</label>
                            <select class="js-example-basic-multiple form-control" name="show_options[]"
                                id="show_options" multiple="multiple" required>
                                @foreach ($show_options as $show_option)
                                    <option value="{{ $show_option['id'] }}">{{ $show_option['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <button type="submit" name="action" value="search" class="btn btn-label-dark">{{ __('admin.search') }}</button>
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
                        {{dd($accounts)}}
                        {{-- @foreach ($account_totals as $account)
                            @if ($account['account_number'] != null)
                                <tr>
                                    <td>{{ $account['account_number']['account_name'] }}
                                        {{ $account['account_number']['account_code'] }}</td>
                                    <td>{{ $account['total_debit'] }}</td>
                                    <td>{{ $account['total_credit'] }}</td>
                                    <td>{{ $account['balance'] }}</td>
                                </tr>
                            @endif
                        @endforeach --}}
                    </tbody>
                </table>
                {{-- {{ $entries->links() }} --}}

            </div>
        </div>


    </div>


    @section('VendorsJS')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.js-example-basic-multiple').select2();
            });
        </script>
    @endsection
</x-app-layout>
