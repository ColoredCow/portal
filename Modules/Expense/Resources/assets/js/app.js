$(function() {
	$(".text-underline").on("click", function(e) {
	  var frm =$(".parent:first").clone();
	  frm.find("input").val("");
	  $(".parent:last").after(frm);
	});
  });
$("body").on("click", ".btn-danger", function() {
    var closest = $(this).closest(".parent").remove();
});