
$(document).ready(function () {
	$("#createSessionModal, #editSessionModal").on("hidden.bs.modal", function() {
		$(this)
			.find("form")
			.trigger("reset");
		$(this)
			.find(".text-danger")
			.addClass("d-none")
			.empty();
	});

	$("#sessionForm, #editSessionForm").on("submit", function(e) {
		e.preventDefault();
		let modalId = $(this)
			.closest(".modal")
			.attr("id");
		let spinnerId = "#" + modalId + " .spinner-border";
		let form = $(this);
		console.log(modalId);
		$(spinnerId).removeClass("d-none");

		$.ajax({
			type: form.attr("method"),
			url: form.attr("action"),
			data: form.serialize(),
			success: function(response) {
				$(spinnerId).addClass("d-none");
				$("#" + modalId).modal("hide");
				if (modalId === "createSessionModal") {
					Vue.$toast.success("Session Created successfully!");
				} else {
					Vue.$toast.success("Session Updated successfully!");
				}
				location.reload(true);
			},
			error: function(response) {
				$(spinnerId).addClass("d-none");
				Vue.$toast.error("there is some problem");

				if (response.responseJSON && response.responseJSON.errors) {
					let errors = response.responseJSON.errors;

					form
						.find(".text-danger")
						.addClass("d-none")
						.empty();

					if (errors.topic_name) {
						let text = errors.topic_name[0];
						$("#" + modalId + " #sessionNameError")
							.html(text)
							.removeClass("d-none");
					} else {
						$("#" + modalId + " #sessionNameError").addClass("d-none");
					}

					if (errors.link) {
						let text = errors.link[0];
						$("#" + modalId + " #sessionLinkError")
							.html(text)
							.removeClass("d-none");
					} else {
						$("#" + modalId + " #sessionLinkError").addClass("d-none");
					}

					if (errors.date) {
						let text = errors.date[0];
						$("#" + modalId + " #sessionDateError")
							.html(text)
							.removeClass("d-none");
					} else {
						$("#" + modalId + " #sessionDateError").addClass("d-none");
					}

					if (errors.level) {
						let text = errors.level[0];
						$("#" + modalId + " #sessionLevelError")
							.html(text)
							.removeClass("d-none");
					} else {
						$("#" + modalId + " #sessionLevelError").addClass("d-none");
					}

					if (errors.summary) {
						let text = errors.summary[0];
						$("#" + modalId + " #sessionSummaryError")
							.html(text)
							.removeClass("d-none");
					} else {
						$("#" + modalId + " #sessionSummaryError").addClass("d-none");
					}

					$("#" + modalId).modal("show");
				} else {
					$("#" + modalId).modal("hide");
				}
			},
		});
	});
});
