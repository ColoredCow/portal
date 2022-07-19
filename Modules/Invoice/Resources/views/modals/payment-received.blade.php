@php
if(optional($invoice->client->tertiary_contact)->first() != null) {
    $bccEmails='';
    foreach($invoice->client->tertiary_contact as $bccEmail)
    {
        $bccEmails .= ",$bccEmail->email";
    } 
    $bccEmails = substr($bccEmails, 1);
} else {
    $bccEmails = null;
}
if(optional($invoice->client->secondary_contact)->first() != null) {
    $ccEmails='';
    foreach($invoice->client->secondary_contact as $ccEmail)
    {
        $ccEmails .= ",$ccEmail->email";
    } 
    $ccEmails = substr($ccEmails, 1);
} else {
    $ccEmails = null;
}
@endphp

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
                    <input type="hidden" name="to_name" id="sendToName" class="form-control" value="{{ optional($invoice->client->billing_contact)->name }}" required>
                    <div class="form-group col-md-12">
                        <label class="leading-none" for="cc">
                            {{ __('CC') }} 
                            <span data-toggle="tooltip" data-placement="right" title="Comma separated emails">
                                <i class="fa fa-question-circle"></i>
                            </span>
                        </label>
                        <input type="text" name="cc" id="cc" class="form-control" value="{{$ccEmails == null ? config('invoice.mail.send-invoice.email') : config('invoice.mail.send-invoice.email') .','. $ccEmails}}">
                    </div>
                    <div class="form-group col-md-12">
                        <label class="leading-none" for="bcc">
                            {{ __('BCC') }} 
                            <span data-toggle="tooltip" data-placement="right" title="Comma separated emails">
                                <i class="fa fa-question-circle"></i>
                            </span>
                        </label>
                        <input type="text" name="bcc" id="bcc" class="form-control" value="{{$bccEmails}}">
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