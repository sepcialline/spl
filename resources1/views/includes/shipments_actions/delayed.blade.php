<div class="mb-3 d-none" id='delayed'>
    <label for="invoice-to" class="form-label">{{ __('admin.date') }}</label>
    <input type="date" class="form-control" name="delivered_date" id="delivered_date"
        value="{{ Carbon\Carbon::now()->addDay()->format('Y-m-d') }}">
    <br>
    <span id="note_delayed"
        class="text-danger">{{ __('admin.it_will_be_assigned_to_no_rider') }}</span>
</div>
