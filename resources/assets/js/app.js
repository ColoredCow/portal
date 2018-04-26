
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

import 'jquery-ui/ui/widgets/datepicker.js';
import ImageCompressor from 'image-compressor.js';

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('project-stage-component', require('./components/ProjectStageComponent.vue'));
Vue.component('project-stage-billing-component', require('./components/ProjectStageBillingComponent.vue'));
Vue.component('applicant-round-action-component', require('./components/HR/ApplicantRoundActionComponent.vue'));

if (document.getElementById('page_hr_applicant_edit')) {
    const applicantEdit = new Vue({
        el: '#page_hr_applicant_edit'
    });
}

if (document.getElementById('project_container')) {
    const projectContainer = new Vue({
        el: '#project_container',
        data: {
            newStage: false
        },
        methods: {
            createProjectStage: function() {
                this.$refs.projectStage.create();
            }
        }
    });
}

if (document.getElementById('form_invoice')) {
    const invoiceForm = new Vue({
        el: '#form_invoice',
        data: {
            paymentType: document.getElementById('payment_type').dataset.paymentType || ''
        }
    });
}

$('#page_hr_applicant_edit .applicant-round-form').on('click', '.round-submit', function(){
    var form = $(this).closest('.applicant-round-form');
    form.find('[name="round_status"]').val($(this).data('status'));
    form.find('[name="next_round"]').val($(this).data('next-round'));
    form.submit();
});

$('#page_hr_applicant_edit .applicant-round-form').on('click', '.round-update', function(){
    var form = $(this).closest('.applicant-round-form');
    form.find('[name="action_type"]').val('update');
    form.submit();
});

$('.date-field').datepicker({
    dateFormat: "dd/mm/yy"
});

$(document).ready(() => {
    if ($('.form-create-invoice').length) {
        let form = $('.form-create-invoice');
        let client_id = form.find('#client_id').val();
        if (client_id) {
            updateClientProjects(form, client_id);
        }
    }

    $('#submit_book_form_btn').on('click', submitBookForm);

    $('#show_book').on('click', '#save_book_to_records', function() {
        saveBookToRecords();
    });
<<<<<<< HEAD

=======
    
>>>>>>> 91b5c318e614ea3be66a043938c8f3eff4247a48
});

$('#form_invoice').on('change', '#client_id', function(){
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

$('.status-close').on('click', function(){
    let wrapper = $(this).closest('.alert');
    wrapper.fadeOut(500);
});

tinymce.init({
    selector: '.richeditor',
    skin: 'lightgray',
    plugins: [ 'lists autolink link' ],
    menubar: false,
    statusbar: false,
    entity_encoding: 'raw',
    forced_root_block : "",
    force_br_newlines : true,
    force_p_newlines : false,
    height : "280"
});

$('.hr_round_guide').on('click', '.edit-guide', function(){
    let container = $(this).closest('.hr_round_guide');
    container.find('.btn-guide, .guide-container').toggleClass('d-none');
});

$('.hr_round_guide').on('click', '.save-guide', function(){
    let container = $(this).closest('.hr_round_guide');
    let form = container.find('form');
    let button = $(this);
    $.ajax({
        method: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize() + '&guidelines=' + tinyMCE.activeEditor.getContent(),
        beforeSend: function () {
            button.prop('disabled', true).find('.item').toggleClass('d-none');
        },
        success: function (res) {
            button.prop('disabled', false).find('.item').toggleClass('d-none');
            if (res.length) {
                container.find('.guide-display').html(res);
                container.find('.btn-guide, .guide-container').toggleClass('d-none');
            }
        },
    });
});

//coloredcow

var compressedFile  = null;
var bookData = null;

if (document.getElementById('book_form')) {
    const bookForm = new Vue({
        el: '#book_form',
        data: {
            addMethod: 'from_image'
        }
    });

document.getElementById('book_image').addEventListener('change', (e) => {
    let file = e.target.files[0];
    if (!file) { return; }
    compressedFile =  null;
    let image  = new ImageCompressor(file, {quality: .1, success: function(result) {
        compressedFile = result;
    }});
  });


}



function submitBookForm() {
    let formData = new FormData(document.getElementById('book_form'));

    if(compressedFile) {
        formData.append('book_image', compressedFile, compressedFile.name);
    }
    $('#show_book').html('');
    bookData = null;
    axios.post('/knowledgecafe/library/book/fetchinfo', formData).then((response) => {
       let data = response.data;

       if(!data) {
           alert("Error:Please try again");
       }

       if(data.error) {
           alert(data.message);
           return;
       }
       bookData = data.book;
       $('#show_book').html(data.view);
       $('#add_book').hide();
       $('#show_book').show();
    });
}

function saveBookToRecords() {
    if(!bookData) {
        alert("Error in saving records");
    }

    axios.post('/knowledgecafe/library/books', bookData).then((response) => {
       
    });
}
