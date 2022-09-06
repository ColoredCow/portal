<div class="modal fade" id="round_confirm" tabindex="-1" role="dialog" aria-labelledby="round_confirm"
    aria-hidden="true" v-if="selectedAction == 'round'">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-block">
                    <h5 class="modal-title" id="round_confirm">@{{ this.nextRoundName }}</h5>
                    <h6 class="text-secondary d-inline" id="applicantName">{{ $applicationRound->application->applicant->name }}</h6> &mdash;
                   <span>{{ $applicationRound->application->applicant->email }}</span>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none pr-0.83" id="InteractionError">
                    <button type="button" id="interactionErrorModalCloseBtn" class="float-right bg-transparent text-danger border-0 fz-16 mt-n1.33">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong id="errors"></strong>
                </div>
                <div class="d-none alert alert-success fade show" role="alert" id="interactionsuccess">
                    <strong>Success!!!</strong>Email generated successfully please find it below in the editor.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
               <div class="my-3 w-full border p-3" id="sendmailform">
                    <div class="form-group col-md-12">
                        <label>Office Location</label>
                        <input type="text" id="location" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-md-12">
                        <label>Date</label>
                        <input type="date" id="date" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-md-12">
                        <label>Timing</label>
                        <input type="time" id="timing" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-md-12">
                        <button type="button" class="btn btn-success px-4" id="updateEmail">Generate Email</button>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5 next-scheduled-person-container">
                        <label class="fz-14 leading-none text-secondary" for="next_scheduled_person_id">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>{{ __('Assignee') }}</span>
                        </label>
                        <select name="next_scheduled_person_id" id="next_scheduled_person_id" class="form-control"
                            required="required">
                            @foreach ($interviewers as $interviewer)
                                @php
                                    $selected = $interviewer->id == auth()->id() ? 'selected' : '';
                                @endphp
                                <option value="{{ $interviewer->id }}" {{ $selected }}>{{ $interviewer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12 d-flex align-items-center">
                        <div class="py-0.67">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="send_mail_to_applicant[confirm]" class="custom-control-input send-mail-to-applicant" id="confirmSendMailToApplicant" data-target="#previewMailToApplicant" checked>
                                <label class="custom-control-label" for="confirmSendMailToApplicant">Send email</label>
                            </div>
                        </div>
                        <div class="toggle-block-display c-pointer rounded-circle bg-theme-gray-lightest hover-bg-theme-gray-lighter px-1 py-0.67 ml-1" id="previewMailToApplicant" data-target="#confirmMailToApplicantBlock" data-toggle-icon="true">
                            <i class="fa fa-eye toggle-icon d-none" aria-hidden="true"></i>
                            <i class="fa fa-eye-slash toggle-icon" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="form-row d-none" id="confirmMailToApplicantBlock">
                    <div class="form-group col-md-12">
                        <label class="leading-none" for="confirmMailToApplicantSubject">Subject</label>
                        <input type="text" name="mail_to_applicant[confirm][subject]" id="confirmMailToApplicantSubject"
                            class="form-control">
                    </div>
                    <div class="form-group col-md-12">
                        <label class="leading-none" for="confirmMailToApplicantBody">Body</label>
                        <textarea name="mail_to_applicant[confirm][body]" id="confirmMailToApplicantBody" class="form-control richeditor"></textarea>
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