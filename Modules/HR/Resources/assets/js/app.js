$(document).on("click", ".delete-form", (e) => {
	var container = $(e.target.closest(".delete-form"));
	var loaderAndText = container.find(".delete-loader,.delete-text");
	var card = container.closest(".update-card");
	var form = card.find(".remove-form");
	$.ajax({
		url: form.attr("action"),
		type: form.attr("method"),
		data: form.serialize(),
		beforeSend: function() {
			container.prop("disabled", true);
			$(loaderAndText).toggleClass("d-none");
		},
		success: function(response) {
			setTimeout(() => {
				$(loaderAndText).toggleClass("d-none");
				card.remove();
			}, 2000);
		},
		error: function(response) {
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
		beforeSend: function() {
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
		success: function(response) {
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
		error: function(response) {
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
		beforeSend: function() {
			button.prop("disabled", true);
			loaderAndText.toggleClass("d-none");
			setErrors(form, {
				name: [],
			});
		},
		success: function(response) {
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
		error: function(response) {
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
		success: function(res) {
			if (res.status == true) {
				$(".university-update-success").removeClass("d-none");
				showFlashMessage("university-update-success", 2000);
				$("#applicant_college").removeClass("d-none");
			} else {
				updateUniversityFailureAction();
			}
		},
		error: function(res) {
			updateUniversityFailureAction();
		},
	});
}
function updateUniversityFailureAction() {
	$(".university-update-failure").removeClass("d-none");
	showFlashMessage("university-update-failure", 2000);
}
$(document).on("submit", "#addResourceForm", (e) => {
	var resourcelink = document.getElementById("resource_link");
	var hrResourceCategory = document.getElementById("hrResourceCategory");
	if (resourcelink.value == "" || resourcelink.value == null) {
		alert("Resource Url is required");
		e.preventDefault();
	}
	else if(!resourcelink.value.match(/^(http:\/\/www.|https:\/\/www.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/)){
		alert("Enter a valid Url");
		e.preventDefault();
	}
	if (hrResourceCategory.value == "" || hrResourceCategory.value == null) {
		alert("Category is required");
		e.preventDefault();
	}
});
/**
 * TODO: Need to generalize the idea.
 * Instead of showing and hiding the element,
 * we can add a child element and remove it after the time out.
 */
function showFlashMessage(className, fadingTimeout) {
	$("." + className).removeClass("d-none");
	setTimeout(function() {
		$("." + className).addClass("d-none");
	}, fadingTimeout);
}
