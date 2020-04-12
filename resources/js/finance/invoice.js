Vue.component('invoice', require('../components/Finance/Invoice.vue').invoice);

if (document.getElementById('form_invoice')) {
    const invoiceForm = new Vue({
        el: '#form_invoice',
    });
}
