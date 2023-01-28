<div class="card mt-4">
	<form action="{{ url('/settings/hr/update') }}" method="POST">

		{{ csrf_field() }}
		<div class="card-header c-pointer" data-toggle="collapse" data-target="#team_interaction_email_template" aria-expanded="true" aria-controls="team_interaction_email_template">Team Interaction email to applicant</div>
		<div id="team_interaction_email_template" class="collapse">
			<div class="card-body">
				<div class="form-row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="setting_key[hr_team_interaction_round_subject]">Subject</label>
							<input type="text" name="setting_key[hr_team_interaction_round_subject]" class="form-control" value="{{ isset($settings['hr_team_interaction_round_subject']->setting_value) ? $settings['hr_team_interaction_round_subject']->setting_value : '' }}">
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="setting_key[hr_team_interaction_round_body]">Mail body:</label>
							<textarea name="setting_key[hr_team_interaction_round_body]" rows="10" class="richeditor form-control" placeholder="Body">{{ isset($settings['hr_team_interaction_round_body']->setting_value) ? $settings['hr_team_interaction_round_body']->setting_value : '' }}</textarea>
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
