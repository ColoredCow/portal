<template>
    <div>
        <div class="card mt-4">
            <form :action="stage.id ? '/project/stages/' + stage.id : '/project/stages'" method="POST">
                <input v-if="stage.id" type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="_token" :value="csrfToken">
                <input type="hidden" name="project_id" :value="projectId">
                <div class="card-header">
                    <div v-if="stage.name" v-show="!editMode">{{ stage.name }}</div>
                    <div class="form-group w-25p mb-0" v-show="editMode">
                        <div class="d-flex align-items-center">
                            <label for="name" class="mb-0 mr-3 field-required">Name</label>
                            <input type="text" class="form-control d-inline" name="name" id="name" placeholder="Stage name" required="required" v-model="stage.name">
                        </div>
                    </div>
                    <div class="card-edit icon-pencil" @click="editMode = !editMode" v-show="!editMode"><i class="fa fa-pencil"></i></div>
                    <button class="btn btn-primary card-edit" type="submit" v-show="editMode">{{ stage.id ? 'Update' : 'Create' }}</button>
                </div>
                <div class="card-body" v-show="editMode">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="cost" class="field-required">Cost</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" v-text="client.currency"></span>
                                        </div>
                                        <input type="hidden" name="currency" :value="client.currency">
                                        <input type="number" class="form-control" name="cost" id="cost" placeholder="Stage cost" step=".01" min="0"  required="required" v-model="inputStageCost">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row" v-if="clientCountryGstApplicable">
                                <div class="form-group col-md-8 d-flex align-items-center">
                                    <label for="cost_include_gst" class="mb-0">Stage cost include GST?&nbsp;</label>
                                    <label class="switch mb-0">
                                        <input type="checkbox" id="cost_include_gst" name="cost_include_gst" value="1" v-model="inputStageCostIncludeGst">
                                        <div class="slider secondary-slider round" @click="toggleInputStageCostIncludeGst" :class="[inputStageCostIncludeGst ? 'active' : 'inactive']" >
                                            <span class="on w-full text-left pl-3">Yes</span>
                                            <span class="off w-full text-right pr-3">No</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="mt-2 mb-2" v-if="clientCountryGstApplicable">
                                <h5 class="mb-2"><b>Project Total Cost:</b> <span>{{ stageCurrencySymbol }} {{ stageCostWithGst }}</span></h5>
                                <p class="mb-1"><b>GST:</b> <span>{{ stageCurrencySymbol }} {{ gstAmount }}</span></p>
                                <p class="mb-1"><b>Project's Base Cost:</b> <span>{{ stageCurrencySymbol }} {{ stageCostWithoutGst }}</span></p>
                            </div>
                            <br>
                        </div>
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="name" class="field-required">Type</label>
                                    <select name="type" id="type" class="form-control" required="required" v-model="stageType">
                                        <option v-for="(displayName, type) in configs.projectTypes" :value="type" :key="type">
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
                                <th>#</th>
                                <th>Percentage</th>
                                <th v-if="!clientCountryGstApplicable">Cost</th>
                                <th v-if="clientCountryGstApplicable">Base Amount</th>
                                <th v-if="clientCountryGstApplicable">GST</th>
                                <th v-if="clientCountryGstApplicable">Total Amount</th>
                                <th>Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            <project-stage-billing-component
                            v-for="(billing, index) in stageBillings"
                            :stage="stage"
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
                    <button type="button" class="mt-3 btn btn-info btn-sm px-3" v-on:click="addBilling"><i class="fa fa-plus"></i>&nbsp;Add Billing</button>
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
                                        <label for="sent_on" class="field-required">Sent on</label>
                                        <input type="date" class="form-control" name="sent_on" id="sent_on" placeholder="dd/mm/yyyy" required="required" v-model="sentOn">
                                    </div>
                                    <div class="form-group col-md-offset-1 col-md-5">
                                        <label for="project_invoice_id" class="field-required">Invoice ID</label>
                                        <input type="text" class="form-control" name="project_invoice_id" id="project_invoice_id" placeholder="Invoice ID" required="required">
                                    </div>
                                </div>
                                <div class="form-row mt-4">
                                    <div class="form-group col-md-5">
                                        <label for="amount" class="field-required">Amount</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" v-text="inputStageCurrency"></span>
                                            </div>
                                            <input type="hidden" name="currency" id="currency" :value="inputStageCurrency">
                                            <input type="number" class="form-control" name="amount" id="amount" placeholder="Invoice Amount" required="required" step=".01" min="0">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-offset-1 col-md-5" v-if="clientCountryGstApplicable">
                                        <label for="gst">GST</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">INR</span>
                                            </div>
                                            <input type="number" class="form-control" name="gst" id="gst" placeholder="GST" step=".01" min="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row mt-4">
                                    <div class="form-group col-md-5">
                                        <label for="invoice_file" class="field-required">Upload Invoice</label>
                                        <div><input id="invoice_file" name="invoice_file" type="file" required="required"></div>
                                    </div>
                                    <div class="form-group col-md-offset-1 col-md-5">
                                        <label for="due_on">Due date</label>
                                        <input type="date" name="due_on" required="required" class="form-control" v-model="dueOn">
                                    </div>
                                </div>
                                <div class="form-row mt-4">
                                    <div class="form-group col-md-12">
                                        <label for="comments">Comments</label>
                                        <textarea name="comments" id="comments" rows="5" class="form-control"></textarea>
                                    </div>
                                </div>
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
import ProjectStageBillingComponent from "./ProjectStageBillingComponent.vue";

export default {
	props: ["stage", "csrfToken", "projectId", "configs", "client", "stageRoute"],
	data() {
		return {
			editMode: Object.keys(this.stage).length ? false : true,
			inputStageCost: this.stage.hasOwnProperty("cost") ? parseFloat(this.stage.cost) : null,
			inputStageCurrency: this.stage.hasOwnProperty("currency_cost") ? this.stage.currency_cost : this.configs.countries[this.client.country].currency,
			inputStageCostIncludeGst: this.stage.hasOwnProperty("cost_include_gst") ? this.stage.cost_include_gst : false,
			stageBillings: this.stage.hasOwnProperty("billings") ? this.stage.billings : [],
			stageType: this.stage.hasOwnProperty("type") ? this.stage.type : "fixed_budget",
			clientCountryGstApplicable: this.client.country == "india" ? true : false,
			selectedPaymentType: "",
			selectedChequeStatus: "",
			status: "unpaid",
			sentOn: this.formatDate(new Date()),
		};
	},
	components: {
		"project-stage-billing-component": ProjectStageBillingComponent,
	},
	computed: {
		dueOn() {
			let sentOn = new Date(this.sentOn);
			sentOn.setDate(sentOn.getDate() + 10);
			return this.formatDate(sentOn);
		},
		stageCurrencySymbol : function() {
			return this.configs.currencies[this.inputStageCurrency].symbol;
		},
		stageCostWithGst: function() {
			if (this.inputStageCostIncludeGst) {
				return this.inputStageCost === "" || this.inputStageCost == null ? parseFloat(0).toFixed(2)  : parseFloat(this.inputStageCost).toFixed(2);
			}
			return this.inputStageCost === "" || this.inputStageCost == null ? parseFloat(0).toFixed(2)  : (parseFloat(this.inputStageCost) + parseFloat(this.gstAmount)).toFixed(2);
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
				return this.inputStageCost ==="" || this.inputStageCost == null ? parseFloat(0).toFixed(2) : (this.inputStageCost - this.gstAmount).toFixed(2);
			}
			return this.inputStageCost === "" || this.inputStageCost == null ? parseFloat(0).toFixed(2) : parseFloat(this.inputStageCost).toFixed(2);
		},
	},
	methods: {
		async storeStages() {
			let newBillings = [];
			let billings = [];
			for (let index in this.stageBillings) {
				let billing = this.stageBillings[index];
				if (billing.isNew) {
					newBillings.push(billing.percentage);
				} else {
					billings.push({[billing.id] : billing.percentage});
				}
			}
			let formData = ({
				name: this.stage.name,
				cost: this.inputStageCost,
				currency_cost: this.inputStageCurrency,
				cost_include_gst: this.inputStageCostIncludeGst,
				start_date: this.stage.start_date,
				end_date: this.stage.end_date,
				type: this.stageType,
				project_id: this.projectId,
				billing: billings,
				new_billing: newBillings,
			});

			let methodName = "post";
			let url = this.stageRoute;

			if(this.stage.id){
				methodName = "put";
				url = this.stageRoute +"/" + this.stage.id;
			};

			let response = await axios({method: methodName, url: url, data:formData});
			alert(response.data.status);
		},
		addBilling() {
			this.stageBillings.push({
				"percentage": null,
				"isNew" : true
			});
		},
		addInvoice(args) {
			document.getElementById("new_invoice_billing_id").value = args.billingId;
			document.getElementById("amount").value = args.invoiceAmount;
			if (document.getElementById("gst")) {
				document.getElementById("gst").value = args.gst;
			}
		},
		formatDate(date) {
			var d = new Date(date),
				month = (d.getMonth() + 1).toString(),
				day = d.getDate().toString(),
				year = d.getFullYear();

			if (month.length < 2) {
				month = "0" + month;
			}
			if (day.length < 2) {
				day = "0" + day;
			}
			return [year, month, day].join("-");
		},
		toggleInputStageCostIncludeGst() {
			this.inputStageCostIncludeGst = !this.inputStageCostIncludeGst;
		}
	}
};
</script>
