<div class="card mt-4">
	<form action="{{ url('/settings/hr/update') }}" method="POST">

		{{ csrf_field() }}
		<div class="card-header c-pointer" data-toggle="collapse" data-target="#Follow_up_email_template" aria-expanded="true" aria-controls="Follow_up_email_template">Follow up email to applicant</div>
		<div id="Follow_up_email_template" class="collapse">
			<div class="card-body">
				<div class="form-row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="setting_key[{{ config('hr.templates.follow_up_email_for_scheduling_interview.subject') }}]">Subject</label>
							<input type="text" name="setting_key[{{config('hr.templates.follow_up_email_for_scheduling_interview.subject')}}]" class="form-control" value="{{ isset($settings[config('hr.templates.follow_up_email_for_scheduling_interview.subject')]->setting_value) ? $settings[config('hr.templates.follow_up_email_for_scheduling_interview.subject')]->setting_value : '' }}">
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="setting_key[{{config('hr.templates.follow_up_email_for_scheduling_interview.body')}}]">Mail body:</label>
							<textarea name="setting_key[{{ config('hr.templates.follow_up_email_for_scheduling_interview.body') }}]" rows="10" class="richeditor form-control" placeholder="Body">{{ isset($settings[config('hr.templates.follow_up_email_for_scheduling_interview.body')]->setting_value) ? $settings[config('hr.templates.follow_up_email_for_scheduling_interview.body')]->setting_value : '' }}</textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary">Save</button>
			</div>
		</div>
	</form>
</div>