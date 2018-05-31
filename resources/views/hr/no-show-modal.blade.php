<span class="text-danger c-pointer" data-toggle="modal" data-target="#no_show_modal"><i class="fa fa-warning fa-lg"></i>&nbsp;No show</span>
<div class="modal fade" id="no_show_modal" tabindex="-1" role="dialog" aria-labelledby="no_show_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
			<h5 class="modal-title" id="no_show_modal">No show</h5>
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
							<label for="no_show_reason">Select reason</label>
							<select name="no_show_reason" id="no_show_reason" class="form-control">
							@foreach(config('constants.hr.application-meta.reasons-no-show') as $reason => $reasonTitle)
								<option value="{{ $reason }}">{{ $reasonTitle }}</option>
							@endforeach
							</select>
						</div>
					</div>
					<div class="form-row mt-4">
						<div class="form-group col-md-12">
							<label for="no_show_mail_subject">Mail subject:</label>
							<input type="text" name="no_show_mail_subject" class="form-control" placeholder="Subject" required="required" value="{{ $settings['noShow']['subject'] }}">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="no_show_mail_body">Mail body:</label>
							<textarea name="no_show_mail_body" class="richeditor form-control" rows="10">{{ $settings['noShow']['body'] }}</textarea>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12">
							<input type="hidden" name="application_round_id" value="{{ $applicationRound->id }}">
							<input type="hidden" name="action" value="{{ config('constants.hr.application-meta.keys.no-show') }}">
							<button type="submit" class="btn btn-primary px-4">Save</button>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
