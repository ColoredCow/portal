<div class="modal fade" id="syncEffortsModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase text-center" id="exampleModalLabel">Syncing Efforts</h5>
            </div>  
            <div class="modal-body">
                <form method="POST" action="{{ route('effort-tracking.refresh', $project) }}" id="backDateEffortsSyncForm">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <label for="isBackDateSync" class="form-label">To sync the efforts of the last billing cycle, please check the checkbox, else leave it unchecked.</label>
                        <input type="checkbox" id="isBackDateSync" name="isBackDateSync">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="backDateEffortsSyncForm" id="confirmBackDateSync">Submit</button>
            </div>
        </div>
    </div>
</div>
