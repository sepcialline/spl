<div class="card mb4">
    <h5 class="card-header">{{ __('admin.add_account') }}</h5>
    <div class="card-body">
        <form action="{{ route('admin.store_branch_account_details') }}" method="post" class="row g-3 needs-validation"
            novalidate>
            @csrf
            <input type="hidden" name="id" id="id" value="{{$account->id ?? ''}}">
            <input type="hidden" name="branch_id" id="branch_id" value="{{ $branch->id }}">
            <input type="hidden" name="account_detail" id="account_detail" value="{{ $store }}">

            <div class="mb-1">
                <label for="defaultSelect" class="form-label">{{ __('admin.level') }}</label>
                <select id="level" class="form-select js-example-basic-single" name="level" required>
                    {{-- <option value="">{{ __('admin.please_select') }}</option> --}}
                    @for ($i = 1; $i <= 4; $i++)
                        <option value="{{ $i }}"
                            {{ $account && $account->account_level == $i ? 'selected' : '' }}>{{ $i }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="mb-1">
                <label for="defaultSelect" class="form-label">{{ __('admin.parent_account') }}</label>
                <select id="parent" class="form-select js-example-basic-single" name="parent">
                    @foreach ($parnets as $parent)
                        <option value="{{ $parent->id }}"
                            {{ $account && $account->account_parent == $parent->id ? 'selected' : '' }}>
                            {{ $parent->account_name }} #{{ $parent->account_code }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-1">
                <label for="defaultSelect" class="form-label">{{ __('admin.accounts_arabic_name') }}</label>
                <input type="text" id="name_ar" class="form-control" name="name_ar" required
                    value="{{ $account ? $account->getTranslation('account_name', 'ar') : $branch->getTranslation('branch_name', 'ar') . ' - ' . __("admin.$store", [], 'ar') }}">
            </div>
            <div class="mb-1">
                <label for="defaultSelect" class="form-label">{{ __('admin.accounts_english_name') }}</label>
                <input type="text" id="name_en" class="form-control" name="name_en" required
                    value="{{ $account ? $account->getTranslation('account_name', 'en') : $branch->getTranslation('branch_name', 'en') . ' - ' . __("admin.$store", [], 'en') }}">
            </div>
            <div class="mb-1">
                <label for="defaultSelect" class="form-label">{{ __('admin.accounts_code') }}</label>
                <input type="text" id="account_code" name="code"
                    value="{{ $account ? $account->account_code : '' }}"
                    class="form-control @error('code') is-invalid @enderror" name="code" required>
                @error('code')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-1">
                <label for="account_type" class="form-label">{{ __('admin.type') }}</label>
                <select id="account_type" class="form-select js-example-basic-single" name="type" required>
                    {{-- <option  selected disabled>{{ __('admin.please_select') }}</option> --}}
                    <option value="0" {{ $account && $account->account_type == 0 ? 'selected' : '' }}>
                        {{ __('admin.main_account') }}</option>
                    <option value="1" {{ $account && $account->account_type == 1 ? 'selected' : '' }}>
                        {{ __('admin.secondary_account') }}</option>
                </select>
            </div>
            <div class="mb-1">
                <label for="defaultSelect" class="form-label">{{ __('admin.nature_of_account') }}</label>
                <select id="account_dc_type" class="form-select js-example-basic-single" required
                    name="account_dc_type">
                    {{-- <option  selected disabled>{{ __('admin.please_select') }}</option> --}}
                    <option value="0" {{ $account && $account->account_dc_type == 0 ? 'selected' : '' }}>
                        {{ __('admin.credit') }}</option>
                    <option value="1" {{ $account && $account->account_dc_type == 1 ? 'selected' : '' }}>
                        {{ __('admin.debit') }}</option>
                </select>
            </div>
            <div class="mb-1">
                <label for="defaultSelect" class="form-label">{{ __('admin.account_final') }}</label>
                <select id="account_final" class="form-select js-example-basic-single" required name="account_final">
                    {{-- <option selected disabled>{{ __('admin.please_select') }}</option> --}}
                    <option value="1" {{ $account && $account->account_final == 1 ? 'selected' : '' }}>
                        {{ __('admin.budget') }}</option>
                    <option value="2" {{ $account && $account->account_final == 2 ? 'selected' : '' }}>
                        {{ __('admin.profits_and_losses') }}</option>
                    <option value="3" {{ $account && $account->account_final == 3 ? 'selected' : '' }}>
                        {{ __('admin.trading') }}</option>

                </select>
            </div>
            <div class="mb-1">
                <button type="submit" class="btn btn-label-facebook">{{ __('admin.submit') }}</button>
                {{-- <a id="empty" class="btn btn-label-danger">{{ __('admin.refresh') }}</a> --}}
            </div>
        </form>
    </div>
</div>
