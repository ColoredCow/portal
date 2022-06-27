<div class="card mt-4">
	<form action="{{ url('/settings/hr/update') }}" method="POST">

		{{ csrf_field() }}

		<div class="card-header c-pointer" data-toggle="collapse" data-target="#applicant_autoresponder" aria-expanded="true" aria-controls="applicant_autoresponder">Auto responder mail to applicant</div>
		<div id="applicant_autoresponder" class="collapse">
			<div class="card-body">
				<div class="form-row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="setting_key[applicant_create_autoresponder_subject]">Subject</label>
							<input type="text" name="setting_key[applicant_create_autoresponder_subject]" class="form-control" value="{{ isset($settings['applicant_create_autoresponder_subject']->setting_value) ? $settings['applicant_create_autoresponder_subject']->setting_value : '' }}">
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="setting_key[applicant_create_autoresponder_body]">Mail body:</label>
							<textarea name="setting_key[applicant_create_autoresponder_body]" rows="10" class="richeditor form-control" placeholder="Body">{{ isset($settings['applicant_create_autoresponder_body']->setting_value) ? $settings['applicant_create_autoresponder_body']->setting_value : '' }}</textarea>
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
