<x-app-layout>
    @section('title')
        {{ __('admin.branch_branch_manager') }} / {{ __('admin.branch_branch_show') }}
    @endsection
    @section('VendorsCss')
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
        <link rel="stylesheet" href="{{ asset('build/assets/vendor/libs/select2/select2.css') }}" />
    @endsection
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light"> {{ __('admin.vendors_companies') }} / </span>
            {{ __('admin.show') }}
        </h4>

        <div class="card-body">
            <div class="d-flex justify-content-around card">
                <div>
                    {{-- <div class="card mb-3 p-2" style="max-width: 540px;"> --}}
                    <div class="row g-0">
                        <div class="col-md-4">
                            @if ($company->logo)
                                <img src="{{ asset('build/assets/img/uploads/logos/' . $company->logo) }}"
                                    class="img-fluid rounded-start" alt="...">
                            @else
                                <img src="{{ asset('build/assets/img/uploads/avatars/1.png') }}"
                                    class="img-fluid rounded-start" alt="...">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><strong>{{ __('admin.vendors_companies_company_name') }}
                                        :</strong>
                                    {{ $company->name }}</h5>
                                <h5 class="card-title">
                                    <strong>{{ __('admin.vendors_companies_company_owner_name') }}
                                        :</strong> {{ $company?->vendor?->name }}
                                </h5>
                                <h5 class="card-text"><strong>{{ __('admin.delivery_fees') }} :</strong>
                                    {{ $company?->vendor_rate }} {{ __('admin.currency') }}</h5>
                                <h5 class="card-text"><strong>{{ __('admin.branch_branch_name') }} :</strong>
                                    {{ $company?->branch?->branch_name }}</h5>
                                <h5 class="card-text"> {{ $company?->phone_number }} -
                                    {{ $company?->mobile_number }}
                                </h5>
                                <h4>رقم حساب الشركة في شجرة الحسابات</h4>
                                <h4>{{ $company->account_number }}</h4>
                                <div class="d-flex justify-content-start">
                                    <a href="{{ route('admin.vendors_company_edit', $company->id) }}"
                                        class="btn btn-success">{{ __('admin.edit') }}</a>
                                    @hasrole('Super Admin', 'admin')
                                        @if ($company->status == 1)
                                            <a href="#" class="btn btn-label-info mx-2">{{ __('admin.stop_it') }}</a>
                                        @else
                                            <a href="#" class="btn btn-label-info">{{ __('admin.active_it') }}</a>
                                        @endif
                                    @endhasrole
                                    @if ($company->vendor_id)
                                        <a href="{{ route('admin.vendors_show', $company->vendor_id) }}"
                                            class="btn btn-label-danger">{{ __('admin.show_owner') }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-4">
                <h2>
                    {{ __('admin.bank_accounts') }}
                </h2>
                <div class="d-flex justify-content-around flex-wrap">
                    @foreach ($banks as $bank)
                        <div class="mb-4">
                            <div class="card" style="width: 18rem;">
                                <div class="card-img-container" style="background-color: #fff; padding: 10px;">
                                    <img src="{{ asset('build/assets/img/banks/' . $bank?->bank?->logo) }}"
                                        class="card-img-top" alt="Bank Logo"
                                        style="max-width: 100%; height: 150px; object-fit: contain;">
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title">{{ $bank?->bank?->name_bank }}</h5>
                                        <p class="card-text"> {{ $bank?->iban_number }}</p>
                                        @if ($bank->is_default == 0)
                                            <a href="#"
                                                class="btn btn-xs btn-label-facebook">{{ __('admin.make_as_default') }}</a>
                                        @else
                                            <h6 class="text-bg-danger p-2">الحساب الافتراضي</h6>
                                            <br>
                                        @endif
                                        @hasrole('Super Admin', 'admin')
                                            <a href="#"
                                                class="btn btn-xs btn-label-danger">{{ __('admin.delete') }}</a>
                                        @endhasrole
                                        @hasrole('Super Admin', 'admin')
                                            @if ($bank->status == 1)
                                                <a href="#"
                                                    class="btn btn-xs btn-label-info">{{ __('admin.stop_it') }}</a>
                                            @else
                                                <a href="#"
                                                    class="btn btn-xs btn-label-info">{{ __('admin.active_it') }}</a>
                                            @endif
                                        @endhasrole
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


    </div>

    <!-- / Content -->
    @section('VendorsJS')
        <!-- Vendors JS -->
        <script src="{{ asset('build/assets/vendor/libs/cleavejs/cleave.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/moment/moment.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
        <script src="{{ asset('build/assets/vendor/libs/select2/select2.js') }}"></script>

        <!-- Main JS -->
        <script src="{{ asset('build/assets/js/main.js') }}"></script>

        <!-- Page JS -->
        <script src="{{ asset('build/assets/js/form-layouts.js') }}"></script>
    @endsection
</x-app-layout>
