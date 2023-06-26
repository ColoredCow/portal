$(document).ready(function() {
	$(".thumbs-radio-button").change(function() {
	  $(".thumbs-up").css("color", "");
	  $(".thumbs-down").css("color", "");
	  if ($(this).val() === "positive") {
			$(this).siblings(".thumbs-up").css("color", "green");
	  } else if ($(this).val() === "negative") {
			$(this).siblings(".thumbs-down").css("color", "red");
	  }
	});
});