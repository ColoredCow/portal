<div class="card">
    <div class="card-header">
        <span>Client type details</span>
    </div>
    <div>
            <div class="card-body">
                <div class="form-row">
                    <div class=" col-md-5 form-check-inline mr-0 form-group">
                        <input type="checkbox" 
                            class="checkbox-custom mb-1.9 mb-1.67 mr-3" 
                            name="is_channel_partner" 
                            id="is_channel_partner"
                            {{ ($client->is_channel_partner) ? 'checked=checked' : '' }}
                            value="1">
                        <label for="is_channel_partner" >Is this client a channel partner?</label>
                    </div>
    
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="channel_partner_id" >Channel partner 
                            <span class="fz-12 text-muted">(If client belongs to an existing channel partner)</span> 
                        </label>
                        <select name="channel_partner_id" id="channel_partner_id" class="form-control">
                            <option value="">Select channel partner</option>
                            @foreach ($channelPartners as $status => $channelPartner)
                            @if($client->channel_partner_id == $channelPartner->id)
                                <option selected="selected" value="{{ $channelPartner->id}}">{{ $channelPartner->name }}</option>
                            @else
                                <option value="{{ $channelPartner->id}}">{{ $channelPartner->name }}</option>
                            @endif
                        
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
    
                <div class="form-row">
                    <div class=" col-md-5 form-check-inline mr-0 form-group">
                        <input type="checkbox" {{ ($client->has_departments) ? 'checked=checked' : '' }} class="checkbox-custom mb-1.9 mb-1.67 mr-3" name="has_departments" id="has_departments"
                            value="1">
                        <label for="has_departments" >Has multiple departments</label>
                    </div>
    
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="key_account_manager_id">Parent organisation
                            <span class="fz-12 text-muted">(If client is a department of existing organisation)</span> 
                        </label>
                        <select name="parent_organisation_id" id="parent_organisation_id" class="form-control">
                            <option value="">Select parent organisation</option>
                            @foreach ($parentOrganisations as $key => $parentOrganisation)
                                @if($client->parent_organisation_id == $parentOrganisation->id)
                                    <option selected="selected" value="{{ $parentOrganisation->id}}">{{ $parentOrganisation->name }}</option>
                                @else
                                    <option value="{{ $parentOrganisation->id}}">{{ $parentOrganisation->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
    </div>
   
</div>