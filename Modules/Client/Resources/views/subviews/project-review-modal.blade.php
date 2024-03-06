<div class="modal" id="projectReviewModal">
    
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Country Details</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        @method("post")
        <div class="modal-body">
            <div class="form-group">
                <input hidden type="text" class="form-control">
                <label for="teamMember">Choose Project Reviewer</label>
                <div>
                    <select name="project_reviewer_id" class="custom-select">
                        <option value="">Select Project Reviewer</option>
                        @foreach($users as $user)
                        <option
                            {{ (old('project_reviewer_id') == $user->id || ($client->latest_project_review && $client->latest_project_review->project_reviewer_id == $user->id)) ? 'selected' : '' }}
                            value="{{ $user->id }}"
                        >
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="datetime">Date and Time</label>
                <input 
                    type="datetime-local" 
                    name="datetime" 
                    class="form-control" 
                    value="{{ optional($client->latest_project_review)->meeting_datetime ?: '' }}"
                >
            </div>
        </div>

        <div class="modal-footer">
            <input type="submit" class='btn btn-outline-primary' value="Save">
            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
        </div>
        <!-- </form> -->
    </div>
</div>
