$(function () {
	$(".fa-refresh").on("click", function () {
		let button = $(this).prop("disabled", true);
		button.toggleClass("d-none");
		button.siblings(".fa-spinner").toggleClass("d-none");

		$.ajax({
			url: button.data("url"),
			type: "POST",
			success: function(response) {
				setTimeout(() => {
					button.prop("disabled", false);
					button.toggleClass("d-none");
					button.siblings(".fa-spinner").toggleClass("d-none");
					location.reload();
				}, 3000);
			},
			error: function(response) {
				Vue.$toast.error("Something went wrong!\nPlease check if the effortsheet formatting is correct.");
				button.prop("disabled", true);
				button.toggleClass("d-none");
				button.siblings(".fa-spinner").toggleClass("d-none");
			},
		});
	});;
});

$(document).on("click", "#add_task", (e) => {
	let form = $("#add_form")
		.children()
		.clone(true);

	form.find(".add").toggleClass("d-none");
	form.find(".btn-update").val("add");
	form.find(".btn-text").text("Add");
	form.find("form").attr("action", "/efforttracking/task");
	form.find(".method").remove();
	$("#add_task_form_list").append(form);
});


$(document).on("click", ".remove-contact", (e) => {
	let button = $(e.target);
	button.closest(".update-card").remove();
});


$(document).on("submit", ".task-form", (e) => {
	const addUpdateForm = (task) => {
		let form = $("#add_form")
			.children()
			.clone(true);

		form.find(".remove_button").toggleClass("d-none");
		form.find(".btn-update").val("update");
		form.find(".btn-text").text("Update");
		if (task.comment) {
			form.find("#show_comment").text("View Note");
		}
		form.find("form").attr("action", `/efforttracking/task/${task.id}`);
		form.find(".task-form")
			.find("input")
			.map((key, val) => {
				if (val.name !== "_token" && val.name !== "_method") {
					val.value = task[val.name];
				}
			});
		form.find(".task-form").find(".type").val(task.type);
		form.find(".task-form").find(".asignee_id").val(task.asignee_id);
		$("#update_task_form_list").append(form);
	};
	e.preventDefault();

	let form = $(e.target);
	let loaderAndText = form.find(".loader,.btn-text");
	let button = form.find(".btn-update");
	$.ajax({
		url: form.attr("action"),
		type: form.attr("method"),
		data: form.serialize(),
		beforeSend: function() {
			button.prop("disabled", true);
			loaderAndText.toggleClass("d-none");
		},
		success: function(response) {
			loaderAndText.addClass("d-none");
			form.find(".icon").toggleClass("d-none");
			setTimeout(() => {
				form.find(".icon,.btn-text").toggleClass("d-none");
				button.prop("disabled", false);
			}, 2000);

			if (button.val() == "add") {
				form.closest(".update-card").remove();
				addUpdateForm(response.data);
			} else {
				if (response.data.comment) {
					form.find("#show_comment").text("View Note");
				}
			}
		},
		error: function(response) {
			loaderAndText.toggleClass("d-none");
			button.prop("disabled", false);
		},
	});
});

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

$(document).on("click", "#show_comment", (e) => {
	let addNoteBtn = $(e.target);
	addNoteBtn.parent().find(".comment_toggle").toggleClass("d-none");
});

if ($("#effortTrackingGraph").length) {
	effortTrackingChart();
}

function effortTrackingChart() {
	const effortDetails = JSON.parse($("input[name='team_members_effort']").val()),
		workingDays = JSON.parse($("input[name='workingDays']").val()),
		users = JSON.parse($("input[name='users']").val()),
		totalWorkingDays = $("input[name='totalWorkingDays']").val(),
		estimatedHours = $("#projectHours").find("span").html(),
		datasetValue = [],
		hoursPerDay = [];

	for (var i = 1; i <= totalWorkingDays; i++) {
		hoursPerDay.push(estimatedHours / totalWorkingDays);
	}

	for (let i = users.length - 1; i >= 0; i--) {
		const userId = users[i].id;
		const userData = effortDetails[userId];
		let data=[];
		if(userData){
			const userDataKeys = Object.keys(userData);
			const userDates = userDataKeys.map((key) => ({
				effort: userData[key].actual_effort,
				addedOn: userData[key].added_on
			}));
			data = workingDays.map((workingDay) => {
				for (let i = 0; i <= userDates.length - 1; i++) {
					if (userDates[i].addedOn === workingDay) {
						return userDates[i].effort;
					}
				}
				return 0;
			});
		}
		const userColor = `rgb(${255-i*35},0,0)`;
		datasetValue[i] = {
			type: "bar",
			label: users[i].name,
			data,
			borderColor: userColor,
			backgroundColor: userColor,
			stack: "combined",
		};
		document.querySelector(`#user-name${userId}`).style.color = userColor;
	}
	datasetValue[users.length] = {
		type: "line",
		label: "Expected Hours",
		data: hoursPerDay,
		fill: false,
		borderColor: "#4BC0C0",
		backgroundColor: "#4BC0C0",
		stack: "combined",
	};
	const data = {
		labels: workingDays,
		datasets: datasetValue,
	};
	var options = {
		scales: {
			x: {
				type: "time",
				display: true,
				offset: true,
				time: {
					unit: "day",
				},
			},
			y: {
				stacked: true,
			}
		},
	};

	const canvasElementId = "effortTrackingGraph";
	new Chart(canvasElementId, {
		type: "bar",
		data,
		options,
	});
}
