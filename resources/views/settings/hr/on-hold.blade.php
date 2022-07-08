<div class="card mt-4">
	<form action="{{ url('/settings/hr/update') }}" method="POST">

		{{ csrf_field() }}
		<div class="card-header c-pointer" data-toggle="collapse" data-target="#on_hold_email_template" aria-expanded="true" aria-controls="no_show_email_template">On hold email to applicant</div>
		<div id="on_hold_email_template" class="collapse">
			<div class="card-body">
				<div class="form-row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="setting_key[application_on_hold_subject]">Subject</label>
							<input type="text" name="setting_key[application_on_hold_subject]" class="form-control" value="{{ isset($settings['application_on_hold_subject']->setting_value) ? $settings['application_on_hold_subject']->setting_value : '' }}">
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="setting_key[application_on_hold_body]">Mail body:</label>
							<textarea name="setting_key[application_on_hold_body]" rows="10" class="richeditor form-control" placeholder="Body">{{ isset($settings['application_on_hold_body']->setting_value) ? $settings['application_on_hold_body']->setting_value : '' }}</textarea>
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