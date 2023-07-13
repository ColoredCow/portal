$(document).ready(function() {
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
		e.preventDefault(); //This stops the page from reloading when forms are submitted.
		let modalId = $(this)
			.closest(".modal") // It finds the closest element with the class "modal" from the form
			.attr("id"); // retrieves its ID attribute
		let spinnerId = "#" + modalId + " .spinner-border";
		let form = $(this);
		$(spinnerId).removeClass("d-none"); // To make the spinner visible

		$.ajax({
			type: form.attr("method"),
			url: form.attr("action"),
			data: form.serialize(),
			success: function(response) {
				// If there is no error this function will run and hide the modal
				$(spinnerId).addClass("d-none");
				$("#" + modalId).modal("hide");
				if (modalId === "createSessionModal") {
					//Checks if the current modal is create modal
					Vue.$toast.success("Session Created successfully!"); // Display the Created toast message
				} else {
					Vue.$toast.success("Session Updated successfully!"); // Display the Updated toast message
				}
				location.reload(true);
			},
			error: function(response) {
				// This function will run if there was an error
				$(spinnerId).addClass("d-none"); //Disable the visibility of the spinner

				if (response.responseJSON && response.responseJSON.errors) {
					//If a JSON object with the field "errors" is included in the response data, it indicates that there were validation errors.
					let errors = response.responseJSON.errors;

					form
						.find(".text-danger")
						.addClass("d-none")
						.empty(); //These line find the div in form which arre used to display the error message

					if (errors.topic_name) {
						// These if conditions checks the error in  a particular field and display the corresponding errors
						let text = errors.topic_name[0];
						$("#" + modalId + " #sessionTopicNameError")
							.html(text)
							.removeClass("d-none"); //To make the error message visible, it removes the "d-none" class and sets the error message text for the topic name input.
						Vue.$toast.error("There is some problem in topic name"); //Display toast notification
					} else {
						$("#" + modalId + " #sessionTopicNameError").addClass("d-none");
					}

					if (errors.link) {
						let text = errors.link[0];
						$("#" + modalId + " #sessionLinkError")
							.html(text)
							.removeClass("d-none");
						Vue.$toast.error("There is some problem in link");
					} else {
						$("#" + modalId + " #sessionLinkError").addClass("d-none");
					}

					if (errors.date) {
						let text = errors.date[0];
						$("#" + modalId + " #sessionDateError")
							.html(text)
							.removeClass("d-none");
						Vue.$toast.error("There is some problem in date");
					} else {
						$("#" + modalId + " #sessionDateError").addClass("d-none");
					}

					if (errors.level && modalId === "createSessionModal") {
						let text = errors.level[0];
						$("#" + modalId + " #sessionLevelError")
							.html(text)
							.removeClass("d-none");
						Vue.$toast.error("There is some problem in level");
					} else {
						$("#" + modalId + " #sessionLevelError").addClass("d-none");
					}

					if (errors.summary) {
						let text = errors.summary[0];
						$("#" + modalId + " #sessionSummaryError")
							.html(text)
							.removeClass("d-none");
						Vue.$toast.error("There is some problem in summary");
					} else {
						$("#" + modalId + " #sessionSummaryError").addClass("d-none");
					}

					$("#" + modalId).modal("show");
				} else {
					$("#" + modalId).modal("hide");
					Vue.$toast.error("There is some problem ");
				}
			},
		});
	});
});
