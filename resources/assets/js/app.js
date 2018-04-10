
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
Vue.component('project-stage-create-component', require('./components/ProjectStageCreateComponent.vue'));
Vue.component('project-stage-billing-component', require('./components/ProjectStageBillingComponent.vue'));

const app = new Vue({
    el: '#app',
    methods: {
        createProjectStage: function() {
            this.$refs.projectStageCreate.create();
        }
    }
});

$('#page-hr-applicant-edit .applicant-round-form').on('click', '.round-submit', function(){
    var form = $(this).closest('.applicant-round-form');
    form.find('[name="round_status"]').val($(this).data('status'));
    form.submit();
});

$('.date-field').datepicker({
    dateFormat: "dd/mm/yy"
});

$(document).ready(() => {
    if ($('#form_create_invoice').length) {
        let form = $('#form_create_invoice');
        let client_id = form.find('#client_id').val();
        if (client_id) {
            updateClientProjects(form, client_id);
        }
    }
});

$('#form_create_invoice, #form_edit_invoice').on('change', '#client_id', function(){
    let form = $(this).closest('form');
    let client_id = $(this).val();
    if (! client_id) {
        form.find('#project_ids').html('');
        return false;
    }
    updateClientProjects(form, client_id);
});

function updateClientProjects(form, client_id) {
    $.ajax({
        url : '/clients/' + client_id + '/get-projects',
        method : 'GET',
        success : function (res) {
            form.find('#project_ids').html(getProjectList(res));
        },
        error : function (err) {
            console.log(err);
        }
    });
}

function getProjectList(projects) {
    let html = '';
    for (var index = 0; index < projects.length; index++) {
        let project = projects[index];
        html += '<option value="' + project.id + '">';
        html += project.name;
        html += '</option>';
    }
    return html;
}

$('#copy_weeklydose_service_url').tooltip({
  trigger: 'click',
  placement: 'bottom'
});
function setTooltip(btn, message) {
	$(btn).tooltip('hide')
		.attr('data-original-title', message)
    	.tooltip('show');
}
function hideTooltip(btn) {
	setTimeout(function() {
		$(btn).tooltip('hide');
	}, 1000);
}

var weeklyDoseClipboard = new ClipboardJS('#copy_weeklydose_service_url');
weeklyDoseClipboard.on('success', function(e) {
  setTooltip(e.trigger, 'Copied!');
  hideTooltip(e.trigger);
});
