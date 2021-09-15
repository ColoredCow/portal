<div id="edit_invoice_details_form">
    <div class="card-body">

        <div class="form-row mb-4">
            <div class="col-md-5">
                <div class="form-group d-flex">
                    <label for="project_invoice_id" class="pt-2"><b>Status</b></label>
                    <select class="form-control ml-4 flex-1" name="status" v-model="status">
                        <option value="sent">Sent</option>
                        <option value="paid">Paid</option>
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
                            <p>{{ $invoice->project->name }}</p>
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
                    <label for="amount" class="field-required mr-3 pt-1">Received Amount</label>
                    <div class="input-group flex-1">
                        <input v-model="amount_paid" type="number" class="form-control" name="amount_paid" id="amount_paid"
                            placeholder="Amount Received" required="required" step=".01" min="0" v-on:input="changePaidAmountListener">
                            <div class="input-group-prepend">
                                <select name="currency_transaction_charge" v-model="currency_transaction_charge" id="currency_transaction_charge" class="input-group-text" required="required">
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
                        <input type="text" name="tds"  class = "form-control w-272 ml-auto" v-model='tds' required="required">
                    </div>
                </div>

                <div class="form-group" v-if="this.client.type == 'indian'">
                    <div class="d-flex">
                        <label for="tds_percentage" class="mr-4 pt-1 field-required">TDS %:</label>
                        <input type="text" class = "form-control w-272 ml-auto" name="tds_percentage" v-model='tds_percentage' required="required">
                    </div>
                </div>

                <div class="form-group" v-if="this.client.type != 'indian'">
                    <div class="d-flex">
                        <label for="bank_charges" class="mr-4 pt-1 field-required">Bank Charges:</label>
                        <input type="text" class = "form-control w-272 ml-auto" name="bank_charges" v-model='bank_charges' required="required">
                    </div>
                </div>

                <div class="form-group" v-if="this.client.type != 'indian'">
                    <div class="d-flex">
                        <label for="client_id" class="mr-4 pt-1 field-required">Conversion Rate Diff:</label>
                        <input type="text" class = "form-control w-272 ml-auto" name="conversion_rate_diff" v-model = 'conversion_rate_diff'required="required">
                    </div>
                </div>

                <div class="form-group ">
                    <label for="comments">Comments</label>
                    <textarea name="comments" id="comments" rows="5" class="form-control" v-model="comments"></textarea>
                </div>

            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary mr-4">Save</button>
        <span class="btn btn-danger" @click="deleteInvoice()" >Delete</span>
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
            this.tds = this.amount - this.amount_paid + (this.amount * 0.18)
            this.tds_percentage = (this.tds/this.amount) * 100
        },

        updateBankCharges() {
            this.bank_charges = this.amount - this.amount_paid
        }
    },

    data() {
        return {
            clients: @json($clients),
            invoice:@json($invoice),
            projects:@json( $invoice->client->projects),
            clientId:"{{ $invoice->client_id  }}",
            projectId:"{{ $invoice->project_id  }}",
            client:@json( $invoice->client),
            currency_transaction_charge:"{{ $invoice->currency_transaction_charge ? : $invoice->currency }}",
            comments:`{{ $invoice->comments }}`, 
            status:"{{ $invoice->status }}",
            amount:"{{ $invoice->amount }}",
            sent_on:"{{ $invoice->sent_on->format('Y-m-d') }}",
            due_on:"{{ $invoice->due_on->format('Y-m-d') }}",
            amount_paid: "{{ $invoice->amount_paid }}",
            bank_charges: "{{ $invoice->bank_charges }}",
            conversion_rate_diff: "{{ $invoice->conversion_rate_diff }}",
            tds: "{{ $invoice->tds }}",
            tds_percentage: "{{ $invoice->tds_percentage }}",
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
