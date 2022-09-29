<div class="modal fade" id="designationEditFormModal" tabindex="-1" role="dialog" aria-labelledby="designationEditFormModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="designationEditFormModalLabel">Designation Name</h5> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="designation-edit modal-body">
                <form action="{{ route('designation.edit', "id") }}" method="get" id="designationEditForm" >
                    @csrf
                    <div class="form-group">
                        <input value="{{ route('designation.edit', "id") }}" type="hidden" class="hidden" aria-hidden="true" name="routePlaceHolder">
                        <label class="field-required" for="designationfield">name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>  
                </form>
            </div>
        </div>
    </div>
</div>
