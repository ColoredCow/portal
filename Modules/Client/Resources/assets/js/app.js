$(document).ready(function () {
	$("input").on("change", function () {
		this.value = (this.value).replace(/\s+/g, " ");
	});

	$("#billing_frequency").on("change", function() {

  		if($("#billing_frequency option:selected").data('value') == 'Monthly') {
			$(".dates").show();
		}
 		else if($("#billing_frequency option:selected").data('value') == 'Quarterly') {
			$(".dates").show();
		}
		else if($("#billing_frequency option:selected").data('value') == 'Yearly') {
			$(".dates").show();
		}
 		else if($("#billing_frequency option:selected").data('value') == 'Net 15 days') {
			$(".dates").hide();
		}
		else if($("#billing_frequency option:selected").data('value') == 'Based on project terms') {
			$(".dates").hide();
		}
	});
});