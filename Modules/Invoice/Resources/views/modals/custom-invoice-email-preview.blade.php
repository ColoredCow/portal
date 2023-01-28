<div class="modal fade" id="invoiceMailPreview" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-block">
                    <h4 class="modal-title">{{ __('Invoice mail preview') }}</h4>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="leading-none" for="sendFrom">{{ __('From') }}</label>
                        <input type="email" name="from" id="sendFrom"
                            class="form-control not-required-in-preview" value="{{ config('invoice.mail.send-invoice.email') }}" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="leading-none" for="sendTo">{{ __('To') }}</label>
                        <input type="email" name="to" id="sendTo" class="form-control not-required-in-preview" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="leading-none" for="sendToName">{{ __('Receiver Name') }}</label>
                        <input type="text" name="to_name" id="sendToName" class="form-control not-required-in-preview" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="leading-none" for="cc">
                            {{ __('CC') }} 
                            <span data-toggle="tooltip" data-placement="right" title="Comma separated emails">
                                <i class="fa fa-question-circle"></i>
                            </span>
                        </label>
                        <input type="text" name="cc" id="cc" class="form-control" value="{{ config('invoice.mail.send-invoice.email') }}">
                    </div>
                    <div class="form-group col-md-12">
                        <label class="leading-none" for="bcc">
                            {{ __('BCC') }} 
                            <span data-toggle="tooltip" data-placement="right" title="Comma separated emails">
                                <i class="fa fa-question-circle"></i>
                            </span>
                        </label>
                        <input type="text" name="bcc" id="bcc" class="form-control" value="">
                    </div>
                    <div class="form-group col-md-12">
                        <label class="leading-none" for="emailSubject">{{ __('Subject') }}</label>
                        <input type="text" name="email_subject" id="emailSubject"
                            class="form-control" value="{{ $sendInvoiceEmailSubject }}">
                    </div>
                    <div class="form-group col-md-12">
                        <label class="leading-none" for="emailBody">{{ __('Body') }}</label>
                        <textarea name="email_body" id="emailBody" class="form-control richeditor">{{ $sendInvoiceEmailBody }}</textarea>
                    </div>
                    <div class="form-group ml-1">
                        <input type="checkbox" id="verifyInvoice" class="c-pointer not-required-in-preview" required> 
                        <label for="verifyInvoice" name="verify_invoice" class="c-pointer">{{ __("I've verified the Invoice data.") }}</label>
                    </div>
                </div>
                <div class="modal-footer justify-content-start">
                    <div class="btn btn-primary close ml-0 text-light" data-dismiss="modal" aria-label="Close">
                        {{ __('Close') }}
                    </div>
                    <div class="btn btn-success close ml-0 text-light" onclick="saveInvoice(this)">
                        {{ __('Send') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>