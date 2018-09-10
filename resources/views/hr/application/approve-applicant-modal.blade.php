<div class="modal fade" id="approve_application" tabindex="-1" role="dialog" aria-labelledby="approve_application" aria-hidden="true">
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
                <input type="hidden" name="showbtn" id="showbtn" v-model="showbtn" value={{!$application->offer_letter ? true : false}}>
                    <div class="form-group">
                        <a target="_blank" v-if="showbtn == false" href="{{ route("applications.{$application->job->type}.offer-letter", $application) }}" class="d-flex align-items-center">
                            <i class="fa fa-file fa-2x text-primary btn-file"></i>&nbsp;See offer letter
                        </a>
                    </div>
                    <div class="form-group" v-if="showbtn == true">
                        <button v-on:click="generateOfferLetter({{$application->id}})" type="button" class="btn btn-primary">Generate Offer Letter</button>
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
                        <textarea name="body" id="body" rows="5" class="richeditor form-control" required="required">{{$approveMailTemplate['body']}}</textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                         <button type="button" class="btn btn-success px-4 round-submit" data-action="approve">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
