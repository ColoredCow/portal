<template>
    <div>
        <div class="card-header">
            <span>Invoice Details</span>
        </div>
        <div class="card-body">
            <div class="form-row mb-4">
                <div class="form-group col-md-5">
                    <label for="client_id" class="field-required">Client</label>
                    <select  name="client_id" id="client_id" class="form-control" required="required" v-model="clientId" @change="updateClientDetails()" :disabled="this.invoice">
                        <option v-for="activeClient in clients" :value="activeClient.id" v-text="activeClient.name" :key="activeClient.id"></option>
                    </select>
                </div>
            </div>

            <div class="form-row mb-4">
                <div class="form-group col-md-5">
                    <label for="client_id" class="field-required">Project</label>
                    <select name="client_id" id="client_id" class="form-control" required="required" v-model="clientId"  :disabled="this.invoice">
                        <option v-for="activeClient in clients" :value="activeClient.id" v-text="activeClient.name" :key="activeClient.id"></option>
                    </select>
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
                project:{},
                selectedClientID:0
            }
        },
        computed: { 
        },

        methods: {
            updateClientDetails:function() {
                Object.keys()
            }
        },
        mounted() {
          
        }
    }
</script>
