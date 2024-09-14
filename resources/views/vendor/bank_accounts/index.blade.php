<x-vendor-layout>
    @section('title')
        {{ __('admin.dashboard_dashboard') }}
    @endsection

    @section('VendorsCss')
        <!-- Page CSS -->
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/css/pages/page-profile.css') }}" />
        <!-- Helpers -->
    @endsection
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <!-- Layout container -->
            <div class="layout-page">

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="card">
                            <div class="card-body">
                                <span class="text-danger">{{__('admin.to_add_bank_accounts_you_should_return_to_dashboard_then_from_action_for_company_select_profile')}}</span>
                                <hr>
                                <span class="text-danger">{{__('admin.you_can_just_make_one_account_as_default_for_every_company')}}</span>
                                <hr>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('admin.bank_name') }}</th>
                                                <th>{{ __('admin.name_owner') }}</th>
                                                <th>Iban / Account Number</th>
                                                <th>{{ __('admin.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $i=1; @endphp
                                            @foreach ($banks as $bank)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $bank?->bank?->name_bank }}</td>
                                                    <td>{{ $bank?->name_owner }}</td>
                                                    <td><span class="badge bg-label-danger">
                                                            {{ str_repeat('*', strlen($bank?->iban_number) - 4) . substr($bank?->iban_number, -4) }}
                                                        </span></td>
                                                    <td>
                                                        <a class="btn btn-label-success btn-xs"
                                                            href="{{ route('vendor.bank_accounts_edit', $bank->id) }}">{{ __('admin.edit') }}</a>
                                                        @if ($bank->status == 1)
                                                            <a class="btn btn-label-danger btn-xs"
                                                                href="{{ route('vendor.bank_accounts_stop_it', $bank->id) }}">{{ __('admin.stop_it') }}</a>
                                                        @else
                                                            <a class="btn btn-label-facebook btn-xs"
                                                                href="{{ route('vendor.bank_accounts_active_it', $bank->id) }}">{{ __('admin.active_it') }}</a>
                                                        @endif

                                                        @if ($bank->is_default == 0)
                                                            <a class="btn btn-label-facebook btn-xs"
                                                                href="{{ route('vendor.update_to_default', $bank->id) }}">{{ __('admin.make_as_default') }}</a>
                                                        @else
                                                            <span>
                                                                <i> {{ __('admin.default') }}</i>
                                                            </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-vendor-layout>
