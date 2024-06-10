<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
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
        <li class="menu-item">
            <a href="{{ route('employee.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="{{ __('admin.dashboard_dashboard') }}">{{ __('admin.dashboard_dashboard') }}</div>
            </a>
        </li>


        {{-- warehouse --}}
        @if (Auth::guard('employee')->user()->can('employee-warehouse-show-products') ||
                Auth::guard('employee')->user()->can('employee-warehouse-transfer-request') ||
                Auth::guard('employee')->user()->can('employee-warehouse-delivered_quantity'))
            <li class="menu-item {{ request()->is('*/*/warehouse/*') ? '  active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    {{-- <i class='menu-icon tf-icons  bx bxs-store-alt'></i> --}}
                    <i class="menu-icon fa-solid fa-warehouse"></i>
                    <div data-i18n="Shopify">{{ __('admin.warehouse') }}</div>
                </a>
                <ul class="menu-sub">

                    @if (Auth::guard('employee')->user()->can('employee-warehouse-show-products'))
                        <li class="menu-item">
                            <a href="{{ route('employee.products_index') }}"
                                class="menu-link {{ Request::routeIs('employee.products_index') ? 'active' : '' }}">
                                <div data-i18n="{{ __('admin.warehouse_products') }}">
                                    {{ __('admin.warehouse_products') }}</div>
                            </a>
                        </li>
                    @endif
                    @if (Auth::guard('employee')->user()->can('mployee-warehouse-transfer-request'))
                        <li class="menu-item">
                            <a href="{{ route('employee.transfer_index') }}"
                                class="menu-link {{ Request::routeIs('employee.transfer_index') ? 'active' : '' }}">
                                <div data-i18n="{{ __('admin.warehouse_transfer') }}">
                                    {{ __('admin.warehouse_transfer') }}</div>
                            </a>
                        </li>
                    @endif
                    @if (Auth::guard('employee')->user()->can('employee-warehouse-delivered_quantity'))
                        <li class="menu-item">
                            <a href="{{ route('employee.transfer_product_index') }}"
                                class="menu-link {{ Request::routeIs('employee.transfer_product_index') ? 'active' : '' }}">
                                <div data-i18n="{{ __('admin.transfer_product') }}">
                                    {{ __('admin.transfer_product') }}</div>
                            </a>
                        </li>
                    @endif

                </ul>
            </li>
        @endif

        {{-- User Management --}}
        @if (Auth::guard('employee')->user()->can('employee-Employee-show-page') ||
                Auth::guard('employee')->user()->can('employee-rider-show-page') ||
                Auth::guard('employee')->user()->can('employee-role-show-page'))
            <li class="menu-item  {{ request()->is('*/*/users/*') ? '  active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon fa-solid fa-circle-user"></i>
                    <div data-i18n="{{ __('admin.user_management') }}">
                        {{ __('admin.user_management') }}</div>
                </a>

                <ul class="menu-sub">
                    @if (Auth::guard('employee')->user()->can('employee-Employee-show-page'))
                        <li class="menu-item {{ Request::routeIs('employee.users_employee_index') ? 'active' : '' }}">
                            <a href="{{ route('employee.users_employee_index') }}" class="menu-link">
                                <div data-i18n="{{ __('admin.user_management_employee') }}">
                                    {{ __('admin.user_management_employee') }}</div>

                            </a>
                        </li>
                    @endif

                    @if (Auth::guard('employee')->user()->can('employee-rider-show-page'))
                        <li class="menu-item">
                            <a href="{{ route('employee.users_rider_index') }}"
                                class="menu-link {{ Request::routeIs('employee.users_rider_index') ? 'active' : '' }}">
                                <div data-i18n="{{ __('admin.user_management_rider') }}">
                                    {{ __('admin.user_management_rider') }}</div>
                            </a>
                        </li>
                    @endif


                    @if (Auth::guard('employee')->user()->can('employee-role-show-page'))
                        <li class="menu-item {{ Request::routeIs('employee.roles_employee_index') ? 'active' : '' }}">
                            <a href="{{ route('employee.roles_employee_index') }}" class="menu-link">
                                <div data-i18n="{{ __('admin.user_management_Role') }}">
                                    {{ __('admin.user_management_Role') }}</div>

                            </a>
                        </li>
                    @endif


                </ul>
            </li>
        @endif




        @if (Auth::guard('employee')->user()->can('employee-Shipment-Report') ||
                Auth::guard('employee')->user()->can('employee-Shipment-add') ||
                Auth::guard('employee')->user()->can('employee-Shipment-daily-report') ||
                Auth::guard('employee')->user()->can('employee-Shipment-assign rider'))
            <!-- shipments -->
            <li class="menu-item {{ request()->is('*/*/shipments/*') ? 'active open' : '' }}  ">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bxs-truck"></i>
                    <div data-i18n="{{ __('admin.shipments_shipments') }}">{{ __('admin.shipments_shipments') }}</div>
                </a>
                <ul class="menu-sub">
                    @if (Auth::guard('employee')->user()->can('employee-Shipment-Report'))
                        <li class="menu-item">
                            <a href="{{ route('employee.shipments_index') }}"
                                class="menu-link {{ Request::routeIs('employee.shipments_index') ? 'active' : '' }}">
                                <div data-i18n="Analytics">{{ __('admin.shipments_shipments_list') }}</div>
                            </a>
                        </li>
                    @endif

                    @if (Auth::guard('employee')->user()->can('employee-Shipment-add'))
                        <li class="menu-item">
                            <a href="{{ route('employee.shipments_create') }}"
                                class="menu-link {{ Request::routeIs('employee.shipments_create') ? 'active' : '' }}">
                                <div data-i18n="{{ __('admin.shipments_create_shipment') }}">
                                    {{ __('admin.shipments_create_shipment') }}</div>
                            </a>
                        </li>
                    @endif

                    @if (Auth::guard('employee')->user()->can('employee-Shipment-daily-report'))
                        <li class="menu-item">
                            <a href="{{ route('employee.shipments_daily_rider') }}"
                                class="menu-link {{ Request::routeIs('employee.shipments_daily_rider') ? 'active' : '' }}">
                                <div data-i18n="{{ __('admin.shipments_daily_report') }}">
                                    {{ __('admin.shipments_daily_report') }}</div>
                            </a>
                        </li>
                    @endif

                    @if (Auth::guard('employee')->user()->can('employee-Shipment-assign rider'))
                        <li class="menu-item">
                            <a href="{{ route('employee.shipments_assign_to_rider') }}"
                                class="menu-link {{ Request::routeIs('employee.shipments_assign_to_rider') ? 'active' : '' }}">
                                <div data-i18n="{{ __('admin.assign_shipments_to_rider') }}">
                                    {{ __('admin.assign_shipments_to_rider') }}</div>
                            </a>
                        </li>
                    @endif

                    @if (Auth::guard('employee')->user()->can('employee-Shipment-print'))
                        <li class="menu-item">
                            <a href="{{ route('employee.shipment_vendor_stickers') }}"
                                class="menu-link
                        {{ Request::routeIs('employee.shipment_vendor_stickers') ? 'active' : '' }}">
                                <div data-i18n="{{ __('admin.shipments_print_management') }}">
                                    {{ __('admin.shipments_print_management') }}</div>
                            </a>
                        </li>

                        <li class="menu-item">
                            <a href="{{ route('employee.shipment_vendor_invoices') }}"
                                class="menu-link
                            {{ Request::routeIs('employee.shipment_vendor_invoices') ? 'active' : '' }}">
                                <div data-i18n="{{ __('admin.print_multi_invoices') }}">
                                    {{ __('admin.print_multi_invoices') }}</div>
                            </a>
                        </li>
                    @endcan

            </ul>
        </li>
    @endif
    {{-- expenses --}}
    @if (Auth::guard('employee')->user()->can('employee-Expense-show-page'))
        <li class="menu-item {{ request()->is('*/*/expenses') ? '  active open' : '' }}">
            <a href="{{ route('employee.expenses_index') }}" class="menu-link">
                <i class="menu-icon fa-solid fa-receipt"></i>
                <div data-i18n="{{ __('admin.dashboard_expenses') }}">{{ __('admin.dashboard_expenses') }}</div>
            </a>
        </li>
    @endif



    @if (Auth::guard('employee')->user()->can('employee-transiction-collect-cash'))
        <!-- Misc -->
        <li class="menu-header small text-uppercase"><span
                class="menu-header-text">{{ __('admin.accounts_accounts') }}</span></li>

        <li
            class="menu-item  {{ request()->is('*/*/collect-cash/*') ? '  active open' : '' }} {{ request()->is('*/*/account/*') ? '  active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-money-withdraw"></i>
                <div data-i18n="{{ __('admin.transactions') }}">{{ __('admin.transactions') }}</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('employee.transactions_get_collect_rider_cash') }}"
                        class="menu-link {{ Request::routeIs('employee.transactions_get_collect_rider_cash') ? 'active' : '' }}">
                        <div data-i18n="{{ __('admin.collect_rider_cash') }}">
                            {{ __('admin.collect_rider_cash') }}</div>
                    </a>
                </li>

            </ul>
        </li>
    @endif
    @if (Auth::guard('employee')->user()->can('employee-report-paymetns'))
        {{-- Reports --}}
        <li class="menu-item {{ request()->is('*/*/reports/*') ? '  active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="{{ __('admin.accounts_reports') }}">{{ __('admin.accounts_reports') }}</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('employee.reports_payments') }}"
                        class="menu-link {{ Request::routeIs('employee.reports_payments') ? 'active' : '' }}">
                        <div data-i18n="{{ __('admin.payments') }}">
                            {{ __('admin.payments') }}</div>
                    </a>
                </li>


            </ul>
        </li>
        {{-- End Reports --}}
    @endif




</ul>
</aside>
