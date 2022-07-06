<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('resources.store') }}" id="create-form">
                    @csrf
                    <div class="mb-3">
                        <input type="text" onkeyup="if(this.value.length > 0) document.getElementById('save-btn-action').disabled = false; else document.getElementById('save-btn-action').disabled = true;"/>
                        <label for="name" class="form-label">Category Name<strong class="text-danger">*</strong></label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" form="create-form" id="save-btn-action" disabled>Save</button>
            </div>
        </div>
    </div>
</div>
