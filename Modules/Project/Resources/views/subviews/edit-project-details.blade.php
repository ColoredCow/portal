<div class="card">
    <div class="card-header">
    </div>

    <div id="project_detail_form">
        <form action="{{ route('project.update', $project) }}" method="POST" id="form_update_project_details">
            @csrf
            <input type="hidden" value="project_details" name="update_section">

            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="name" class="field-required">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter project name"
                            required="required" value="{{ old('name') ?: $project->name }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="client_id" class="field-required">Client</label>
                        <select name="client_id" id="client_id" class="form-control" required="required">
                            <option value="">Select Client</option>
                            @foreach ($clients as $client)
                                @php
                                    $selected = ($client->id == $project->client_id || old('client_id') == $client->id) ? 'selected' : '';
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
                                @if ($project->status == $status || old('status') == $status)
                                    <option selected value="{{ $status }}">{{ $display_name }}
                                    </option>
                                @else
                                    <option value="{{ $status }}">{{ $display_name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="effort_sheet_url">{{ __('Effort Sheet URL') }}</label>
                        <a id="view_effort_sheet_badge"
                            class="badge badge-primary p-1 ml-2 text-light {{ $project->effort_sheet_url ? '' : 'd-none' }}"
                            target="_blank" href="{{ $project->effort_sheet_url }}">{{ __('view') }}</a>
                        <input type="url" class="form-control" name="effort_sheet_url" id="effort_sheet_url"
                            placeholder="Enter Effort Sheet URL"
                            value="{{ old('effort_sheet_url') ?: $project->effort_sheet_url }}">
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="total_estimated_hours">{{ __('Total Estimated Hours') }}</label>
                        <input type="number" class="form-control" name="total_estimated_hours"
                            id="total_estimated_hours" placeholder="Enter total estimated hours"
                            value="{{ old('total_estimated_hours') ?: $project->total_estimated_hours }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="monthly_estimated_hours">{{ __('Monthly Estimated Hours') }}</label>
                        <input type="number" class="form-control" name="monthly_estimated_hours"
                            id="monthly_estimated_hours" placeholder="Enter monthly estimated hours"
                            value="{{ old('monthly_estimated_hours') ?: $project->monthly_estimated_hours }}">
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="name" class="field-required">Project Type</label>
                        <select name="project_type" id="project_type" class="form-control" required="required">
                            @foreach (config('project.type') as $key => $project_type)
                                @php
                                    $selected = ($project->type == $key || old('project_type') == $key) ? 'selected' : '';
                                @endphp
                                <option value="{{ $key }}" {{ $selected }}>{{ $project_type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div data-id="he" type="button" v-on:click="updateProjectForm('form_update_project_details')"
                    class="btn btn-primary save-btn">Save</div>
            </div>
        </form>
    </div>

</div>
