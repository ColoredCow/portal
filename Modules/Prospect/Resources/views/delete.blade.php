<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="delete"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="GET" action="{{ route('prospect.delete', $prospect->id) }}"  id="delete-form">
                @csrf
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body">
                    <p>Are you sure?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" form="delete-form" class="btn btn-danger">Delete</button>
                </div>
            </form>
        <div>
    </div>
</div>