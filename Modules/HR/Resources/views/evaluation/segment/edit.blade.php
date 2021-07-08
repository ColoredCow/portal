<div class="modal fade" id="editSegmentModal" tabindex="-1" role="dialog" aria-labelledby="editSegmentModal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editSegmentForm" method="Post" :action="updateRoute">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editSegmentModal">Segment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="field-required">Segment Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" required="required" :value="segmentName">
                    </div>
              
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>