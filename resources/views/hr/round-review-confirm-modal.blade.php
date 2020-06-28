<div class="modal fade" id="round_confirm" tabindex="-1" role="dialog" aria-labelledby="round_confirm" aria-hidden="true" v-if="selectedAction == 'round'">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-block">
                    <h5 class="modal-title" id="round_confirm">@{{ this.nextRoundName }}</h5>
                    <h6 class="text-secondary">{{ $applicationRound->application->applicant->name }} &mdash; {{ $applicationRound->application->applicant->email }}</h6>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               
                <div class="form-row">
                    <div class="form-group col-md-5">
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
                        <input type="hidden" name="next_round" id="next_round" :value="selectedNextRound">
                        <button type="button" class="btn btn-success px-4 round-submit" data-action="confirm">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
