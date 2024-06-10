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
        <li class="menu-item">
            <a href="{{ route('admin.index') }}" class="menu-link">
              <i class="menu-icon tf-icons bx bx-home-circle"></i>
              <div data-i18n="{{ __('admin.dashboard_dashboard') }}">{{ __('admin.dashboard_dashboard') }}</div>
            </a>
          </li>






      <!-- Misc -->
      <li class="menu-header small text-uppercase"><span class="menu-header-text">{{ __('admin.setting_general_setting') }}</span></li>



            <!-- branch manager -->
      <li class="menu-item {{  request()->is('*/*/branch/*')  ? ' active ' : '' }}">
        <a href="{{ route('admin.branch_index') }}" class="menu-link">
          <i class="menu-icon fa-solid fa-code-branch"></i>
          <div data-i18n="{{ __('admin.branch_branch_manager') }}">{{ __('admin.branch_branch_manager') }}</div>
        </a>
      </li>
         <!-- end branch manager -->

            <!-- City manager -->
            <li class="menu-item {{  request()->is('*/*/city/*')  ? ' active ' : '' }}">
                <a href="{{ route('admin.city_index') }}" class="menu-link">
                  <i class="menu-icon fa-solid fa-location-crosshairs"></i>
                  <div data-i18n="{{ __('admin.city_city_manager') }}">{{ __('admin.city_city_manager') }}</div>
                </a>
              </li>
        <!-- end City manager -->
        <!-- Finanace Year -->
        <li class="menu-item {{  request()->is('*/*/finance-year/*')  ? ' active ' : '' }}">
            <a href="{{ route('admin.finance_year_index') }}" class="menu-link">
                <i class="menu-icon fa-solid fa-calendar-days"></i>
            <div data-i18n="{{ __('admin.finance_year') }}">{{ __('admin.finance_year') }}</div>
            </a>
        </li>
        <!-- end Finanace Year -->

        <!--  General Setting -->

    <li class="menu-item {{  request()->is('*/*/setting/*')  ? '  active open' : '' }} ">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons fa-solid fa-gear"></i>
          <div data-i18n="{{ __('admin.setting_general_setting') }}">{{ __('admin.setting_general_setting') }}</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ Request::routeIs('admin.software_setting') ? 'active' : '' }}">
            <a href="{{ route('admin.software_setting') }}" class="menu-link">
              <div data-i18n="{{ __('admin.setting_software_setting') }}">{{ __('admin.setting_software_setting') }}</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="dashboards-ecommerce.html" class="menu-link">
              <div data-i18n="{{ __('admin.shipments_create_shipment') }}">{{ __('admin.shipments_create_shipment') }}</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="dashboards-ecommerce.html" class="menu-link">
              <div data-i18n="{{ __('admin.shipments_rider_management') }}">{{ __('admin.shipments_rider_management') }}</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="dashboards-ecommerce.html" class="menu-link">
              <div data-i18n="{{ __('admin.shipments_print_management') }}">{{ __('admin.shipments_print_management') }}</div>
            </a>
          </li>
          <li class="menu-item {{ Request::routeIs('admin.mail_config') ? 'active' : '' }}">
            <a href="{{ route('admin.mail_config') }}" class="menu-link">
              <div data-i18n="{{ __('admin.mail') }}">{{ __('admin.mail') }}</div>
            </a>
          </li>
          <li class="menu-item {{ Request::routeIs('admin.whatsapp_settings') ? 'active' : '' }}">
            <a href="{{ route('admin.whatsapp_settings') }}" class="menu-link">
              <div data-i18n="{{ __('admin.whatsapp_sms') }}">{{ __('admin.whatsapp_sms') }}</div>
            </a>
          </li>
          <li class="menu-item {{ Request::routeIs('admin.map_settings') ? 'active' : '' }}">
            <a href="{{ route('admin.map_settings') }}" class="menu-link">
              <div data-i18n="{{ __('admin.google_map') }}">{{ __('admin.google_map') }}</div>
            </a>
          </li>
          <li class="menu-item {{ Request::routeIs('admin.push_notification') ? 'active' : '' }}">
            <a href="{{ route('admin.push_notification') }}" class="menu-link">
              <div data-i18n="{{ __('admin.firebase') }}">{{ __('admin.firebase') }}</div>
            </a>
          </li>
        </ul>
      </li>

        <!-- end General Setting -->
    </ul>
  </aside>
