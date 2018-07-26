<template>
    <div>
        <div class="card mt-4">
            <form :action="stage.id ? '/project/stages/' + stage.id : '/project/stages'" method="POST">
                <input v-if="stage.id" type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="_token" :value="csrfToken">
                <input type="hidden" name="project_id" :value="projectId">
                <div class="card-header">
                    <div v-if="stage.name" v-show="!editMode">{{ stage.name }}</div>
                    <div class="form-group w-25 mb-0" v-show="editMode">
                        <div class="d-flex align-items-center">
                            <label for="name" class="mb-0 mr-3 field-required">Name</label>
                            <input type="text" class="form-control d-inline" name="name" id="name" placeholder="Stage name" required="required" v-model="stage.name">
                        </div>
                    </div>
                    <div class="card-edit icon-pencil" @click="editMode = !editMode" v-show="!editMode"><i class="fa fa-pencil"></i></div>
                    <button type="submit" class="btn btn-primary card-edit" v-show="editMode">{{ stage.id ? 'Update' : 'Create' }}</button>
                </div>
                <div class="card-body" v-show="editMode">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="sent_amount" class="field-required">Cost</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <select name="currency_cost" id="currency_cost" class="btn btn-secondary" required="required" v-model="inputStageCurrency">
                                                <option v-for="(currency_meta, currency) in configs.currencies" :value="currency" :selected="currency == stage.currency_cost">
                                                    {{ currency }}
                                                </option>
                                            </select>
                                        </div>
                                        <input type="number" class="form-control" name="cost" id="cost" placeholder="Stage cost" step=".01" min="0"  required="required" v-model="inputStageCost">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row" v-show="clientCountryGstApplicable">
                                <div class="form-group col-md-8 d-flex align-items-center">
                                    <label for="sent_amount" class="mb-0">Stage cost include GST?&nbsp;</label>
                                    <label class="switch mb-0">
                                        <input type="checkbox" id="cost_include_gst" name="cost_include_gst" value="1" v-model="inputStageCostIncludeGst">
                                        <div class="slider secondary-slider round" @click="toggleInputStageCostIncludeGst" :class="[inputStageCostIncludeGst ? 'active' : 'inactive']" >
                                            <span class="on w-100 text-left pl-3">Yes</span>
                                            <span class="off w-100 text-right pr-3">No</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="mt-2 mb-2" v-show="clientCountryGstApplicable">
                                <h5 class="mb-2"><b>Project Total Cost:</b> <span>{{ stageCurrencySymbol }} {{ stageCostWithGst }}</span></h5>
                                <p class="mb-1"><b>GST:</b> <span>{{ stageCurrencySymbol }} {{ gstAmount }}</span></p>
                                <p class="mb-1"><b>Project's Base Cost:</b> <span>{{ stageCurrencySymbol }} {{ stageCostWithoutGst }}</span></p>
                            </div>
                            <br>
                        </div>
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="name">Type</label>
                                    <select name="type" id="type" class="form-control" required="required" v-model="stageType">
                                        <option v-for="(displayName, type) in configs.projectTypes" :value="type">
                                            {{ displayName }}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="start_date">Start date</label>
                                    <input type="date" class="form-control" name="start_date" id="start_date" placeholder="dd/mm/yy" v-model="stage.start_date">
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="end_date">End date</label>
                                    <input type="date" class="form-control" name="end_date" id="end_date" placeholder="dd/mm/yy" v-model="stage.end_date">
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>

                    <table v-if="stageBillings.length" class="table table-bordered" id="billings_table">
                        <thead class="thead-light">
                            <tr>
                                <th>Percentage</th>
                                <th v-show="!clientCountryGstApplicable">Cost</th>
                                <th v-show="clientCountryGstApplicable">Base Amount</th>
                                <th v-show="clientCountryGstApplicable">GST</th>
                                <th v-show="clientCountryGstApplicable">Total Amount</th>
                                <th>Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            <project-stage-billing-component
                            v-for="(billing, index) in stageBillings"
                            :billing="billing"
                            :stage-cost-without-gst="stageCostWithoutGst"
                            :gst-amount="gstAmount"
                            :stage-cost-with-gst="stageCostWithGst"
                            :index="index"
                            :currency="stageCurrencySymbol"
                            :client-country-gst-applicable="clientCountryGstApplicable"
                            :key="index"
                            @addBillingInvoice="addInvoice($event)">
                            </project-stage-billing-component>
                        </tbody>
                    </table>
                <button type="button" class="mt-3 btn btn-info btn-sm" v-on:click="addBilling"><i class="fa fa-plus"></i>&nbsp;Add billing</button>
                </div>
            </form>

            <div id="new_billing_invoice_modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="/finance/invoices" method="POST" enctype="multipart/form-data" id="form_new_invoice_billing">
                            <input type="hidden" name="_token" :value="csrfToken">
                            <input type="hidden" name="request_from_billing" value="1">
                            <input type="hidden" name="billings[]" id="new_invoice_billing_id" value="">
                            <div class="modal-header">
                                <h4 class="modal-title">Create invoice</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <label for="project_invoice_id" class="field-required">Invoice ID</label>
                                        <input type="text" class="form-control" name="project_invoice_id" id="project_invoice_id" placeholder="Invoice ID" required="required">
                                    </div>
                                    <div class="form-group offset-md-1 col-md-5">
                                        <label for="status" class="field-required">Status</label>
                                        <select name="status" id="status" v-model="status" class="form-control" required="required">
                                            <option v-for="(title, status) in configs.invoiceStatus" :value="status">{{ title }}</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="form-group" :class="[clientCountryGstApplicable ? 'col-md-4' : 'col-md-5']">
                                        <label for="sent_on" class="field-required">Sent on</label>
                                        <input type="date" class="form-control" name="sent_on" id="sent_on" placeholder="dd/mm/yyyy" required="required">
                                    </div>
                                    <div class="form-group" :class="[clientCountryGstApplicable ? 'col-md-4' : 'offset-md-1 col-md-5']">
                                        <label for="sent_amount" class="field-required">Invoice amount</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <select name="currency_sent_amount" id="currency_sent_amount" class="btn btn-secondary" required="required">
                                                    <option :value="inputStageCurrency">{{ inputStageCurrency }}</option>
                                                </select>
                                            </div>
                                            <input type="number" class="form-control" name="sent_amount" id="sent_amount" placeholder="Invoice Amount" required="required" step=".01" min="0">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4" v-show="clientCountryGstApplicable">
                                        <label for="gst">GST amount</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <select class="btn btn-secondary">
                                                    <option value="INR">INR</option>
                                                </select>
                                            </div>
                                            <input type="number" class="form-control" name="gst" id="gst" placeholder="GST amount" step=".01" min="0">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <label for="invoice_file" class="field-required">Upload Invoice</label>
                                        <div><input id="invoice_file" name="invoice_file" type="file" required="required"></div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="comments">Comments</label>
                                        <textarea name="comments" id="comments" rows="5" class="form-control"></textarea>
                                    </div>
                                </div>
                                <br>
                                <h4 class="my-4"><u>Payment Details</u></h4>
                                <div class="form-row">
                                    <div class="form-group" :class="[clientCountryGstApplicable ? 'col-md-4' : 'col-md-5']" v-if="isPaid">
                                        <label for="paid_on" class="field-required">Paid on</label>
                                        <input type="date" class="form-control" required="required" name="paid_on" id="paid_on" placeholder="dd/mm/yyyy">
                                    </div>
                                    <div class="form-group" :class="[clientCountryGstApplicable ? 'col-md-4' : 'offset-md-1 col-md-5']" v-if="isPaid">
                                        <label for="paid_amount" class="field-required">Received amount</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <select name="currency_paid_amount" id="currency_paid_amount" class="btn btn-secondary">
                                                    <option :value="inputStageCurrency">{{ inputStageCurrency }}</option>
                                                </select>
                                            </div>
                                            <input type="number" class="form-control" name="paid_amount" id="paid_amount" placeholder="Received Amount" step=".01" min="0" required="required">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4" v-show="clientCountryGstApplicable">
                                        <label for="tds">TDS amount</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                {{ configs.currency }}
                                                <select name="currency_tds" id="currency_tds" class="btn btn-secondary" required="required">
                                                    <option value="INR">INR</option>
                                                </select>
                                            </div>
                                            <input type="number" class="form-control" name="tds" id="tds" placeholder="TDS Amount" step=".01" min="0">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-row" v-if="isPaid">
                                    <div class="form-group col-md-4">
                                        <label for="payment_type" class="field-required">Payment type</label>
                                        <select name="payment_type" id="payment_type" class="form-control" v-model="selectedPaymentType" required="required">
                                            <option value="">Select payment type</option>
                                            <option v-for="(title, label) in configs.paymentTypes" :value="label">{{ title }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 cheque-status" v-if="selectedPaymentType == 'cheque'">
                                        <label for="cheque_status" class="field-required">Cheque status</label>
                                        <select name="cheque_status" id="cheque_status" class="form-control" v-model="selectedChequeStatus" required="required">
                                            <option value="">Select cheque status</option>
                                            <option v-for="(title, label) in configs.chequeStatus" :value="label">{{ title }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4" v-if="selectedPaymentType == 'cheque' && selectedChequeStatus == 'received'">
                                        <label for="cheque_received_date" class="field-required">Cheque Received Date</label>
                                        <input type="date" class="form-control" required="required" name="cheque_received_date" id="cheque_received_date" placeholder="dd/mm/yyyy">
                                    </div>
                                    <div class="form-group col-md-4" v-if="selectedPaymentType == 'cheque' && selectedChequeStatus == 'cleared'">
                                        <label for="cheque_cleared_date" class="field-required">Cheque Cleared Date</label>
                                        <input type="date" class="form-control" required="required" name="cheque_cleared_date" id="cheque_cleared_date" placeholder="dd/mm/yyyy">
                                    </div>
                                    <div class="form-group col-md-4" v-if="selectedPaymentType == 'cheque' && selectedChequeStatus == 'bounced'">
                                        <label for="cheque_bounced_date" class="field-required">Cheque Bounced Date</label>
                                        <input type="date" class="form-control" required="required" name="cheque_bounced_date" id="cheque_bounced_date" placeholder="dd/mm/yyyy">
                                    </div>
                                </div>
                                <br>
                            </div>
                            <div class="modal-footer">
                                <input type="submit" value="Create" class="btn btn-primary">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- modal -->

        </div>
    </div>
</template>

<script>
    import ProjectStageBillingComponent from './ProjectStageBillingComponent.vue';

    export default {
        props: ['stage', 'csrfToken', 'projectId', 'configs', 'client'],
        data() {
            return {
                editMode: Object.keys(this.stage).length ? false : true,
                inputStageCost: this.stage.hasOwnProperty('cost') ? parseFloat(this.stage.cost) : null,
                inputStageCurrency: this.stage.hasOwnProperty('currency_cost') ? this.stage.currency_cost : this.configs.countries[this.client.country].currency,
                inputStageCostIncludeGst: this.stage.hasOwnProperty('cost_include_gst') ? this.stage.cost_include_gst : false,
                stageBillings: this.stage.hasOwnProperty('billings') ? this.stage.billings : [],
                stageType: this.stage.hasOwnProperty('type') ? this.stage.type : 'fixed_budget',
                clientCountryGstApplicable: this.client.country == 'india' ? true : false,
                selectedPaymentType: '',
                selectedChequeStatus: '',
                status:'unpaid',
            }
        },
        components: {
            'project-stage-billing-component': ProjectStageBillingComponent,
        },
        computed: {
            isPaid : function(){
                return (this.status == 'paid' ? true : false);
            },
            stageCurrencySymbol : function() {
                return this.configs.currencies[this.inputStageCurrency].symbol;
            },
            stageCostWithGst: function() {
                if (this.inputStageCostIncludeGst) {
                    return this.inputStageCost === '' || this.inputStageCost == null ? parseFloat(0).toFixed(2)  : parseFloat(this.inputStageCost).toFixed(2);
                }
                return this.inputStageCost === '' || this.inputStageCost == null ? parseFloat(0).toFixed(2)  : (parseFloat(this.inputStageCost) + parseFloat(this.gstAmount)).toFixed(2);
            },
            gstAmount: function() {
                if (this.clientCountryGstApplicable) {
                    let gst = 0;
                    let configGst = parseFloat(this.configs.gst);
                    if (this.inputStageCostIncludeGst) {
                        gst = (configGst/(100 + configGst)) * this.inputStageCost;
                    } else {
                        gst = (configGst/100) * this.inputStageCost;
                    }
                    return parseFloat(gst).toFixed(2);
                }
                return 0;
            },
            stageCostWithoutGst: function() {
                if (this.inputStageCostIncludeGst) {
                    return this.inputStageCost ==='' || this.inputStageCost == null ? parseFloat(0).toFixed(2) : (this.inputStageCost - this.gstAmount).toFixed(2);
                }
                return this.inputStageCost === '' || this.inputStageCost == null ? parseFloat(0).toFixed(2) : parseFloat(this.inputStageCost).toFixed(2);
            },
        },
        methods: {
            addBilling() {
                this.stageBillings.push({
                    'percentage': null,
                    'isNew' : true
                });
            },
            addInvoice(args) {
                document.getElementById('new_invoice_billing_id').value = args.billingId;
                document.getElementById('sent_amount').value = args.invoiceAmount;
                document.getElementById('gst').value = args.gst;
            },
            toggleInputStageCostIncludeGst() {
                this.inputStageCostIncludeGst = !this.inputStageCostIncludeGst;
            }
        }
    }
</script>
