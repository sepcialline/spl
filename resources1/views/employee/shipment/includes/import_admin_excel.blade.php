<button type="button" class="btn btn-label-success" data-bs-toggle="modal" data-bs-target="#import_excel">
    <i class='bx bx-upload'></i>
</button>

<!-- Modal -->
<div class="modal fade" id="import_excel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">import Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

          
            <form method="post" action="{{ route('employee.shipment.import') }}" enctype="multipart/form-data"
                class="was-validated" onsubmit="submitForm()">
                @csrf

                <div class="modal-body">
                    {{-- <div class="mb-3">
                        <label for="exampleFormControlInput1"
                            class="form-label">{{ __('admin.branch_created') }}</label>
                        <select class="form-control" name="branch_created" required>
                            <option value="">{{ __('admin.please_select') }}</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    <input type="hidden" name="branch_created"
                        value="{{ Auth::guard('employee')->user()->branch_id }}">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">{{ __('admin.company_list') }}</label>
                        <select class="form-control s-example-basic-single" name="company_id" required>
                            <option value="">{{ __('admin.please_select') }}</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1"
                            class="form-label">{{ __('admin.shipments_delivered_Date') }}</label>
                        <input type="date" class="form-control" name="delivered_Date" id="delivered_Date"
                            placeholder="" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1"
                            class="form-label">{{ __('admin.shipments_create_shipment') }}</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('admin.close') }}</button>
                    <button type="submit" class="btn btn-primary" id="clk">{{ __('admin.submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
