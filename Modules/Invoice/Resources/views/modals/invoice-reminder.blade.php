<div class="modal fade" id="invoiceReminder" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-block">
                    <h4 class="modal-title">{{ __('Pending Invoice Mail') }}</h4>
                </div>
                <button type="button" class="close"   data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('invoice.reminder.email') }}" method="POST" id="sendInvoiceReminderForm">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="leading-none" for="sendFrom">{{ __('From') }}</label>
                            <input type="email" name="from" id="sendFrom"
                                class="form-control" value="{{ config('invoice.mail.send-invoice.email') }}" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="leading-none" for="sendTo">{{ __('To') }}</label>
                            <input type="email" name="to" id="sendTo"
                                class="form-control" required>
                        </div>
                        <input type="hidden" name="to_name" id="sendToName" class="form-control" required>
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
                                class="form-control" value="{{ $invoiceReminderEmailSubject }}" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="leading-none" for="emailBody">{{ __('Body') }}</label>
                            <textarea name="email_body" id="emailBody" class="form-control richeditor">{{ $invoiceReminderEmailBody }}</textarea>
                        </div>
                    </div>
                    <div class="form-group ml-1 mt-2">
                        <input type="hidden" name="invoice_id" id="invoiceId" value="">
                        <input type="submit" id="sendReminderBtn" class="btn btn-success text-light" value="Send Reminder">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>