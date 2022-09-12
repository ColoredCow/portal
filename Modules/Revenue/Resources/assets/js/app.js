$("#modalEdit").on("show.bs.modal", function (e) {
  const revenueEdited = e.relatedTarget; // edit button
  const revenue = $(revenueEdited).data("json");

  const editForm = $(this).find("form");
  const newId = editForm.find("input.hidden");
  const value = newId.attr("value");
  const action = value.replace("id", revenue.id);

  editForm.attr("action", action);

  editForm.find("input[name='category']").val(revenue.category);
  editForm.find("input[name='name']").val(revenue.name);
  editForm.find("input[name='amount']").val(revenue.amount);
  editForm.find("input[name='currency']").val(revenue.currency);
  editForm.find("input[name='recieved_at']").val(revenue.recieved_at);
  editForm.find("input[name='notes']").val(revenue.notes);
});
$("body").on("click","#deleteRevenue",function(){
  alert("Are you sure?");
});
