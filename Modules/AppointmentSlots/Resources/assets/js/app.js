var moment = require("moment");
$(document).ready(() => {

	if (document.getElementById("create_slots")) {
		let recurrence = document.getElementById("recurrence");
		recurrence.addEventListener("change",function(){
			showRepeatTillInput();
		});
	}

	if (document.getElementById("show_slots")) {
		showSlots();
	}
	if(document.getElementById("show_create_modal")){
		$("#createSlotsModal").modal("show");
	}
});

/**
 * UserAppointmentSlots
 *
 */

if (document.getElementById("create_slots")) {
 	let startTimeInput = document.getElementById("start_time");
 	let recurrenceInput = document.getElementById("recurrence");
 	startTimeInput.addEventListener("blur", setEndTime);
 	recurrenceInput.addEventListener("click", showRepeatTillInput);
}

function setEndTime(e) {
	let endTimeInput = document.getElementById("end_time");
	endTimeInput.value = moment(e.target.value).add(30, "m").format("YYYY-MM-DDTHH:mm");
}

function showRepeatTillInput() {
	let repeatTillInput = document.getElementById("repeat_date_field");
	let recurrenceInput = document.getElementById("recurrence");
	if (recurrenceInput.value == "none") {
		repeatTillInput.classList.add("d-none");
	} else {
		repeatTillInput.classList.remove("d-none");
	}
}

function showSlots() {
	let events = JSON.parse($("#slots_value").val());
	var calendarEl = document.getElementById("calendar");
	var calendar = new FullCalendar.Calendar(calendarEl, {
		headerToolbar: { left: "prev,next today", center: "title", right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek" },
		height: "auto",
		navLinks: true,
		editable: true,
		selectable: true,
		selectMirror: true,
		nowIndicator: true,
		displayEventEnd: true,
		events: events,
		eventClick: function(info) {
			startTime=moment(info.event.start).format("YYYY-MM-DDTHH:mm");
			endTime=moment(info.event.end).format("YYYY-MM-DDTHH:mm");
			let editUrl="/userappointmentslots/"+info.event.id;
			let deleteUrl="/userappointmentslots/"+info.event.id;
			$("#editSlotsModal #editForm").attr("action",editUrl);
			$("#editSlotsModal #deleteForm").attr("action",deleteUrl);
			$("#editSlotsModal #edit_start_time").val(startTime);
			$("#editSlotsModal #edit_end_time").val(endTime);
			$("#editSlotsModal").modal("show");
		},

		dateClick:function(info){
			var date=info.dateStr;
			let link=$("#createSlotsModal #google-calendar-link").attr("value")+moment(date).format("YYYY/MM/DD");
			startTime=moment(date).format("YYYY-MM-DDTHH:mm");
			endTime=moment(startTime).add(30, "m").format("YYYY-MM-DDTHH:mm");
			document.getElementById("create_errors").innerHTML = "";
			$("#createSlotsModal #start_time").val(startTime);
			$("#createSlotsModal #end_time").val(endTime);
			$("#createSlotsModal #recurrence").val("none");
			$("#createSlotsModal #google-calendar-link").attr("href", link);
			document.getElementById("repeat_date_field").classList.add("d-none");
			$("#createSlotsModal").modal("show");
		},
		eventTimeFormat: {
			hour: "numeric",
			minute: "2-digit",
			meridiem: "short",
		}
	});
	calendar.render();  
}
