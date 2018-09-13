<template>
    <div>
        <div class="card-header">
            <span>Invoice Details</span>
        </div>
        <div class="card-body">
            <div class="form-row mb-4">
                <div class="form-group col-md-5">
                    <label for="client_id" class="field-required">Client</label>
                    <select name="client_id" id="client_id" class="form-control" required="required" v-model="clientId" @change="updateClientDetails()" :disabled="this.invoice">
                        <option v-for="activeClient in clients" :value="activeClient.id" v-text="activeClient.name"></option>
                    </select>
                </div>
            </div>

            <div v-for="(billing, index) in billings">
                <invoice-project-component :client="client" :billing="billing" v-bind:key="index" v-on:remove="removeProject(index)">
                </invoice-project-component>
            </div>
            <button type="button" class="btn btn-info btn-sm mb-4" v-on:click="addProject">Add Project</button>

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
                    <label for="due_on" class="field-required">Due date</label>
                    <input type="date" class="form-control" name="due_on" id="due_on" v-model="dueOn" required="required">
                </div>
            </div>
            <div class="form-row mb-4">
                <div class="form-group col-md-5" v-if="file">
                    <label class="font-weight-bold">Invoice File</label>
                    <div>
                        <a target="_blank" :href="'/finance/invoices/download/' + file"><i class="fa fa-file fa-3x text-primary btn-file"></i></a>
                    </div>
                </div>
                <div class="form-group col-md-5" v-else>
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
        data() {
            return {
                client: this.clients[0],
                clientId: this.invoice ? this.invoice.client.id : this.clients[0].id,
                projectInvoiceId: this.invoice ? this.invoice.project_invoice_id : null,
                sentOn: this.invoice ? this.getDateFromTimestamp(this.invoice.sent_on) : null,
                amount: this.invoice ? this.invoice.amount : null,
                gst: this.invoice ? this.invoice.gst : null,
                comments: this.invoice ? this.invoice.comments : null,
                invoiceFile: null,
                dueOn: this.invoice ? this.getDateFromTimestamp(this.invoice.due_on) : null,
                billings: this.invoice ? this.invoice.project_stage_billings : [],
                file: this.invoice ? this.invoice.file_path : null,
                currency: this.invoice ? this.invoice.currency : this.clients[0].currency,
            }
        },
        methods: {
            updateClientDetails() {
                for (var item = 0; item < this.clients.length; item++) {
                    let client = this.clients[item];
                    if (client.id == this.clientId) {
                        this.client = client;
                        this.currency = client.currency;
                        break;
                    }
                }
            },
            getDateFromTimestamp(timestamp) {
                var d = new Date(timestamp),
                month = (d.getMonth() + 1).toString(),
                day = d.getDate().toString(),
                year = d.getFullYear();

                if (month.length < 2) {
                    month = '0' + month;
                }
                if (day.length < 2) {
                    day = '0' + day;
                }
                return [year, month, day].join('-');
            },
            addProject() {
                this.billings.push({});
            },
            removeProject(index) {
                this.billings.splice(index, 1);
            }
        },
        mounted() {
            this.updateClientDetails();
        }
    }
</script>
