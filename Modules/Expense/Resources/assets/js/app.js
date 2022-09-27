$(function() {
	$(".add_btn").on("click", function(e) {
	  var update =$(".documents:first").clone();
	  update.find("select").val("");
	  update.find("input[type='file']").val("");
	  $(".documents:last").after(update);
	});
});
$("body").on("click", ".remove_btn", function() {
	var closest = $(this).closest(".documents").remove();
});

$(function() {
	$(".text-underline").on("click", function(e) {
	  var frm =$(".parent:first").clone();
	  frm.find("input[type='file']").val("");
	  frm.find("input").val("");
	  $(".parent:last").after(frm);
	});
});
$("body").on("click", ".btn-danger", function() {
	var closest = $(this).closest(".parent").remove();
});