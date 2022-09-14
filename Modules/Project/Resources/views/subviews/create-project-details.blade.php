<div id="create_project_details_form">
    <div class="card-body">
        <input type="hidden" name="create_project" value="create_project">
        <div class="form-row">
            <div class="form-group col-md-5">
                <label for="name" class="field-required">Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter project name"
                    required="required" value="{{ old('name') }}">
            </div>
            <div class="form-group offset-md-1 col-md-5">
                <label for="client_id" class="field-required">Client</label>
                <select name="client_id" id="client_id" class="form-control" required="required">
                    <option value="">Select client</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-5">
                <label for="effort_sheet_url">{{ __('Effort Sheet URL') }}</label>
                <input type="url" class="form-control" name="effort_sheet_url" id="effort_sheet_url"
                    placeholder="Enter effort sheet url" value="{{ old('effort_sheet_url') }}">
            </div>
            <div class="form-group offset-md-1 col-md-5">
                <label for="project_type" class="field-required">{{ __('Project Type') }}</label>
                <select v-model="projectType" name="project_type" id="project_type" class="form-control" required>
                    <option value="">Select project type</option>
                    @foreach (config('project.type') as $key => $project_type)
                        <option value="{{ $key }}" {{ old('project_type') == $key ? 'selected' : '' }}>{{ $project_type }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-5">
                <label for="contract_file"> {{ __('Upload Contract File') }}</label>
                <div class="custom-file">
                    <input type="file" id="contract_file" name="contract_file" class="custom-file-input">
                    <label for="contract" class="custom-file-label">Choose file</label>
                </div>
            </div>
            <div class="form-group offset-md-1 col-md-5">
                <label for="billing_level" class="field-required">Billing Level</label>
                <select name="billing_level" id="billing_level" class="form-control" required="required">
                    <option value="">{{ __('Select Billing Level') }}</option>
                    @foreach (config('project.meta_keys.billing_level.value') as $key => $billingLevel)
                        <option value="{{ $key }}">{{ $billingLevel['label'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-5">
                <label for="google_chat_webhook_url">{{ __('Google Chat Webhook URL') }}</label>
                <input type="url" class="form-control" name="google_chat_webhook_url" id="google_chat_webhook_url"
                    placeholder="Enter Google Chat Webhook URL"
                    value="{{ old('google_chat_webhook_url') }}">
            </div>
            <div class="form-group offset-md-1 col-md-5">
                <input type="checkbox" id="isamc" name="isamc">
                <label for="isamc">AMC</label><br>
            </div>
            <div class="form-group offset col-md-2" v-if="projectType === 'fixed-budget'">
                <label for="start_date">Start Date</label>
                <input type="date" class="form-control" name="start_date" id="startDate"
                    value="{{ old('start_date') }}">
            </div>
            <div class="form-group offset-md-1 col-md-2" v-if="projectType === 'fixed-budget'">
                <label for="end_date">End Date</label>
                <input type="date" class="form-control" name="end_date" id="endDate"
                     value="{{ old('start_date') }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-5" v-if="projectType ==='fixed-budget'">
                <label for="total_estimated_hours">{{ __('Total Estimated Hours') }}</label>
                <input type="number" class="form-control" name="total_estimated_hours" id="total_estimated_hours"
                    placeholder="Enter total estimated hours" value="{{ old('total_estimated_hours') }}">
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="button" class="btn btn-primary" id="save-btn-action">Create</button>
    </div>
</div>

@section('js_scripts')
    <script>
        new Vue({
        el: '#create_project_details_form',
            data() {
                return{
                    projectType: '',
                }
            },
            methods: {
            },
        });
    </script>
@endsection
