document.addEventListener('DOMContentLoaded', function () {
    const customerTypeField = document.getElementById('customer_type');
    const orgNameTextField = document.getElementById('org_name_text_field');
    const orgNameSelectField = document.getElementById('org_name_select_field');
    const orgNameTextInput = document.getElementById('org_name');
    const orgNameSelectInput = document.getElementById('org_name_select');

    customerTypeField.addEventListener('change', function () {
        if (customerTypeField.value === 'new') {
            orgNameTextField.classList.remove('d-none');
            orgNameSelectField.classList.add('d-none');

            orgNameTextInput.required = true;
            orgNameSelectInput.required = false;
        } else if (customerTypeField.value === 'existing') {
            orgNameTextField.classList.add('d-none');
            orgNameSelectField.classList.remove('d-none');

            orgNameTextInput.required = false;
            orgNameSelectInput.required = true;
        } else {
            orgNameTextField.classList.remove('d-none');
            orgNameSelectField.classList.add('d-none');
            
            orgNameTextInput.required = true;
            orgNameSelectInput.required = false;
        }
    });
});
