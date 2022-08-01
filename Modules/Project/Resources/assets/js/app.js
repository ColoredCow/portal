$(document).ready(function () {
	$("input").on("change", function () {
		this.value = (this.value).replace(/\s+/g, " ");
	});
	$(".form-body").on("keyup", ".daily-effort", function() {
		var dailyEffort=$(this).val();
		const objdays = document.getElementById("working_days_in_month");
		const daysInMonth = objdays.getAttribute("data-days-count");
		if (dailyEffort== "") {
			$(this).parent(".daily-effort-div").siblings(".weekly-effort-div").children(".weekly-effort").val("");
			$(this).parent(".daily-effort-div").siblings(".monthly-effort-div").children(".monthly-effort").val("");
		} else {
			$(this).parent(".daily-effort-div").siblings(".weekly-effort-div").children(".weekly-effort").val(dailyEffort*5);
			$(this).parent(".daily-effort-div").siblings(".monthly-effort-div").children(".monthly-effort").val(dailyEffort*daysInMonth);
		}
	});

	$(".form-body").on("keyup", ".weekly-effort", function() {
		var weeklyEffort=$(this).val();
		const objdays = document.getElementById("working_days_in_month");
		const daysInMonth = objdays.getAttribute("data-days-count");
		if (weeklyEffort=="") {
			$(this).parent(".weekly-effort-div").siblings(".daily-effort-div").children(".daily-effort").val("");
			$(this).parent(".weekly-effort-div").siblings(".monthly-effort-div").children(".monthly-effort").val("");
		} else {
			$(this).parent(".weekly-effort-div").siblings(".daily-effort-div").children(".daily-effort").val(weeklyEffort/5);
			$(this).parent(".weekly-effort-div").siblings(".monthly-effort-div").children(".monthly-effort").val((weeklyEffort/5)*daysInMonth);
		}

	});

	$(".form-body").on("keyup", ".monthly-effort", function() {
		var monthlyEffort=$(this).val();
		const objdays = document.getElementById("working_days_in_month");
		const daysInMonth = objdays.getAttribute("data-days-count");
		if (monthlyEffort=="") {
			$(this).parent(".monthly-effort-div").siblings(".daily-effort-div").children(".daily-effort").val("");
			$(this).parent(".monthly-effort-div").siblings(".weekly-effort-div").children(".weekly-effort").val("");
		} else {
			$(this).parent(".monthly-effort-div").siblings(".daily-effort-div").children(".daily-effort").val(monthlyEffort/daysInMonth);
			$(this).parent(".monthly-effort-div").siblings(".weekly-effort-div").children(".weekly-effort").val(monthlyEffort/daysInMonth * 5);
		}
	});
	window.setTimeout(function() {
		$(".alert").fadeTo(1000, 0).slideUp(1000, function(){
			$(this).remove();
		});
	}, 6000);
});
