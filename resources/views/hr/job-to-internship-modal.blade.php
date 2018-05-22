<div class="modal fade" id="job_to_internship" tabindex="-1" role="dialog" aria-labelledby="job_to_internship" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
			<h5 class="modal-title" id="job_to_internship">Move {{ $application->applicant->name }} to Internship</h5>
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
							<label for="hr_job_id">Select internship</label>
							<select name="hr_job_id" id="hr_job_id" class="form-control">
								@foreach ($internships as $internship)
									<option value="{{ $internship->id }}">{{ $internship->title }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12">
							<input type="hidden" name="action" value="change-job">
							<button type="submit" class="btn btn-success px-4">Confirm</button>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
