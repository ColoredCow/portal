<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="delete"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="GET" action="{{ route('prospect.delete',$prospect->id) }}"  id="delete-form">
                @csrf
                <div class="modal-header">
                    <p>Are you sure?</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                    <button type="submit" form="delete-form" class="btn btn-danger">Yes</button>
                </div>
            </form>
        <div>
    </div>
</div>