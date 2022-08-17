<div class="modal fade" id="deleteSegmentModal" tabindex="-1" role="dialog" aria-labelledby="deleteSegmentModal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="deleteSegmentForm" method="Post" :action="deleteRoute">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteSegmentModal">Segment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this segment - @{{ segmentName }}?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>