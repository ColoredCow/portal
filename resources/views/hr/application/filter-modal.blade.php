<div class="container" id="vueContainer">   
    <div class="modal job-application-modal" id="application-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">Filter By</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            <div class="modal-body">
                <form action="{{ route('applications.job.index') }}" method="GET">
                    <div class="filter form-group-row-sm-10" style="display: flex;">
                        <label style= "margin-top: 0.5rem;">Status: </label>
                        <div class="row justify-content-center mt-100" style="width: 120%;">
                            <div class="col-sm-10">
                                <select name="status" class="job-application-filters" id="choices-multiple-remove-button" placeholder="Select one or more status"  multiple>
                                    <option value="on-hold">Awaiting Confirmation</option>
                                    <option value="rejected">Closed</option>
                                    <option value="in-progress">In Progress</option>
                                    <option value="">Need follow Up</option>
                                    <option value="new">New Application</option>
                                    <option value="">No Show</option>
                                    <option value="no-show-reminded">No Show Reminded</option>
                                    <option value="approved">On Board</option>
                                    <option value="sent-for-approval">Send For Approval</option>
                                </select>
                                <button type="submit" class="btn btn-outline-primary">Apply</button>
                                <button type="reset" class="btn btn-outline-danger">Clear</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            {{-- <div class="modal-footer">
                <button type="submit" name="submitbtn" class="btn btn-outline-primary" data-dismiss="modal">Apply</button>
                <button type="reset" name="" class="btn btn-outline-danger">Clear</button>
            </div>  --}}
           </div>
        </div>
    </div>
</div>