<template>
    <tr>
        <td class="form-group mt-3">
            <div class="d-flex align-items-center">
                <div for="billing" class="d-inline mr-2">{{ index+1 }}. <strong>Billing:</strong></div>
                <div class="input-group w-50">
                    <input type="number" class="form-control input-billing" v-model="billing.percentage" step="0.01" min="0" :name="billing.isNew ? 'new_billing[]' : 'billing[][' + billing.id + ']'" :disabled="billing.finance_invoice_id">
                    <div class="input-group-append">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
        </td>
        <td>
            {{ currency }}&nbsp;{{ billingCostWithoutGst }}
        </td>
        <td v-show="clientCountryGstApplicable">
            {{ currency }}&nbsp;{{ billingGstAmount }}
        </td>
        <td v-show="clientCountryGstApplicable">
            {{ currency }}&nbsp;{{ billingCostWithGst }}
        </td>
        <td v-if="billing.finance_invoice_id">
            <a target="_blank" :href="'/finance/invoices/download/' + billing.invoice.file_path">
                <i class="fa fa-file fa-2x text-primary btn-file"></i>
            </a>
            <a :href="'/finance/invoices/' + billing.invoice.id + '/edit'" target="_blank" class="ml-2">More details</a>
        </td>
        <td v-else>
            <span class="modal-toggler-text text-primary" data-toggle="modal" data-target="#new_billing_invoice_modal" @click="addNewInvoice">Create invoice</span>
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['billing', 'index', 'stageCostWithGst', 'gstAmount', 'stageCostWithoutGst', 'currency', 'clientCountryGstApplicable'],
        computed: {
            billingCostWithoutGst: function() {
                return this.stageCostWithoutGst  == 0 ?parseFloat(0).toFixed(2) : parseFloat((this.billing.percentage/100)*this.stageCostWithoutGst).toFixed(2);
            },
            billingGstAmount: function() {
                return parseFloat((this.billing.percentage/100)*this.gstAmount).toFixed(2);
            },
            billingCostWithGst: function() {
                return this.stageCostWithGst == 0 ? parseFloat(0).toFixed(2): parseFloat((this.billing.percentage/100)*this.stageCostWithGst).toFixed(2);
            }
        },
        methods: {
            addNewInvoice() {
                let args = {
                    'billingId' : this.billing.id,
                    'invoiceAmount' : this.clientCountryGstApplicable ? this.billingCostWithGst : this.billingCostWithoutGst,
                    'gst' : this.billingGstAmount,
                };
                this.$emit('addBillingInvoice', args);
            }
        }
    }
</script>
