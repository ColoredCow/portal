
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

import 'jquery-ui/ui/widgets/datepicker.js';

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app'
});

$('#page-hr-applicant-edit .applicant-round-form').on('click', '.round-submit', function(){
	var form = $(this).closest('.applicant-round-form');
	form.find('[name="round_status"]').val($(this).data('status'));
	form.submit();
});

// $('#form_project').find('#started_on').datepicker();
$('.date-field').datepicker({
	dateFormat: "dd/mm/yy"
});
