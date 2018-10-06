Vue.component('payment', require('../components/Finance/Payment.vue'));

if (document.getElementById('form_payment')) {
    const projectContainer = new Vue({
        el: '#form_payment',
    });
}
