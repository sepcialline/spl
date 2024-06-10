<div class="d-none" id="new">
    <div class="mb-3">
        <label class="form-label"
            for="client_name">{{ __('admin.branch_created') }}</label>
        <select
            class="js-example-basic-single form-select"
            name="branch_created_id" id="branch_created_id">
            <option value="">
                {{ __('admin.please_select') }}
            </option>
            @php $branches = App\Models\Branches::where('is_main',0)->get(); @endphp
            @foreach ($branches as $branch)
                <option value="{{ $branch->id }}">
                    {{ $branch->branch_name }}</option>
            @endforeach
        </select>

    </div>
    <div class="mb-3">
        <label class="form-label"
            for="client_name">{{ __('admin.branch_destination') }}</label>
        <select
            class="js-example-basic-single form-select"
            name="branch_destination_id" id="branch_destination_id">
            <option value="">
                {{ __('admin.please_select') }}
            </option>
            @php $branches = App\Models\Branches::where('is_main',0)->get(); @endphp
            @foreach ($branches as $branch)
                <option value="{{ $branch->id }}">
                    {{ $branch->branch_name }}</option>
            @endforeach
        </select>

    </div>


    <br>
    <span id="note_delayed"
        class="text-danger">{{ __('admin.it_will_be_assigned_to_no_rider') }}</span>
</div>
