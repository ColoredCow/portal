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

var page = 1; 
$(window).scroll(function() {
	if ($(window).scrollTop() > $(document).height() - $(window).height() - 50) {
		page++
		var offset = page*5;
		loadMoreData(offset);
	}
});
var originalUrl = window.location.origin;
function loadMoreData(offset){
	let url = window.location.href;
	let params = (new URL(url)).searchParams;
	params.get('name') 
	params.get('projects') 
	params.get('status')  
	var data = {
		'offset': offset,
		'name': params.get("name"), 
		'status': params.get("status"), 
		'projects': params.get("projects"),
	}
	$.ajax({
		url : originalUrl + "/projects",
		type: "get",
		data: data,
		contentType:"client/json",
		success: function(response) {
			let value = response.html;
			console.log(value);
			$("#clientList").append(value);
		}
	})
};