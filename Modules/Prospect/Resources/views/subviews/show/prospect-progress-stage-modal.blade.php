<div class="modal fade" id="prospect_progress_new_stage_form">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add new stage</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <div class="form-group">
                    <input v-model="newStageName" placeholder="Enter stage name" type="text" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" v-on:click="saveNewStage" class="btn btn-info text-white">Save state</button>
            </div>
        </div>
    </div>
</div>