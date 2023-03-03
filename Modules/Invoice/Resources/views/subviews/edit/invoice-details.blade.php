<div id="edit_invoice_details_form">
    <div class="card-body">
        <div class="form-row mb-4">
            <div class="col-md-5">
                <div class="form-group d-flex">
                    <label for="project_invoice_id" class="pt-2"><b>Status</b></label>
                    <select class="form-control ml-4 flex-1" name="status" v-model="status">
                        @foreach(config('invoice.status') as $label => $status)
                            @if($label != "pending")
                                <option value="{{ $label }}">{{ $status }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2 col-lg-3 offset-md-4" v-if="status === 'partially_paid' || status ==='paid'">
                <a class="btn btn-sm btn-info text-white mr-4 font-weight-bold" data-toggle="modal" data-target="#invoiceModal">{{ __('Payments History') }}</a>
            </div>
        </div>

        <div class="form-row mb-4">
            <div class="col-md-5">
                <div>
                    <h4><b>Invoice Information:</b></h4>
                    <br>
                </div>

                <div class="form-group">
                    <div class="d-flex">
                        <label for="client_id font-weight-bold" class="mr-5">Client:</label>
                        <span>
                            <p>{{ $invoice->client->name }}</p>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-flex">
                        <label for="client_id" class="mr-5">Project:</label>
                        <span>
                            <p>{{ optional($invoice->project)->name ?: ($invoice->client->name . ' Projects') }}</p>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-flex">
                        <label for="client_id" class="mr-5">Amount:</label>
                        <span>
                            <p>{{ $invoice->display_amount }}</p>
                        </span>
                    </div>
                </div>

                <div class="form-group" v-if="status == 'partially_paid'">
                    <div class="d-flex">
                        <label for="client_id" class="mr-5">Remaining Amount:</label>
                        <span>
                            <p> @{{remainingAmount}} {{$invoiceValue['symbol']}}</p>
                      </span>
                    </div>
                </div>

                <div class="form-group" v-if="this.client.type == 'indian'">
                    <div class="d-flex">
                        <label for="client_id" class="mr-5">GST:</label>
                        <span>
                            <p>{{ $invoice->gst . " ₹" }}</p>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-flex">
                        <label for="client_id" class="mr-5">Sent on:</label>
                        <span>
                            <p>{{ $invoice->sent_on->format(config('invoice.default-date-format')) }}</p>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-flex">
                        <label for="client_id" class="mr-5">Due on:</label>
                        <span>
                            <p>{{ $invoice->due_on->format(config('invoice.default-date-format'))}}</p>
                        </span>
                    </div>
                </div>

                <div class="form-group d-flex">
                    <label for="receivable_date" class="field-required mr-3 pt-2">Receivable date</label>
                    <input type="date" class="form-control flex-1" name="receivable_date" id="receivable_date" required="required"
                        value="{{ $invoice->receivable_date->format('Y-m-d') }}">
                </div>

            </div>

            <div class="col-md-5 offset-md-1" v-if="status === 'partially_paid' || status === 'paid'">
                <div>
                    <h4><b>Payment Information:</b></h4>
                    <br>
                </div>

                <div class="custom-control custom-switch" v-if="status === 'paid'">
                    <input type="checkbox" id="hidebtn" class="custom-control-input" v-model="showPendingInvoices">
                    <label class="custom-control-label" for="hidebtn">Pending Payments</label>
                </div>

                <div id="pendingInvoice" v-show="showPendingInvoices && status === 'paid'" class =>
                    @if($unpaidInvoiceDetailsByInvoiceId)
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="col-4 text-center">Invoice Number</th>
                                    <th class="col-4 text-center">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($unpaidInvoiceDetailsByInvoiceId as $key=>$pendinginvoicedata)
                                    <tr>
                                        <td class="col-4">
                                            <label>
                                                <input type="checkbox" 
                                                    name="pendingpayment[]" 
                                                    value="{{ $key }}" 
                                                    v-model="selectedInvoices">
                                                {{ $pendinginvoicedata['invoice_number'] }}
                                            </label>
                                        </td>
                                        <td class="col-4 text-center">{{ $pendinginvoicedata['amount'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-success small font-weight-bold">No pending invoices</p>
                    @endif 
                </div>

                <div class="form-group mt-5">
                    <div class="d-flex align-items-start">
                        <label for="amountPaid" class="field-required mr-3 pt-1">Received Amount</label>
                        <div class="input-group flex-1">
                            <input v-model="amountPaid" type="number" class="form-control" name="amount_paid" id="amountPaid"
                                placeholder="Amount Received" required="required" step=".01" min="0" v-on:input="changePaidAmountListener">
                            <div class="input-group-prepend">
                                <select name="currency_transaction_charge" v-model="currencyTransactionCharge" id="currencyTransactionCharge"
                                    class="input-group-text" required="required">
                                    @foreach($countries as $country)
                                        <option value="{{$country->currency}}">{{$country->currency}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p v-if="totalAmountStatus()==false && status === 'paid'" class="text-danger small font-weight-bold">Please enter the overall amount.</p>
                    </div>
                </div>

                <div class="form-group-inline d-flex mb-2">
                    <label for="payment_at" class="field-required mr-8 pt-1">Payment date</label>
                    <input type="date" class="form-control flex-1" name="payment_at" id="payment_at"
                    required="required"
                    value="{{ $invoice->payment_at ? $invoice->payment_at->format('Y-m-d') : date('Y-m-d') }}">
                </div>

                <div class="form-group" v-if="this.client.type == 'indian'">
                    <div class="d-flex">
                        <label for="tds" class="mr-4 pt-1 field-required">TDS:</label>
                        <input type="text" name="tds"  class = "form-control w-272 ml-auto" v-model='tds' required="required">
                    </div>
                </div>

                <div class="form-group" v-if="this.client.type == 'indian'">
                    <div class="d-flex">
                        <label for="tds_percentage" class="mr-4 pt-1 field-required">TDS %:</label>
                        <input type="text" class = "form-control w-272 ml-auto" name="tds_percentage" v-model='tdsPercentage' required="required">
                    </div>
                </div>

                <div class="form-group" v-if="this.client.type != 'indian'">
                    <div class="d-flex">
                        <label for="bank_charges" class="mr-4 pt-1 field-required">Bank Charges:</label>
                        <input type="number" class="form-control w-272 ml-auto" step="0.01" name="bank_charges" v-model='bankCharges' required="required">
                    </div>
                </div>

                <div class="form-group" v-if="this.client.type !== 'indian'">
                    <div class="d-flex">
                        <label for="client_id" class="mr-4 pt-1 field-required">Conversion Rate Diff:</label>
                        <input type="number" class="form-control w-272 ml-auto" step="0.01" name="conversion_rate_diff" v-model = 'conversionRateDiff' required="required">
                    </div>
                </div>

                <div class="form-group" v-if="this.client.type !== 'indian'">
                    <div class="d-flex">
                        <label for="conversion_rate" class="mr-4 pt-1 field-required">Conversion Rate:</label>
                        <input type="number" id="conversionRate" class="form-control w-272 ml-auto" step="0.01" name="conversion_rate" v-model = 'conversionRate' required="required">
                    </div>
                </div>

                <div>
                    <div class="custom-control custom-switch mb-4">
                        <input type="checkbox" id="toggleComments" class="custom-control-input" v-model="showPaymentDetails">
                        <label class="custom-control-label" for="toggleComments">Enable Payment Parsing</label>
                    </div>
                    <div class="form-group">
                        <textarea name="comments" id="paidInvoiceComment" rows="5" class="form-control" @keyup="parseComment($event)" v-model="comments"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-5 offset-md-1 mt-auto" v-if="status=='disputed'">
                <div class="form-group">
                    <label for="comments">Comments</label>
                    <textarea name="comments" id="comments" rows="5" class="form-control" v-model="comments"></textarea>
                </div>
            </div>
            <div v-if="status == 'partially_paid' || status == 'paid'">
                @if(!$invoiceValue['showMailOption'])
                    <input type="checkbox" id="showEmail" class="ml-auto" name="send_mail">
                    <label for="showEmail" class="mx-1 pt-1">{{ __('Send Confirmation Mail') }}</label>
                    <i class="pt-1 ml-1 fa fa-external-link-square" data-toggle="modal" data-target="#paymentReceived"></i>
                    <div class="fz-14 text-theme-orange">{{ __('If disabled the mail will not be sent.') }}</div>
                @else
                    <label class="mx-1 pt-1">
                        {{ __('Confirmation Mail Status: ') }}
                        <span class="text-success font-weight-bold">
                            {{ __('Sent') }}
                        </span>
                    </label>
                @endif
            </div> 
        <div>
            @include('invoice::modals.payment-received')
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" :disabled="!totalAmountStatus()" class="btn btn-primary mr-4">Save</button>
        @if(auth()->user()->can('finance_invoices.delete'))
            <span class="btn btn-danger" @click="deleteInvoice()" >Delete</span>
        @else
            @include('errors.403')
        @endif
    </div>
</div>

@section('scripts')
<script>
    new Vue({
    el:'#edit_invoice_details_form',

    methods: {
        deleteInvoice: async function() {
            if(!confirm("Are you sure?")) {
                return true;
            }
            await axios.delete("{{ route('invoice.delete', $invoice) }}")
            window.location.href =  "{{ route('invoice.index') }}";
        },

        changePaidAmountListener() {
            var emailBody = $("#emailBody").text();
            emailBody = emailBody.replace(this.amountPaidText, this.amountPaid);
            tinymce.get("emailBody").setContent(emailBody, { format: "html" });
            this.remainingPayment()
            this.calculateTaxes()
        },

        remainingPayment(){
            if (!this.amountPaid) {
                this.remainingAmount = (this.totalProjectAmount - this.previousAmount).toFixed(2)
            } else {
                this.remainingAmount = (this.totalProjectAmount - (parseFloat(this.amountPaid) + parseFloat(this.previousAmount))).toFixed(2);
            }  
        },       

        calculateTaxes() {
            if(this.client.type == 'indian') {
                this.updateTds()
            } else {
                this.updateBankCharges()
            }
        },

        updateTds() {
            if(!this.amountPaid){
                this.tds = '',
                this.tdsPercentage = ''
            }else{
                this.tds = (this.amount - this.amountPaid + (this.amount * 0.18)).toFixed(2);
                this.tdsPercentage = ((this.tds/this.amount) * 100).toFixed(2);
            }
        },

        updateBankCharges() {
            if(!this.amountPaid){
                this.bankCharges = '';
            }else{
                this.bankCharges = this.amount - this.amountPaid;
            }
        },

        showEmail($event) {
            if (event.target.checked) {
                this.show_on_select = true
            } else {
                this.show_on_select = false
            }
        },

        parseComment($event) {
            let comment = event.target.value

            extractedNumberList = comment.split(" ").map(function(word) {
                var number = Number(word.trim().replaceAll(",", ""))
                if (isNaN(number)) {
                    return null;
                }
                return number;
            });

            var filteredNumberList = extractedNumberList.filter(function (number) {
                return number != null;
            });

            this.updatePaymentAmountDetails(filteredNumberList)
        },

        updatePaymentAmountDetails(filtered_number_list) {
            if (!this.showPaymentDetails) {
                return;
            }
            let totalNumbersInList =  filtered_number_list.length
            var emailBody = $("#emailBody").text();
            for (var index = 0; index < totalNumbersInList; index++) {
                if (this.client.type == 'indian') {
                    if (index == totalNumbersInList - 1) {
                        this.amountPaid = filtered_number_list[index]
                        $('#amountPaid').val(this.amountPaid)
                        emailBody = emailBody.replace(this.amountPaidText, this.amountPaid);
                        this.calculateTaxes()
                    }
                    continue;
                }

                if (index == 0) {
                    this.amountPaid = filtered_number_list[index]
                    $('#amountPaid').val(this.amountPaid)
                    emailBody = emailBody.replace(this.amountPaidText, this.amountPaid);
                    this.calculateTaxes()
                } else if (index == 1) {
                    conversionRate = filtered_number_list[index]
                    this.conversionRate = conversionRate
                    this.conversionRateDiff = Math.abs(this.currentExchangeRate - conversionRate).toFixed(2)
                }
            }

            tinymce.get("emailBody").setContent(emailBody, { format: "html" });
        },

        totalPendingAmount() {
            var total = 0;
            for (let i = 0; i < this.selectedInvoices.length; i++) {
                var invoice = this.unpaidInvoiceDetailsByInvoiceId[this.selectedInvoices[i]];
                if (invoice) {
                    total += parseInt(invoice.amount);
                    console.log(total);
                }
            }
            return total;
        },
        
        totalAmountStatus() {
            const totalPendingAmount = this.totalPendingAmount();
            const inputAmount = parseInt(this.amountPaid);
            const projectAmount = parseInt(this.amount);

            if (this.status === 'paid') {
                if (totalPendingAmount) {
                    if(inputAmount === totalPendingAmount + projectAmount){
                        return true;
                    }else{
                        return false;
                    }
                } else if (inputAmount){
                    if(inputAmount === projectAmount){
                        return true;
                    }else{
                        return false;
                    }
                }
            } else {
                return true;
            }
        }
    },

    data() {
        return {
            clients: @json($clients),
            invoice:@json($invoice),
            projects:@json( $invoice->client->projects),
            clientId:"{{ $invoice->client_id  }}",
            projectId:"{{ $invoice->project_id }}",
            client:@json( $invoice->client),
            amountPaidText:"|*amount_paid*|",  
             currentExchangeRate: "{{ $currencyService->getCurrentRatesInINR() }}",
            currencyTransactionCharge:"{{ $invoice->currency_transaction_charge ? : $invoice->currency }}",
            comments:`{{''}}`,
            status:"{{ $invoice->status }}",
            amount:"{{ $invoice->amount }}",
            sent_on:"{{ $invoice->sent_on->format('Y-m-d') }}",
            due_on:"{{ $invoice->due_on->format('Y-m-d') }}",
            amountPaid: "{{''}}",
            bankCharges: "{{ '' }}",
            conversionRateDiff: "{{''}}",
            conversionRate: "{{''}}",
            tds: "{{''}}",
            tdsPercentage: "{{''}}",
            show_on_select: true,
            remainingAmount: "{{$invoiceValue['totalProjectAmount'] - $invoiceValue['amount_paid_till_now']}}",
            previousAmount: "{{$invoiceValue['amount_paid_till_now']}}",
            totalProjectAmount: "{{$invoiceValue['totalProjectAmount']}}",
            allInstallmentPayments: "{{$invoiceValue['allInstallmentPayments']}}",
            showPendingInvoices: false,
            showInvoiceComment:false,
            selectedInvoices: [],
            unpaidInvoiceDetailsByInvoiceId: @json($unpaidInvoiceDetailsByInvoiceId),
        }
    },
    mounted() {
    },

    computed: {
        gst: function () {
            return (this.amount * 0.18).toFixed(2);
        },
    }
});

</script>
@include('invoice::subviews.edit.invoice-payment-modal')
@endsection
