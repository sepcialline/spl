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


                        <!-- Header -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="user-profile-header-banner">
                                        <img
                                            src="{{ asset('build/assets/img/pages/profile-banner.png') }}"
                                            alt="Banner image" class="rounded-top" />
                                    </div>
                                    <div
                                        class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                                        <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                                            @if ($vendor->avatar)
                                                <img src="{{ asset('build/assets/img/uploads/vendors/' . $vendor->avatar) }}"
                                                    alt="user image"
                                                    class="d-block h-auto ms-0 ms-sm-4 rounded-3 user-profile-img vendor_image" />
                                            @else
                                                <img src="{{ asset('build/assets/img/avatars/1.png') }}"
                                                    alt="user image"
                                                    class="d-block h-auto ms-0 ms-sm-4 rounded-3 user-profile-img vendor_image" />
                                            @endif
                                        </div>
                                        <div class="flex-grow-1 mt-3 mt-sm-5">
                                            <div
                                                class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                                <div class="user-profile-info">
                                                    <h4>{{ $vendor->name }}</h4>
                                                    <ul
                                                        class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                                        <li class="list-inline-item fw-semibold"><i
                                                                class="bx bx-mail-send"></i> {{ $vendor?->email }}</li>
                                                        <li class="list-inline-item fw-semibold"><i
                                                                class="bx bx-mobile"></i>{{ $vendor?->mobile }}</li>
                                                        <li class="list-inline-item fw-semibold">
                                                            <i class="bx bx-calendar-alt"></i>
                                                            {{ __('admin.joined_date') }}
                                                            {{ \Carbon\Carbon::parse($vendor?->created_at)->format('Y-m-d') }}
                                                        </li>
                                                    </ul>
                                                </div>
                                                <a href="javascript:void(0)" class="btn btn-label-danger text-nowrap">
                                                    <i class="bx bx-user-x me-1"></i>{{ __('admin.stop_it') }}
                                                    <a href="{{ route('vendor.vendor_profile_index') }}"
                                                        class="btn btn-label-success text-nowrap">
                                                        <i
                                                            class="bx bx-user-check me-1"></i>{{ __('admin.my_profile') }}
                                                    </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Header -->

                        {{-- <!-- Navbar pills -->
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-pills flex-column flex-sm-row mb-4">
                                    <li class="nav-item">
                                        <a class="nav-link" href="pages-profile-user.html"><i
                                                class="bx bx-user me-1"></i> Profile</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="javascript:void(0);"><i
                                                class="bx bx-group me-1"></i> Teams</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="pages-profile-projects.html"><i
                                                class="bx bx-grid-alt me-1"></i> Projects</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="pages-profile-connections.html"><i
                                                class="bx bx-link-alt me-1"></i> Connections</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--/ Navbar pills --> --}}

                        <!-- Teams Cards -->
                        <div class="row g-4">
                            <h3>{{ __('admin.company_list') }}</h3>
                            @foreach ($companies as $company)
                                <div class="col-xl-4 col-lg-6 col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <a href="javascript:;" class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-2">
                                                        @if ($company->logo)
                                                            <img src="{{ asset('build/assets/img/uploads/logos/' . $company->logo) }}"
                                                                alt="Avatar" class="rounded-circle" />
                                                        @else
                                                            <img src="{{ asset('build/assets/img/avatars/1.png') }}"
                                                                alt="Avatar" class="rounded-circle" />
                                                        @endif

                                                    </div>
                                                    <div class="me-2 text-body h5 mb-0">{{ $company?->name }}</div>
                                                </a>
                                                <div class="ms-auto">
                                                    <ul class="list-inline mb-0 d-flex align-items-center">
                                                        {{-- <li class="list-inline-item me-0">
                                                            <a href="javascript:void(0);"
                                                                class="d-flex align-self-center text-body"><i
                                                                    class="bx bx-star"></i></a>
                                                        </li> --}}
                                                        <li class="list-inline-item">
                                                            <div class="dropdown">
                                                                <button type="button"
                                                                    class="btn dropdown-toggle hide-arrow p-0"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                                    {{ __('admin.actions') }}
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li><a class="dropdown-item"
                                                                            href="{{ route('vendor.company_profile', $company->id) }}">{{ __('admin.company_profile') }}</a>
                                                                    </li>
                                                                    <li>
                                                                        <form
                                                                            action="{{ route('vendor.shipments_index') }}"
                                                                            method="get">
                                                                            <input type="hidden" name="company_id"
                                                                                value="{{ $company->id }}">
                                                                            <button class="dropdown-item"
                                                                                type="submit">{{ __('admin.shipments_shipments_list') }}</button>
                                                                        </form>
                                                                    </li>
                                                                    {{-- <li><a class="dropdown-item"
                                                                            href="javascript:void(0);">{{ __('admin.payments') }}</a> --}}
                                                                    </li>
                                                                    <li><a class="dropdown-item"
                                                                            href="{{route('vendor.bank_accounts',$company->id)}}">{{ __('admin.bank_accounts') }}</a>
                                                                    </li>
                                                                    <li><a class="dropdown-item"
                                                                            href="{{route('vendor.services.index',$company->id)}}">{{ __('admin.service_request') }}</a>
                                                                    </li>
                                                                    <li>
                                                                        <hr class="dropdown-divider" />
                                                                    </li>
                                                                    <li>
                                                                        @if ($company->status == 1)
                                                                            <a class="dropdown-item text-danger"
                                                                                href="javascript:void(0);">{{ __('admin.stop_it') }}</a>
                                                                        @else
                                                                            <a class="dropdown-item text-primary"
                                                                                href="javascript:void(0);">{{ __('admin.active_it') }}</a>
                                                                        @endif
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <p>{{ $company?->description }}</p>
                                            <p></p>
                                            <div class="d-flex align-items-center flex-wrap gap-1">
                                                <div class="d-flex align-items-center">
                                                    {{-- <ul
                                                        class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-bs-placement="top" title="Vinnie Mostowy"
                                                            class="avatar avatar-sm pull-up">
                                                            <img class="rounded-circle"
                                                                src="../../assets/img/avatars/5.png" alt="Avatar" />
                                                        </li>
                                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-bs-placement="top" title="Allen Rieske"
                                                            class="avatar avatar-sm pull-up">
                                                            <img class="rounded-circle"
                                                                src="../../assets/img/avatars/12.png" alt="Avatar" />
                                                        </li>
                                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-bs-placement="top" title="Julee Rossignol"
                                                            class="avatar avatar-sm pull-up">
                                                            <img class="rounded-circle"
                                                                src="../../assets/img/avatars/6.png" alt="Avatar" />
                                                        </li>
                                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-bs-placement="top" title="George Burrill"
                                                            class="avatar avatar-sm pull-up">
                                                            <img class="rounded-circle"
                                                                src="../../assets/img/avatars/7.png" alt="Avatar" />
                                                        </li>
                                                        <li>
                                                            <small class="text-muted ms-1">+254</small>
                                                        </li>
                                                    </ul> --}}
                                                    <p>{{ __('admin.account_number') }} #
                                                        <strong>{{ $company?->account_number }}</strong>#
                                                    </p>
                                                </div>
                                                @if ($company->bankAccounts && count($company->bankAccounts) > 0)
                                                    <div class="ms-auto">
                                                        @foreach ($company->bankAccounts as $bank)
                                                            @if($bank->is_default == 1)
                                                            <a href="javascript:;" class="me-1"><span
                                                                    class="badge bg-label-primary">{{ $bank?->bank->name_bank }}</span> <br> <span>  {{ str_repeat('*', strlen($bank?->iban_number) - 4) . substr($bank?->iban_number, -4) }}</span>
                                                            </a>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="ms-auto">
                                                        <span
                                                            class="text-danger">{{ __('admin.there_no_bank_account_refer_to_this_company') }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <!--/ Teams Cards -->
                    </div>
                    <!-- / Content -->



                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
</x-vendor-layout>
