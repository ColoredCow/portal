<template>
    <div>
        <div class="form-group row mt-3" v-for="(billing, index) in billings">
            <div class="col-md-4">
                <div class="d-flex align-items-center">
                    <div for="billing" class="d-inline w-25">{{ index+1 }}. <strong>Billing:</strong></div>
                    <div class="input-group w-50">
                        <input type="number" class="form-control input-billing" :name="billing.name ? billing.name : 'billing[][' + billing.id + ']'" :value="billing.percentage" step="0.01" min="0">
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="mt-3 btn btn-info btn-sm" v-on:click="addBilling"><i class="fa fa-plus"></i>&nbsp;Add billing</button>
    </div>
</template>

<script>
    export default {
        props: ['stageBillings'],
        data() {
            return {
                billings: this.stageBillings ? this.stageBillings : [],
            }
        },
        methods: {
            addBilling() {
                this.billings.push({
                    percentage: '',
                    name: 'new_billing[]'
                });
            }
        },
        mounted() {

        },
    }
</script>
