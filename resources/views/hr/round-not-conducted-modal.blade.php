<span class="text-danger c-pointer" data-toggle="modal" data-target="#myModal"><i class="fa fa-warning fa-lg"></i>&nbsp;Interview not conducted</span>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
			<h5 class="modal-title" id="myModal">Interview not conducted</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				<form action="{{ route('applications.job.update', $application->id) }}" method="POST">

					{{ csrf_field() }}
					{{ method_field('PATCH') }}

					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="round_not_conducted_reason">Select reason</label>
							<select name="round_not_conducted_reason" id="round_not_conducted_reason" class="form-control">
								<option value="absent-applicant">Applicant was absent</option>
								<option value="absent-interviewer">The interviewer was absent</option>
							</select>
						</div>
					</div>
					<div class="form-row mt-4">
						<div class="form-group col-md-12">
							<label for="round_not_conducted_mail_subject">Mail subject:</label>
							<input type="text" name="round_not_conducted_mail_subject" class="form-control" placeholder="Subject" required="required">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="round_not_conducted_mail_body">Mail body:</label>
							<textarea name="round_not_conducted_mail_body" class="richeditor form-control" rows="10"></textarea>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12">
							<input type="hidden" name="application_round_id" value="{{ $applicationRound->id }}">
							<input type="hidden" name="action" value="{{ config('constants.hr.application-meta.keys.round-not-conducted') }}">
							<button type="submit" class="btn btn-primary px-4">Save</button>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
