const CUSTOMER_TYPES = {
    NEW: 'new',
    EXISTING: 'existing',
    DORMANT: 'dormant'
};
document.addEventListener('DOMContentLoaded', function () {
    const customerTypeField = document.getElementById('customer_type');
    const orgNameTextField = document.getElementById('org_name_text_field');
    const orgNameSelectField = document.getElementById('org_name_select_field');
    const orgNameTextInput = document.getElementById('org_name');
    const orgNameSelectInput = document.getElementById('org_name_select');

    function toggleOrgNameField() {
        if (customerTypeField.value === CUSTOMER_TYPES.NEW) {
            orgNameTextField.classList.remove('d-none');
            orgNameSelectField.classList.add('d-none');
            orgNameTextInput.required = true;
            orgNameSelectInput.value = null;
            orgNameSelectInput.required = false;
        } else if (customerTypeField.value === CUSTOMER_TYPES.EXISTING) {
            orgNameTextField.classList.add('d-none');
            orgNameSelectField.classList.remove('d-none');
            orgNameSelectInput.required = true;
            orgNameTextInput.required = false;
            orgNameTextInput.value = null;
        } else {
            orgNameTextField.classList.remove('d-none');
            orgNameSelectField.classList.add('d-none');
            orgNameTextInput.required = true;
            orgNameSelectInput.value = null;
            orgNameSelectInput.required = false;
        }
    }

    toggleOrgNameField();

    customerTypeField.addEventListener('change', toggleOrgNameField);
});
