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

if ($(".effort-tracking-data").find("canvas").length) {
	effortTrackingChart();
}

function effortTrackingChart() {
	var effortDetails = JSON.parse($("input[name='team_members_effort']").val());
	var workingDays = JSON.parse($("input[name='workingDays']").val());
	var users = JSON.parse($("input[name='users']").val());
	var totalWorkingDays = $("input[name='totalWorkingDays']").val();
	var estimatedHours = $("#projectHours").find("span").html();
	const datasetValue = [];
	const hoursPerDay = [];
	for (var i = 1; i <= totalWorkingDays; i++) {
		hoursPerDay.push((estimatedHours/totalWorkingDays) * i);
	}
	for (var i = users.length - 1; i >= 0; i--) {
		datasetValue[i] = {
			type: "bar",
			label: users[i].name,
			data:[6, 3, 2, 2, 7, 0, 16],
			borderColor: users[i].color,
			backgroundColor: users[i].color,
			stack: "combined",
		}
	}
	datasetValue[users.length] = {
		type: "line",
		label: "Expected Hours",
		data: hoursPerDay,
		fill: false,
		borderColor: "#4BC0C0",
		backgroundColor: "#4BC0C0",
		stack: "combined",
	}
	const data = {
		labels: workingDays,
		datasets: datasetValue,
	};
	var options = {
		plugins: {
			title: {
				text: "Chart.js Combo Time Scale",
				display: true,
			}
		},
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
	var ctx = $("#effortTrackingGraph");
	var ctx = "effortTrackingGraph";
	var charts = new Chart(ctx, {
		type: "bar",
		data: data,
		options: options,
	});
}