<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="#" class="app-brand-link">
            <img src="{{ asset('build/assets/img/logo/logo_' . LaravelLocalization::getCurrentLocale() . '.png') }}"
            width="200">
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx menu-toggle-icon d-none d-xl-block fs-4 align-middle"></i>
            <i class="bx bx-x d-block d-xl-none bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        {{-- dashboard --}}
        <li class="menu-item">
            <a href="{{ route('vendor.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="{{ __('admin.dashboard_dashboard') }}">{{ __('admin.dashboard_dashboard') }}</div>
            </a>
        </li>


        <!-- shipments -->
        <li class="menu-item {{ request()->is('*/*/shipments/*') ? 'active open' : '' }}  ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-truck"></i>
                <div data-i18n="{{ __('admin.shipments_shipments') }}">{{ __('admin.shipments_shipments') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('vendor.shipments_index') }}"
                        class="menu-link {{ Request::routeIs('vendor.shipments_index') ? 'active' : '' }}">
                        <div data-i18n="Analytics">{{ __('admin.shipments_shipments_list') }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('vendor.shipments_create') }}"
                        class="menu-link {{ Request::routeIs('admin.shipments_create') ? 'active' : '' }}">
                        <div data-i18n="{{ __('admin.shipments_create_shipment') }}">
                            {{ __('admin.shipments_create_shipment') }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('vendor.shipment_vendor_invoices') }}"
                        class="menu-link
                    {{ Request::routeIs('vendor.shipment_vendor_invoices') ? 'active' : '' }}">
                        <div data-i18n="{{ __('admin.print_multi_invoices') }}">
                            {{ __('admin.print_multi_invoices') }}</div>
                    </a>
                </li>
            </ul>
        </li>



        {{-- Reports --}}
        {{-- <li class="menu-item {{ request()->is('*/*/reports/*') ? '  active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="{{ __('admin.accounts_reports') }}">{{ __('admin.accounts_reports') }}</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('vendor.reports_payments') }}"
                        class="menu-link {{ Request::routeIs('vendor.reports_payments') ? 'active' : '' }}">
                        <div data-i18n="{{ __('admin.payments') }}">
                            {{ __('admin.payments') }}</div>
                    </a>
                </li>
            </ul>
        </li> --}}
        <!-- end General Setting -->
    </ul>
</aside>
