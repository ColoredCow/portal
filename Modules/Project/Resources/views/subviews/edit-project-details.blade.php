<div class="card">
    <div class="card-header" data-toggle="collapse" data-target="#project_detail_form">
        <h4>Project details</h4>
    </div>

    <div id="project_detail_form" class="collapse show">
        <form action="{{ route('project.update', $project) }}" method="POST" id="form_update_project_details">
            @csrf
            <input type="hidden" value="project_details" name="update_section">    
    
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="name" class="field-required">Name</label>
                        <input type="text" class="form-control" 
                            name="name" 
                            id="name" 
                            placeholder="Enter project name" 
                            required="required"
                            value="{{ $project->name }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="client_id" class="field-required">Client</label>
                        <select name="client_id" id="client_id" class="form-control" required="required">
                            <option value="">Select Client</option>
                            @foreach ($clients as $client)
                            @php
                            $selected = $client->id == $project->client_id ? 'selected="selected"' : '';
                            @endphp
                            <option value="{{ $client->id }}" {{ $selected }}>{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="name" class="field-required">Status</label>
                        <select name="status" id="status" class="form-control" required="required">
                            @foreach (config('project.status') as $status => $display_name)
                            @if($project->status == $status) 
                            <option selected="selected" value="{{ $status }}">{{ $display_name }}</option>
                            @else
                            <option value="{{ $status }}">{{ $display_name }}</option>
                            @endif
                            
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="effort_sheet_url">{{ __('Effort-Sheet Url') }}</label>
                        @if($project->effort_sheet_url)
                            <a class="badge badge-primary p-1 ml-2 text-light" target="_blank" href="{{ $project->effort_sheet_url }}">{{ __('view') }}</a>
                        @endif
                        <input type="url" class="form-control" 
                        name="effort_sheet_url" 
                        id="effort_sheet_url" 
                        placeholder="Enter Effortsheet url" 
                        value="{{ old('effort_sheet_url') ?: $project->effort_sheet_url }}">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div data-id="he" type="button"  v-on:click="updateProjectForm('form_update_project_details')" class="btn btn-primary">Update details</div>
            </div>
        </form>
    </div>
    
</div>
