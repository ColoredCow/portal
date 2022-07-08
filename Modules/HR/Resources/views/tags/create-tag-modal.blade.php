<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Tag</h5>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('hr.tags.store') }}" id="create-form">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Label name<strong class="text-danger">*</strong></label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" name="description">
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">Color<strong class="text-danger">*</strong></label>
                        <input type="color" class="form-control" id="color" name="color">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" form="create-form" id="save-btn-action">Create</button>
            </div>
        </div>
    </div>
</div>

<script>
    const saveTag = (button) => {
        button.disabled = true;
        if (!button.form.checkValidity()) {
            button.disabled = false;
            button.form.reportValidity();
            return;
        }
        button.form.submit();
    }
</script>