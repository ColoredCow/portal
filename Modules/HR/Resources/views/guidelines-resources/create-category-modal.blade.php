<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('resources.store') }}" id="create-form">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name<strong class="text-danger">*</strong></label>
                        <input type="text" class="form-control" id="categoryName" name="name" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="create-form" id="save-btn-action" disabled>Save</button>
            </div>
        </div>
    </div>
</div>