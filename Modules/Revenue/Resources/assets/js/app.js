$("#modalEdit").on("show.bs.modal", function (e) {
	const revenueProceedEdited = e.relatedTarget;
	const revenueProceed = $(revenueProceedEdited).data("json");

	const editForm = $(this).find("form");
	const newId = editForm.find("input.hidden");
	const value = newId.attr("value");
	const action = value.replace("id", revenueProceed.id);

	editForm.attr("action", action);

	editForm.find("input[name='category']").val(revenueProceed.category);
	editForm.find("input[name='name']").val(revenueProceed.name);
	editForm.find("input[name='amount']").val(revenueProceed.amount);
	editForm.find("input[name='currency']").val(revenueProceed.currency);
	editForm.find("input[name='recieved_at']").val(revenueProceed.recieved_at);
	editForm.find("input[name='notes']").val(revenueProceed.notes);
});
$("body").on("click","#deleteRevenue",function(){
	alert("Are you sure?");
});
