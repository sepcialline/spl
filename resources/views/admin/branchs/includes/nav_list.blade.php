<ul class="nav nav-pills flex-column flex-md-row mb-3" style="background: #ffd20042 !important">
    <li class="nav-item" style="font-size: 12px">
        <a class="nav-link {{ $active === 'rev' ? 'active' : '' }}"
            href="{{ route('admin.branch_account_details_rev', $branch->id) }}">
            <i class="bx bx-money me-1"></i>
            {{ __('admin.accountant_details(revenues)') }}</a>
    </li>
    <li class="nav-item" style="font-size: 12px">
        <a class="nav-link {{ $active === 'vat_on_sales' ? 'active' : '' }}"
            href="{{ route('admin.branch_account_details_vat_on_sales', $branch->id) }}">
            <i class="bx bx-money me-1"></i>
            {{ __('admin.vat_on_sales') }}</a>
    </li>
    <li class="nav-item" style="font-size: 12px">
        <a class="nav-link {{ $active === 'vat_on_purchase' ? 'active' : '' }}"
            href="{{ route('admin.branch_account_details_vat_on_purchase', $branch->id) }}">
            <i class="bx bx-money me-1"></i>
            {{ __('admin.vat_on_purchase') }}</a>
    </li>
    <li class="nav-item" style="font-size: 12px">
        <a class="nav-link {{ $active === 'exp' ? 'active' : '' }}"
            href="{{ route('admin.branch_account_details_exp', $branch->id) }}">
            <i class="bx bx-money me-1"></i>
            {{ __('admin.accounts_expenses') }}</a>
    </li>

</ul>
