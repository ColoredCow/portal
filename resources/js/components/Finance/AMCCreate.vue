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
                            <option v-for="activeClient in clients" :value="activeClient.id" v-text="activeClient.name" :key="activeClient.id"></option>
                        </select>
                    </div>

                    <div class="mt-4">
                        <label for="project_id" class="field-required">Project</label>
                        <select name="project_id" @change="setProject()" id="project_id" class="form-control" required="required" v-model="projectID"  :disabled="this.invoice">
                            <option v-for="project in client.projects" :value="project.id" v-text="project.name" :key="project.id"></option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-row mb-4">
                <div class="form-group col-md-5">
                    <div>
                        <label for="payment_cycle" class="field-required">Started at:</label>
                        <input type="date" name="started_at" id="started_at" placeholder="dd/mm/yyyy" class="form-control" value="">
                    </div>
                </div>
            </div>

            <div class="form-row mb-4">
                <div class="form-group col-md-5">
                    <div>
                        <label for="payment_cycle" class="field-required">Payment cycle</label>
                        <select  name="payment_cycle" id="payment_cycle" class="form-control" required="required" >
                            <option value="quarterly" selected>Quarterly</option>
                            <option value="yearly">Yearly</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-row mb-4">
                <div class="form-group col-md-3">
                    <div>
                        <label for="per_hour_charges" class="field-required">Per hour charges</label>
                        <input name="per_hour_charges" id="per_hour_charges" type="number" value="1000" class="form-control w-50" required="required">
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <div>
                        <label for="alloted_hours" class="field-required">Alloted hours</label>
                        <input name="alloted_hours" id="alloted_hours" type="number" value="0" class="form-control w-25" required="required">
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <div>
                        <label for="extra_hours">Extra hours (discounted)</label>
                        <input name="extra_hours" id="extra_hours" type="number" value="0" class="form-control w-25">
                    </div>
                </div>
                
            </div>


            <div class="form-row mb-4">
                <div class="form-group col-md-5">
                    <div>
                        <label for="effort_sheet_link" class="field-required">Effort sheet link:</label>
                        <input type="link" name="effort_sheet_link" id="effort_sheet_link"  class="form-control" value="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    export default {
        props: ['clients', 'invoice'],
        data() {
            return {
                client: this.clients[0],
                clientId: this.invoice ? this.invoice.client.id : this.clients[0].id,
                project:this.invoice ? this.invoice.project : this.clients[0].projects[0],
                selectedClientID:0,
                currency: this.invoice ? this.invoice.currency : this.clients[0].currency,
                projectID: this.invoice ? this.invoice.project.id : this.clients[0].projects[0].id,
                projectBillingInfo: this.invoice ? this.invoice.project.projectBillingInfo : this.clients[0].projects[0].projectBillingInfo,
            }
        },
        computed: { 
            billingInfo: function() {
                return this.project && this.project.billing_info ? this.project.billing_info : {};
            } 
        },

        methods: {
            updateClientDetails:function() {
                for (var item = 0; item < this.clients.length; item++) {
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
            }
        },
        mounted() {
          
        }
    }
</script>
