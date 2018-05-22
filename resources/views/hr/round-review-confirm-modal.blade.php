<div class="modal fade" id="round_confirm_{{ $applicationRound->id }}" tabindex="-1" role="dialog" aria-labelledby="round_confirm_{{ $applicationRound->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="round_confirm_{{ $applicationRound->id }}">Schedule @{{ nextRoundName }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="next_scheduled_date">Scheduled date</label>
                        <input type="datetime-local" name="next_scheduled_date" id="next_scheduled_date" class="form-control" required="required">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="next_scheduled_person_id">Scheduled for</label>
                        <select name="next_scheduled_person_id" id="next_scheduled_person_id" class="form-control" required="required">
                            @foreach ($interviewers as $interviewer)
                                <option value="{{ $interviewer->id }}">{{ $interviewer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="form-group col-md-12">
                        <button type="button" class="btn btn-success px-4 round-submit" data-action="confirm">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
