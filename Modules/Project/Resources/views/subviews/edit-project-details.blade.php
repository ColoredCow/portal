<div id="edit_project_details_form">
    <div class="card">
        <div id="project_detail_form">
            <form action="{{ route('project.update', $project) }}" method="POST" id="updateProjectDetails" enctype="multipart/form-data">
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
                            <label for="name" class="field-required">Project Type</label>
                            <select v-model="projectType"  name="project_type" id="project_type" class="form-control" required="required">`
                                @foreach (config('project.type') as $key => $project_type)
                                    @php
                                        $selected = ($project->type == $key || old('project_type') == $key) ? 'selected' : '';
                                    @endphp
                                    <option value="{{ $key }}" {{ $selected }}>{{ $project_type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                            <label for="billing_level" class="field-required">Billing Level</label>
                            <select name="billing_level" id="billing_level" class="form-control" required="required">
                                <option value="">{{ __('Select Billing Level') }}</option>
                                @foreach (config('project.meta_keys.billing_level.value') as $key => $billingLevel)
                                    @php
                                        $selected = ($project->billing_level == $key || old('billing_level') == $key) ? 'selected' : '';
                                    @endphp
                                    <option value="{{ $key }}" {{ $selected }}>{{ $billingLevel['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="contract_file"> {{ __('Upload Contract File') }}</label>
                            @if($project->projectContracts->isEmpty() == false)
                                <a id="contract_file"
                                    class="badge badge-primary p-1 ml-2 text-light {{ $project->projectContracts ? '' : 'd-none' }}"
                                    target="_blank" href="{{route('pdf.show', $project->projectContracts->first())}}">
                                    {{ __('view') }}
                                </a>
                            @endif
                            <div class="custom-file mb-3">
                                <input type="file" id="contract_file" name="contract_file" class="custom-file-input">
                                <label for="contract_file" class="custom-file-label overflow-hidden" >Upload New Contract</label>
                            </div>
                        </div>
                        <div class="form-group offset-md-1 col-md-2" v-if="projectType == 'fixed-budget'">
                            <label for="start_date">Start date</label>
                            <input type="date" class="form-control" name="start_date" id="start_date"
                                value="{{ optional($project->start_date)->format('Y-m-d') }}">
                        </div>
                        <div class="form-group offset-md-1 col-md-2" v-if="projectType == 'fixed-budget'">
                            <label for="end_date">End date</label>
                            <input type="date" class="form-control" name="end_date" id="end_date"
                                value="{{ optional($project->end_date)->format('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="google_chat_webhook_url">{{ __('Google Chat Webhook URL') }}</label>
                            <input type="url" class="form-control" name="google_chat_webhook_url" id="google_chat_webhook_url"
                                placeholder="Enter Google Chat Webhook URL"
                                value="{{ old('google_chat_webhook_url') ?: $project->google_chat_webhook_url }}">
                        </div>
                    </div>
                </form>
            </div>
        <div class="card-footer">
            <div data-id="he" type="button" v-on:click="updateProjectForm('form_update_project_details')"
                class="btn btn-primary save-btn">Save</div>
        </div>
    </div>
</div>

@section('vue_scripts')
    <script>
        new Vue({
        el: '#edit_project_details_form',
            data() {
                return {
                    projectType: "{{ $project->type }}",
                }
            },
        });
    </script>
@endsection
