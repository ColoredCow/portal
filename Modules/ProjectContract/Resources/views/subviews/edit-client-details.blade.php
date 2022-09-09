<div id="create_project_contract_details_form">
    <div class="card-body">
        <input type="hidden" name="create_project" value="create_project">
        <div class="form-row">
            <div class="form-group col-md-5">
                <label for="client_name" required>Client Name</label>
                <input type="text" class="form-control" name="client_name" id="client_name" placeholder="Enter Client name"
                    required="required" value="{{ old('client_name') }}">
            </div>
            <div class="form-group offset-md-1 col-md-5">
                <label for="authority_name">Authority Name</label>
                <input type="text" class="form-control" name="authority_name" id="authority_name"
                    placeholder="Enter Authority Name" value="{{ old('authority_name') }}">
            </div>
        </div>
        <div class="form-row mt-4">
            <div class="form-group col-md-5">
                <label for="website_url">Website URL</label>
                <input type="url" class="form-control" name="website_url" id="website_url"
                    placeholder="Enter Website url" value="{{ old('website_url') }}">
            </div>
            <div class="form-group offset-md-1 col-md-5">
                <label for="logo_img" class="field-required">Logo Image</label>
                <input type="file" name="logo_img" id="logo_img">
            </div>
        </div>
        <div class="form-row mt-4">
            <div class="form-group offset-md-1 col-md-2" v-if="projectType === 'fixed-budget'">
                <label for="contract_date_for_signing">Contract Date for signing</label>
                <input type="date" class="form-control" name="contract_date_for_signing" id="contract_date_for_signing"
                    value="{{ old('contract_date_for_signing') }}">
            </div>
            <div class="form-group offset-md-1 col-md-2" v-if="projectType === 'fixed-budget'">
                <label for="contract_date_for_effective">Contract Date for Effective</label>
                <input type="date" class="form-control" name="contract_date_for_effective" id="contract_date_for_effective"
                    value="{{ old('contract_date_for_effective') }}">
            </div>
            <div class="form-group offset-md-1 col-md-2" v-if="projectType === 'fixed-budget'">
                <label for="contract_expiry_date">Contract Expiry Date</label>
                <input type="date" class="form-control" name="contract_expiry_date" id="contract_expiry_date"
                     value="{{ old('contract_expiry_date') }}">
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="button" class="btn btn-primary" id="save-btn-action">Create</button>
    </div>
</div>