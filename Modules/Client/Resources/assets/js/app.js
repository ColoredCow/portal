$(document).ready(function () {
	$("input").on("change", function () {
		this.value = (this.value).replace(/\s+/g, " ");
	});
	$("#billing_frequency").on("change", function() {
		$dateAvailableForValue = ["Monthly", "Quaterly", "Yearly"];
  		if($dateAvailableForValue.includes($("#billing_frequency option:selected").data("value"))) {
			$(".dates").show();
			return;
		}
		$(".dates").hide();
	});
});