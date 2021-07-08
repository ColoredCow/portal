<div class="modal fade" id="editSlotsModal">
    <div class="modal-dialog">
        <div class="modal-content" id="edit_slots">
        <div class="modal-header">
            <h4>Edit Slot</h4>
        </div>
        <form action="" method="POST" id="editForm">
            @csrf
            @method('PATCH')
            <div class="modal-body">
                <div class="row">
                        <div class="form-group col">
                            <label for="edit_start_time">Start Time*</label>
                            <input type="datetime-local" id="edit_start_time" name="edit_start_time" class="form-control" value="{{ old('edit_start_time')}}"required>
                        </div>
                        <div class="form-group col">
                            <label for="edit_end_time">End time*</label>
                            <input type="datetime-local" id="edit_end_time" name="edit_end_time" class="form-control" value="{{ old('edit_end_time')}}"required>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
            <input class="btn btn-success" type="submit" value="Update">
        </form>
                <form action="" method="POST" id="deleteForm" >
                        @csrf
                        @method('delete')
                            <input type="submit" class='btn btn-danger' value="Delete">
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
