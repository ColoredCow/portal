<div class="modal fade" id="approve_applicant" tabindex="-1" role="dialog" aria-labelledby="approve_applicant" aria-hidden="true" v-if="selectedAction == 'approve'">
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
                        <div class="form-group col-md-12">
                            <label for="offer_letter" class="field-required">Offer letter</label><br>
                            <input id="offer_letter" type="file" name="offer_letter" required="required">
                        </div>
                    @endif
                </div>
                <div class="form-row mt-4">
                    <div class="form-group col-md-12">
                        <label for="designation" class="field-required">Subject</label>
                        <input type="text" class="form-control" name="subject" id="subject" required="required">
                    </div>
                </div>
                <div class="form-row mt-4">
                    <div class="form-group col-md-12">
                        <label for="comments" class="field-required">Body</label>
                        <textarea name="body" id="comments" rows="5" class="form-control" required="required">{{ old('body') }}</textarea>
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
</div>
