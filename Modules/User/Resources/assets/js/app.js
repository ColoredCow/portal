/** If we want to use this module in another project we need to require bootstrap.php 
 * Don't forgot to add all the Vue dependency  there.
 * 
 * require('./../../../../resources/js/bootstrap');
 * **/


 $(document).ready(function () {
    $("#unmarried").click(function () {
		$("#spouse").addClass("d-none");
	});
    $("#married").click(function () {
		$("#spouse").removeClass("d-none");
	});
    $("#divorced").click(function () {
		$("#spouse").addClass("d-none");
	});
});
