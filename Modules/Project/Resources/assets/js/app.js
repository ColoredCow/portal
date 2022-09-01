const { data } = require("jquery");

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
        if($(window).scrollTop() + $(window).height() >= $(document).height()) {
            page++
            var offset = page;
            loadMoreData(offset);
        }
    });
    var originalUrl = window.location.origin;
    function loadMoreData(offset){
    $.ajax({
       url : originalUrl + "/projects",
       type: "get",
       data: {
        'offset': offset,
        'projects': 'all-projects', 
       },
       contentType:"client/json",
       success: function(response) {
        const clients = response.clients;
        Object.keys(clients).forEach((value, index) => {
            const client = clients[value]

        let clientHtml = `<tr class="bg-theme-warning-lighter"><td colspan="4" class="font-weight-bold"><div class="d-flex justify-content-between"><div>
            ${client.name}
            </div><div>Total Hours Booked: ${client.is_channel_partner}</div></div></td></tr>`
            $('table.table-striped > tbody').append(clientHtml)

        client.projects.forEach((project, index) => {
            let projectHtml = `<tr><td class="w-33p"><div class="pl-2 pl-xl-3"><a href="http://portal.test/projects/66/show">${project.name}</a></div></td><td class="w-20p"></td><td><span class="badge badge-light border border-dark rounded-0"></span></td> <td class="w-20p"><a href="http://portal.test/effort-tracking/project/66" class="text-danger"><i class="mr-0.5 fa fa-external-link-square"></i></a> <span class="text-danger font-weight-bold">${client.has_departments}</span></td></tr>`
            $('table.table-striped > tbody').append(projectHtml)

            })
            })
        }
    })};

// type="text/javascript">
// console.log('kk');
// 	// var clients = 1;
// 	$(window).scroll(function() {
// 	    if($(window).scrollTop() + $(window).height() >= $(document).height()) {
// 	    clients++;
// 	        loadMoreData(clients);
// 	    }
// 	});


// 	function load(data){
// 	  $.ajax(
// 	        {
// 	            url: "/",
// 	            type: "get",
// 	            beforeSend: function()
// 	            {
// 	                $('.ajax-load').show();
// 	            }
// 	        })
// 	        .done(function(data)
// 	        {
// 	            if(data.html == " "){
// 	                $('.ajax-load').html("No more records found");
// 	                return;
// 	            }
// 	            $('.ajax-load').hide();
// 	            $("#post-data").append(html);
// 	        })
// 	        .fail(function(jqXHR, ajaxOptions, thrownError)
// 	        {
// 	              alert('server not responding...');
// 	        });
// 	}
