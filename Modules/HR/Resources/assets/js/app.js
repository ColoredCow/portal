$(document).on("click", ".delete-form", (e) => {
	var container = $(e.target.closest(".delete-form"));
	var loaderAndText = container.find(".delete-loader,.delete-text");
	var card = container.closest(".update-card");
	var form = card.find(".remove-form");
	$.ajax({
		url: form.attr("action"),
		type: form.attr("method"),
		data: form.serialize(),
		beforeSend: function () {
			container.prop("disabled", true);
			$(loaderAndText).toggleClass("d-none");
		},
		success: function (response) {
			setTimeout(() => {
				$(loaderAndText).toggleClass("d-none");
				card.remove();
			}, 2000);
		},
		error: function (response) {
			container.prop("disabled", false);
			$(loaderAndText).toggleClass("d-none");
		},
	});
});

$(document).on("submit", ".contact-form", (e) => {
	const setErrors = (form, errors) => {
		for (var key in errors) {
			if (errors.hasOwnProperty(key)) {
				form.find(`.${key}-feedback`).text(errors[key]);
			}
		}
	};
	const addUpdateForm = (contact) => {
		var form = $(".clone")
			.children()
			.clone(true);
		form.find(".update").toggleClass("d-none");
		form.find(".btn-update").val("update");
		form.find(".btn-text").text("Update");
		form.find("form").attr("action", () => {
			return "/hr/universities/contacts/" + contact.id;
		});
		form.find(".contact-form")
			.find("input")
			.map((key, val) => {
				switch (val.name) {
					case "name":
						val.value = contact.name;
						return val;
					case "email":
						val.value = contact.email;
						return val;
					case "phone":
						val.value = contact.phone;
						return val;
					case "designation":
						val.value = contact.designation;
						return val;
					case "hr_university_id":
						val.value = contact.hr_university_id;
						return val;
				}
			});
		$("#update_form_list").append(form);
	};
	e.preventDefault();
	var form = $(e.target);
	var loaderAndText = form.find(".loader,.btn-text");
	var button = form.find(".btn-update");
	$.ajax({
		url: form.attr("action"),
		type: form.attr("method"),
		data: form.serialize(),
		beforeSend: function () {
			button.prop("disabled", true);
			loaderAndText.toggleClass("d-none");
			setErrors(form, {
				name: [],
				phone: [],
				designation: [],
				phone: [],
				hr_university_id: [],
			});
		},
		success: function (response) {
			loaderAndText.addClass("d-none");
			form.find(".icon").toggleClass("d-none");
			setTimeout(() => {
				form.find(".icon,.btn-text").toggleClass("d-none");
				button.prop("disabled", false);
				if (button.val() == "add") {
					form.closest(".update-card").remove();
					addUpdateForm(response.data);
				}
			}, 2000);
		},
		error: function (response) {
			loaderAndText.toggleClass("d-none");
			setErrors(form, response.responseJSON.errors);
			button.prop("disabled", false);
		},
	});
});
$(document).on("click", ".remove-contact", (e) => {
	e.preventDefault();
	var button = $(e.target);
	button.closest(".update-card").remove();
});
$(document).on("click", ".add-contact", (e) => {
	e.preventDefault();
	var form = $(".clone")
		.children()
		.clone(true);
	form.find(".add").toggleClass("d-none");
	form.find(".btn-update").val("add");
	form.find(".btn-text").text("Add");
	form.find("form").attr("action", "/hr/universities/contacts");
	form.find(".method").remove();
	$("#create_form_list").append(form);
});

$(document).on("click", ".add-aliases", (e) => {
	e.preventDefault();
	var form = $(".alias-clone")
		.children()
		.clone(true);
	form.find(".add").toggleClass("d-none");
	form.find(".btn-update").val("add");
	form.find(".btn-text").text("Add");
	form.find("form").attr("action", "/hr/universities/aliases");
	form.find(".method").remove();
	$("#create_alias_form_list").append(form);
});

$(document).on("click", ".remove-alias", (e) => {
	e.preventDefault();
	var button = $(e.target);
	button.closest(".update-card").remove();
});

$(document).on("submit", ".alias-form", (e) => {
	const setErrors = (form, errors) => {
		for (var key in errors) {
			if (errors.hasOwnProperty(key)) {
				form.find(`.${key}-feedback`).text(errors[key]);
			}
		}
	};
	const addUpdateForm = (alias) => {
		var form = $(".alias-clone")
			.children()
			.clone(true);
		form.find(".update").toggleClass("d-none");
		form.find(".btn-update").val("update");
		form.find(".btn-text").text("Update");
		form.find("form").attr("action", () => {
			return "/hr/universities/aliases/" + alias.id;
		});
		form.find(".alias-form")
			.find("input")
			.map((key, val) => {
				switch (val.name) {
					case "name":
						val.value = alias.name;
						return val;
				}
			});
		$("#update_alias_form_list").append(form);
	};
	e.preventDefault();
	var form = $(e.target);
	var loaderAndText = form.find(".loader,.btn-text");
	var button = form.find(".btn-update");
	$.ajax({
		url: form.attr("action"),
		type: form.attr("method"),
		data: form.serialize(),
		beforeSend: function () {
			button.prop("disabled", true);
			loaderAndText.toggleClass("d-none");
			setErrors(form, {
				name: [],
			});
		},
		success: function (response) {
			loaderAndText.addClass("d-none");
			form.find(".icon").toggleClass("d-none");
			setTimeout(() => {
				form.find(".icon,.btn-text").toggleClass("d-none");
				button.prop("disabled", false);
				if (button.val() == "add") {
					form.closest(".update-card").remove();
					addUpdateForm(response.data);
				}
			}, 2000);
		},
		error: function (response) {
			loaderAndText.toggleClass("d-none");
			setErrors(form, response.responseJSON.errors);
			button.prop("disabled", false);
		},
	});
});

$(document).on("change", "#application_university_id", function () {
	var applicantId = $(this).data("applicant-id");
	var universityId = $(this).val();
	updateUniversityId(applicantId, universityId);
});
function updateUniversityId(applicantId, universityId) {
	$.ajax({
		url: `/hr/${applicantId}/update-university`,
		method: "POST",
		data: {
			university_id: universityId,
		},
		success: function (res) {
			if (res.status == true) {
				$(".university-update-success").removeClass("d-none");
				showFlashMessage("university-update-success", 2000);
				$("#applicant_college").removeClass("d-none");
			} else {
				updateUniversityFailureAction();
			}
		},
		error: function (res) {
			updateUniversityFailureAction();
		},
	});
}
function updateUniversityFailureAction() {
	$(".university-update-failure").removeClass("d-none");
	showFlashMessage("university-update-failure", 2000);
}
/**
 * TODO: Need to generalize the idea.
 * Instead of showing and hiding the element,
 * we can add a child element and remove it after the time out.
 */
function showFlashMessage(className, fadingTimeout) {
	$("." + className).removeClass("d-none");
	setTimeout(function () {
		$("." + className).addClass("d-none");
	}, fadingTimeout);
}

$(document).ready(function () {
	var values = {
		jobValue: null,
		opportunityValue: null,
		roundValue: null,
		dateValue: null,
		searchValue: null,
		page: 1
	};
	var jobValueDisplay = null;
	var roundValueDisplay = null;
	var opportunityValueDisplay = null;

	function resetValues() {
		values.jobValue = null;
		values.opportunityValue = null;
		values.roundValue = null;
		values.searchValue = null;
		values.page = 1;
		jobValueDisplay = null;
		roundValueDisplay = null;
		opportunityValueDisplay = null;
	}

	function updateDisplay(category, value, displayValue) {
		var categoryElement = $(`.selected-${category}-category`);
		categoryElement.find('span').html(displayValue ? displayValue.replace(/\b\w/g, char => char.toUpperCase()) : '');
		categoryElement.attr('data-value', value);
		categoryElement.toggleClass('d-none', !displayValue);
	}

	function sendAjaxRequest() {
		var form = $(".interview-data-fetch");
		var interviewLoader = $(".interview-loader");

		interviewLoader.removeClass('d-none');

		$.ajax({
			url: form.attr("action"),
			type: form.attr("method"),
			contentType: 'application/json',
			data: values,
			success: function (response) {
				var selectedInterviews = $(response).find('[data-counter]');
				$('.total-interview-tasks').html(selectedInterviews.length);
				if (selectedInterviews.length > 0) {
					form.html(response);
				} else {
					form.html('<div class="mt-10 fz-24 text-center w-full">No interviews found for this filter.</div>');
				}
				interviewLoader.addClass('d-none');

				updateDisplay('job', values.jobValue, jobValueDisplay);
				updateDisplay('opportunity', values.opportunityValue, opportunityValueDisplay);
				updateDisplay('round', values.roundValue, roundValueDisplay);

				// Update pagination links
				$('.pagination-wrapper').html($(response).find('.pagination-wrapper').html());
			},
			error: function (xhr, status, error) {
				console.log("Error:", error);
			}
		});
	}

	$(document).on("click", ".interview-job-filter, .interview-opportunity-filter, .interview-round-filter, .interview-data-reset, .interview-date-filter, .interview-search", function (e) {
		e.preventDefault();
		var $this = $(this);
		
		var elementClass = $this.attr('class').split(' ').find(cls => {
			return cls === 'interview-data-reset' ||
				   cls === 'interview-job-filter' ||
				   cls === 'interview-opportunity-filter' ||
				   cls === 'interview-round-filter' ||
				   cls === 'interview-date-filter' ||
				   cls === 'interview-search';
		});
	
		switch (elementClass) {
			case 'interview-data-reset':
				resetValues();
				$('#searchInterviews').val('');
				break;
	
			case 'interview-job-filter':
				values.jobValue = $this.attr('data-id');
				jobValueDisplay = $this.attr('value');
				break;
	
			case 'interview-opportunity-filter':
				values.opportunityValue = $this.attr('data-id');
				opportunityValueDisplay = $this.attr('value');
				break;
	
			case 'interview-round-filter':
				values.roundValue = $this.attr('data-id');
				roundValueDisplay = $this.attr('value');
				break;
	
			case 'interview-date-filter':
				values.dateValue = $this.attr('data-id');
				$('.interview-date-filter').removeClass('active');
				$this.addClass('active');
				break;
	
			case 'interview-search':
				values.searchValue = $('#searchInterviews').val();
				break;
	
			default:
				console.error('Unexpected class');
		}
	
		values.page = 1; // Reset to the first page when applying new filters
		sendAjaxRequest();
	});

	$(document).on("click", ".remove-round, .remove-opportunity, .remove-job", function (e) {
		e.preventDefault();
		var $this = $(this);

		if ($this.hasClass('remove-job')) {
			values.jobValue = null;
			jobValueDisplay = null;
		} else if ($this.hasClass('remove-opportunity')) {
			values.opportunityValue = null;
			opportunityValueDisplay = null;
		} else if ($this.hasClass('remove-round')) {
			values.roundValue = null;
			roundValueDisplay = null;
		}

		values.page = 1;
		sendAjaxRequest();
	});

	$(document).on('click', '.pagination-links a', function (e) {
		e.preventDefault();
		var page = $(this).attr('href').split('page=')[1];
		values.page = page;
		sendAjaxRequest();
	});

});


