Vue.component('invoice', require('../components/Finance/Invoice.vue'));

if (document.getElementById('form_invoice')) {
    const invoiceForm = new Vue({
        el: '#form_invoice',
        data: {
            // paymentType: document.getElementById('payment_mode').dataset.paymentType || '',
            // chequeStatus: document.getElementById('cheque_status') ? document.getElementById('cheque_status').dataset.chequeStatus : null,
            // selectedClient: '',
            // status: document.getElementById('status').dataset.invoicePayments > 0 ? 'paid' : 'unpaid',
            // activeClient: document.getElementById('client_id').dataset.activeClient ? JSON.parse(document.getElementById('client_id').dataset.activeClient) : [],
            // paymentCurrency: document.getElementById('payment_currency').dataset.paymentCurrency || 'INR',
            // paidAmount: document.getElementById('payment_amount').dataset.paidAmount || '',
            // sentAmount: document.getElementById('invoice_amount').dataset.sentAmount || '',
            // invoiceCurrency: document.getElementById('invoice_currency').dataset.invoiceCurrency || '',
            // conversionRate: document.getElementById('conversion_rate') ? document.getElementById('conversion_rate').dataset.conversionRate : '',
            // countries: document.getElementById('client_id').dataset.countries || [],
            // tdsAmount: document.getElementById('tds').dataset.tds || '',
            // transactionCharge: document.getElementById('bank_charges') ? document.getElementById('bank_charges').dataset.transactionCharge : '',
            // newPayment: false,
        },
        computed: {
            // suggestedDueAmount: function() {
            //     let dueAmount = document.getElementById('due_amount').dataset.dueAmount;
            //     if (dueAmount) {
            //         return dueAmount;
            //     }
            //     return this.sentAmount - this.paidAmount - this.tdsAmount - this.transactionCharge;
            // },
            // currencyTransactionCharge: function() {
                // return document.getElementById('currency_transaction_charge').dataset.currencyTransactionCharge || this.paymentCurrency || 'USD';
            // },
            // currencyDueAmount: function() {
                // return document.getElementById('currency_due_amount').dataset.currencyDueAmount || this.paymentCurrency || 'USD';
            // }
        },
        mounted() {
            // console.log(this.paymentType);
            // console.log(this.paymentCurrency);
            // console.log(document.getElementById('status').dataset.invoicePayments);
        },
        methods : {
            // updateActiveClient: function() {
            //     let clients = JSON.parse(document.getElementById('client_id').dataset.clients);
            //     let selected = this.selectedClient;
            //     for (var index = 0; index < clients.length; index++) {
            //         let client = clients[index];
            //         if (client.id == this.selectedClient) {
            //             this.activeClient = client;
            //             this.paymentCurrency = JSON.parse(this.countries)[client.country].currency;
            //             break;
            //         }
            //     }
            // },
        }
    });
}
