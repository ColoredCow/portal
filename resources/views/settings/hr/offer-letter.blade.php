<div class="card mt-4">
	<form action="{{ url('/settings/hr/update') }}" method="POST">

		@csrf

		<div class="card-header c-pointer" data-toggle="collapse" data-target="#offer_letter_template" aria-expanded="true" aria-controls="offer_letter_template">Offer Letter Template</div>
		<div id="offer_letter_template" class="collapse">
			<div class="card-body">
				<div class="form-row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="setting_key[offer_letter_template]">Offer letter:</label>
							<textarea name="setting_key[offer_letter_template]" rows="10" class="richeditor form-control" placeholder="Body">{{ isset($settings['offer_letter_template']->setting_value) ? $settings['offer_letter_template']->setting_value : '' }}</textarea>
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
