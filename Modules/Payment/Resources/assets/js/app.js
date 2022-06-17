$(document).ready(function () {
    $(".table-body").on("click", ".add-source", function() {
        $('.add-source').remove();
        var html='';
        var time = Date.now();
        html+='<tr>';
        html+=`<td scope="col"><input type="textarea" class="form-control" name="source[${time}][source]"></td>`;
        html+=`<td scope="col"><input type="textarea" class="form-control" name="source[${time}][${time}][category]"></td>`;
        html+=`<td scope="col"><input type="textarea" class="form-control" name="source[${time}][${time}][value]"></td>`;
        html+=`<td scope="col"><input type="textarea" class="form-control" name="source[${time}][${time}][comment]"></td>`;
        html+='</tr>';
        html+='<tr>';
        html+='<td><div type="button" class="btn btn-primary add-source"><i class="fa fa-plus" aria-hidden="true"></i></div></td>';
        html+=`<td><div type="button" class="btn btn-primary add-category"><i class="fa fa-plus" aria-hidden="true"></i></div></td>`;
        html+='<td></td>';
        html+='<td></td>';
        html+='</tr>';
        $('tbody').append(html);
	});

    $(".table-body").on("click", ".add-category", function() {
        var sourceId = $(this).attr('data-value');
        $('.add-category').remove();
        var time = Date.now();
        var html='';
        html+='<tr>';
        html+='<td></td>';
        html+=`<td scope="col"><input type="textarea" class="form-control" name="source[${sourceId}][${time}][category]"></td>`;
        html+=`<td scope="col"><input type="textarea" class="form-control" name="source[${sourceId}][${time}][value]"></td>`;
        html+=`<td scope="col"><input type="textarea" class="form-control" name="source[${sourceId}][${time}][comment]"></td>`;
        html+='</tr>';
        html+='<tr>';
        html+='<td></td>';
        html+='<td><div type="button" class="btn btn-primary add-category"><i class="fa fa-plus" aria-hidden="true"></i></div></td>';
        html+='<td></td>';
        html+='<td></td>';
        html+='</tr>';
        $('tbody').append(html);
	});
});