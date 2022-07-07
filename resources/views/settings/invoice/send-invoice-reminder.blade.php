<div class="card">
    <form action="{{ route('setting.invoice.update') }}" method="POST">
        @csrf
        <div class="card-header c-pointer" data-toggle="collapse" data-target="#sendInvoiceReminder" aria-expanded="true" aria-controls="sendInvoice">Send invoice reminder</div>
        <div id="sendInvoiceReminder" class="collapse">
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="setting_key[invoice_reminder_subject]">Subject</label>
                            <input type="text" name="setting_key[invoice_reminder_subject]" class="form-control" value="{{ isset($settings['invoice_reminder_subject']->setting_value) ? $settings['invoice_reminder_subject']->setting_value : '' }}">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="setting_key[invoice_reminder_body]">Mail body:</label>
                            <textarea name="setting_key[invoice_reminder_body]" rows="10" class="richeditor form-control" placeholder="Body">{{ isset($settings['invoice_reminder_body']->setting_value) ? $settings['invoice_reminder_body']->setting_value : '' }}</textarea>
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
