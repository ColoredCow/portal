<div class="modal fade" id="approve_application" tabindex="-1" role="dialog" aria-labelledby="approve_application" aria-hidden="true" v-if="selectedAction == 'approve'">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-inline-block">
                    <h5 class="modal-title">Approve</h5>
                    <h6 class="text-secondary">{{$application->applicant->name}} • {{$application->applicant->email}}</h6>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    @if ($application->offer_letter)
                    <div class="col-md-12">
                        <a target="_blank" href="{{ route("applications.{$application->job->type}.offer-letter", $application) }}" class="d-flex align-items-center">
                            <i class="fa fa-file fa-2x text-primary btn-file"></i>&nbsp;See offer letter
                        </a>
                    </div>
                    @else
                        <a href="{{ route('applications.getOfferLetter', $application) }}" class="btn btn-secondary px-4">Generate Offer Letter</a>
                    @endif
                </div>
                <div class="form-row mt-4">
                    <div class="form-group col-md-12">
                        <label for="subject" class="field-required">Subject</label>
                        <input type="text" class="form-control" name="subject" value="{{$approveMailTemplate['subject']}}" id="subject" required="required">
                    </div>
                </div>
                <div class="form-row mt-4">
                    <div class="form-group col-md-12">
                        <label for="body" class="field-required">Body</label>
                        <textarea name="body" id="body" rows="5" class="form-control" required="required">{{$approveMailTemplate['body']}}</textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                         <button type="button" class="btn btn-success px-4 round-submit richeditor" data-action="approve">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>