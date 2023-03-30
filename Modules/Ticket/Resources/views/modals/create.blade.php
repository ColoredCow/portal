<div class="modal fade" tabindex="-1" id="modal-ticket-details" value="">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">New Ticket</h4>
            </div>
            <form>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="field-required">Title</label>
                        <textarea name="comments" id="comments" rows="1" class="form-control"></textarea>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="field-required">Issue Type</label>
                            <select class="form-control" required="required">
                                <option value="Select Type" disabled selected>Select Type</option>
                                @foreach (config('ticket.type') as $display_type)
                                    <option value="">{{ $display_type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="field-required">Priority</label>
                            <select class="form-control" required="required">
                                <option value="Select Priority" disabled selected>Select Priority</option>
                                @foreach (config('ticket.priority') as $priority)
                                    <option value="">{{ $priority }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="field-required">Status</label>
                            <select class="form-control" name="status">
                                <option value="Select Status" disabled selected>Select Status</option>
                                @foreach (config('ticket.status') as $status)
                                    <option value="">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>GitHub Link</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea id="description" class="form-control richeditor" name="description" rows="4"
                            placeholder="Enter Issue description..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success mr-auto" onclick="#">Create</button>
                    <button type="reset" class="btn btn-primary ml-auto" onclick="#" value="Reset">Clear</button>
                </div>
            </form>
        </div>
    </div>
</div>
