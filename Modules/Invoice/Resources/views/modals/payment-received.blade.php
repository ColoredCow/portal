<div class="modal fade" id="paymentReceived" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-block">
                    <h4 class="modal-title">{{ __('Payment Received Mail') }}</h4>
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
                            class="form-control" value="{{ config('invoice.mail.send-invoice.email') }}" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="leading-none" for="sendTo">{{ __('To') }}</label>
                        <input type="email" name="to" id="sendTo" class="form-control" value="{{ optional($invoice->client->billing_contact)->email }}" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="leading-none" for="sendToName">{{ __('Receiver Name') }}</label>
                        <input type="text" name="to_name" id="sendToName" class="form-control" value="{{ optional($invoice->client->billing_contact)->name }}" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="leading-none" for="cc">
                            {{ __('CC') }} 
                            <span data-toggle="tooltip" data-placement="right" title="Comma separated emails">
                                <i class="fa fa-question-circle"></i>
                            </span>
                        </label>
                        <input type="text" name="cc" id="cc" class="form-control" value="{{$invoice->client->cc_emails}}">
                    </div>
                    <div class="form-group col-md-12">
                        <label class="leading-none" for="bcc">
                            {{ __('BCC') }} 
                            <span data-toggle="tooltip" data-placement="right" title="Comma separated emails">
                                <i class="fa fa-question-circle"></i>
                            </span>
                        </label>
                        <input type="text" name="bcc" id="bcc" class="form-control" value="{{$invoice->client->bcc_emails}}">
                    </div>
                    <div class="form-group col-md-12">
                        <label class="leading-none" for="emailSubject">{{ __('Subject') }}</label>
                        <input type="text" name="email_subject" id="emailSubject"
                            class="form-control" value="{{ $paymentReceivedEmailSubject }}">
                    </div>
                    <div class="form-group col-md-12">
                        <label class="leading-none" for="emailBody">{{ __('Body') }}</label>
                        <textarea name="email_body" id="emailBody" class="form-control richeditor">{{ $paymentReceivedEmailBody }}</textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-start">
                <div class="btn btn-primary close text-light" data-dismiss="modal" aria-label="Close">
                    {{ __('Close') }}
                </div>
            </div>
        </div>
    </div>
</div>