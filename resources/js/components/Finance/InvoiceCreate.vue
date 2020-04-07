<template>
    <div>
        <div class="card-header">
            <span>Invoice Details</span>
        </div>
        <div class="card-body">
            <div class="form-row mb-4">
                <div class="form-group col-md-5">
                    <div>
                        <label for="client_id" class="field-required">Client</label>
                        <select  name="client_id" id="client_id" class="form-control" required="required" v-model="clientId" @change="updateClientDetails()" :disabled="this.invoice">
                            <option value="0">Select Client</option>
                            <option v-for="activeClient in clients" :value="activeClient.id" v-text="activeClient.name" :key="activeClient.id"></option>
                        </select>
                    </div>

                    <div class="mt-4" v-if="this.client.id">
                        <label for="project_id" class="field-required">Project</label>
                        <select name="project_id" @change="setProject()" id="project_id" class="form-control" required="required" v-model="projectID" >
                            <option value="0">Select project</option>
                            <option v-for="project in client.projects" :value="project.id" v-text="project.name" :key="project.id"></option>
                        </select>
                    </div>

                    <div class="mt-4" v-if="this.project.id">
                        <label for="invoice_type" class="field-required">Invoice Type</label>
                        <select name="invoice_type" @change="setInvoiceType()" id="invoice_type" class="form-control" required="required" v-model="invoiceType" >
                            <option value="" >Select invoice type</option>
                            <option value="regular" >Regular</option>
                            <option value="amc">AMC</option>
                        </select>
                    </div>

                </div>

                <div class="form-group col-md-7" v-if="this.invoiceType">
                    <div class="d-flex justify-content-end mr-5 text-muted"> 
                        F-61, Suncity, Sector - 54 <br>
                        Gurgaon, Haryana, 122003, India<br>
                        finance@coloredcow.com<br>
                        91 9818571035<br>
                        PAN : AAICC2546G<br>
                        GSTIN : 06AAICC2546G1ZT<br>
                        SAC / HSN code : 998311<br>
                        CIN No. U72900HR2019PTC081234<br>
                    </div>
                </div>
            </div>

            <div class="form-row mb-4" v-if="this.invoiceType">
                <div class="form-group col-md-12">
                    <div class="row">
                        <div class="col-5">
                            <p class="font-weight-bold">Bill To:</p>
                            <div class="text-muted">
                                <span>{{ this.billingInfo.contact_person_name }}</span><br>
                                <span>{{ this.project.name }}</span><br>
                                <span>{{ this.billingInfo.contact_person_email }}</span><br>
                                <span> {{ this.billingInfo.address }} {{ this.billingInfo.pincode }} </span><br>
                            </div>
                        </div>

                        <div class="col-7 d-flex justify-content-end ">
                            <div class="w-50">
                                <p class="font-weight-bold">Details:</p>
                                <div class="text-muted">

                                    <div class="row">
                                        <div class="col-6 font-weight-bold">Term:</div>
                                        <div class="col-6">{{ meta.month }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6 font-weight-bold">Invoice Number :</div>
                                        <div class="col-6">{{ this.client.reference_number }}-{{ this.project.client_project_id }}-{{ this.project.invoice_number }}</div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-6 font-weight-bold">Issue Date :</div>
                                        <div class="col-6">{{ meta.issue_date }}</div>
                                    </div>

                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <regular-invoice v-if="this.invoiceType == 'regular'"></regular-invoice>
            <amc-invoice v-if="this.invoiceType == 'amc'"></amc-invoice>
        </div>

    </div>
</template>
<script>

    export default {
        props: ['clients', 'invoice', 'meta'],
        data() {
            return {
                client: {},
                clientId: this.invoice ? this.invoice.client.id : 0,
                project:this.invoice ? this.invoice.project : {},
                selectedClientID:0,
                currency: this.invoice ? this.invoice.currency : this.clients[0].currency,
                projectID: this.invoice ? this.invoice.project.id : 0,
                projectBillingInfo: this.invoice ? this.invoice.project.projectBillingInfo : this.clients[0].projects[0].projectBillingInfo,
                invoiceType:''
            }
        },
        computed: { 
            billingInfo: function() {
                return this.project && this.project.billing_info ? this.project.billing_info : {};
            } 
        },

        methods: {
            updateClientDetails:function() {
                for ( var item = 0; item < this.clients.length; item++) {
                        let client = this.clients[item];
                        if (client.id == this.clientId) {
                            this.client = client;
                            this.currency = client.currency;
                            break;
                        }
                }
            },

            setProject: function() {
                for (var item = 0; item < this.client.projects.length; item++) {
                    let project = this.client.projects[item];
                    if (project.id == this.projectID) {
                        this.project = project;
                        break;
                    }
                }
            },

            setInvoiceType:function() {
            }
        },
        mounted() {
        }
    }
</script>
