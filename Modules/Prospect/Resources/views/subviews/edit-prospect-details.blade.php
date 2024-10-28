<div class="card">
    <form action={{ route('prospect.update', $prospect->id) }} method="POST" enctype="multipart/form-data"
        id="form_project">
        @csrf
        @method('PUT')
        <div id="create_prospect_details_form">
            <div class="card-body">
                <input type="hidden" name="create_prospect" value="create_prospect">
                <div class="form-row">
                    <div class="form-group form-group col-md-5">
                        <label for="name">Organization Name</label>
                        <input type="text" class="form-control" name="org_name" id="org_name"
                            placeholder="Enter Organization Name" value="{{ $prospect->organization_name }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="client_id">ColoredCow POC</label>
                        <select name="poc_user_id" id="poc_user_id" class="form-control">
                            <option value="">Select POC User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ $prospect->poc_user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}</option>
                            @endforeach
                        </select>
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
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="budget">{{ __('Budget') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select name="currency" v-model="currency" id="currency" class="input-group-text">
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->currency }}">{{ $country->currency }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="number" class="form-control" name="budget" placeholder="Enter Budget"
                                id="budget" value="{{ $prospect->budget }}">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="proposal_status">{{ __('Proposal Status') }}</label>
                        <input type="text" class="form-control" name="proposal_status" id="proposal_status"
                            placeholder="Enter Proposal Status" value="{{ $prospect->proposal_status }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="introductory_call">{{ __('Introductory Call') }}</label>
                        <input type="date" class="form-control" name="introductory_call" id="introductory_call"
                            value="{{ $prospect->introductory_call }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="last_followup_date">{{ __('Last Followup Date') }}</label>
                        <input type="date" class="form-control" name="last_followup_date" id="last_followup_date"
                            value="{{ $prospect->last_followup_date }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="rfp_link">{{ __('RFP Link') }}</label>
                        <input type="url" class="form-control" name="rfp_link" id="rfp_link"
                            placeholder="Enter RFP URL" value="{{ $prospect->rfp_link }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="proposal_link">{{ __('Proposal Link') }}</label>
                        <input type="url" class="form-control" name="proposal_link" id="proposal_link"
                            placeholder="Enter Proposal URL" value="{{ $prospect->proposal_link }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>
