$(document).ready(function () {
	$("input").on("change", function () {
		this.value = (this.value).replace(/\s+/g, " ");
	});

	$(".form-body").on("keyup", ".daily-effort",function(){
		var dailyEffort=$(this).val();
		$(this).parent(".daily-effort-div").siblings(".weekly-effort-div").children(".weekly-effort").val(dailyEffort*5);
	});

	$(".form-body").on("keyup", ".weekly-effort",function(){
		var weeklyEffort=$(this).val();
		$(this).parent(".weekly-effort-div").siblings(".daily-effort-div").children(".daily-effort").val(weeklyEffort/5);
	});    
});
