<template>
    <div>
        <div class="form-group row mt-3" v-for="(billing, index) in billings">
            <label for="billing" class="col-md-2 col-form-label">{{ index+1 }}. Percentage</label>
            <div class="col-md-4">
                <input type="text" class="form-control" :name="billing.name ? billing.name : 'billing[][' + billing.id + ']'" id="billing" placeholder="billing" :value="billing.percentage">
            </div>
        </div>
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
