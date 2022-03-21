$("#remove_contract_file").on("click", function() {
	$("#upload_contract_file").remove();
});

$("#add_contract_file").on("click", function() {
	var addContractFile = `<div class="form-row col-12" id="upload_contract_file">
		<div class="form-group col-md-5">
			<div class="custom-file mb-3">
				<input type="text" id="contract_file" name="contract_file" class="custom-file-input">
				<label for="contract" class="custom-file-label">Choose file</label>
			</div>
		</div>
		<div class="col-4">
			<button type="button" class="btn btn-danger btn-sm mt-1 ml-2 text-white fz-14" id="remove_contract_file">Remove</button>
		</div>
	</div>`;
	$("#upload_contract_file").append(addContractFile);
});
