{{-- <div class="modal fade hr_round_review" id="application_reject_modal" tabindex="-1" role="dialog" aria-labelledby="application_reject_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select action</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            	<div class="d-flex align-items-center">
                	<span>Refer this candidate for&nbsp;&nbsp;</span>
            		<select name="refer_to" id="refer_to" class="form-control w-50">
                    @foreach($allApplications as $application)
                        @if ($application->id != $currentApplication->id)
                            <option value="{{ $application->id }}">{{ $application->job->title }}</option>
                        @endif
                    @endforeach
            		</select>
            		<button class="btn btn-primary ml-2 px-4 round-submit" data-action="refer">GO</button>
                </div>
                <h3 class="my-4 pl-1">OR</h3>
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-outline-danger round-submit" data-action="reject">Reject this candidate for all jobs</button>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="modal fade" id="application_reject_modal" tabindex="-1" role="dialog" aria-labelledby="application_reject_modal"
    aria-hidden="true" v-if="selectedAction == 'round'">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-block">
                    <h5 class="modal-title">Reject application</h5>
                    <h6 class="text-secondary">{{ $applicationRound->application->applicant->name }} &mdash;
                        {{ $applicationRound->application->applicant->email }}</h6>
                </div>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="form-check mt-3">
                <p class="font-weight-bold">Select Reasons</p>
                @foreach(config('hr.reasons-for-rejections') as $index => $reasonForRejection)
                    <div class="rejection-reason-block">
                        <label for="reasonTitle{{ $index }}">
                            <input type="checkbox" class="reject-reason mr-1" id="reasonTitle{{ $index }}" name='reject_reason[{{ $index }}][title]' value='{{ $index }}'>{{ $reasonForRejection }}<br>
                        </label>
                        <br />
                        <input type="text" class="form-control w-half mb-3" name='reject_reason[{{ $index }}][comment]' style="display: none" placeholder="Reason for {{ $reasonForRejection }}" />
                    </div>
                @endforeach
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-12 d-flex align-items-center">
                        <div class="py-0.67">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="send_mail_to_applicant[reject]" class="custom-control-input send-mail-to-applicant" id="rejectSendMailToApplicant" data-target="#previewMailToApplicant" checked>
                                <label class="custom-control-label" for="rejectSendMailToApplicant">Send email</label>
                            </div>
                        </div>
                        <div class="toggle-block-display c-pointer rounded-circle bg-theme-gray-lightest hover-bg-theme-gray-lighter px-1 py-0.67 ml-1" id="previewMailToApplicant" data-target="#rejectMailToApplicantBlock" data-toggle-icon="true">
                            <i class="fa fa-eye toggle-icon d-none" aria-hidden="true"></i>
                            <i class="fa fa-eye-slash toggle-icon" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="form-row d-none" id="rejectMailToApplicantBlock">
                    <div class="form-group col-md-12">
                        <label for="rejectMailToApplicantSubject">Subject</label>
                        <input type="text" name="mail_to_applicant[reject][subject]" id="rejectMailToApplicantSubject"
                            class="form-control">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="rejectMailToApplicantBody">Body</label>
                        <textarea name="mail_to_applicant[reject][body]" id="rejectMailToApplicantBody" class="form-control richeditor"></textarea>
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="form-group col-md-12">
                        <input type="hidden" name="follow_up_comment_for_reject" id="followUpCommentForReject" />
                        <button type="save" class="btn btn-danger px-4 round-submit" data-action="reject">Reject</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
