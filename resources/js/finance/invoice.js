Vue.component('invoice', require('../components/Finance/Invoice.vue'));
Vue.component('invoice-create', require('../components/Finance/InvoiceCreate.vue'));

if (document.getElementById('form_invoice')) {
    const invoiceForm = new Vue({
        el: '#form_invoice',
    });
}
