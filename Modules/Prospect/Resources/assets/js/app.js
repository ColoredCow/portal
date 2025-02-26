const CUSTOMER_TYPES = {
	NEW: "new",
	EXISTING: "existing",
	DORMANT: "dormant"
};

const PROPOSAL_STATUS = {
	PENDING: "pending",
	DISCUSSION_ONGOING: "discussions-ongoing", 
	CONVERTED: "converted",
	REJECTED: "rejected",
	CLIENT_UNRESPONSIVE: "client-unresponsive",
	FINAL_DECISION_PENDING: "final-decision-pending"
};

document.addEventListener("DOMContentLoaded", function () {
	const customerTypeField = document.getElementById("customer_type");
	const orgNameTextField = document.getElementById("org_name_text_field");
	const orgNameSelectField = document.getElementById("org_name_select_field");
	const orgNameTextInput = document.getElementById("org_name");
	const orgNameSelectInput = document.getElementById("org_name_select");
	const proposalStatus = document.getElementById("proposal_status");
	const updateAndCreateProjectButton = document.getElementById("update_create_project_button");

	function toggleOrgNameField() {
		if (customerTypeField.value === CUSTOMER_TYPES.NEW) {
			orgNameTextField.classList.remove("d-none");
			orgNameSelectField.classList.add("d-none");
			orgNameTextInput.required = true;
			orgNameSelectInput.value = "";
			orgNameSelectInput.required = false;
		} else if (customerTypeField.value === CUSTOMER_TYPES.EXISTING) {
			orgNameTextField.classList.add("d-none");
			orgNameSelectField.classList.remove("d-none");
			orgNameSelectInput.required = true;
			orgNameTextInput.required = false;
			orgNameTextInput.value = null;
		} else {
			orgNameTextField.classList.remove("d-none");
			orgNameSelectField.classList.add("d-none");
			orgNameTextInput.required = true;
			orgNameSelectInput.value = "";
			orgNameSelectInput.required = false;
		}
	}

	function toggleUpdateAndCreateProjectButton() {
		if(proposalStatus.value === PROPOSAL_STATUS.CONVERTED) {
			updateAndCreateProjectButton.classList.remove("d-none");
		} else {
			updateAndCreateProjectButton.classList.add("d-none");
		}
	}

	toggleOrgNameField();
	toggleUpdateAndCreateProjectButton();

	customerTypeField.addEventListener("change", toggleOrgNameField);
	proposalStatus.addEventListener("change", toggleUpdateAndCreateProjectButton);
});
