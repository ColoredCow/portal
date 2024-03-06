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
                <label for="project_reviewer_id">Choose Project Reviewer</label>
                <div>
                    <select id="project_reviewer_id" name="project_reviewer_id" class="custom-select">
                        <option value="">Select Project Reviewer</option>
                        @foreach($users as $user)
                        <option
                            {{ (old('project_reviewer_id') == $user->id || (optional($client->project_review)->project_reviewer_id == $user->id)) ? 'selected' : '' }}
                            value="{{ $user->id }}"
                        >
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <input hidden type="text" class="form-control">
                <label for="meeting_day">Choose Day</label>
                <div>
                    <select id="meeting_day" name="meeting_day" class="custom-select">
                        <option value="">Select Day</option>
                        @foreach(config('constants.working_week_days') as $index => $day)
                        <option
                            {{ old('meeting_day') == $index || optional($client->project_review)->meeting_day == $index ? 'selected' : ''}}
                            value="{{ $index }}"
                        >
                            {{ $day }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="meeting_time">Date and Time</label>
                <input 
                    type="time" 
                    name="meeting_time" 
                    class="form-control" 
                    value="{{ optional($client->project_review)->meeting_time ?: '' }}"
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
