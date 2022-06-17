<div class="modal fade" id="send_for_approval" tabindex="-1" role="dialog" aria-labelledby="send_for_approval" aria-hidden="true" v-if="selectedAction == 'send-for-approval'">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send for approval</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="send_for_approval_person" class="field-required">Select supervisor</label>
                        <select name="send_for_approval_person" id="send_for_approval_person" class="form-control" required="required">
                            @foreach ($interviewers as $interviewer)
                                <option value="{{ $interviewer->id }}">{{ $interviewer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="form-group col-md-12">
                        <button type="button" class="btn btn-success px-4 round-submit" data-action="send-for-approval">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
