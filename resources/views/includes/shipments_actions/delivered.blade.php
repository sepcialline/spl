<div class="d-none" id="delivered">

    {{-- <div class="mb-3">
        <label class="form-label" for="payment_divided">{{ __('admin.payment_divided') }}</label>
        <select name="payment_divided" id="payment_divided" class="form-select">
            <option value="2">{{ __('admin.no') }}</option>
            <option value="1">{{ __('admin.yes') }}</option>
        </select>
    </div> --}}
    <div class="mb-3">
        <label class="form-label" for="payment_method">{{ __('admin.payment_method') }}</label>
        <select name="payment_method" id="payment_method" class="form-select">
            <option value="" selected disabled>{{__('admin.please_select')}}</option>
            @foreach ($payment_methods as $payment_method)
                <option value="{{ $payment_method->id }}">{{ $payment_method->name }}</option>
            @endforeach
            <option value="0">{{ __('admin.split') }}</option>
        </select>
    </div>


    <div class="mb-3 d-none" id="cash_payment" >
        <label class="form-label" for="delivered_amount">{{ __('admin.delivered_amount') }}</label>
        <input type="number" name="delivered_amount" id="delivered_amount" class="form-control"
            value="">
    </div>


    <div id="transfer_payment" class="d-none">
        <div class="mb-3">
            <label class="form-label" for="transferred_amount">{{ __('admin.transferred_amount') }}</label>
            <input type="number" id="transferred_amount" name="transferred_amount" class="form-control" value="">
        </div>
    </div>

    <div id="image" class="d-none">
        <div class="mb-3">
            <div class="avatar avatar-xl mb-3">
                <img id="avatar" src="{{ asset('build/assets/img/avatars/1.png') }}"
                    alt="{{ __('admin.user_management_admin_avatar') }}">
            </div>
            <label for="logo" class="form-label">{{ __('admin.user_management_admin_avatar') }}</label>
            <input class="form-control" name="file" type="file" id="file"
                onchange="document.getElementById('avatar').src=window.URL.createObjectURL(this.files[0])">

        </div>
    </div>

    <div class="mb-3">
        <label class="form-label" for="client_name">{{ __('admin.branch_delivered') }}</label>
        <select class="js-example-basic-single form-select " name="branch_id" id="branch_id">
            <option value="">
                {{ __('admin.please_select') }}
            </option>
            @foreach ($branches as $branch)
                <option value="{{ $branch->id }}" {{($shipment->rider_id && ($branch->id == App\Models\Rider::where('id',$shipment->rider_id)->first()->branch_id))  ? 'selected' : ''}} >{{ $branch->branch_name }}</option>
            @endforeach
        </select>
    </div>
    <br>
    <div id="note_delayed">
        <input type="date" class="form-control" name="delivered_date_delivered"
            value="{{ $shipment->delivered_date }}">
        -<span id=""
            class="text-danger">{{ __('admin.it_will_be_delivered_into_branch_selected') }}</span><br>
        -<span id="" class="text-danger">{{ __('admin.rider_should_recive') }} :
            {{ $shipment->rider_should_recive }} {{ __('admin.currency') }}</span>
    </div>


</div>
