<div class="mb-3 d-none" id="in_progress">
    <label for="invoice-to" class="form-label">{{ __('admin.assign_to_rider') }}</label>
    <select class="js-example-basic-single form-select @error('rider_id') is-invalid @enderror"
        name="rider_id" id="rider_id">
        <option value="0">
            {{ __('admin.please_select') }}
        </option>
        @foreach ($riders as $rider)
            <option value="{{ $rider->id }}" {{$shipment->rider_id == $rider->id ? 'selected' : ''}}>{{ $rider->name }}</option>
        @endforeach
    </select>
    <span class="text-success">{{ __('admin.please_dont_forget_assigned_to_rider') }}</span>
</div>
