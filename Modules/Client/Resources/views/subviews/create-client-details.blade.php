<div class="card-body">
    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="name" class="field-required">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter client name" required="required"
                value="{{ old('name') }}">
        </div>
        <div class="form-group offset-md-1 col-md-5">
            <label for="channel_partner_id" >Channel partner 
                <span class="fz-12 text-muted">(If client belongs to an existing channel partner)</span> 
            </label>
            <select name="channel_partner_id" id="channel_partner_id" class="form-control">
                <option value="">Select channel partner</option>
                @foreach ($channelPartners as $status => $channelPartner)
                    <option value="{{ $channelPartner->id}}">{{ $channelPartner->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <br>
    <div class="form-row">
            <div class=" col-md-5 ">
                <div class="form-check-inline mr-0 form-group">
                    <input type="checkbox" 
                        class="checkbox-custom mb-1.9 mb-1.67 mr-3" 
                        name="is_channel_partner" 
                        id="is_channel_partner"
                        value="1">
                    <label for="is_channel_partner" >Is this client a channel partner?</label>
                </div>

                <div class="form-check-inline mr-0 form-group">
                    <input type="checkbox" class="checkbox-custom mb-1.9 mb-1.67 mr-3" name="has_departments" id="has_departments"
                    value="1">
                    <label for="has_departments" >Has multiple departments?</label>
                </div>
            </div>
     
        

        <div class="form-group offset-md-1 col-md-5">
            <label for="key_account_manager_id">Parent organisation
                <span class="fz-12 text-muted">(If client is a department)</span> 
            </label>
            <select name="parent_organisation_id" id="parent_organisation_id" class="form-control">
                <option value="">Select parent organisation</option>
                @foreach ($parentOrganisations as $key => $parentOrganisation)
                    <option value="{{ $parentOrganisation->id}}">{{ $parentOrganisation->name }}</option>
                @endforeach
            </select>
        </div>

    </div>

</div>
<div class="card-footer">
    <button type="submit" class="btn btn-primary">Create</button>
</div>