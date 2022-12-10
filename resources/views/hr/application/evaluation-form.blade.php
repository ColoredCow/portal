{{-- @section('scripts') --}}
   {{-- <script src="{{ asset('js/partials.js') }}"></script> --}}
{{-- @endsection --}}

<form method="POST"  action="/hr/evaluation/{{ $applicationRound->id }}">
    @method('PATCH')
    @csrf
    {{-- TODO: We can utilize this code in the future if needed --}}

    {{-- <div class="spinner d-none text-center">
        <div id="spinner-div" class="pt-3">
            <div class="spinner-border text-primary" role="status"></div>
        </div>
    </div>
    <div class="row mb-3 d-none evaluation-result">
        <div class="col-12">
            <h4>
                <span>Result: </span>
                @if ($evaluationScores['score'] >= 2)
                    <span class="text-success">Passing</span>
                @else
                    <span class="text-danger">Failing</span>
                @endif
            </h4>
        </div>
    </div> --}}
    {{-- this depends on the application round. currently hard-coded for resume-screening --}}
    @if ($applicationRound->round->name == "Telephonic Interview")
        @include('hr::evaluation.evaluation-form.knowledge')
        <div class="row py-4">
            <div class="col-12">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>
    @else
    {{-- <script type="text/javascript">
    
    function showAlert(){
        alert("hii");
        console.log("hhhh");
    }
    // document.getElementById("rejectApplications").onclick = showAlert;
    </script> --}}
        <div class="evaluation-stage" id="evaluationStage1">
            @include('hr::evaluation.evaluation-form.resume-screening.feeling')
            <div class="row py-4">
                <div class="col-12">
                    {{-- TODO: save form on click using AJAX --}}
                    <button class="btn btn-success show-evaluation-stage" id="nextButton" data-target="#evaluationStage2"
                        type="button" >Next</button>
                        
                    <button type="button" class="btn btn-outline-danger ml-2 d-none" id="rejectApplications" onClick="rejectApplication()" >
                        Reject</button>

                        <script type="text/javascript">
                            function  rejectApplication()
                            {
                                $("#application_reject_modal").modal("show");
                                loadTemplateMail("reject", (res) => {
                                    $("#rejectMailToApplicantSubject").val(res.subject);
                                    tinymce
                                        .get("rejectMailToApplicantBody")
                                        .setContent(res.body, { format: "html" });
                                });
                            }
                            $("label[for=resume-looks-good-no]").click(function(){ $("#rejectApplications").removeClass("d-none"); });
                            $("label[for=resume-looks-good-no]").click(function(){ $("#nextButton").addClass("d-none"); });
                        </script>
                </div>    
            </div>
        </div>

{{-- 
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
</div> --}}

        <div class="d-none evaluation-stage" id="evaluationStage2">
            @include('hr::evaluation.evaluation-form.resume-screening.review')
            {{-- TODO: hardcoded block below. Need to make it functional --}}
            <div class="row my-3">
                <div class="col-12">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input section-toggle-checkbox" id="SendForReview"
                            data-show-on-checked="#assignSendForReview">
                        <label class="custom-control-label" for="SendForReview">Send for review</label>
                    </div>
                </div>
                <div class="col-4 d-none my-1" id="assignSendForReview">
                    <select name="reviewer" class="custom-select custom-select-sm fz-14">
                        <option selected>Select reviewer</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row py-4">
                <div class="col-12">
                    <button type="button" class="btn btn-light border mr-2 show-evaluation-stage"
                        data-target="#evaluationStage1">Back</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </div>
        </div>
    @endif

</form>