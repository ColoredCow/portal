<div class="card">
	<form action="{{ url('/settings/hr/update') }}" method="POST">

		{{ csrf_field() }}

		<div class="card-header c-pointer" data-toggle="collapse" data-target="#applicant_verification" aria-expanded="true" aria-controls="applicant_verification">Application verification mail to applicant</div>
		<div id="applicant_verification" class="collapse">
			<div class="card-body">
				<div class="form-row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="setting_key[application_verification_subject]">Subject</label>
							<input type="text" name="setting_key[application_verification_subject]" class="form-control" value="{{ isset($settings['application_verification_subject']->setting_value) ? $settings['application_verification_subject']->setting_value : '' }}">
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="setting_key[application_verification_body]">Mail body:</label>
							<textarea name="setting_key[application_verification_body]" rows="10" class="richeditor form-control" placeholder="Body">{{ isset($settings['application_verification_body']->setting_value) ? $settings['application_verification_body']->setting_value : '' }}</textarea>
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
