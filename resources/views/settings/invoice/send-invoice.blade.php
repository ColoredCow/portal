<div class="card">
	<form action="{{ route('setting.invoice.update') }}" method="POST">
		{{ csrf_field() }}
		<div class="card-header c-pointer" data-toggle="collapse" data-target="#sendInvoice" aria-expanded="true" aria-controls="sendInvoice">Send invoice to client</div>
		<div id="sendInvoice" class="collapse">
			<div class="card-body">
				<div class="form-row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="setting_key[send_invoice_subject]">Subject</label>
							<input type="text" name="setting_key[send_invoice_subject]" class="form-control" value="{{ isset($settings['send_invoice_subject']->setting_value) ? $settings['send_invoice_subject']->setting_value : '' }}">
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="setting_key[send_invoice_body]">Mail body:</label>
							<textarea name="setting_key[send_invoice_body]" rows="10" class="richeditor form-control" placeholder="Body">{{ isset($settings['send_invoice_body']->setting_value) ? $settings['send_invoice_body']->setting_value : '' }}</textarea>
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
