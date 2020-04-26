<div class="modal fade" id="prospect_history_details_modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="">@{{ selectedHistory.performed_on }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label class="font-weight-bold mb-0">Description:</label>
                    <p class="fz-16">@{{selectedHistory.description}}</p>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold mb-0">Stage:</label>
                    <p class="fz-16">@{{selectedHistory.performed_as}}</p>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold mb-0">Added by:</label>
                    <p class="fz-16">@{{selectedHistory.performed_by}}</p>
                </div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" type="button" class="btn btn-info text-white">Ok</button>
            </div>
        </div>
    </div>
</div>