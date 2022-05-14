<div class="card">
 
    <div id="client_detail_form" class="collapse show" data-parent="#edit_client_form_container">
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="name" class="field-required">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter client name"
                        required="required" value="{{ $client->name }}">
                </div>
                <div class="form-group col-md-5 offset-md-1">
                    <label for="status" class="field-required">Status</label>
                    <span class="ml-2" data-toggle="tooltip" data-placement="right" title="If mark inactive then all the projects associated to the client will be marked as inactive."><i class="fa fa-question-circle"></i>&nbsp;</span>
                    <select name="status" id="status" class="form-control" required="required">
                        <option value="">Select status</option>
                        @foreach (config('client.status') as $status => $label)
                        <option {{ ($status == $client->status) ? 'selected=selected' : '' }} value="{{ $status }}" {{ $label == config('client.status.active') ? 'disabled' : '' }}>
                            {{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <br>
            <div class="form-row">
                <div class=" col-md-5 form-check-inline mr-0 form-group">
                        <input type="checkbox" 
                            class="checkbox-custom mb-1.9 mb-1.67 mr-3" 
                            name="is_channel_partner" 
                            id="is_channel_partner"
                            {{ ($client->is_channel_partner) ? 'checked=checked' : '' }}
                            value="1">
                        <label for="is_channel_partner">Is this client a channel partner?
                            <span data-toggle="tooltip" data-placement="right" title="Check if this client will have multiple sub clients."><i class="fa fa-question-circle"></i>&nbsp;</span>
                        </label>
                </div>
                <div class="form-group offset-md-1 col-md-5">
                    <label for="channel_partner_id" >Channel partner 
                        <span data-toggle="tooltip" data-placement="right" title="If this client came via a channel partner then link that client from here."><i class="fa fa-question-circle"></i>&nbsp;</span>
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

            <div class="form-row">
                <div class=" col-md-5 form-check-inline mr-0 form-group">
                    <input type="checkbox" {{ ($client->has_departments) ? 'checked=checked' : '' }} class="checkbox-custom mb-1.9 mb-1.67 mr-3" name="has_departments" id="has_departments"
                        value="1">
                    <label for="has_departments">Has multiple departments?
                        <span data-toggle="tooltip" data-placement="right" title="Check if this client will have multiple departments as a new client."><i class="fa fa-question-circle"></i>&nbsp;</span>
                    </label>
                </div>
                <div class="form-group offset-md-1 col-md-5">
                    <label for="key_account_manager_id">Parent organisation
                        <span data-toggle="tooltip" data-placement="right" title="If this client is a department of another client then link that organisation from here."><i class="fa fa-question-circle"></i>&nbsp;</span>
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


        </div>
        <div class="card-footer">
            @include('client::subviews.edit-client-form-submit-buttons')
        </div>
    </div>

</div>