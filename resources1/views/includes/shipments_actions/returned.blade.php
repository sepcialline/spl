<div class="d-none" id="returned">



    <div class="mb-3">
        <label class="form-label" for="payment_type">{{ __('admin.payment_type') }}</label>
        <select name="payment_type" id="payment_type" class="form-select" >
            <option value="">{{__('admin.please_select')}}</option>
            <option value="1">{{ __('admin.client') }}</option>
            <option value="2">{{ __('admin.vendors_company') }}</option>
        </select>
    </div>


    <div class="mb-3" >
        <label class="form-label" for="fees_amount">{{ __('admin.delivered_amount') }}</label>
        <input type="number" name="fees_amount" id="fees_amount" class="form-control"
            value="">
    </div>




    <div class="mb-3">
        <label class="form-label" for="client_name">{{ __('admin.branch_delivered') }}</label>
        <select class="js-example-basic-single form-select " name="fess_branch_id" id="fess_branch_id">
            <option value="">
                {{ __('admin.please_select') }}
            </option>
            @foreach ($branches as $branch)
                <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
            @endforeach
        </select>
    </div>
</div>
