<div class="modal fade" id="emailPreview" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-block">
                    <h4 class="modal-title">{{ __('Invoice mail preview') }}</h4>
                </div>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('invoice.send-invoice-mail') }}" method="POST" id="sendInvoiceForm">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="leading-none" for="sendFrom">{{ __('From') }}</label>
                            <input type="email" name="from" id="sendFrom"
                                class="form-control" value="{{ config('invoice.mail.send-invoice.email') }}">
                        </div>
                        <div class="form-group col-md-12">
                            <label class="leading-none" for="sendTo">{{ __('To') }}</label>
                            <input type="email" name="to" id="sendTo"
                                class="form-control" >
                        </div>
                        <div class="form-group col-md-12">
                            <label class="leading-none" for="sendToName">{{ __('Receiver Name') }}</label>
                            <input type="text" name="to_name" id="sendToName" class="form-control" >
                        </div>
                        <input type="hidden" name="to_name" id="sendToName" class="form-control">
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
                                class="form-control" value="{{ $sendInvoiceEmailSubject }} ">
                        </div>
                        <div class="form-group col-md-12">
                            <label class="leading-none" for="emailBody">{{ __('Body') }}</label>
                            <textarea name="email_body" id="emailBody" class="form-control richeditor">{{ $sendInvoiceEmailBody }}</textarea>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="form-group ml-1">
                            <input type="checkbox" id="verifyInvoice" class="c-pointer"> 
                            <label for="verifyInvoice" class="c-pointer">{{ __("I've verified the Invoice data.") }}</label>
                        </div>
                        <div class="alert alert-danger d-none pr-0.83" id="errorMessage">
                            {{-- <button type="button" id="InvoicePreviewModalCloseBtn" class="hahahahaha">
                                <span aria-hidden="true">&times;</span>
                            </button> --}}
                            <strong id="errors"></strong>
                        </div>
                        <div class="form-group ml-1">
                            <input type="hidden" name="client_id" id="clientId" value="">
                            <input type="hidden" name="project_id" id="projectId" value="">
                            <input type="hidden" name="term" value="{{ $year . '-' . $month }}">
                            <input type="submit" id="sendInvoiceBtn" class="btn btn-success text-light" value="Send Invoice" disabled>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>