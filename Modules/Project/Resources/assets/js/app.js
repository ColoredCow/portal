$(document).ready(function () {
	$("input").on("change", function () {
		this.value = (this.value).replace(/\s+/g, " ");
	});

	$(".form-body").on("keyup", ".daily-effort",function(){
	var daily_effort=$(this).val();
	$(this).parent('.daily-effort-div').siblings('.weekly-effort-div').children('.weekly-effort').val(daily_effort*5);
	});
	$(".form-body").on("keyup", ".weekly-effort",function(){
	var weekly_effort=$(this).val();
	$(this).parent('.weekly-effort-div').siblings('.daily-effort-div').children('.daily-effort').val(weekly_effort/5);
	});
    
});
