
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

Vue.component('project-stage-component', require('./components/ProjectStageComponent.vue'));
Vue.component('project-stage-billing-component', require('./components/ProjectStageBillingComponent.vue'));
Vue.component('invoice-project-component', require('./components/InvoiceProjectComponent.vue'));
Vue.component('applicant-round-action-component', require('./components/HR/ApplicantRoundActionComponent.vue'));

if (document.getElementById('page_hr_applicant_edit')) {

    const applicantEdit = new Vue({
        el: '#page_hr_applicant_edit',
        data: {
            showResumeFrame: false,
            showEvaluationFrame: false,
            applicationJobRounds: JSON.parse(document.getElementById('action_type').dataset.applicationJobRounds) || {},
            selectedNextRound: '',
            nextRoundName: '',
            selectedAction: '',
            nextRound: '',
            createCalendarEvent: true,
        },
        methods: {
            toggleResumeFrame: function() {
                this.showResumeFrame = !this.showResumeFrame;
            },
            toggleEvaluationFrame: function() {
                this.showEvaluationFrame = !this.showEvaluationFrame;
            },
            getApplicationEvaluation: function(applicationRoundID) {
                if(!this.showEvaluationFrame) {
                    axios.get('/hr/applications/evaluation/' + applicationRoundID).then(function(response) {
                        $('#page_hr_applicant_edit #application_evaluation_body').html(response.data);
                    }).catch(function (error) {
                        alert('Error fetching applicaiton evaluation!');
                    });
                }
                this.toggleEvaluationFrame();
            },
            takeAction: function() {
                switch (this.selectedAction) {
                    case 'round':
                        let selectedRound = document.querySelector('#action_type option:checked');
                        this.selectedNextRound = selectedRound.dataset.nextRoundId;
                        this.nextRoundName = selectedRound.innerText;
                        $('#round_confirm').modal('show');
                        break;
                    case 'send-for-approval':
                        $('#send_for_approval').modal('show');
                        break;
                    case 'approve':
                        $('#onboard_applicant').modal('show');
                }
            }
        },
        mounted() {
            this.selectedNextRound = this.applicationJobRounds[0].id;
            this.selectedAction = 'round';
            this.nextRoundName = this.applicationJobRounds[0].name;
        }
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
            paymentType: document.getElementById('payment_type').dataset.paymentType || '',
            chequeStatus: document.getElementById('cheque_status').dataset.chequeStatus || null,
            selectedClient: '',
            activeClient: document.getElementById('client_id').dataset.activeClient ? JSON.parse(document.getElementById('client_id').dataset.activeClient) : [],
            activeClientCurrency: document.getElementById('currency_paid_amount').dataset.paidAmountCurrency || 'INR',
            paidAmount: document.getElementById('paid_amount').dataset.paidAmount || '',
            sentAmount: document.getElementById('sent_amount').dataset.sentAmount || '',
            conversionRate: document.getElementById('conversion_rate').dataset.conversionRate || '',
            status: document.getElementById('status').dataset.status || '',
            countries: document.getElementById('client_id').dataset.countries || [],
            tdsAmount: document.getElementById('tds').dataset.tds || '',
            transactionCharge: document.getElementById('transaction_charge').dataset.tds || '',
        },
        computed: {
            convertedAmount: function() {
                return (this.paidAmount * this.conversionRate).toFixed(2);
            },
            suggestedDueAmount: function() {
                let dueAmount = document.getElementById('due_amount').dataset.dueAmount;
                if (dueAmount) {
                    return dueAmount;
                }
                return this.sentAmount - this.paidAmount - this.tdsAmount - this.transactionCharge;
            },
            currencyTransactionCharge: function() {
                return document.getElementById('currency_transaction_charge').dataset.currencyTransactionCharge || this.activeClientCurrency || 'USD';
            },
            currencyDueAmount: function() {
                return document.getElementById('currency_due_amount').dataset.currencyDueAmount || this.activeClientCurrency || 'USD';
            }
        },
        methods : {
            updateActiveClient: function() {
                let clients = JSON.parse(document.getElementById('client_id').dataset.clients);
                let selected = this.selectedClient;
                for (var index = 0; index < clients.length; index++) {
                    let client = clients[index];
                    if (client.id == this.selectedClient) {
                        this.activeClient = client;
                        this.activeClientCurrency = JSON.parse(this.countries)[client.country].currency;
                        break;
                    }
                }
            }
        }
    });
}

if (document.getElementById('client_form')) {
    const clientForm = new Vue({
        el: '#client_form',
        data: {
            country: document.getElementById('country').dataset.preSelectCountry || '',
            isActive: document.getElementById('is_active').dataset.preSelectStatus ? parseInt(document.getElementById('is_active').dataset.preSelectStatus) : 1,
            newEmailName: '',
            newEmailId: '',
            clientEmails: document.getElementById('emails').value == '' ? [] : document.getElementById('emails').value.split(','),
        },
        methods: {
            toggleActive: function() {
                this.isActive = !this.isActive;
            },
            addNewEmail: function() {
                this.clientEmails.push(this.newEmailName + ' <' + this.newEmailId + '>');
                this.newEmailName = '';
                this.newEmailId = '';
            },
            removeEmail: function(item) {
                let index = this.clientEmails.indexOf(item);
                if (index !== -1) {
                    this.clientEmails.splice(index, 1);
                }
            }
        }
    });
}

if (document.getElementById('finance_report')) {
    const financeReport = new Vue({
        el: '#finance_report',
        data: {
            showReportTable: 'received',
            sentAmountINR: document.getElementById('sent_amount_INR').dataset.sentAmount || 0,
            sentAmountUSD: document.getElementById('sent_amount_USD').dataset.sentAmount || 0,
            conversionRateUSD: document.getElementById('conversion_rate_usd').dataset.conversionRateUsd || 0,
        },
        computed: {
            convertedUSDSentAmount: function() {
                let convertedAmount = parseFloat(this.sentAmountUSD) * parseFloat(this.conversionRateUSD);
                return isNaN(convertedAmount) ? 0 : convertedAmount.toFixed(2);
            },
            totalINREstimated: function() {
                return parseFloat(this.sentAmountINR) + parseFloat(this.convertedUSDSentAmount);
            }
        }
    });
}

$('#page_hr_applicant_edit .applicant-round-form').on('click', '.round-submit', function() {
    let button = $(this);
    let form = $(this).closest('.applicant-round-form');
    let selectedAction = $(this).data('action');
    if (selectedAction == 'confirm' || selectedAction == 'send-for-approval' || selectedAction == 'onboard') {
        if (!form[0].checkValidity()) {
            form[0].reportValidity();
            return false;
        }
    }
    form.find('[name="action"]').val(selectedAction);
    button.prop('disabled', 'disabled').addClass('disabled');
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
    $('[data-toggle="tooltip"]').tooltip();
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


/**
 * Knowledge Cafe
 *
 */

if (document.getElementById('show_and_save_book')) {
    const bookForm = new Vue({
        el: '#show_and_save_book',
        data: {
            addMethod: 'from_image',
            showInfo: false,
            book: {},
            routes: {
                index: document.getElementById('show_book').dataset.indexRoute || '',
                fetch: document.getElementById('book_form').dataset.actionRoute || '',
                store: document.getElementById('show_book').dataset.storeRoute || ''
            },
            buttons: {
                disableSubmitButton:false,
                disableSaveButton: false
            }
        },

        methods: {
            onFileSelected: function(e) {
                let file = e.target.files[0];
                if (!file) { return; }
                this.compressedFile =  null;
                let image  = new ImageCompressor(file, {
                    quality: .1,
                    success: function(result) {
                        this.compressedFile = result;
                    }
                });
            },

            submitBookForm: function() {
                let formData = new FormData(document.getElementById('book_form'));

                if(this.compressedFile) {
                    formData.append('book_image', compressedFile, compressedFile.name);
                }

                this.book = {};
                this.buttons.disableSubmitButton = true;

                axios.post(this.routes.fetch, formData).then(
                    (response) => {
                        this.buttons.disableSubmitButton = false;
                        let data = response.data;

                        if(!data) {
                            alert("Error:Please try again");
                            return;
                        }

                        if(data.error) {
                            alert(data.message);
                            return;
                        }

                        this.book = data.book;

                        if (Object.keys(this.book).length )
                        {
                            this.showInfo = true;
                        }
                });
            },

            saveBookToRecords: function () {
                if(!this.book ) {
                    alert("Error in saving records");
                }
                this.buttons.disableSaveButton = true;

                axios.post(this.routes.store, this.book ).then (
                (response) => {
                    this.buttons.disableSaveButton = false;

                    if(response.data.error) {
                        alert("Error in saving records");
                        return false;
                    }
                   window.location.href = this.routes.index
                });
            }
        }

    });
}

if (document.getElementById('books_listing')) {
    const bookForm = new Vue({
        el: '#books_listing',
        data: {
            books: document.getElementById('books_table').dataset.books ? JSON.parse(document.getElementById('books_table').dataset.books) : {},
            bookCategories: document.getElementById('books_table').dataset.categories ? JSON.parse(document.getElementById('books_table').dataset.categories) : [],
            updateRoute:document.getElementById('books_table').dataset.indexRoute  || '',
            categoryIndexRoute:document.getElementById('books_table').dataset.categoryIndexRoute  || '',
            categoryInputs: [],
            currentBookIndex: 0,
            newCategory:'',
            searchKey: document.getElementById('search_input') ? document.getElementById('search_input').dataset.value : '',
        },

        methods: {
            updateCategoryMode : function(index) {
                let categories = this.books[index]['categories'];
                if(!categories) {
                    return false;
                }
                this.currentBookIndex = index;

                this.categoryInputs.map((checkbox) => checkbox.checked = false );
                categories.forEach((category) => this.categoryInputs[category.id].checked =  true );
            },

            updateCategory: function() {
                let selectedCategory = [];
                let bookID = this.books[this.currentBookIndex]['id'];

                this.categoryInputs.forEach(function(checkbox) {
                    if(checkbox.checked) {
                        selectedCategory.push({
                            name:checkbox.dataset.category,
                            id:checkbox.value
                        });
                    }
                });

                this.$set(this.books[this.currentBookIndex], 'categories',  selectedCategory);
                let route = `${this.updateRoute}/${bookID}`;
                axios.put(route, {categories: JSON.parse(JSON.stringify(selectedCategory))});
                document.getElementById('close_update_category_modal').click();
            },

            addNewCategory: async function() {
                if(!this.newCategory) {
                    alert("Please enter category name");
                    return false;
                }

                let response = await axios.post(this.categoryIndexRoute, {name: this.newCategory});
                if(response.data && response.data.category) {
                    await this.bookCategories.push(response.data.category);
                    this.newCategory = "";
                    let allCheckboxes = document.querySelectorAll('#update_category_modal input[type="checkbox"]');
                    let lastCheckbox = allCheckboxes[allCheckboxes.length-1];
                    this.categoryInputs[lastCheckbox.value] = lastCheckbox;
                }
            },

            deleteBook: async function(index) {
                let confirmDelete = confirm ('Are you sure ?');

                if(!confirmDelete) {
                    return false;
                }

                let bookID = this.books[index]['id'];
                let route = `${this.updateRoute}/${bookID}`;
                let response = await axios.delete(route);
                this.books.splice(index, 1);
            },

            searchBooks: function() {
                window.location.href = `${this.updateRoute}?search=${this.searchKey}`;
            },

            strLimit: function (str, length) {
                return str.length > length ? str.substring(0, length) + "..." : str;
            }
        },

        mounted: function() {
            let categoryInputContainer = document.querySelector("#update_category_modal");
            let allCategoryInputs = categoryInputContainer.querySelectorAll('input[type="checkbox"]');
            allCategoryInputs.forEach((checkbox) => this.categoryInputs[checkbox.value] = checkbox);
        }
    });
}

if (document.getElementById('books_category')) {
    const bookForm = new Vue({
        el: '#books_category',
        data: {
            categories: document.getElementById('category_container').dataset.categories ? JSON.parse(document.getElementById('category_container').dataset.categories) : [],
            categoryNameToChange: [],
            indexRoute:document.getElementById('category_container').dataset.indexRoute  || '',
            newCategoryName:'',
            newCategoryMode:'',

        },

        methods: {
            showEditMode : function(index) {
                this.categoryNameToChange[index] = this.categories[index]['name'];
                this.$set(this.categories[index], 'editMode', true);
            },

            updateCategoryName : function(index) {
                this.$set(this.categories[index], 'name',  this.categoryNameToChange[index]);
                let categoryID = this.categories[index]['id'];
                let route = `${this.indexRoute}/${categoryID}`;
                axios.put(route, {name: this.categories[index]['name']});
                this.$set(this.categories[index], 'editMode', false);
            },

            deleteCategory: async function(index) {

                let confirmDelete = confirm ('Are you sure ?');

                if(!confirmDelete) {
                    return false;
                }

                let categoryID = this.categories[index]['id'];
                let route = `${this.indexRoute}/${categoryID}`;
                let response = await axios.delete(route);
                this.categories.splice(index, 1);
            },

            updateNewCategoryMode: function(mode) {
                if(mode != 'add') {
                    this.newCategoryName = "";
                }
                this.newCategoryMode = mode;
            },

            addNewCategory: async function() {
                if(!this.newCategoryName) {
                    alert("Please enter category name");
                    return false;
                }
                let route = `${this.indexRoute}`;
                let response = await axios.post(route, {name: this.newCategoryName});

                if(response.data && response.data.category) {
                    this.categories.unshift(response.data.category);
                }

                this.newCategoryMode = 'saved';

            }
        }
    });
}

if (document.getElementById('show_book_info')) {
    const bookForm = new Vue({
        el: '#show_book_info',
        data: {
            book: document.getElementById('show_book_info').dataset.book
                        ? document.getElementById('show_book_info').dataset.book
                        : [],
            route:document.getElementById('show_book_info').dataset.markBookRoute
                        ? document.getElementById('show_book_info').dataset.markBookRoute
                        : '',
            isRead: document.getElementById('show_book_info').dataset.isRead ? true: false,
            readers: document.getElementById('show_book_info').dataset.readers
                        ? document.getElementById('show_book_info').dataset.readers
                        : []
        },
        methods: {
            markBook: async function (read) {
                    let response = await axios.post(this.route, {book_id:this.book.id, is_read:read});
                    this.isRead = read;
                    if(!response.data) {
                        return false;
                    }
                    this.readers = response.data.readers;
            },
        },

        mounted() {
            this.readers = JSON.parse(this.readers);
            this.book    = JSON.parse(this.book);
        }
    });
}

if(document.getElementById('home_page')) {
    var el = document.getElementById("markBookAsRead");
    el.addEventListener("click", markBookAsRead, false);
    var wishlistBtn = document.getElementById("addBookToWishlist");
    wishlistBtn.addEventListener("click", addBookToWishlist, false);
    var disableBookSuggestionBtn = document.getElementById("disableBookSuggestion");
    disableBookSuggestionBtn.addEventListener("click", disableBookSuggestions, false);
    let isModalShown = sessionStorage.getItem('book_modal_has_shown');
    if(!isModalShown) {
        sessionStorage.setItem("book_modal_has_shown", "true");
        $('#show_nudge_modal').modal('show');
    }
}

function markBookAsRead() {
    let bookID = document.getElementById('markBookAsRead').dataset.id;
    let route = document.getElementById('markBookAsRead').dataset.markBookRoute;
    axios.post(route, {book_id:bookID, is_read:true});
    $('#show_nudge_modal').modal('hide');
}

function addBookToWishlist() {
    let bookID = document.getElementById('addBookToWishlist').dataset.id;
    let route =  document.getElementById('addBookToWishlist').dataset.route;
    axios.post(route, {book_id:bookID});
    $('#show_nudge_modal').modal('hide');
}

function disableBookSuggestions() {
    $('#show_nudge_modal').modal('hide');
    window.location.href = document.getElementById('disableBookSuggestion').dataset.href;
}
