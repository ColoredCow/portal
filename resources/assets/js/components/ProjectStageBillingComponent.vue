<template>
    <div>
        <div class="form-group row mt-3" v-for="(billing, index) in billings">
            <label for="billing" class="col-md-2 col-form-label">{{ index+1 }}. <strong>Billing%</strong></label>
            <div class="col-md-4">
                <input type="text" class="form-control" :name="billing.name ? billing.name : 'billing[][' + billing.id + ']'" id="billing" placeholder="percentage" :value="billing.percentage">
            </div>
        </div>
        <button type="button" class="btn btn-info btn-sm" v-on:click="addBilling">Add billing</button>
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
