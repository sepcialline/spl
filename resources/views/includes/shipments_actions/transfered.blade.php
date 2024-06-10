<div class="d-none" id="transfer">
    <div class="mb-3">
        <label class="form-label"
            for="client_name">{{ __('admin.shipments_client_emirate') }}</label>
        <select
            class="js-example-basic-single form-select"
            name="client_emirate_id" id="client_emirate_id">
            <option value="">
                {{ __('admin.please_select') }}
            </option>
            @foreach ($emirates as $emirate)
                <option value="{{ $emirate->id }}">
                    {{ $emirate->name }}</option>
            @endforeach
        </select>

    </div>

    <div class="mb-3">
        <label class="form-label"
            for="client_name">{{ __('admin.shipments_client_city') }}</label>
        <select
            class="js-example-basic-single form-select"
            name="client_city_id" id="client_city_id">
            <option value="">
                {{ __('admin.please_select') }}
            </option>
        </select>

    </div>

    <div class="col mb-3">
        <label class="form-label"
            for="client_name">{{ __('admin.shipments_client_address') }}</label>
        <input type="text" id="client_address" name='client_address'
            value="{{ old('client_address') }}"
            class="form-control" placeholder=""
            aria-label="" />

    </div>
    <br>
    <span id="note_delayed"
        class="text-danger">{{ __('admin.it_will_be_assigned_to_no_rider') }}</span>
</div>
