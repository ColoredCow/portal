<div class="card">
    <form action="{{ route('setting.invoice.update') }}" method="POST">
        @csrf
        <div class="card-header c-pointer" data-toggle="collapse" data-target="#receivedInvoicePayment" aria-expanded="true" aria-controls="sendInvoice">{{ __('Received invoice payment') }}</div>
        <div id="receivedInvoicePayment" class="collapse">
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="setting_key[received_invoice_payment_subject]">{{ __('Subject') }}</label>
                            <input type="text" name="setting_key[received_invoice_payment_subject]" class="form-control" value="{{ isset($settings['received_invoice_payment_subject']->setting_value) ? $settings['received_invoice_payment_subject']->setting_value : '' }}">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="setting_key[received_invoice_payment_body]">{{ __('Mail body:') }}</label>
                            <textarea name="setting_key[received_invoice_payment_body]" rows="10" class="richeditor form-control" placeholder="Body">{{ isset($settings['received_invoice_payment_body']->setting_value) ? $settings['received_invoice_payment_body']->setting_value : '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
            </div>
        </div>
    </form>
</div>
