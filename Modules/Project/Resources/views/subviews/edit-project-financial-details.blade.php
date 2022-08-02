<div class="card">
    <div class="card-header">
    </div>
    <div id="projectFinancialDetailsForm">
        <form action="{{ route('project.update', $project) }}" method="POST" id="updateProjectFinancialDetails" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="project_financial_details" name="update_section">
            <input type="hidden" name="currency" value="{{ $project->client->country->currency }}">
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="service_rates">Service Rates</label>
                        <div class="d-flex justify-content-between">
                            <div class="input-group mr-5">
                                <input value="{{ optional($project->billingDetail)->service_rates }}" name="service_rates" type="number" step="0.01" class="form-control" placeholder="amount">
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ $project->client->country->currency }}</span>
                                </div>
                            </div>

                            <select name="service_rate_term" class="form-control">
                                @foreach (config('client.service-rate-terms') as $serviceRateTerm)
                                    <option {{ optional($project->billingDetail)->service_rate_term == $serviceRateTerm['slug'] ? 'selected=selected' : '' }} value="{{ $serviceRateTerm['slug'] }}">{{ $serviceRateTerm['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <br>
            </div>
            <div class="card-footer">
                <div type="button" v-on:click="updateProjectForm('updateProjectFinancialDetails')" class="btn btn-primary save-btn">Save</div>
            </div>
        </form>
    </div>

</div>
