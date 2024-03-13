<div id="edit_invoice_details_form">
    <div class="card-body">

        <div class="form-row mb-4">
            <div class="col-md-5">
                <div class="form-group d-flex">
                    <label for="project_invoice_id" class="pt-2"><b>Status</b></label>
                    <select class="form-control ml-4 flex-1" name="status" v-model="status">
                        @foreach (config('invoice.status') as $label => $status)
                            @if ($label != 'pending')
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
                        <label for="client_id font-weight-bold" class="mr-3 w-90">Client:</label>
                        <span>
                            <p>{{ $invoice->client->name }}</p>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-flex">
                        <label for="client_id" class="mr-3 w-90">Project:</label>
                        <span>
                            <p>{{ optional($invoice->project)->name ?: $invoice->client->name . ' Projects' }}</p>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-flex">
                        <label for="client_id" class="mr-3 w-90">Amount:</label>
                        <span>
                            <p>{{ $invoice->display_amount }}</p>
                        </span>
                    </div>
                </div>

                <div class="form-group" v-if="this.client.type == 'indian'">
                    <div class="d-flex">
                        <label for="client_id" class="mr-3 w-90">GST:</label>
                        <span>
                            <p>{{ $invoice->gst . ' ₹' }}</p>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-flex">
                        <label for="client_id" class="mr-3 w-90">Sent on:</label>
                        <span>
                            <p>{{ $invoice->sent_on->format(config('invoice.default-date-format')) }}</p>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-flex">
                        <label for="client_id" class="mr-3 w-90">Due on:</label>
                        <span>
                            <p>{{ $invoice->due_on->format(config('invoice.default-date-format')) }}</p>
                        </span>
                    </div>
                </div>

                <div class="form-group d-flex">
                    <label for="receivable_date" class="field-required mr-3 w-md-90 w-xl-auto pt-2">Receivable <br> date</label>
                    <input type="date" class="form-control flex-1" name="receivable_date" id="receivable_date"
                        required="required" value="{{ $invoice->receivable_date->format('Y-m-d') }}">
                </div>

            </div>

            <div class="col-md-5 offset-md-1" v-if="status == 'paid'">
                <div>
                    <h4><b>Payment Information:</b></h4>
                    <br>
                </div>

                <div class="form-group d-flex">
                    <label for="amountPaid" class="field-required w-145 mr-4 pt-1">Received Amount</label>
                    <div class="input-group flex-1">
                        <input v-model="amountPaid" type="number" class="form-control ml-auto" name="amount_paid"
                            id="amountPaid" placeholder="Amount Received" required="required" step=".01"
                            min="0" v-on:input="changePaidAmountListener">
                        <div class="input-group-prepend">
                            <select name="currency_transaction_charge" v-model="currencyTransactionCharge"
                                id="currencyTransactionCharge" class="input-group-text h-xl-44" required="required">
                                @foreach ($countries as $country)
                                    <option value="{{ $country->currency }}">{{ $country->currency }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group-inline d-flex mb-2">
                    <label for="payment_at" class="field-required w-145 mr-4 pt-1">Payment date</label>
                    <input type="date" class="form-control w-200 w-xl-272 ml-auto flex-1" name="payment_at" id="payment_at"
                        required="required"
                        value="{{ $invoice->payment_at ? $invoice->payment_at->format('Y-m-d') : date('Y-m-d') }}">
                </div>

                <div class="form-group" v-if="this.client.type == 'indian'">
                    <div class="d-flex">
                        <label for="tds" class="field-required w-145 mr-4 pt-1">TDS:</label>
                        <input type="text" name="tds" class="form-control w-200 w-xl-272 ml-auto" v-model='tds'
                            required="required">
                    </div>
                </div>

                <div class="form-group" v-if="this.client.type == 'indian'">
                    <div class="d-flex">
                        <label for="tds_percentage" class="field-required w-145 mr-4 pt-1">TDS %:</label>
                        <input type="text" class="form-control w-200 w-xl-272 ml-auto" name="tds_percentage"
                            v-model='tdsPercentage' required="required">
                    </div>
                </div>

                <div class="form-group" v-if="this.client.type != 'indian'">
                    <div class="d-flex">
                        <label for="bank_charges" class="field-required w-145 mr-4 pt-1">Bank Charges:</label>
                        <input type="number" class="form-control w-200 w-xl-272 ml-auto" step="0.01" name="bank_charges"
                            v-model='bankCharges' required="required">
                    </div>
                </div>
                
                <div class="form-group" v-if="this.client.type !== 'indian'">
                    <div class="d-flex">
                        <label for="conversion_rate" class="w-145 mr-4"><a target="_blank" href="https://www.google.co.in/search?q=conversion+rate+usd+to+inr">Today's Google Conversion Rate:</a></label>
                        <input type="number" id="currentConversionRate" class="form-control ml-auto w-200 w-xl-272 bg-white" step="0.01"
                            value="{{$currencyService->getCurrentRatesInINR()}}" disabled>
                    </div>
                </div>

                <div class="form-group" v-if="this.client.type !== 'indian'">
                    <div class="d-flex">
                        <label for="conversion_rate" class="field-required w-145 mr-4 pt-1">Client Conversion Rate:</label>
                        <input type="number" id="conversionRate" class="form-control w-200 w-xl-272 ml-auto" step="0.01"
                            name="conversion_rate" v-model='conversionRate' required="required">
                    </div>
                </div>

                <div class="form-group" v-if="this.client.type !== 'indian'">
                    <div class="d-flex">
                        <label for="client_id" class="field-required w-145 mr-4 pt-1">Conversion Rate Diff:</label>
                        <input type="number" class="form-control w-200 w-xl-272 ml-auto" step="0.01"
                            name="conversion_rate_diff" v-model='conversionRateDiff' required="required">
                    </div>
                </div>

                <div class="form-group ">
                    <label for="comments">Comments</label>
                    <textarea name="comments" id="paidInvoiceComment" rows="5" class="form-control" @keyup="parseComment($event)"
                        v-model="comments"></textarea>
                        <div id="bank-not-found" class="text-theme-orange fz-14 leading-20 font-weight-bold"></div>
                </div>

            </div>
            <div class="col-md-5 offset-md-1 mt-auto" v-if="status=='disputed'">
                <div class="form-group">
                    <label for="comments">Comments</label>
                    <textarea name="comments" id="comments" rows="5" class="form-control" v-model="comments"></textarea>
                </div>
            </div>
            <div v-if="status == 'paid'">
                @if ($invoice->payment_confirmation_mail_sent === 0)
                    <input type="checkbox" id="showEmail" class="ml-auto" name="send_mail">
                    <label for="showEmail" class="mx-1 pt-1">{{ __('Send Confirmation Mail') }}</label>
                    <i class="pt-1 ml-1 fa fa-external-link-square" data-toggle="modal"
                        data-target="#paymentReceived"></i>
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
        @if (auth()->user()->can('finance_invoices.delete'))
            <span class="btn btn-danger" @click="deleteInvoice()">Delete</span>
        @else
            @include('errors.403')
        @endif
    </div>
</div>


@section('js_scripts')
        @php $bank_message_patterns = (config('invoice.bank_message_patterns')); @endphp
        <script>
        let bank_message_patterns = @json($bank_message_patterns);
        new Vue({
            el: '#edit_invoice_details_form',

            methods: {
                deleteInvoice: async function() {
                    if (!confirm("Are you sure?")) {
                        return true;
                    }
                    await axios.delete("{{ route('invoice.delete', $invoice) }}")
                    window.location.href = "{{ route('invoice.index') }}";
                },

                changePaidAmountListener() {
                    var emailBody = $("#emailBody").text();
                    emailBody = emailBody.replace(this.amountPaidText, this.amountPaid);
                    tinymce.get("emailBody").setContent(emailBody, {
                        format: "html"
                    });
                    this.calculateTaxes()
                },

                calculateTaxes() {
                    if (this.client.type == 'indian') {
                        this.updateTds()
                    } else {
                        this.updateBankCharges()
                    }
                },

                updateTds() {
                    this.tds = this.amount - this.amountPaid + (this.amount * 0.18)
                    this.tdsPercentage = (this.tds / this.amount) * 100
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
            
                // Comment parsing logic for different banks.
                citiBankParser(comment) {
                    extractedNumberList = comment.split(" ").map(function(word) {
                                var number = word.trim().replaceAll(",", "")
                                if (number == 0 || isNaN(number)) {
                                    return null;
                                }
                                return Number(number);
                            });
                    
                            var filteredNumberList = extractedNumberList.filter(function(number) {
                                return number != null
                            });

                            this.updatePaymentAmountDetails(filteredNumberList, bank = bank_message_patterns.citi.key);
                },

                axisBankParser(comment) {
                    extractedNumberList = comment.split(/[\/\s]/g).map(function(word) {
<<<<<<< HEAD
                        var number = word.trim().replaceAll(",", "")
=======
                            var number = word.trim().replace(/,\s/, "")
>>>>>>> 0bc2693654b81d82c582aa9716b71fb3ab9162db
                                if (number == 0 || isNaN(number)) {
                                    return null;
                                }
                                return Number(number);
                            });
                
                            var filteredNumberList = extractedNumberList.filter(function(number) {
                                return number != null
                            });

                            this.updatePaymentAmountDetails(filteredNumberList, bank = bank_message_patterns.axis.key);

                },

                //Calculate percentage of matching string
                showMatchingPercentage(comment, bankPattern){
                    var tmpValue = 0;
                    var maxLength = comment.length;
                    var minLength = bankPattern.length;
                    if(comment.length > bankPattern.length){
                        var minLength = bankPattern.length;
                    }
                    for(var i = 0; i < minLength; i++) {
                        if(comment[i] == bankPattern[i]) {
                            tmpValue++;
                        }
                    }
                    var percent = (tmpValue / maxLength) * 100;
                    return (percent);
                },

                defaultParser(comment, bank_message_patterns) {
                    let bankWithMaxSimilarityPercentages = {}
                    for(let bankName in bank_message_patterns) {
                        let result = this.showMatchingPercentage(comment, bank_message_patterns[bankName].value)
                        bankWithMaxSimilarityPercentages[bank_message_patterns[bankName].key] = result;
                    }
                    bankWithMaxSimilarityPercentages = Object.keys(bankWithMaxSimilarityPercentages).reduce((a, b) => bankWithMaxSimilarityPercentages[a] > bankWithMaxSimilarityPercentages[b] ? a : b);

                    switch (bankWithMaxSimilarityPercentages) {
                        case bank_message_patterns.citi.key:
                            this.citiBankParser(comment);
                            break;
                        case bank_message_patterns.axis.key:
                            this.axisBankParser(comment);
                            break;
                    }
                },

                parseComment($event) {
                    let comment = event.target.value
                    formattedComment = comment.replace(/\s/g, ""); // Variable for storing the formatted comment string so that we can match it with the stored bank patterns
                    
                    // Extracting the paid amount according to the bank transaction pattern string.
                    var bank = null; 
                    for(let bankName in bank_message_patterns) {
                        if (formattedComment.includes(bank_message_patterns[bankName].value)) {
                            bank = bank_message_patterns[bankName].key;
                        } 
                    }
                    // Showing message if bank statement does not match any exising bank pattern
                    if (bank || !comment) {
                        document.getElementById("bank-not-found").innerHTML = null ;
                    } else {
                            document.getElementById("bank-not-found").innerHTML = 'The bank statement does not match existing patterns. Trying to give the best possible result.' ;
                        }

                    switch (bank) {
                        case bank_message_patterns.citi.key:
                                this.citiBankParser(comment);
                            break;
                        
                        case bank_message_patterns.axis.key:
                                this.axisBankParser(comment);
                            break;

                        default:
                            this.defaultParser(comment, bank_message_patterns);
                            break;
                    }
                
                },

                setBankConversionRate(filtered_number_list, index, bank) {
                    conversionRate = filtered_number_list[index]
                    switch (bank) {
                        case bank_message_patterns.axis.key:
                                this.conversionRate = conversionRate / this.amountPaid;
                                this.conversionRateDiff = Math.abs(this.currentExchangeRate - this.conversionRate).toFixed(2)
                            break;
        
                        default:
                                this.conversionRate = conversionRate;
                                this.conversionRateDiff = Math.abs(this.currentExchangeRate - this.conversionRate).toFixed(2)
                            break;
                    }
                },

                updatePaymentAmountDetails(filtered_number_list, bank) {
                    let totalNumbersInList = filtered_number_list.length
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
                        } else if (index == totalNumbersInList-1) {
                            this.setBankConversionRate(filtered_number_list, index, bank);
                        }
                    }

                    tinymce.get("emailBody").setContent(emailBody, {
                        format: "html"
                    });
                }
            },

            data() {
                return {
                    clients: @json($clients),
                    invoice: @json($invoice),
                    projects: @json($invoice->client->projects),
                    clientId: "{{ $invoice->client_id }}",
                    projectId: "{{ $invoice->project_id }}",
                    client: @json($invoice->client),
                    amountPaidText: "|*amount_paid*|",
                    currentExchangeRate: "{{ $currencyService->getCurrentRatesInINR() }}",
                    currencyTransactionCharge: "{{ $invoice->currency_transaction_charge ?: $invoice->currency }}",
                    comments: `{{ $invoice->comments }}`,
                    status: "{{ $invoice->status }}",
                    amount: "{{ $invoice->amount }}",
                    sent_on: "{{ $invoice->sent_on->format('Y-m-d') }}",
                    due_on: "{{ $invoice->due_on->format('Y-m-d') }}",
                    amountPaid: "{{ $invoice->amount_paid }}",
                    bankCharges: "{{ $invoice->bank_charges }}",
                    conversionRateDiff: "{{ $invoice->conversion_rate_diff }}",
                    conversionRate: "{{ $invoice->conversion_rate }}",
                    tds: "{{ $invoice->tds }}",
                    tdsPercentage: "{{ $invoice->tds_percentage }}",
                    show_on_select: true,
                }
            },



            mounted() {},

            computed: {
                gst: function() {
                    return (this.amount * 0.18).toFixed(2);
                },
            }
        });
    </script>
@endsection