<template>
    <tr>
        <td class="form-group mt-3">
            <div class="d-flex align-items-center">
                <div for="billing" class="d-inline mr-2">{{ index+1 }}. <strong>Billing:</strong></div>
                <div class="input-group w-50">
                    <input type="number" class="form-control input-billing" v-model="billing.percentage" step="0.01" min="0" :name="billing.isNew ? 'new_billing[]' : 'billing[][' + billing.id + ']'">
                    <div class="input-group-append">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
        </td>
        <td>
            {{ currency }}&nbsp;{{ billingCostWithoutGst }}
        </td>
        <td>
            {{ currency }}&nbsp;{{ billingGstAmount }}
        </td>
        <td>
            {{ currency }}&nbsp;{{ billingCostWithGst }}
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['billing', 'index', 'stageCostWithGst', 'gstAmount', 'stageCostWithoutGst', 'currency'],
        computed: {
            billingCostWithoutGst: function() {
                return parseFloat((this.billing.percentage/100)*this.stageCostWithoutGst);
            },
            billingGstAmount: function() {
                return parseFloat((this.billing.percentage/100)*this.gstAmount);
            },
            billingCostWithGst: function() {
                return parseFloat((this.billing.percentage/100)*this.stageCostWithGst);
            }
        },
        mounted: function() {
            console.log(this.billing.percentage);
        }
    }
</script>
