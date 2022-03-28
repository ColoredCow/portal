<div class="card-body">
    <input type="hidden" name="create_project" value="create_project">
    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="name" class="field-required">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter project name" required="required" value="{{ old('name') }}">
        </div>
        <div class="form-group offset-md-1 col-md-5">
            <label for="client_id" class="field-required">Client</label>
            <select name="client_id" id="client_id" class="form-control" required="required">
                <option value="">Select client</option>
                @foreach ($clients as $client)
                @php
                $selected = $client->id == old('client_id') ? 'selected="selected"' : '';
                @endphp
                <option value="{{ $client->id }}" {{ $selected }}>{{ $client->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-5">
            <label for="effort_sheet_url">{{ __('Effort Sheet URL') }}</label>
            <input type="url" class="form-control" name="effort_sheet_url" id="effort_sheet_url" placeholder="Enter effort sheet url" value="{{ old('effort_sheet_url') }}">
        </div>
        <div class="form-group offset-md-1 col-md-5">
            <label for="project_type" class="field-required">{{ __('Project Type') }}</label>
            <select name="project_type" id="project_type" class="form-control" required>
                <option value="">Select project type</option>
                @foreach (config('project.type') as $key => $project_type)
                @php
                $selected = old('project_type') == $project_type ? 'selected' : '';
                @endphp
                <option value="{{ $key }}" {{ $selected }}>{{ $project_type }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-5">
            <label for="total_estimated_hours">{{ __('Total Estimated Hours') }}</label>
            <input type="number" class="form-control" name="total_estimated_hours" id="total_estimated_hours" placeholder="Enter total estimated hours" value="{{ old('total_estimated_hours') }}">
        </div>
        <div class="form-group offset-md-1 col-md-5">
            <label for="monthly_estimated_hours">{{ __('Monthly Estimated Hours') }}</label>
            <input type="number" class="form-control" name="monthly_estimated_hours" id="monthly_estimated_hours" placeholder="Enter monthly estimated hours" value="{{ old('monthly_estimated_hours') }}">
        </div>
        <div class="form-group col-md-5">
            <label for="contract_file">Upload File</label>
            <div class="custom-file mb-3">
                <input type="file" id="contract_file" name="contract_file" class="custom-file-input">
                <label for="contract" class="custom-file-label">Choose file</label>
            </div>
        </div>
    </div>
<br>
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-primary">Create</button>
</div>