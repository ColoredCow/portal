<div class="card">
    <form action={{ route('prospect.update', $prospect->id) }} method="POST" enctype="multipart/form-data"
        id="form_project">
        @csrf
        @method('PUT')
        <div id="create_prospect_details_form">
            <div class="card-body">
                <input type="hidden" name="create_prospect" value="create_prospect">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="customer_type">{{ __('Customer Type') }}</label>
                        <select name="customer_type" id="customer_type" class="form-control">
                            <option value="">Select Customer Type</option>
                            @foreach (config('prospect.customer-types') as $key => $customer_type)
                                <option value="{{ $key }}"
                                    {{ $prospect->customer_type == $key ? 'selected' : '' }}>
                                    {{ $customer_type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group offset-md-1 col-md-5" id="org_name_text_field">
                        <label for="org_name" class="field-required">Organization Name</label>
                        <input type="text" class="form-control" name="org_name" id="org_name"
                            placeholder="Enter Organization Name" value="{{ $prospect->organization_name }}" required>
                    </div>

                    <div class="form-group offset-md-1 col-md-5 d-none" id="org_name_select_field">
                        <label for="client" class="field-required">Organization Name</label>
                        <select class="form-control" name="client_id" id="org_name_select" required="required">
                            <option value="">Select Organization Name</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}"
                                    {{ $prospect->client ? ($prospect->client->id == $client->id ? 'selected' : '') : '' }}>
                                    {{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="client_id">ColoredCow POC</label>
                        <select name="poc_user_id" id="poc_user_id" class="form-control">
                            <option value="">Select POC User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ $prospect->pocUser->id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group offset-md-1 col-md-5" id="org_name_text_field">
                        <label for="project_name">Project Name</label>
                        <input type="text" class="form-control" name="project_name" id="project_name"
                            placeholder="Enter Project Name" value="{{ $prospect->project_name }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="proposal_sent_date">Proposal Sent Date</label>
                        <input type="date" class="form-control" name="proposal_sent_date" id="proposal_sent_date"
                            value="{{ $prospect->proposal_sent_date }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="domain">{{ __('Domain') }}</label>
                        <input type="text" class="form-control" name="domain" id="domain"
                            placeholder="Enter Domain" value="{{ $prospect->domain }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="budget">{{ __('Budget') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select name="currency" v-model="currency" id="currency" class="input-group-text">
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->currency }}"
                                            {{ $prospect->currency == $country->currency ? 'selected' : '' }}>
                                            {{ $country->currency }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="number" class="form-control" name="budget" placeholder="Enter Budget"
                                id="budget" value="{{ $prospect->budget }}">
                        </div>
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="proposal_status">{{ __('Proposal Status') }}</label>
                        <select name="proposal_status" id="proposal_status" class="form-control">
                            <option value="">Select Prospect Status</option>
                            @foreach (config('prospect.status') as $key => $status)
                                <option value="{{ $key }}"
                                    {{ $prospect->proposal_status == $key ? 'selected' : '' }}>
                                    {{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="introductory_call">{{ __('Introductory Call') }}</label>
                        <input type="date" class="form-control" name="introductory_call" id="introductory_call"
                            value="{{ $prospect->introductory_call }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="last_followup_date">{{ __('Last Followup Date') }}</label>
                        <input type="date" class="form-control" name="last_followup_date" id="last_followup_date"
                            value="{{ $prospect->last_followup_date }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="rfp_link">{{ __('RFP Link') }}</label>
                        <input type="url" class="form-control" name="rfp_link" id="rfp_link"
                            placeholder="Enter RFP URL" value="{{ $prospect->rfp_link }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="proposal_link">{{ __('Proposal Link') }}</label>
                        <input type="url" class="form-control" name="proposal_link" id="proposal_link"
                            placeholder="Enter Proposal URL" value="{{ $prospect->proposal_link }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" name="action" value="update" class="btn btn-primary">Update</button>
            @if($prospect->customer_type === "existing")
            <button type="submit" name="action" id="update_create_project_button" value="update_create_project" class="btn ml-3 d-none btn-primary">Update and Create Project</button>
            @endif
        </div>
    </form>
</div>
