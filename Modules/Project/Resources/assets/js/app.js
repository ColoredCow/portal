$(document).ready(function() {
    // Attach click event handler to elements with class 'card-header'
    $('.card-header').on('click', function() {
        var sectionId = $(this).data('target'); // Get the section ID from data-target attribute
        var arrowElement = $(this).find('.arrow'); // Find the arrow element within the clicked card-header

        // Close all sections except the clicked one
        $('.collapse').not(sectionId).removeClass('show');

        // Rotate the arrow of the clicked section
        $('.arrow').not(arrowElement).removeClass('rotate180');
        arrowElement.toggleClass('rotate180');
    });
})

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
