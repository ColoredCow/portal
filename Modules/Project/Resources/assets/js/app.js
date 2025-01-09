$(document).ready(function() {
	// Attach click event handler to elements with class 'card-header'
	$(".card-header").on("click", function() {
		var sectionId = $(this).data("target"); // Get the section ID from data-target attribute
		var arrowElement = $(this).find(".arrow"); // Find the arrow element within the clicked card-header

		// Close all sections except the clicked one
		$(".collapse").not(sectionId).removeClass("show");

		// Rotate the arrow of the clicked section
		$(".arrow").not(arrowElement).removeClass("rotate180");
		arrowElement.toggleClass("rotate180");
	});
});

$(document).ready(function () {
	$("input").on("change", function () {
		this.value = (this.value).replace(/\s+/g, " ");
	});

	window.setTimeout(function() {
		$(".alert").fadeTo(1000, 0).slideUp(1000, function(){
			$(this).remove(); 
		});
	}, 6000);
});

$(document).ready(function () {
	function toggleButtonAndSpinner(button) {
		button.toggleClass("d-none");
		button.siblings(".fa-spinner").toggleClass("d-none");
	}

	function handleAjaxRequest(url, data, button, loader) {
		button.prop("disabled", true);
		if (loader) loader.removeClass("d-none");

		$.ajax({
			url: url,
			type: "POST",
			data: data,
			success: function (response) {
				Vue.$toast.success(response.message);
				setTimeout(() => {
					button.prop("disabled", false);
					if (! loader) toggleButtonAndSpinner(button);
					location.reload();
				}, 1000);
			},
			error: function (response) {
				Vue.$toast.error("Something went wrong!\nPlease check if the effortsheet formatting is correct.");
				if (! loader) toggleButtonAndSpinner(button);
			},
			complete: function () {
				if (loader) loader.addClass("d-none");
				button.prop("disabled", false);
			}
		});
	}
	if ($(".fa-refresh").is("[data-url]")) {
		$(".fa-refresh").on("click", function () {
			let button = $(this);
			toggleButtonAndSpinner(button);
			handleAjaxRequest(button.data("url"), {"isBackDateSync": "off"}, button, null);
		});
	} else {
		$("#backDateEffortsSyncForm").on("submit", function (event) {
			event.preventDefault();
			let form = $(this);
			let button = $("#confirmBackDateSync");
			let effortSyncLoader = $(".efforts-sync-loader");
			let isBackDateSync = $("#isBackDateSync");

			$("#hiddenIsBackDateSync").remove();

			if (!isBackDateSync.is(":checked")) {
				$("<input>").attr({
					type: "hidden",
					id: "hiddenIsBackDateSync",
					name: "isBackDateSync",
					value: "off"
				}).appendTo(form);
			}
			handleAjaxRequest(form.attr("action"), form.serialize(), button, effortSyncLoader);
		});
	}
});

if ($("#effortTrackingGraph").length) {
	effortTrackingChart();
}

function effortTrackingChart() {
	const effortDetails = JSON.parse($("input[name='team_members_effort']").val()),
		workingDays = JSON.parse($("input[name='workingDays']").val()),
		users = JSON.parse($("input[name='users']").val()),
		totalWorkingDays = $("input[name='totalWorkingDays']").val(),
		estimatedHours = $("input[name='dailyEffort']").val(),
		datasetValue = [],
		hoursPerDay = [];
	hoursdIncrement = 0;

	for (var i = 1; i <= totalWorkingDays; i++) {
		hoursdIncrement += parseFloat(estimatedHours);
		console.log(hoursdIncrement);
		hoursPerDay.push(hoursdIncrement);
	}

	for (let i = users.length - 1; i >= 0; i--) {
		const userId = users[i].id;
		const userData = effortDetails[userId];
		console.log(userData);
		let data=[];
		if(userData){
			const userDataKeys = Object.keys(userData);
			const userDates = [];
			for (const key in userData) {
				userDates.push({
					addedOn: userData[key]["added_on"],
					effort: userData[key]["total_effort_in_effortsheet"],
				});
			}
			console.log(userDates);
			data = workingDays.map((workingDay) => {
				for (let i = 0; i <= userDates.length - 1; i++) {
					if (userDates[i].addedOn === workingDay) {
						return userDates[i].effort;
					}
					console.log(i);
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
	}
	console.log(workingDays);
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
