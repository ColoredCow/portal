window.toggleAccordion = function toggleAccordion(sectionId, arrowElement) 
{
    console.log("inside toggleAccordion");
    var section = document.getElementById(sectionId);
    var allSections = document.querySelectorAll('.collapse');
    var allArrows = document.querySelectorAll('.arrow');
    
    // Close all sections except the clicked one
    allSections.forEach(function(sec) {
        console.log("section toggle");
        if (sec.id !== sectionId) {
            sec.classList.remove('show');
        }
    });
    // Rotate the arrow of the clicked section
    allArrows.forEach(function(arrow) {
        console.log("arrow");
        if (arrow === arrowElement.querySelector('.arrow')) {
            arrow.classList.toggle('rotate180');
        } else {
            arrow.classList.remove('rotate180');
        }
    });
}

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
