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
            <a href="{{ route('admin.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="{{ __('admin.dashboard_dashboard') }}">{{ __('admin.dashboard_dashboard') }}</div>
            </a>
        </li>
        @can('admin-shopify-show-page')
            {{-- Shopify --}}
            <li class="menu-item {{ request()->is('*/*/shopify') ? '  active open' : '' }}">
                <a href="{{ route('admin.shopify_settings') }}" class="menu-link">
                    <i class='menu-icon tf-icons  bx bxs-store-alt'></i>
                    <div data-i18n="Shopify">Shopify</div>
                </a>
            </li>
        @endcan


        @if(auth()->user()->can('admin-Product-show-page') || auth()->user()->can('admin-Product-details-showPage') || auth()->user()->can('admin-Product-details-transfer')|| auth()->user()->can('admin-warehouse-report'))
            {{-- warehouse --}}
            <li class="menu-item {{ request()->is('*/*/warehouse/*') ? '  active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    {{-- <i class='menu-icon tf-icons  bx bxs-store-alt'></i> --}}
                    <i class="menu-icon fa-solid fa-warehouse"></i>
                    <div data-i18n="Shopify">{{ __('admin.warehouse') }}</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('admin.warehouse_index') }}"
                            class="menu-link {{ Request::routeIs('admin.warehouse_index') ? 'active' : '' }}">
                            <div data-i18n="{{ __('admin.warehouse_warehouses') }}">
                                {{ __('admin.warehouse_warehouses') }}</div>
                        </a>
                    </li>
                    @can('admin-Product-show-page')
                        <li class="menu-item">
                            <a href="{{ route('admin.products_index') }}"
                                class="menu-link {{ Request::routeIs('admin.products_index') ? 'active' : '' }}">
                                <div data-i18n="{{ __('admin.warehouse_products') }}">
                                    {{ __('admin.warehouse_products') }}</div>
                            </a>
                        </li>
                    @endcan
                    @can('admin-Product-details-showPage')
                        <li class="menu-item">
                            <a href="{{ route('admin.product_details_index') }}"
                                class="menu-link {{ Request::routeIs('admin.product_details_index') ? 'active' : '' }}">
                                <div data-i18n="{{ __('admin.products_products_details') }}">
                                    {{ __('admin.products_products_details') }}</div>
                            </a>
                        </li>
                    @endcan
                    @can('admin-Product-details-transfer')
                        <li class="menu-item">
                            <a href="{{ route('admin.transfer_index') }}"
                                class="menu-link {{ Request::routeIs('admin.transfer_index') ? 'active' : '' }}">
                                <div data-i18n="{{ __('admin.warehouse_transfer') }}">
                                    {{ __('admin.warehouse_transfer') }}</div>
                            </a>
                        </li>
                    @endcan
                    @can('admin-warehouse-report')
                        <li class="menu-item">
                            <a href="{{ route('admin.warehouse_report_index') }}"
                                class="menu-link {{ Request::routeIs('admin.transfer_index') ? 'active' : '' }}">
                                <div data-i18n="{{ __('admin.warehouse_report') }}">
                                    {{ __('admin.warehouse_report') }}</div>
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>
        @endif

        {{-- User Management --}}

        @if(auth()->user()->can('admin-admin-Show-Page') || auth()->user()->can('admin-rider-show-page') || auth()->user()->can('admin-Customers-Show-Page')|| auth()->user()->can('admin-role-show-page') || auth()->user()->can('admin-Employees-show-page'))

        <li class="menu-item  {{ request()->is('*/*/users/admin/*') ? '  active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-circle-user"></i>
                <div data-i18n="{{ __('admin.user_management') }}">
                    {{ __('admin.user_management') }}</div>
            </a>

            <ul class="menu-sub">
                @can('admin-admin-Show-Page')
                    <li class="menu-item">
                        <a href="{{ route('admin.users_admin_index') }}"
                            class="menu-link {{ Request::routeIs('admin.users_admin_index') ? 'active' : '' }}">
                            <div data-i18n="{{ __('admin.user_management_admin') }}">
                                {{ __('admin.user_management_admin') }}</div>
                        </a>
                    </li>
                @endcan

                @can('admin-rider-show-page')
                    <li class="menu-item">
                        <a href="{{ route('admin.users_rider_index') }}"
                            class="menu-link
                    {{ Request::routeIs('admin.users_rider_index') ? 'active' : '' }}">
                            <div data-i18n="{{ __('admin.user_management_rider') }}">
                                {{ __('admin.user_management_rider') }}</div>
                        </a>
                    </li>
                @endcan

                @can('admin-Customers-Show-Page')
                    <li class="menu-item {{ Request::routeIs('admin.users_customer_index') ? 'active' : '' }}">
                        <a href="{{ route('admin.users_customer_index') }}" class="menu-link">
                            <div data-i18n="{{ __('admin.user_management_user') }}">
                                {{ __('admin.user_management_user') }}</div>
                        </a>
                    </li>
                @endcan

                @can('admin-role-show-page')
                    <li class="menu-item {{ Request::routeIs('admin.roles_admin_index') ? 'active' : '' }}">
                        <a href="{{ route('admin.roles_admin_index') }}" class="menu-link">
                            <div data-i18n="{{ __('admin.user_management_Role') }}">
                                {{ __('admin.user_management_Role') }}</div>
                        </a>
                    </li>
                @endcan

                @can('admin-Employees-show-page')
                    <li class="menu-item {{ Request::routeIs('admin.users_employee_index') ? 'active' : '' }}">
                        <a href="{{ route('admin.users_employee_index') }}" class="menu-link">
                            <div data-i18n="{{ __('admin.user_management_employee') }}">
                                {{ __('admin.user_management_employee') }}</div>
                        </a>
                    </li>
                @endcan


            </ul>
        </li>
        @endif
        {{-- Vendors Management --}}


        @can('admin-Company-show page')
            <li class="menu-item  {{ request()->is('*/*/vendors/company/*') ? '  active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon fa-solid fa-building"></i>
                    <div data-i18n="{{ __('admin.vendors_management') }}">
                        {{ __('admin.vendors_management') }}</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('admin.vendors_company_index') }}"
                            class="menu-link {{ Request::routeIs('admin.vendors_company_index') ? 'active' : '' }}">
                            <div data-i18n="{{ __('admin.vendors_companies') }}">
                                {{ __('admin.vendors_companies') }}</div>
                        </a>
                    </li>


                </ul>
            </li>
        @endcan

        @if(auth()->user()->can('admin-Shipment-Report') || auth()->user()->can('admin-Shipment-add') || auth()->user()->can('admin-Shipment-daily-report')|| auth()->user()->can('admin-Shipment-assign rider') || auth()->user()->can('admin-Shipment-print') || auth()->user()->can('admin-Shipment-vendor-shipments'))

        <!-- shipments -->
        <li class="menu-item {{ request()->is('*/*/shipments/*') ? 'active open' : '' }}  ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-truck"></i>
                <div data-i18n="{{ __('admin.shipments_shipments') }}">{{ __('admin.shipments_shipments') }}</div>
            </a>
            <ul class="menu-sub">
                @can('admin-Shipment-Report')
                    <li class="menu-item">
                        <a href="{{ route('admin.shipments_index') }}"
                            class="menu-link {{ Request::routeIs('admin.shipments_index') ? 'active' : '' }}">
                            <div data-i18n="Analytics">{{ __('admin.shipments_shipments_list') }}</div>
                        </a>
                    </li>
                @endcan

                @can('admin-Shipment-add')
                    <li class="menu-item">
                        <a href="{{ route('admin.recived_shipment_index') }}"
                            class="menu-link {{ Request::routeIs('admin.recived_shipment_index') ? 'active' : '' }}">
                            <div data-i18n="استلامات">
                                استلامات</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.shipments_create') }}"
                            class="menu-link {{ Request::routeIs('admin.shipments_create') ? 'active' : '' }}">
                            <div data-i18n="{{ __('admin.shipments_create_shipment') }}">
                                {{ __('admin.shipments_create_shipment') }}</div>
                        </a>
                    </li>
                @endcan

                @can('admin-Shipment-daily-report')
                    <li class="menu-item">
                        <a href="{{ route('admin.shipments_daily_rider') }}"
                            class="menu-link {{ Request::routeIs('admin.shipments_daily_rider') ? 'active' : '' }}">
                            <div data-i18n="{{ __('admin.shipments_daily_report') }}">
                                {{ __('admin.shipments_daily_report') }}</div>
                        </a>
                    </li>
                @endcan


                    {{-- <li class="menu-item">
                        <a href="{{ route('admin.shipments_assign_to_rider') }}"
                            class="menu-link {{ Request::routeIs('admin.shipments_assign_to_rider') ? 'active' : '' }}">
                            <div data-i18n="{{ __('admin.assign_shipments_to_rider') }}">
                                {{ __('admin.assign_shipments_to_rider') }}</div>
                        </a>
                    </li> --}}

                    @can('admin-Shipment-assign rider')
                    <li class="menu-item">
                        <a href="{{ route('admin.shipments_assign_to_rider_by_scan') }}"
                            class="menu-link {{ Request::routeIs('admin.shipments_assign_to_rider_by_scan') ? 'active' : '' }}">
                            <div data-i18n="{{ __('admin.assign_shipments_to_riderby_scan') }}">
                                {{ __('admin.assign_shipments_to_riderby_scan') }}</div>
                        </a>
                    </li>
                @endcan

                @can('admin-Shipment-print')
                    <li class="menu-item">
                        <a href="{{ route('admin.shipment_vendor_stickers') }}"
                            class="menu-link
                    {{ Request::routeIs('admin.shipment_vendor_stickers') ? 'active' : '' }}">
                            <div data-i18n="{{ __('admin.shipments_print_management') }}">
                                {{ __('admin.shipments_print_management') }}</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{ route('admin.shipment_vendor_invoices') }}"
                            class="menu-link
                        {{ Request::routeIs('admin.shipment_vendor_invoices') ? 'active' : '' }}">
                            <div data-i18n="{{ __('admin.print_multi_invoices') }}">
                                {{ __('admin.print_multi_invoices') }}</div>
                        </a>
                    </li>

                @endcan

                @can('admin-Shipment-vendor-shipments')
                    <li class="menu-item">
                        <a href="{{ route('admin.shipment.vendorsShipment') }}"
                            class="menu-link
                    {{ Request::routeIs('admin.shipment.vendorsShipment') ? 'active' : '' }}">
                            <div data-i18n="{{ __('admin.vendors_shipment') }}">
                                {{ __('admin.vendors_shipment') }}</div>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>

        @endif
        {{-- expenses --}}
        @can('admin-Expense-showPage')
            <li class="menu-item {{ request()->is('*/*/expenses') ? '  active open' : '' }}">
                <a href="{{ route('admin.expenses_index') }}" class="menu-link">
                    <i class="menu-icon fa-solid fa-receipt"></i>
                    <div data-i18n="{{ __('admin.dashboard_expenses') }}">{{ __('admin.dashboard_expenses') }}</div>
                </a>
            </li>
        @endcan

        <!-- Layouts -->
        {{-- <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="{{ __('admin.stores_stores_management') }}">
                    {{ __('admin.stores_stores_management') }}
                </div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="layouts-collapsed-menu.html" class="menu-link">
                        <div data-i18n="{{ __('admin.stores_stores_list') }}">{{ __('admin.stores_stores_list') }}
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="layouts-content-navbar.html" class="menu-link">
                        <div data-i18n="{{ __('admin.stores_product_management') }}">
                            {{ __('admin.stores_product_management') }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="layouts-content-navbar-with-sidebar.html" class="menu-link">
                        <div data-i18n="{{ __('admin.stores_products_transfer') }}">
                            {{ __('admin.stores_products_transfer') }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="../horizontal-menu-template" class="menu-link">
                        <div data-i18n="{{ __('admin.stores_products_adjustment') }}">
                            {{ __('admin.stores_products_adjustment') }}</div>
                    </a>
                </li>

            </ul>
        </li> --}}


        @if(auth()->user()->can('admin-Transaction-Collect-Rider-Cash') || auth()->user()->can('admin-Transaction-Withdrwal-Bank') || auth()->user()->can('admin-Transaction-Withdrawal-From-Merchant') || auth()->user()->can('admin-Transaction-Pay-To-Merchant') || auth()->user()->can('admin-Transaction-Show-Journals') || auth()->user()->can('admin-Transaction-Journal-Voucher') || auth()->user()->can('admin-Transaction-Recipt-Voucher') || auth()->user()->can('admin-Transaction-Payment-Voucher'))
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
                @can('admin-Transaction-Collect-Rider-Cash')
                    <li class="menu-item">
                        <a href="{{ route('admin.transactions_get_collect_rider_cash') }}"
                            class="menu-link {{ Request::routeIs('admin.transactions_get_collect_rider_cash') ? 'active' : '' }}">
                            <div data-i18n="{{ __('admin.collect_rider_cash') }}">
                                {{ __('admin.collect_rider_cash') }}</div>
                        </a>
                    </li>
                @endcan

                @can('admin-Transaction-Withdrwal-Bank')
                    <li class="menu-item">
                        <a href="{{ route('admin.transactions_get_Withdrawal_from_bank') }}"
                            class="menu-link {{ Request::routeIs('admin.transactions_get_Withdrawal_from_bank') ? 'active' : '' }}">
                            <div data-i18n="{{ __('admin.transactions_Withdrawal_from_bank') }}">
                                {{ __('admin.transactions_Withdrawal_from_bank') }}</div>
                        </a>
                    </li>
                @endcan

                @can('admin-Transaction-Withdrawal-From-Merchant')
                    <li class="menu-item">
                        <a href="{{ route('admin.transactions_get_Withdrawal_from_the_merchant') }}"
                            class="menu-link {{ Request::routeIs('admin.transactions_Withdrawal_from_the_merchant') ? 'active' : '' }}">
                            <div data-i18n="{{ __('admin.transactions_Withdrawal_from_the_merchant') }}">
                                {{ __('admin.transactions_Withdrawal_from_the_merchant') }}</div>
                        </a>
                    </li>
                @endcan

                @can('admin-Transaction-Pay-To-Merchant')
                    <li class="menu-item">
                        <a href="{{ route('admin.transactions_get_pay_to_the_merchant') }}"
                            class="menu-link {{ Request::routeIs('admin.transactions_get_pay_to_the_merchant') ? 'active' : '' }}">
                            <div data-i18n="{{ __('admin.transactions_pay_to_merchant') }}">
                                {{ __('admin.transactions_pay_to_merchant') }}</div>
                        </a>
                    </li>
                @endcan


                {{-- السندات والقيود المحاسبية --}}
                <li class="menu-item  {{ request()->is('*/*/account/*') ? '  active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-no-entry"></i>
                        <div data-i18n="{{ __('admin.transactions') }}">{{ __('admin.transactions') }}</div>
                    </a>
                    <ul class="menu-sub">
                        @can('admin-Transaction-Show-Journals')
                            <li class="menu-item">
                                <a href="{{ route('admin.account.journals') }}"
                                    class="menu-link {{ Request::routeIs('admin.account.journals') ? 'active' : '' }}">
                                    <div data-i18n="{{ __('admin.journals') }}">
                                        {{ __('admin.journals') }}</div>
                                </a>
                            </li>
                        @endcan

                        @can('admin-Transaction-Journal-Voucher')
                            <li class="menu-item">
                                <a href="{{ route('admin.account.journal_voucher') }}"
                                    class="menu-link {{ Request::routeIs('admin.account.journal_voucher') ? 'active' : '' }}">
                                    <div data-i18n="{{ __('admin.journal_voucher') }}">
                                        {{ __('admin.journal_voucher') }}</div>
                                </a>
                            </li>
                        @endcan

                        @can('admin-Transaction-Recipt-Voucher')
                            <li class="menu-item">
                                <a href="{{ route('admin.account.recipt_voucher') }}"
                                    class="menu-link {{ Request::routeIs('admin.account.recipt_voucher') ? 'active' : '' }}">
                                    <div data-i18n="{{ __('admin.recipt_voucher') }}">
                                        {{ __('admin.recipt_voucher') }}</div>
                                </a>
                            </li>
                        @endcan


                        @can('admin-Transaction-Payment-Voucher')
                            <li class="menu-item">
                                <a href="{{ route('admin.account.payment_voucher') }}"
                                    class="menu-link {{ Request::routeIs('admin.account.payment_voucher') ? 'active' : '' }}">
                                    <div data-i18n="{{ __('admin.payment_voucher') }}">
                                        {{ __('admin.payment_voucher') }}</div>
                                </a>
                            </li>
                        @endcan

                    </ul>
                </li>
            </ul>

        </li>
        @endif


        @if(
        auth()->user()->can('admin-Reports-payments') ||
        auth()->user()->can('admin-Reports-claim-invoice') ||
        auth()->user()->can('admin-Reports-emirate-post')
        )
        {{-- Reports --}}
        <li class="menu-item {{ request()->is('*/*/reports/*') ? '  active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="{{ __('admin.accounts_reports') }}">{{ __('admin.accounts_reports') }}</div>
            </a>

            <ul class="menu-sub">
                @can('admin-Reports-payments')
                    <li class="menu-item">
                        <a href="{{ route('admin.reports_payments') }}"
                            class="menu-link {{ Request::routeIs('admin.reports_payments') ? 'active' : '' }}">
                            <div data-i18n="{{ __('admin.payments') }}">
                                {{ __('admin.payments') }}</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.reports_payments_branches') }}"
                            class="menu-link {{ Request::routeIs('admin.reports_payments_branches') ? 'active' : '' }}">
                            <div data-i18n="{{ __('admin.payments_branches') }}">
                                {{ __('admin.payments_branches') }}</div>
                        </a>
                    </li>
                @endcan

                @can('admin-Reports-claim-invoice')
                    <li class="menu-item">
                        <a href="{{ route('admin.claim_invoice') }}" class="menu-link">
                            <div data-i18n="{{ __('admin.claim_invoice') }}">
                                {{ __('admin.claim_invoice') }}</div>
                        </a>
                    </li>
                @endcan

                @can('admin-Reports-emirate-post')
                    <li class="menu-item">
                        <a href="{{ route('admin.emirate_post') }}"
                            class="menu-link {{ Request::routeIs('admin.emirate_post') ? 'active' : '' }}">
                            <div data-i18n="{{ __('admin.emirate_post') }}">
                                {{ __('admin.emirate_post') }}</div>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
        @endif
        {{-- End Reports --}}
        {{-- Chart of accounts --}}

        @can('admin-Chart-Of-Accounts-showPage')
            <li class="menu-item  {{ request()->is('*/*/account/*') ? '  active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="{{ __('admin.accounts_chart_of_accounts') }}">
                        {{ __('admin.accounts_chart_of_accounts') }}</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('admin.account.index') }}"
                            class="menu-link {{ Request::routeIs('admin.account.index') ? 'active' : '' }}">
                            <div data-i18n="{{ __('admin.accounts_accounts_chart_of_accounts_list') }}">
                                {{ __('admin.accounts_accounts_chart_of_accounts_list') }}</div>
                        </a>
                    </li>
                    {{-- <li class="menu-item">
                    <a href="layouts-content-navbar.html" class="menu-link">
                        <div data-i18n="{{ __('admin.accounts_Chart_of_accounts_lv1') }}">
                            {{ __('admin.accounts_Chart_of_accounts_lv1') }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="layouts-content-navbar-with-sidebar.html" class="menu-link">
                        <div data-i18n="{{ __('admin.accounts_accounts_Chart_of_accounts_lv2') }}">
                            {{ __('admin.accounts_accounts_Chart_of_accounts_lv2') }}</div>
                    </a>
                </li> --}}


                </ul>
            </li>
        @endcan

        {{-- end Chart of accounts --}}

        @if(
        auth()->user()->can('admin-Branch-Show-Page') ||
        auth()->user()->can('admin-City-Show-Page') ||
        auth()->user()->can('admin-General-Setting-Show-Page')
        )
        <!-- Misc -->
        <li class="menu-header small text-uppercase"><span
                class="menu-header-text">{{ __('admin.setting_general_setting') }}</span></li>


        @can('admin-Branch-Show-Page')
            <!-- branch manager -->
            <li class="menu-item {{ request()->is('*/*/branch/*') ? ' active ' : '' }}">
                <a href="{{ route('admin.branch_index') }}" class="menu-link">
                    <i class="menu-icon fa-solid fa-code-branch"></i>
                    <div data-i18n="{{ __('admin.branch_branch_manager') }}">{{ __('admin.branch_branch_manager') }}
                    </div>
                </a>
            </li>
            <!-- end branch manager -->
        @endcan


        @can('admin-City-Show-Page')
            <!-- City manager -->
            <li class="menu-item {{ request()->is('*/*/city/*') ? ' active ' : '' }}">
                <a href="{{ route('admin.city_index') }}" class="menu-link">
                    <i class="menu-icon fa-solid fa-location-crosshairs"></i>
                    <div data-i18n="{{ __('admin.city_city_manager') }}">{{ __('admin.city_city_manager') }}</div>
                </a>
            </li>
            <!-- end City manager -->

            {{-- <li class="menu-item {{ request()->is('*/*/rider_location') ? ' active ' : '' }}">
                <a href="{{ route('admin.rider_location') }}" class="menu-link" target="_blank">
                    <i class="menu-icon fa-solid fa-location-crosshairs"></i>
                    <div data-i18n="{{ __('admin.location') }}">{{ __('admin.location') }}</div>
                </a>
            </li> --}}
            <li class="menu-item {{ request()->is('*/*/cars') ? ' active ' : '' }}">
                <a href="{{ route('admin.cars_index') }}" class="menu-link" target="">
                    <i class="menu-icon fa-solid fa-car"></i>
                    <div data-i18n="{{ __('admin.user_management_rider_vehicle_type') }}">{{ __('admin.user_management_rider_vehicle_type') }}</div>
                </a>
            </li>

        @endcan

        <!-- Finanace Year -->
        {{-- <li class="menu-item {{ request()->is('*/*/finance-year/*') ? ' active ' : '' }}">
            <a href="{{ route('admin.finance_year_index') }}" class="menu-link">
                <i class="menu-icon fa-solid fa-calendar-days"></i>
                <div data-i18n="{{ __('admin.finance_year') }}">{{ __('admin.finance_year') }}</div>
            </a>
        </li> --}}
        <!-- end Finanace Year -->

        <!--  General Setting -->

        @can('admin-General-Setting-Show-Page')
            <li class="menu-item {{ request()->is('*/*/setting/*') ? '  active open' : '' }} ">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons fa-solid fa-gear"></i>
                    <div data-i18n="{{ __('admin.setting_general_setting') }}">
                        {{ __('admin.setting_general_setting') }}</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ Request::routeIs('admin.software_setting') ? 'active' : '' }}">
                        <a href="{{ route('admin.software_setting') }}" class="menu-link">
                            <div data-i18n="{{ __('admin.setting_software_setting') }}">
                                {{ __('admin.setting_software_setting') }}</div>
                        </a>
                    </li>
                    {{-- <li class="menu-item">
                    <a href="dashboards-ecommerce.html" class="menu-link">
                        <div data-i18n="{{ __('admin.shipments_create_shipment') }}">
                            {{ __('admin.shipments_create_shipment') }}</div>
                    </a>
                </li> --}}
                    {{-- <li class="menu-item">
                    <a href="dashboards-ecommerce.html" class="menu-link">
                        <div data-i18n="{{ __('admin.shipments_rider_management') }}">
                            {{ __('admin.shipments_rider_management') }}</div>
                    </a>
                </li> --}}
                    {{-- <li class="menu-item">
                    <a href="dashboards-ecommerce.html" class="menu-link">
                        <div data-i18n="{{ __('admin.shipments_print_management') }}">
                            {{ __('admin.shipments_print_management') }}</div>
                    </a>
                </li> --}}
                    {{-- <li class="menu-item {{ Request::routeIs('admin.mail_config') ? 'active' : '' }}">
                    <a href="{{ route('admin.mail_config') }}" class="menu-link">
                        <div data-i18n="{{ __('admin.mail') }}">{{ __('admin.mail') }}</div>
                    </a>
                </li> --}}
                    {{-- <li class="menu-item {{ Request::routeIs('admin.whatsapp_settings') ? 'active' : '' }}">
                    <a href="{{ route('admin.whatsapp_settings') }}" class="menu-link">
                        <div data-i18n="{{ __('admin.whatsapp_sms') }}">{{ __('admin.whatsapp_sms') }}</div>
                    </a>
                </li> --}}
                    <li class="menu-item {{ Request::routeIs('admin.map_settings') ? 'active' : '' }}">
                        <a href="{{ route('admin.map_settings') }}" class="menu-link">
                            <div data-i18n="{{ __('admin.google_map') }}">{{ __('admin.google_map') }}</div>
                        </a>
                    </li>
                    {{-- <li class="menu-item {{ Request::routeIs('admin.push_notification') ? 'active' : '' }}">
                    <a href="{{ route('admin.push_notification') }}" class="menu-link">
                        <div data-i18n="{{ __('admin.firebase') }}">{{ __('admin.firebase') }}</div>
                    </a>
                </li> --}}
                </ul>
            </li>
        @endcan

            @endif


    </ul>
</aside>
