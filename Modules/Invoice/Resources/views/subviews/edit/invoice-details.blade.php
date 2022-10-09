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

                <div class="form-group" v-if="this.client.type == 'indian'">
                    <div class="d-flex">
                        <label for="client_id" class="mr-5">GST:</label>
                        <span>
                            <p>{{ $invoice->gst . " ₹" }}</p>
                        </span>
                    </div>
                </div>
                <div class="form-group" v-if="this.client.type == 'indian'">
                    <div class="d-flex">
                        <label for="client_id" class="mr-5">total amount:</label>
                        <span>
                            {{ $invoice->display_amount . " + " . $invoice->gst ." ₹". " = " }} <span id="totalAmount">{{$invoice->total_amount }} ₹ </span>
                        </span>
                        <span class="d-none checkIcon"><i class="fa fa-check text-success rounded-circle ml-1"></i></span>
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

            <div class="col-md-5 offset-md-1" v-if="status == 'paid'">
                <div>
                    <h4><b>Payment Information:</b></h4>
                    <br>
                </div>

                <div class="form-group d-flex">
                    <label for="amountPaid" class="field-required mr-3 pt-1">Received Amount</label>
                    <div class="input-group flex-1">
                        <input v-model="amountPaid" type="number" class="form-control" name="amount_paid" id="amountPaid"
                            placeholder="Amount Received" required="required" step=".01" min="0" v-on:input="changePaidAmountListener">
                            <div class="input-group-prepend">
                                <select name="currency_transaction_charge" v-model="currencyTransactionCharge" id="currencyTransactionCharge" class="input-group-text" required="required">
                                @foreach($countries as $country)
                                    <option value="{{$country->currency}}">{{$country->currency}}</option>
                                @endforeach
                                </select>
                            </div>
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
                        <input type="text" id="tds" name="tds"  class = "form-control w-272 ml-auto" v-model='tds' required="required">
                    </div>
                </div>

                <div class="form-group" v-if="this.client.type == 'indian'">
                    <div class="d-flex">
                        <label for="tds_percentage" class="mr-4 pt-1 field-required">TDS %:</label>
                        <input type="text" class = "form-control w-272 ml-auto" name="tds_percentage" v-model='tdsPercentage' required="required">
                    </div>
                </div>

                <div class="form-group" v-if="this.client.type == 'indian'">
                    <div class="d-flex">
                        <label for="client_id" class="mr-5">total amount:</label>
                        <span id="totalPaidAmount"></span>
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

                <div class="form-group ">
                    <label for="comments">Comments</label>
                    <textarea name="comments" id="paidInvoiceComment" rows="5" class="form-control" @keyup="parseComment($event)" v-model="comments"></textarea>
                </div>

            </div>
            <div class="col-md-5 offset-md-1 mt-auto" v-if="status=='disputed'">
                <div class="form-group">
                    <label for="comments">Comments</label>
                    <textarea name="comments" id="comments" rows="5" class="form-control" v-model="comments"></textarea>
                </div>
            </div>
            <div v-if="status == 'paid'">
                @if($invoice->payment_confirmation_mail_sent === 0)
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
        </div>
        <div>
            @include('invoice::modals.payment-received')
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary mr-4">Save</button>
        @if(auth()->user()->can('finance_invoices.delete'))
            <span class="btn btn-danger" @click="deleteInvoice()" >Delete</span>
        @else
            @include('errors.403')
        @endif
    </div>
</div>


@section('js_scripts')
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
            let totalPaidAmount = this.amountPaid + " + " + $("#tds").val() + " = " + (parseInt(this.amountPaid) + parseFloat($("#tds").val()));
            document.getElementById("totalPaidAmount").innerText = totalPaidAmount;
            $(".checkIcon").addClass("d-none");
            console.log($("#totalAmount").text().trim(), (totalPaidAmount.split(/\=/)[1]).trim(), $("#totalAmount").text().trim() == (totalPaidAmount.split(/\=/)[1]).trim())
            if ($("#totalAmount").text().trim() == (totalPaidAmount.split(/\=/)[1]).trim()) {
                $(".checkIcon").removeClass("d-none");
            }
            var emailBody = $("#emailBody").text();
            emailBody = emailBody.replace(this.amountPaidText, this.amountPaid);
            tinymce.get("emailBody").setContent(emailBody, { format: "html" });
            this.calculateTaxes()
        },

        calculateTaxes() {
            if(this.client.type == 'indian') {
                this.updateTds()
            } else {
                this.updateBankCharges()
            }
        },

        updateTds() {
            this.tds = this.amount - this.amountPaid + (this.amount * 0.18)
            this.tdsPercentage = (this.tds/this.amount) * 100
        },

        updateBankCharges() {
            this.bankCharges = this.amount - this.amountPaid
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
            comments:`{{ $invoice->comments }}`,
            status:"{{ $invoice->status }}",
            amount:"{{ $invoice->amount }}",
            sent_on:"{{ $invoice->sent_on->format('Y-m-d') }}",
            due_on:"{{ $invoice->due_on->format('Y-m-d') }}",
            amountPaid: "{{ $invoice->amount_paid }}",
            bankCharges: "{{ $invoice->bank_charges }}",
            conversionRateDiff: "{{ $invoice->conversion_rate_diff }}",
            conversionRate: "{{ $invoice->conversion_rate }}",
            tds: "{{ $invoice->tds }}",
            tdsPercentage: "{{ $invoice->tds_percentage }}",
            show_on_select: true,
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

@endsection
