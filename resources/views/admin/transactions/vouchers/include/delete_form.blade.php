<!-- Button trigger modal -->
<button type="button" class="btn btn-label-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
    delete
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.account.journal.delete') }}" method="post">
                @csrf
                <input type="hidden" name="number" id="number" value="{{ $number }}">
                <input type="hidden" name="type" id="number" value="{{ $type }}">
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>

        </div>
    </div>
</div>
