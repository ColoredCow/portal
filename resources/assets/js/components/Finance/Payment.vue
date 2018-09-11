<template>
    <div>
        <div class="card-header">
            <span>Payment Details</span>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="invoice_id" class="field-required">Invoice</label>
                    <select name="invoice_id" id="invoice_id" class="form-control" required="required" v-model="invoiceId" @change="updatePaymentFields()" :disabled="!this.isNew">
                        <option v-if="!this.isNew" :value="invoiceId">
                            {{payment.invoice.project.name}} – {{payment.invoice.sentOnDisplay}}
                        </option>
                        <option v-else v-for="invoice in unpaidInvoices" :value="invoice.id">
                            {{invoice.project.name}} – {{invoice.sentOnDisplay}}
                        </option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="paid_at" class="field-required">Paid on</label>
                    <input type="date" required="required" class="form-control" name="paid_at" id="paid_at" placeholder="dd/mm/yyyy" v-model="paidAt">
                </div>
                <div class="form-group col-md-3">
                    <label for="payment_amount" class="field-required">Payment amount</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <select name="currency" required="required" id="currency" class="btn btn-secondary" v-model="currency">
                                <option value="INR">INR</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>
                        <input type="number" class="form-control" name="amount" id="amount" placeholder="Payment amount" step=".01" min="0" v-model="amount">
                    </div>
                </div>
            </div>
            <div class="form-row mt-4">
                <div class="form-group col-md-3" v-if="currency == 'INR'">
                    <label for="tds">TDS deducted</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">INR</span>
                        </div>
                        <input type="number" class="form-control" name="tds" id="tds" placeholder="TDS" step=".01" min="0" v-model="tds">
                    </div>
                </div>
                <div class="form-group col-md-3" v-if="currency != 'INR'">
                    <label for="conversion_rate">Conversion rate</label>
                    <div class="d-flex flex-column">
                        <input type="number" class="form-control" name="conversion_rate" id="conversion_rate" placeholder="conversion rate" step="0.01" min="0" v-model="conversionRate">
                        <div class="mt-3 mb-0">
                            <p class="m-0">Payment amount after conversion&nbsp;&nbsp;</p>
                            <h4 class="m-0">INR {{ convertedAmount }}</h4>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-3" v-if="currency != 'INR'">
                    <label for="bank_charges">Bank charges on fund transfer</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" v-text="currency"></span>
                        </div>
                        <input type="number" class="form-control" name="bank_charges" id="bank_charges" placeholder="amount" step=".01" min="0" v-model="bankCharges">
                    </div>
                </div>
                <div class="form-group col-md-2" v-if="currency != 'INR'">
                    <label for="bank_service_tax_forex">Bank Service Tax on Forex</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">INR</span>
                        </div>
                        <input type="number" class="form-control" name="bank_service_tax_forex" id="bank_service_tax_forex" placeholder="amount" step=".01" min="0" v-model="bankServiceTaxForex">
                    </div>
                </div>
            </div>
            <div class="form-row mt-4">
                <div class="form-group col-md-3">
                    <label for="mode">Mode</label>
                    <select name="mode" id="mode" class="form-control" v-model="mode">
                        <option value="wire-transfer">Wire Transfer</option>
                        <option value="cash">Cash</option>
                        <option value="cheque">Cheque</option>
                    </select>
                </div>
                <div class="form-group col-md-3" v-if="mode == 'cheque'">
                    <label for="cheque_status">Cheque status</label>
                    <select name="mode" id="mode" class="form-control" v-model="chequeStatus">
                        <option value="received">Received</option>
                        <option value="cleared">Cleared</option>
                        <option value="bounced">Bounced</option>
                    </select>
                </div>
                <div class="form-group col-md-3" v-if="mode == 'cheque' && chequeStatus == 'received'" v-model="chequeReceivedOn">
                    <label for="cheque_received_on">Received on</label>
                    <input type="date" name="cheque_received_on" id="cheque_received_on" class="form-control">
                </div>
                <div class="form-group col-md-3" v-if="mode == 'cheque' && chequeStatus == 'cleared'" v-model="chequeClearedOn">
                    <label for="cheque_cleared_on">Cleared on</label>
                    <input type="date" name="cheque_cleared_on" id="cheque_cleared_on" class="form-control">
                </div>
                <div class="form-group col-md-3" v-if="mode == 'cheque' && chequeStatus == 'bounced'" v-model="chequeBouncedOn">
                    <label for="cheque_bounced_on">Bounced on</label>
                    <input type="date" name="cheque_bounced_on" id="cheque_bounced_on" class="form-control">
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['isNew', 'payment', 'unpaidInvoices'],
        computed: {
            convertedAmount() {
                return this.amount * this.conversionRate;
            },
        },
        data() {
            return {
                paidAt: !this.isNew ? this.formatDate(this.payment.paid_at) : null,
                currency: !this.isNew ? this.payment.currency : this.unpaidInvoices[0].currency,
                amount: !this.isNew ? this.payment.amount : this.unpaidInvoices[0].amount,
                tds: !this.isNew ? this.payment.tds : null,
                bankCharges: !this.isNew ? this.payment.bank_charges : null,
                bankServiceTaxForex: !this.isNew ? this.payment.bank_service_tax_forex : null,
                conversionRate: !this.isNew ? this.payment.conversion_rate : null,
                mode: 'cheque',
                // chequeStatus: !this.isNew && this.payment.mode == 'cheque' ? this.payment.,
                chequeStatus: 'received',
                chequeBouncedOn: null,
                chequeClearedOn: null,
                chequeReceivedOn: null,
                invoiceId: !this.isNew ? this.payment.invoice.id : this.unpaidInvoices[0].id,
            }
        },
        methods: {
            updatePaymentFields() {
                for (var index = 0; index < this.unpaidInvoices.length; index++) {
                    let unpaidInvoice = this.unpaidInvoices[index];
                    if (unpaidInvoice.id == this.invoiceId) {
                        this.amount = unpaidInvoice.amount;
                        this.currency = unpaidInvoice.currency;
                    }
                }
            },
            formatDate(date) {
                var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day = '0' + day;

                return [year, month, day].join('-');
            },
            formatDisplayDate(date) {
                var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day = '0' + day;

                return [day, month, year].join('/');
            }
        },
        mounted() {
            if (!this.payment) {
                this.conversionRate = 65;
                this.paidAt = this.formatDate(new Date());
            }
        }
    }
</script>
