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
