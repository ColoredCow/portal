/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

import "jquery-ui/ui/widgets/datepicker.js";
import ImageCompressor from "image-compressor.js";
var clipboard = new ClipboardJS(".btn-clipboard");

window.Vue = require("vue");

import { Laue } from "laue";
Vue.use(Laue);

// vue toast registration
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
const options = {
	timeout: 2000
};
Vue.use(Toast, options);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('user-listing', require('./../../Modules/User/Resources/assets/js/components/UserListing.vue').default);
//Vue.component('user-listing', require('./components/UserListing.vue').default);

/**
 *  Module Vue Components
 */
require("./../../Modules/User/Resources/assets/js/vueComponents.js");
require("./../../Modules/Salary/Resources/assets/js/vueComponents.js");
// require("./../../Modules/Prospect/Resources/assets/js/vueComponents.js");

Vue.component(
	"project-stage-component",
	require("./components/ProjectStageComponent.vue").default
);
Vue.component(
	"project-stage-billing-component",
	require("./components/ProjectStageBillingComponent.vue").default
);
Vue.component(
	"applicant-round-action-component",
	require("./components/HR/ApplicantRoundActionComponent.vue").default
);
Vue.component(
	"project-details-component",
	require("./components/ProjectDetailsComponent.vue").default
);
Vue.component(
	"books-comments-component",
	require("./components/Book/BooksCommentsComponent.vue").default
);
Vue.component(
	"effort-component",
	require("./components/Project/Report.vue").default
);
Vue.component("comment", require("./components/CommentItem.vue").default);
Vue.component(
	"user-dashboard-read-books",
	require("./components/Dashboard/UserDashboardReadBooks.vue").default
);
Vue.component(
	"user-dashboard-wishlist-books",
	require("./components/Dashboard/UserDashboardWishlistBooks.vue").default
);
Vue.component(
	"user-dashboard-projects",
	require("./components/Dashboard/UserDashboardProjects.vue").default
);
Vue.component(
	"user-dashboard-library",
	require("./components/Dashboard/UserDashboardLibrary.vue").default
);
Vue.component(
	"user-dashboard-infrastructure",
	require("./components/Dashboard/UserDashboardInfrastructure.vue").default
);
Vue.component(
	"user-dashboard-invoice",
	require("./components/Dashboard/UserDashboardInvoice.vue").default
);
Vue.component(
	"job-application-component",
	require("./components/HR/JobApplicationComponent.vue").default
);

if (Vue) {
	Vue.filter("str_limit", function(value, size) {
		if (!value) return "";
		value = value.toString();

		if (value.length <= size) {
			return value;
		}
		return value.substr(0, size) + "...";
	});
}

if (document.getElementById("vueContainer")) {
	new Vue({
		el: "#vueContainer"
	});
}

$(document).ready(() => {
	setTimeout(function() {
		$("#statusAlert").alert("close");
	}, 2000);

	$("#job_title").on("change", function(event) {
		let opportunityId = $(this)
			.find(":selected")
			.attr("id");
		$("#opportunityId").attr("value", opportunityId);
	});

	if ($(".form-create-invoice").length) {
		let form = $(".form-create-invoice");
		let client_id = form.find("#client_id").val();
		if (client_id) {
			updateClientProjects(form, client_id);
		}
	}
	$("[data-toggle=\"tooltip\"]").tooltip();

	$(".status-close").on("click", function() {
		let wrapper = $(this).closest(".alert");
		wrapper.fadeOut(500);
	});

	$(".client_edit_form_submission_btn").on("click", function() {
		if (!$("#edit_client_info_form")[0].checkValidity()) {
			$("#edit_client_info_form")[0].reportValidity();
			return false;
		}
		$("#submit_action_input").val($(this).attr("data-submit-action"));
		$("#edit_client_info_form").submit();
	});

	$(".prospect_edit_form_submission_btn").on("click", function() {
		if (!$("#edit_prospect_info_form")[0].checkValidity()) {
			$("#edit_prospect_info_form")[0].reportValidity();
			return false;
		}
		$("#submit_action_input").val($(this).attr("data-submit-action"));
		$("#edit_prospect_info_form").submit();
	});

	$("body").on("change", ".custom-file-input", function() {
		var fileName = $(this)
			.val()
			.split("\\")
			.pop();
		$(this)
			.siblings(".custom-file-label")
			.addClass("selected")
			.html(fileName);
	});
	$("#addChannel").on("submit",function(e){
		e.preventDefault();
		let form = $("#addChannel");
		let button = $("#channelButton");
		
		$.ajax({
			url: form.attr("action"),
			type: form.attr("method"),
			data: form.serialize(),
			success: function(response) {
				$("#channelName").modal("hide");
				$("#success").toggleClass("d-none");
				$("#success").fadeToggle(5000);
			},
			error: function(response) {
				$("#errorMessage").toggleClass("d-none");
			},
		});		
	});

	if ($(".chart-data").length) {
		datePickerChart();
		barChart();
	}

	$("#save-btn-action").on("click", function() {
		this.disabled = true;
		if (!this.form.checkValidity()) {
			this.disabled = false;
			this.form.reportValidity();
			return;
		}
		this.form.submit();
	});
});

$(document).ready(function(){	
	$("#domainformModal").on("hidden.bs.modal", function () {
		$(this).find("form").trigger("reset");
		$("#domainerror").addClass("d-none");
	});

	$("#domainForm").on("submit",function(e){
		e.preventDefault();
		let form =$("#domainForm");
		
	 	$.ajax({
			type: form.attr("method"),
			url: form.attr("action"),
			data: form.serialize(),
			success:function (response) {
				$("#domainformModal").modal("hide");
				$("#successMessage").toggleClass("d-none");
				$("#successMessage").fadeToggle(3000);
			},
			error: function(response){
				if(response.responseJSON.errors.name){
					let text = response.responseJSON.errors.name[0];
					$("#domainerror").html(text).removeClass("d-none");
					return false;
				}
			},
		});
	});
});

if (document.getElementById("page_hr_applicant_edit")) {
	new Vue({
		el: "#page_hr_applicant_edit",
		data: {
			showResumeFrame: false,
			showEvaluationFrame: false,
			applicationJobRounds: document.getElementById("action_type")

				? JSON.parse(
					document.getElementById("action_type").dataset.applicationJobRounds
				  )

				: {},
			selectedNextRound: "",
			nextRoundName: "",
			selectedAction: "round",
			selectedActionOption: "",
			nextRound: "",
			createCalendarEvent: true
		},
		methods: {
			toggleResumeFrame: function() {
				this.showResumeFrame = !this.showResumeFrame;
			},
			toggleEvaluationFrame: function() {
				this.showEvaluationFrame = !this.showEvaluationFrame;
			},
			getApplicationEvaluation: function(applicationRoundID) {
				$("#page_hr_applicant_edit #application_evaluation_body").html(
					"<div class=\"my-4 fz-18 text-center\">Loading...</div>"
				);
				if (!this.showEvaluationFrame) {
					axios
						.get("/hr/evaluation/" + applicationRoundID)
						.then(function(response) {

							$("#page_hr_applicant_edit #application_evaluation_body").html(
								response.data
							);
						})
						.catch(function(error) {
							alert("Error fetching application evaluation!");
						});
				}
				this.toggleEvaluationFrame();
			},

			onSelectNextRound: function(event) {
				this.selectedAction = event.target.value;
				this.selectedActionOption =
					event.target.options[event.target.options.selectedIndex];
			},
			takeAction: function() {
				switch (this.selectedAction) {
				case "round":
					if (!this.selectedActionOption) {
						this.selectedActionOption = document.querySelector(
							"#action_type option:checked"
						);
					}
					this.selectedNextRound = this.selectedActionOption.dataset.nextRoundId;
					this.nextRoundName = this.selectedActionOption.innerText;
					loadTemplateMail("confirm", res => {
						$("#confirmMailToApplicantSubject").val(res.subject);
						tinymce
							.get("confirmMailToApplicantBody")
							.setContent(res.body, { format: "html" });
					});
					$("#round_confirm").modal("show");
					break;
				case "send-for-approval":
					$("#send_for_approval").modal("show");
					break;
				case "approve":
					$("#approve_application").modal("show");
					break;
				case "onboard":
					$("#onboard_applicant").modal("show");
				}
			},
			rejectApplication: function() {
				$("#application_reject_modal").modal("show");
				loadTemplateMail("reject", res => {
					$("#rejectMailToApplicantSubject").val(res.subject);
					tinymce
						.get("rejectMailToApplicantBody")
						.setContent(res.body, { format: "html" });
				});
			}
		},
		mounted() {
			this.selectedNextRound = this.applicationJobRounds[0].id;
			this.selectedAction = "round";
			this.nextRoundName = this.applicationJobRounds[0].name;
		}
	});
}

if (document.getElementById("project_container")) {
	const projectContainer = new Vue({
		el: "#project_container",
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

if (document.getElementById("employee_projects")) {
	const employeeProjects = new Vue({
		el: "#employee_projects",
		data: {},
		methods: {}
	});
}

if (document.getElementById("client_form")) {
	const clientForm = new Vue({
		el: "#client_form",
		data: {
			country:
				document.getElementById("country").dataset.preSelectCountry || "",
			isActive: document.getElementById("is_active").dataset.preSelectStatus
				? parseInt(document.getElementById("is_active").dataset.preSelectStatus)
				: 1,
			newEmailName: "",
			newEmailId: "",
			clientEmails:
				document.getElementById("emails").value == ""
					? []
					: document.getElementById("emails").value.split(",")
		},
		methods: {
			toggleActive: function() {
				this.isActive = !this.isActive;
			},
			addNewEmail: function() {
				this.clientEmails.push(
					this.newEmailName + " <" + this.newEmailId + ">"
				);
				this.newEmailName = "";
				this.newEmailId = "";
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

if (document.getElementById("finance_report")) {
	const financeReport = new Vue({
		el: "#finance_report",
		data: {
			showReportTable: "received",
			sentAmountINR:
				document.getElementById("sent_amount_INR").dataset.sentAmount || 0,
			sentAmountUSD:
				document.getElementById("sent_amount_USD").dataset.sentAmount || 0,
			conversionRateUSD:
				document.getElementById("conversion_rate_usd").dataset
					.conversionRateUsd || 0
		},
		computed: {
			convertedUSDSentAmount: function() {
				let convertedAmount =
					parseFloat(this.sentAmountUSD) * parseFloat(this.conversionRateUSD);
				return isNaN(convertedAmount) ? 0 : convertedAmount.toFixed(2);
			},
			totalINREstimated: function() {
				return (
					parseFloat(this.sentAmountINR) +
					parseFloat(this.convertedUSDSentAmount)
				);
			}
		}
	});
}

$("#page_hr_applicant_edit .applicant-round-form").on(
	"click",
	".round-submit",
	function() {
		let button = $(this); // reject button
		let form = $(this).closest(".applicant-round-form"); // <form element with class "applicant-round-form" >
		let selectedAction = $(this).data("action"); // reject
		const actions = ["confirm", "send-for-approval", "onboard", "approve"];
		if (actions.includes(selectedAction)) {
			if (!form[0].checkValidity()) {
				form[0].reportValidity();
				return false;
			}
		}

		form.find("[name=\"action\"]").val(selectedAction); // setting name="action" input inside form to "reject"
		button.prop("disabled", "disabled").addClass("disabled"); // making button disabled
		form.submit(); // submitting the form
	}
);

$(".date-field").datepicker({
	dateFormat: "dd/mm/yy"
});

$("#form_invoice").on("change", "#client_id", function() {
	let form = $(this).closest("form");
	let client_id = $(this).val();
	if (!client_id) {
		form.find("#project_ids").html("");
		return false;
	}
	updateClientProjects(form, client_id);
});

$("#copy_weeklydose_service_url").tooltip({
	trigger: "click",
	placement: "bottom"
});

function updateClientProjects(form, client_id) {
	$.ajax({
		url: "/clients/" + client_id + "/get-projects",
		method: "GET",
		success: function(res) {
			form.find("#project_ids").html(getProjectList(res));
		}
	});
}

function getProjectList(projects) {
	let html = "";
	for (var index = 0; index < projects.length; index++) {
		let project = projects[index];
		html += "<option value=\"" + project.id + "\">";
		html += project.name;
		html += "</option>";
	}
	return html;
}

function setTooltip(btn, message) {
	$(btn)
		.tooltip("hide")
		.attr("data-original-title", message)
		.tooltip("show");
}

function hideTooltip(btn) {
	setTimeout(function() {
		$(btn).tooltip("hide");
	}, 1000);
}

clipboard.on("success", function(e) {
	setTooltip(e.trigger, "Copied!");
	hideTooltip(e.trigger);
});

tinymce.init({
	selector: ".richeditor",
	skin: "lightgray",
	toolbar:
		"undo redo formatselect | fontselect fontsizeselect bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
	plugins: ["advlist lists autolink link code image print"],
	font_formats:
		"Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace;AkrutiKndPadmini=Akpdmi-n",
	images_upload_url: "postAcceptor.php",
	content_style: "body{font-size:14pt;}",
	automatic_uploads: false,
	fontsize_formats: "8pt 10pt 12pt 14pt 16pt 18pt 24pt 36pt 48pt",
	menubar: false,
	statusbar: false,
	entity_encoding: "raw",
	forced_root_block: "",
	force_br_newlines: true,
	force_p_newlines: false,
	height: "280",
	convert_urls: 0
});

$(".hr_round_guide").on("click", ".edit-guide", function() {
	let container = $(this).closest(".hr_round_guide");
	container.find(".btn-guide, .guide-container").toggleClass("d-none");
});

$(".hr_round_guide").on("click", ".save-guide", function() {
	let container = $(this).closest(".hr_round_guide");
	let form = container.find("form");
	let button = $(this);
	$.ajax({
		method: form.attr("method"),
		url: form.attr("action"),
		data: form.serialize() + "&guidelines=" + tinyMCE.activeEditor.getContent(),
		beforeSend: function() {
			button
				.prop("disabled", true)
				.find(".item")
				.toggleClass("d-none");
		},
		success: function(res) {
			button
				.prop("disabled", false)
				.find(".item")
				.toggleClass("d-none");
			if (res.length) {
				container.find(".guide-display").html(res);
				container.find(".btn-guide, .guide-container").toggleClass("d-none");
			}
		}
	});
});

/**
 * Knowledge Cafe
 *
 */

if (document.getElementById("show_and_save_book")) {
	const bookForm = new Vue({
		el: "#show_and_save_book",
		data: {
			addMethod: "from_isbn",
			showInfo: false,
			book: {},
			number_of_copies: 1,
			routes: {
				index: document.getElementById("show_book").dataset.indexRoute || "",
				fetch: document.getElementById("book_form").dataset.actionRoute || "",
				store: document.getElementById("show_book").dataset.storeRoute || ""
			},
			buttons: {
				disableSubmitButton: false,
				disableSaveButton: false
			}
		},
		
		methods: {
			onFileSelected: function(e) {
				let file = e.target.files[0];
				if (!file) {
					return;
				}
				this.compressedFile = null;
				let image = new ImageCompressor(file, {
					quality: 0.1,
					success: function(result) {
						this.compressedFile = result;
					}
				});
			},

			submitBookForm: function() {
				let formData = new FormData(document.getElementById("book_form"));
				if (this.compressedFile) {
					formData.append("book_image", compressedFile, compressedFile.name);
				}

				this.book = {};
				this.buttons.disableSubmitButton = true;

				axios.post(this.routes.fetch, formData).then(response => {
					this.buttons.disableSubmitButton = false;
					let data = response.data;

					if (!data) {
						alert("Error:Please try again");
						return;
					}

					if (data.error) {
						alert(data.message);
						return;
					}

					this.book = data.book;

					if (Object.keys(this.book).length) {
						this.showInfo = true;
					}
				});
			},

			saveBookToRecords: function() {
				if (!this.book) {
					alert("Error in saving records");
				}
				this.buttons.disableSaveButton = true;
				this.book.number_of_copies = this.number_of_copies;
				this.book["on_kindle"] = document.getElementById("on_kindle").checked
					? 1
					: 0;
				axios.post(this.routes.store, this.book).then(response => {
					this.buttons.disableSaveButton = false;

					if (response.data.error) {
						alert("Error in saving records");
						return false;
					}
					this.$toast.success("  Book added successfully ");
					window.location.href = this.routes.index;
				});
			}
		}
	});
}

if (document.getElementById("books_listing")) {
	const bookForm = new Vue({
		el: "#books_listing",
		data: {
			books: document.getElementById("books_table").dataset.books
				? JSON.parse(document.getElementById("books_table").dataset.books)
				: {},
			bookCategories: document.getElementById("books_table").dataset.categories
				? JSON.parse(document.getElementById("books_table").dataset.categories)
				: [],
			updateRoute:
				document.getElementById("books_table").dataset.indexRoute || "",
			categoryIndexRoute:
				document.getElementById("books_table").dataset.categoryIndexRoute || "",
			categoryInputs: [],
			currentBookIndex: 0,
			newCategory: "",
			searchKey: document.getElementById("search_input")
				? document.getElementById("search_input").dataset.value
				: ""
		},
		
		methods: {
			updateCategoryMode: function(index) {		
				let categories = this.books[index]["categories"];
				if (!categories) {
					return false;
				}
				this.currentBookIndex = index;
				this.categoryInputs.map(checkbox => (checkbox.checked = false));
				categories.forEach(
					category => (this.categoryInputs[category.id].checked = true)
				);
			},

			updateCategory: function() {
				let selectedCategory = [];
				let bookID = this.books[this.currentBookIndex]["id"];

				this.categoryInputs.forEach(function(checkbox) {
					if (checkbox.checked) {
						selectedCategory.push({
							name: checkbox.dataset.category,
							id: checkbox.value
						});
					}
				});

				this.$set(
					this.books[this.currentBookIndex],
					"categories",
					selectedCategory
				);
				let route = `${this.updateRoute}/${bookID}`;
				axios.put(route, {
					categories: JSON.parse(JSON.stringify(selectedCategory))
				});
				document.getElementById("close_update_category_modal").click();
			},

			addNewCategory: async function() {
				if (!this.newCategory) {
					alert("Please enter category name");
					return false;
				}

				let response = await axios.post(this.categoryIndexRoute, {
					name: this.newCategory
				});
				if (response.data && response.data.category) {
					await this.bookCategories.push(response.data.category);
					this.newCategory = "";
					let allCheckboxes = document.querySelectorAll(
						"#update_category_modal input[type=\"checkbox\"]"
					);
					let lastCheckbox = allCheckboxes[allCheckboxes.length - 1];
					this.categoryInputs[lastCheckbox.value] = lastCheckbox;
				}
			},

			deleteBook: async function(index) {
				let bookID = this.books[index]["id"];
				let route = `${this.updateRoute}/${bookID}`;
				let response = await axios.delete(route);
				this.books.splice(index, 1);
				$("#exampleModal").modal("hide");
			},

			searchBooks: function() {
				window.location.href = `${this.updateRoute}?search=${this.searchKey}`;
			},

			strLimit: function(str, length) {
				if (!str) {
					return "";
				}
				return str.length > length ? str.substring(0, length) + "..." : str;
			},

			updateCopiesCount: function(index) {
				var new_count = parseInt(
					prompt(
						"Number of copies of this book",
						this.books[index].number_of_copies
					)
				);
				if (new_count && isFinite(new_count)) {
					this.books[index].number_of_copies = new_count;
					axios.put(this.updateRoute + "/" + this.books[index].id, {
						number_of_copies: new_count
					});
				}
			}
		},

		mounted: function() {
			let categoryInputContainer = document.querySelector(
				"#update_category_modal"
			);
			let allCategoryInputs = categoryInputContainer.querySelectorAll(
				"input[type=\"checkbox\"]"
			);
			allCategoryInputs.forEach(
				checkbox => (this.categoryInputs[checkbox.value] = checkbox)
			);
		}
	});
}

if (document.getElementById("books_category")) {
	const bookForm = new Vue({
		el: "#books_category",
		data: {
			categories: document.getElementById("category_container").dataset
				.categories
				? JSON.parse(
					document.getElementById("category_container").dataset.categories
				  )
				: [],
			categoryNameToChange: [],
			indexRoute:
				document.getElementById("category_container").dataset.indexRoute || "",
			newCategoryName: "",
			newCategoryMode: ""
		},

		methods: {
			showEditMode: function(index) {
				this.categoryNameToChange[index] = this.categories[index]["name"];
				this.$set(this.categories[index], "editMode", true);
			},

			updateCategoryName: function(index) {
				this.$set(
					this.categories[index],
					"name",
					this.categoryNameToChange[index]
				);
				let categoryID = this.categories[index]["id"];
				let route = `${this.indexRoute}/${categoryID}`;
				axios.put(route, {
					name: this.categories[index]["name"]
				});
				this.$set(this.categories[index], "editMode", false);
				this.$toast.success( "Updated category for books" );
			},

			deleteCategory: async function(index) {
				let confirmDelete = confirm("Are you sure ?");

				if (!confirmDelete) {
					return false;
				}

				let categoryID = this.categories[index]["id"];
				let route = `${this.indexRoute}/${categoryID}`;
				let response = await axios.delete(route);
				this.categories.splice(index, 1);
			},

			updateNewCategoryMode: function(mode) {
				if (mode != "add") {
					this.newCategoryName = "";
				}
				this.newCategoryMode = mode;
			},

			addNewCategory: async function() {
				if (!this.newCategoryName) {
					alert("Please enter category name");
					return false;
				}
				this.$toast.success(" Category for books added successfully ");
				let route = `${this.indexRoute}`;
				let response = await axios.post(route, {
					name: this.newCategoryName
				});

				if (response.data && response.data.category) {
					this.categories.unshift(response.data.category);
				}

				this.newCategoryMode = "saved";
			}
		}
	});
}

if (document.getElementById("show_book_info")) {
	const bookForm = new Vue({
		el: "#show_book_info",
		data: {
			book: document.getElementById("show_book_info").dataset.book
				? document.getElementById("show_book_info").dataset.book
				: [],
			route: document.getElementById("show_book_info").dataset.markBookRoute
				? document.getElementById("show_book_info").dataset.markBookRoute
				: "",
			borrowBookRoute: document.getElementById("show_book_info").dataset
				.borrowBookRoute
				? document.getElementById("show_book_info").dataset.borrowBookRoute
				: "",
			bookAMonthStoreRoute: document.getElementById("show_book_info").dataset
				.bookAMonthStoreRoute
				? document.getElementById("show_book_info").dataset.bookAMonthStoreRoute
				: "",
			bookAMonthDestroyRoute: document.getElementById("show_book_info").dataset
				.bookAMonthDestroyRoute
				? document.getElementById("show_book_info").dataset
					.bookAMonthDestroyRoute
				: "",
			putBackBookRoute: document.getElementById("show_book_info").dataset
				.putBackBookRoute
				? document.getElementById("show_book_info").dataset.putBackBookRoute
				: "",
			isRead: document.getElementById("show_book_info").dataset.isRead
				? true
				: false,
			isBorrowed: document.getElementById("show_book_info").dataset.isBorrowed
				? true
				: false,
			isBookAMonth: document.getElementById("show_book_info").dataset
				.isBookAMonth
				? true
				: false,
			readers: document.getElementById("show_book_info").dataset.readers
				? document.getElementById("show_book_info").dataset.readers
				: [],
			borrowers: document.getElementById("show_book_info").dataset.borrowers
				? document.getElementById("show_book_info").dataset.borrowers
				: []
		},
		methods: {
			markBook: async function(read) {
				let response = await axios.post(this.route, {
					book_id: this.book.id,
					is_read: read
				});
				this.isRead = read;
				if (!response.data) {
					return false;
				}
				this.readers = response.data.readers;
			},

			addToBookAMonth: async function(action) {
				let response = await axios.post(this.bookAMonthStoreRoute);
				this.isBookAMonth = true;
				if (!response.data) {
					return false;
				}
			},

			removeFromBookAMonth: async function(action) {
				let response = await axios.post(this.bookAMonthDestroyRoute);
				this.isBookAMonth = false;
				if (!response.data) {
					return false;
				}
			},

			borrowTheBook: async function() {
				let response = await axios.get(this.borrowBookRoute);
				this.isBorrowed = true;
				this.borrowers = response.data.borrowers;
			},

			putTheBookBackToLibrary: async function() {
				let response = await axios.get(this.putBackBookRoute);
				this.isBorrowed = false;
				this.borrowers = response.data.borrowers;
			}
		},

		mounted() {
			this.readers = JSON.parse(this.readers);
			this.borrowers = JSON.parse(this.borrowers);
			this.book = JSON.parse(this.book);
		}
	});
}

if (document.getElementById("home_page")) {
	var el = document.getElementById("markBookAsRead");
	el.addEventListener("click", markBookAsRead, false);
	var wishlistBtn = document.getElementById("addBookToWishlist");
	wishlistBtn.addEventListener("click", addBookToWishlist, false);
	var disableBookSuggestionBtn = document.getElementById(
		"disableBookSuggestion"
	);
	disableBookSuggestionBtn.addEventListener(
		"click",
		disableBookSuggestions,
		false
	);
	let isModalShown = sessionStorage.getItem("book_modal_has_shown");
	if (!isModalShown) {
		sessionStorage.setItem("book_modal_has_shown", "true");
		$("#show_nudge_modal").modal("show");
	}
}

function markBookAsRead() {
	let bookID = document.getElementById("markBookAsRead").dataset.id;
	let route = document.getElementById("markBookAsRead").dataset.markBookRoute;
	axios.post(route, {
		book_id: bookID,
		is_read: true
	});
	$("#show_nudge_modal").modal("hide");
}

function addBookToWishlist() {
	let bookID = document.getElementById("addBookToWishlist").dataset.id;
	let route = document.getElementById("addBookToWishlist").dataset.route;
	axios.post(route, {
		book_id: bookID
	});
	$("#show_nudge_modal").modal("hide");
}

function disableBookSuggestions() {
	$("#show_nudge_modal").modal("hide");
	window.location.href = document.getElementById(
		"disableBookSuggestion"
	).dataset.href;
}

if (document.getElementById("roles_permission_table")) {
	new Vue({
		el: "#roles_permission_table",
		data: {
			roles: document.getElementById("roles_permission_table").dataset.roles
				? JSON.parse(
					document.getElementById("roles_permission_table").dataset.roles
				  )
				: [],
			permissions: document.getElementById("roles_permission_table").dataset
				.permissions
				? JSON.parse(
					document.getElementById("roles_permission_table").dataset
						.permissions
				  )
				: [],
			updateRoute:
				document.getElementById("roles_permission_table").dataset.updateRoute ||
				"",
			currentRoleIndex: 0,
			permissionInputs: []
		},
		methods: {
			updatePermissionModal: function(index) {
				let permissions = this.roles[index].permissions;
				this.currentRoleIndex = index;
				this.permissionInputs.map(checkbox => (checkbox.checked = false));
				permissions.forEach(
					permission => (this.permissionInputs[permission.id].checked = true)
				);
			},
			updatePermissions: function() {
				let selectedPermissions = [];
				let roleID = this.roles[this.currentRoleIndex]["id"];

				this.permissionInputs.forEach(function(checkbox) {
					if (checkbox.checked) {
						selectedPermissions.push({
							name: checkbox.dataset.permission,
							id: checkbox.value
						});
					}
				});

				this.$set(
					this.roles[this.currentRoleIndex],
					"permissions",
					selectedPermissions
				);
				let route = `${this.updateRoute}/${roleID}`;
				axios.put(route, {
					permissions: JSON.parse(JSON.stringify(selectedPermissions)),
					roleID: roleID
				});
				document.getElementById("update_role_permissions_modal").click();
			}
		},
		mounted: function() {
			let permissionInputContainer = document.querySelector(
				"#update_role_permissions_modal"
			);
			let allPermissionInputs = permissionInputContainer.querySelectorAll(
				"input[type=\"checkbox\"]"
			);
			allPermissionInputs.forEach(
				checkbox => (this.permissionInputs[checkbox.value] = checkbox)
			);
		}
	});
}

if (document.getElementById("user_roles_table")) {
	var userRoles = new Vue({
		el: "#user_roles_table",
		data: {
			users: document.getElementById("user_roles_table").dataset.users
				? JSON.parse(document.getElementById("user_roles_table").dataset.users)
				: "",
			roles: document.getElementById("user_roles_table").dataset.roles
				? JSON.parse(document.getElementById("user_roles_table").dataset.roles)
				: "",
			updateRoute:
				document.getElementById("user_roles_table").dataset.updateRoute || "",
			currentUserIndex: 0,
			roleInputs: []
		},
		methods: {
			updateUserRolesModal: function(index) {
				let roles = this.users[index]["roles"];
				if (!roles) {
					return false;
				}
				this.currentUserIndex = index;
				this.roleInputs.map(checkbox => (checkbox.checked = false));
				roles.forEach(role => (this.roleInputs[role.id].checked = true));
			},

			updateRoles: function() {
				let selectedRoles = [];
				if (this.users) {
					let userID = this.users[this.currentUserIndex].id;
				}

				this.roleInputs.forEach(function(checkbox) {
					if (checkbox.checked) {
						selectedRoles.push({
							name: checkbox.dataset.role,
							id: checkbox.value
						});
					}
				});

				this.$set(this.users[this.currentUserIndex], "roles", selectedRoles);
				let route = `${this.updateRoute}/${userID}`;
				axios.put(route, {
					roles: JSON.parse(JSON.stringify(selectedRoles)),
					userID: userID
				});
				document.getElementById("close_update_user_roles_modal").click();
			},

			formatRoles: function(user) {
				let roleNames = [];
				for (var i in user.roles) {
					let roleName = user.roles[i].label;
					// roleName = roleName.split('_').map(function (item) {
					//     return item.charAt(0).toUpperCase() + item.substring(1);
					// }).join(' ');

					roleNames.push(roleName);
				}

				return roleNames.join(", ");
			}
		},
		mounted: function() {
			let roleInputContainer = document.querySelector(
				"#update_user_roles_modal"
			);
			let allRoleInputs = roleInputContainer.querySelectorAll(
				"input[type=\"checkbox\"]"
			);
			allRoleInputs.forEach(
				checkbox => (this.roleInputs[checkbox.value] = checkbox)
			);
		}
	});
}

require("./finance/invoice");
require("./finance/payment");

/*
 * HR Module JS code start
 */
$(document).ready(function() {
	$(document).on("click", ".show-comment", showCommentBlock);
	$(document).on("click", ".section-toggle", sectionToggle);
	$(document).on("click", "#saveFollowUp", saveFollowUp);
	$(document).on("change", ".section-toggle-checkbox", sectionToggleCheckbox);
	$(document).on("click", ".show-evaluation-stage", function() {
		$(".evaluation-stage").addClass("d-none");
		var target = $(this).data("target");
		$(target).removeClass("d-none");

		if (
			$("#segment-general-information > span")[0].innerText ==
			"General Information"
		) {
			$(".evaluation-score input").each(function() {
				if ($(this).is(":checked")) {
					let evaluationParameterName = this.name.replace(/_/g, "-");
					console.log(evaluationParameterName);
					if (this.id.slice(-1) == 1) {
						// Thumbs-up
						$(`.${evaluationParameterName}`)
							.find("input:eq(0)")
							.prop("checked", true);
					} else {
						// Thumbs-down
						$(`.${evaluationParameterName}`)
							.find("input:eq(1)")
							.prop("checked", true);
					}
				}
			});
		}
	});
	$(document).on("change", ".set-segment-assignee", setSegmentAssignee);
	$(document).on("click", ".toggle-block-display", toggleBlockDisplay);
	$(document).on(
		"change",
		".send-mail-to-applicant",
		toggleApplicantMailEditor
	);
});

$(function() {
	$("#categoryName")
		.keyup(check_save)
		.each(function() {
			check_save();
		});
});
function check_save() {
	if ($(this).val().length == 0) {
		$("#save-btn-action").attr("disabled", true);
	} else {
		$("#save-btn-action").removeAttr("disabled");
	}
}

function showCommentBlock() {
	var blockId = $(this).data("block-id");
	$(blockId)
		.removeClass("d-none")
		.find("input")
		.focus();
	$(this).addClass("d-none");
}

function sectionToggle() {
	var targetParent = $(this).data("target-parent");
	var targetOption = $(this).data("target-option");
	$(`.${targetParent}`).addClass("d-none");
	$(`.${targetOption}`).removeClass("d-none");
}

function sectionToggleCheckbox() {
	var showOnChecked = $(this).data("show-on-checked");
	if ($(this).is(":checked")) {
		$(showOnChecked).removeClass("d-none");
	} else {
		$(showOnChecked).addClass("d-none");
	}
}

function setSegmentAssignee() {
	var segment = $(this).data("target-segment");
	var assignee = $(this)
		.find(":selected")
		.text();
	if (assignee) {
		$(segment)
			.find(".assignee")
			.removeClass("d-none")
			.find(".name")
			.text(assignee);
	} else {
		$(segment)
			.find(".assignee")
			.addClass("d-none")
			.find(".name")
			.text("");
	}
}

function toggleBlockDisplay() {
	let target = $(this).data("target");
	$(target).toggleClass("d-none");

	var toggleIcon = $(this).data("toggle-icon");
	if (toggleIcon) {
		$(".toggle-icon").toggleClass("d-none");
	}
}

function toggleApplicantMailEditor() {
	let target = $(this).data("target");
	$(target).toggleClass("d-none");
}

function loadTemplateMail(status, successCallback) {
	// make query to load current template
	let applicationRoundId = $("#current_applicationround_id").val();
	$.post({
		url: `/hr/recruitment/applicationround/${applicationRoundId}/mail-content/${status}`,
		method: "post",
		success: successCallback,
		error: err => {
			console.log(err);
		}
	});
}

function saveFollowUp() {
	var form = $(this).closest("form");
	if ($("#followUpAndReject").is(":checked")) {
		var followUpComments = form.find("[name=\"comments\"]").val();
		$(document)
			.find("#followUpCommentForReject")
			.val(followUpComments);
		$(this)
			.closest(".modal")
			.modal("hide");
		$(document)
			.find("#rejectApplication")
			.trigger("click");
	} else {
		$(this)
			.attr("disabled", "disabled")
			.addClass("disabled c-disabled");
		form.submit();
	}
}

function datePickerChart() {
	$("#EndDate").change(function() {
		var startDate = document.getElementById("StartDate").value;
		var endDate = document.getElementById("EndDate").value;
		if (Date.parse(endDate) <= Date.parse(startDate)) {
			alert("End date should be greater than Start date");
			document.getElementById("EndDate").value = "";
		}
	});
}

function barChart() {
	var value = $(".chart-data").data("target");
	var cData = value;
	var ctx = $("#barChart");

	var data = {
		labels: cData.label,
		datasets: [
			{
				label: "Count",
				data: cData.data,
				backgroundColor: "#67A7E2",
				borderColor: "#67A7E2",
				borderWidth: 1,
				pointHoverRadius: 7
			}
		]
	};
	var options = {
		responsive: true,
		tooltips: {
			callbacks: {
				afterBody: function(context) {
					console.log(context);
					return `Verified Applications: ${cData.afterBody[context[0].index]}`;
				}
			},
			displayColors: false,
			bodyFontSize: 20,
			bodyFontStyle: "bold",
			backgroundColor: "#282828",
			bodyFontColor: "#ffffff",
			cornerRadius: 0,
			borderWidth: 2
		},
		title: {
			display: false
		},
		legend: {
			display: false
		},
		scales: {
			yAxes: [
				{
					ticks: { stepSize: 1, suggestedMin: 0.5, suggestedMax: 5.5 }
				}
			]
		},

		elements: {
			line: {
				fill: false,
				tension: 0
			},
			point: {
				radius: 0
			}
		}
	};

	var charts = new Chart(ctx, {
		type: "bar",
		data: data,
		options: options
	});
}

$(function() {
	$(".reject-reason").on("click", function() {
		let reasonCheckboxInput = $(this);
		let reasonCommentInput = reasonCheckboxInput
			.closest(".rejection-reason-block")
			.find("input[type=\"text\"]");
		if (reasonCheckboxInput.is(":checked")) {
			reasonCommentInput.show().focus();
		} else {
			reasonCommentInput.hide();
		}
	});
});

$("#job_start_date").on("change", function() {
	let startDate = $("#job_start_date").val();
	$("#job_end_date").attr("min", startDate);
});

$("#job_end_date").on("change", function() {
	let endDate = $("#job_end_date").val();
	$("#job_start_date").attr("max", endDate);
});

$(document).ready(function() {
	var multipleCancelButton = new Choices("#choices-multiple-remove-button", {
		removeItemButton: true,
		maxItemCount: 9,
		searchResultLimit: 9,
		renderChoiceLimit: 9
	});
});

/*
 * HR Module JS code end
 */

// fix for tinymce and bootstrap modal
$(document).on("focusin", function(e) {
	if ($(event.target).closest(".mce-window").length) {
		e.stopImmediatePropagation();
	}
});
