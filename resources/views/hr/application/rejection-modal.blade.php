<div class="modal fade hr_round_review" id="application_reject_modal" tabindex="-1" role="dialog" aria-labelledby="application_reject_modal" aria-hidden="true">
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
</div>
