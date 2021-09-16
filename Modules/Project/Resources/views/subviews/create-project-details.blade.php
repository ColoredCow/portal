<div class="card-body">
    <input type="hidden" name="create_project" value="create_project">
    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="name" class="field-required">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter project name" required="required"
                value="{{ old('name') }}">
        </div>
        <div class="form-group offset-md-1 col-md-5">
            <label for="client_id" class="field-required">Client</label>
            <select name="client_id" id="client_id" class="form-control" required="required">
                <option value="">Select Client</option>
                @foreach ($clients as $client)
                @php
                $selected = $client->id == old('client_id') ? 'selected="selected"' : '';
                @endphp
                <option value="{{ $client->id }}" {{ $selected }}>{{ $client->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-5">
            <label for="effort_sheet_url">{{ __('Effort-Sheet Url') }}</label>
            <input type="url" class="form-control" 
            name="effort_sheet_url" 
            id="effort_sheet_url" 
            placeholder="Enter Effort-Sheet url" 
            value="{{ old('effort_sheet_url') }}">
        </div>
    </div>
    <br>
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-primary">Create</button>
</div>
