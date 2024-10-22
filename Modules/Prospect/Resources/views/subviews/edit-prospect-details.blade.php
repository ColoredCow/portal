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
                        <label for="name" class="field-required">Organization Name</label>
                        <input type="text" class="form-control" name="org_name" id="org_name"
                            placeholder="Enter Organization Name" required="required"
                            value="{{ $prospect->organization_name }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="client_id" class="field-required">ColoredCow POC</label>
                        <select name="poc_user_id" id="poc_user_id" class="form-control" required="required">
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
                        <label for="proposal_sent_date" class="field-required">Proposal Sent Date</label>
                        <input type="date" class="form-control" name="proposal_sent_date" id="proposal_sent_date"
                            value="{{ $prospect->proposal_sent_date }}" required="required">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="domain" class="field-required">{{ __('Domain') }}</label>
                        <input type="text" class="form-control" name="domain" id="domain"
                            placeholder="Enter Domain" value="{{ $prospect->domain }}" required="required">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="customer_type" class="field-required">{{ __('Customer Type') }}</label>
                        <select name="customer_type" id="customer_type" class="form-control" required="required">
                            <option value="">Select Customer Type</option>
                            @foreach (config('prospect.customer-types') as $key => $customer_type)
                                <option value="{{ $key }}"
                                    {{ $prospect->customer_type == $key ? 'selected' : '' }}>
                                    {{ $customer_type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="budget" class="field-required">{{ __('Budget') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select name="currency" v-model="currency" id="currency" class="input-group-text"
                                    required="required">
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->currency }}">{{ $country->currency }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="number" class="form-control" name="budget" placeholder="Enter Budget"
                                required="required" id="budget" step=".01" min="0"
                                value="{{ $prospect->budget }}">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="proposal_status" class="field-required">{{ __('Proposal Status') }}</label>
                        <input type="text" class="form-control" name="proposal_status" id="proposal_status"
                            placeholder="Enter Proposal Status" required="required"
                            value="{{ $prospect->proposal_status }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>
