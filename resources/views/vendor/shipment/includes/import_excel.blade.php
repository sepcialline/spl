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
            <form method="post" action="{{ route('vendor.shipment.import') }}" enctype="multipart/form-data" lass="was-validated" onsubmit="submitForm()">
                @csrf
                <div class="modal-body">
                    <input type="file" name="file" class="form-control" required>
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
