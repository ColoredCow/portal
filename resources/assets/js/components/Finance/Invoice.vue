<template>
    <div>
        <div class="card-header">
            <span>Invoice Details</span>
        </div>
        <div class="card-body">
            <div class="form-row mb-4">
                <div class="form-group col-md-5">
                    <label for="client_id" class="field-required">Client</label>
                    <select name="client_id" id="client_id" class="form-control" required="required" v-model="clientId">
                        <option v-for="activeClient in clients" :value="activeClient.id" v-text="activeClient.name"></option>
                    </select>
                </div>
            </div>
            <invoice-project-component
                :client="client">
            </invoice-project-component>
            <div class="form-row mb-4">
                <div class="form-group col-md-2">
                    <label for="project_invoice_id" class="field-required">Invoice ID</label>
                    <input type="text" class="form-control" name="project_invoice_id" id="project_invoice_id" placeholder="Invoice ID" required="required" v-model="projectInvoiceId">
                </div>
                <div class="form-group col-md-3">
                    <label for="sent_on" class="field-required">Sent on</label>
                    <input type="date" class="form-control" name="sent_on" id="sent_on" required="required" v-model="sentOn">
                </div>
                <div class="form-group offset-md-1 col-md-3">
                    <label for="amount" class="field-required">Amount</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <select name="currency" id="currency" class="btn btn-secondary" required="required" v-model="currency">
                                <option value="INR">INR</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>
                        <input type="number" class="form-control" name="amount" id="amount" placeholder="Invoice Amount" required="required" step=".01" min="0" v-model="amount">
                    </div>
                </div>
                <div class="form-group col-md-2" v-if="currency == 'INR'">
                    <label for="gst">GST</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">INR</span>
                        </div>
                        <input type="number" class="form-control" name="gst" id="gst" placeholder="GST" step=".01" min="0" v-model="gst">
                    </div>
                </div>
            </div>
            <div class="form-row mb-4">
                <div class="form-group col-md-3">
                    <label for="due_on">Due date</label>
                    <input type="date" class="form-control" name="due_on" id="due_on" v-model="dueOn">
                </div>
            </div>
            <div class="form-row mb-4">
                <div class="form-group col-md-5">
                    <label for="invoice_file" class="field-required">Upload Invoice</label>
                    <div><input id="invoice_file" name="invoice_file" type="file" required="required"></div>
                </div>
            </div>
            <div class="form-row mb-4">
                <div class="form-group col-md-5">
                    <label for="comments">Comments</label>
                    <textarea name="comments" id="comments" rows="5" class="form-control" v-model="comments"></textarea>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import InvoiceProjectComponent from '../InvoiceProjectComponent.vue';
    export default {
        props: ['clients', 'invoice'],
        components: {
            'invoice-project-component': InvoiceProjectComponent
        },
        computed: {
            client() {
                for (var item = 0; item < this.clients.length; item++) {
                    let client = this.clients[item];
                    if (client.id == this.clientId) {
                        return client;
                    }
                }
            },
            currency() {
                return this.invoice ? this.invoice.currency : this.client.currency
            }
        },
        data() {
            return {
                clientId: this.clients[0].id,
                billingId: 'billing-1',
                projectInvoiceId: this.invoice ? this.invoice.project_invoice_id : null,
                sentOn: this.invoice ? this.invoice.sent_on : null,
                amount: this.invoice ? this.invoice.amount : null,
                gst: this.invoice ? this.invoice.gst : null,
                comments: this.invoice ? this.invoice.comments : null,
                invoiceFile: null,
                dueOn: this.invoice ? this.invoice.due_on : null,
            }
        },
        mounted() {
            console.log(this.client);
            console.log(this.currency);
        }
    }
</script>
