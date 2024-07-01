<form action="{{ route('project.update', $project) }}" method="POST" id="updateProjectDetails"
    enctype="multipart/form-data">
    <div class="card">
        <div id="project_detail_form">
            @csrf
            <input type="hidden" value="project_details" name="update_section">
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="name" class="field-required">Name</label>
                        <input type="text" class="form-control" name="name" id="name"
                            placeholder="Enter project name" required="required"
                            value="{{ old('name') ?: $project->name }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="client_id" class="field-required">Client</label>
                        <select name="client_id" id="client_id" class="form-control" required="required">
                            <option value="">Select Client</option>
                            @foreach ($clients as $client)
                                @php
                                    $selected =
                                        $client->id == $project->client_id || old('client_id') == $client->id
                                            ? 'selected'
                                            : '';
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
                        <label for="name" class="field-required">Billing Cycle</label>
                        <select v-model="projectType" name="project_type" id="project_type" class="form-control"
                            required="required">`
                            @foreach (config('project.type') as $key => $project_type)
                                @php
                                    $selected = $project->type == $key || old('project_type') == $key ? 'selected' : '';
                                @endphp
                                <option value="{{ $key }}" {{ $selected }}>{{ $project_type }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group offset-md-1 col-md-5">
                        <label for="billing_level" class="field-required">Billing Level</label>
                        <span class="ml-2" data-toggle="tooltip" title="Choose effort calculation method: project-specific hours or client-wide aggregate.">
                            <i class="fa fa-info-circle "></i>
                        </span>
                        <select name="billing_level" id="billing_level" class="form-control" required="required">
                            <option value="">{{ __('Select Billing Level') }}</option>
                            @foreach (config('project.meta_keys.billing_level.value') as $key => $billingLevel)
                                @php
                                    $selected =
                                        $project->billing_level == $key || old('billing_level') == $key
                                            ? 'selected'
                                            : '';
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
                        <div class="flex-row">
                            <label for="contract_file"> {{ __('Upload Contract File') }}</label>
                            @can('finance_reports.view')
                                <a class="badge badge-primary p-1 ml-2 text-light" href="{{ route('report.project.contracts.index') }}">Contract Report</a>
                            @endcan
                        </div>
                        <div class="custom-file mb-3">
                            <input type="file" id="contract_file" name="contract_file" class="custom-file-input">
                            <label for="contract_file" class="custom-file-label overflow-hidden">Upload New
                                Contract</label>
                            <div class="indicator" style="margin-top: 3px">
                                @if ($project->projectContracts->isEmpty() == false)
                                    <a id="contract_file mt-5"
                                        style="{{ $project->projectContracts ? '' : 'd-none' }}"
                                        href="{{ route('pdf.show', $project->projectContracts->first()) }}" target="_blank">
                                        <span class="mr-1 underline theme-info fz-16">File: {{ $project->name}}_contract_{{ optional($project->start_date)->format('d M Y')}}</span>
                                        <i class="fa fa-external-link-square fa-1x"></i></a>
                                @endif
                            </div>
                        </div>
                        <div id="client-financial-detail-link" class="text small d-none">
                            Click <a href="{{ route('client.edit', [$client, 'billing-details']) }}">here</a> to update monthly billing invoice terms.
                        </div>
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="google_chat_webhook_url">{{ __('Google Chat Webhook URL') }}</label>
                        <span data-toggle="tooltip" title="Add a webhook URL to receive payment notifications in the project's dedicated Google Chat space.">
                            <i class="fa fa-info-circle "></i>
                        </span>
                        <input type="url" class="form-control" name="google_chat_webhook_url"
                            id="google_chat_webhook_url" placeholder="Enter Google Chat Webhook URL"
                            value="{{ old('google_chat_webhook_url', $project->google_chat_webhook_url) }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group offset-md-1 col-md-2 ml-0" v-if="projectType !== 'non-billable'">
                        <label for="start_date">Start date</label>
                        <input type="date" class="form-control" name="start_date" id="start_date"
                            value="{{ optional($project->start_date)->format('Y-m-d') }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-2" v-if="projectType !== 'non-billable'">
                        <label for="end_date">End date</label>
                        <input type="date" class="form-control" name="end_date" id="end_date"
                            value="{{ optional($project->end_date)->format('Y-m-d') }}">
                    </div>
                    <div class="form-group col-md-5" style="margin-left:8%" v-if="projectType !== 'non-billable'">
                        <label for="total_estimated_hours">{{ __('Total Estimated Hours') }}</label>
                        <input type="number" class="form-control" name="total_estimated_hours"
                            id="total_estimated_hours" placeholder="Enter total estimated hours"
                            value="{{ old('total_estimated_hours', $project->total_estimated_hours) }}">
                    </div>
                </div>
                <div id="invoice-terms-section" class="mt-3 mb-3 d-none">
                    <label for="invoice-schedule">Invoice Schedule</label>
                    <div class="bg-theme-gray-light p-2 rounded">
                        <div class="row mb-3 pt-2" v-for="(invoiceTerm, index) in invoiceTerms" :key="invoiceTerm.id">
                            <input type="hidden" name="invoiceTerm" value="">
                            <input type="hidden" :name="`invoiceTerms[${index}][id]`" v-model="invoiceTerm.id">
                            <div class="col-1 d-flex justify-content-center align-items-center">
                                <div>@{{ index + 1 }}</div>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-3">
                                        <label for="invoice_date"> {{__('Invoice Date')}}</label>
                                        <input id="invoice_date" class="form-control" type="date" :name="`invoiceTerms[${index}][invoice_date]`" v-model="invoiceTerm.invoice_date">
                                    </div>
                                    <div class="col-3">
                                        <label for="invoice_amount"> {{__('Invoice Amount')}}</label>
                                        <div class="input-group">
                                            <input id="invoice_amount" v-model="invoiceTerm.amount" :name="`invoiceTerms[${index}][amount]`" type="number" step="0.01" class="form-control" placeholder="Amount">
                                            <div class="input-group-append">
                                                <span class="input-group-text">{{ optional($project->client->country)->currency }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <label for="confirmation_required"> {{__('Confirmation Required')}}</label>
                                        <select id="confirmation_required" class="form-control" :name="`invoiceTerms[${index}][confirmation_required]`" v-model="invoiceTerm.confirmation_required">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                    <div class="col-3" v-if="invoiceTerm.confirmation_required == 1">
                                        <label for="confirmed"> {{__('Confirmed From Client')}}</label>
                                        <select id="confirmed" class="form-control" :name="`invoiceTerms[${index}][is_confirmed]`" v-model="invoiceTerm.is_confirmed">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row mt-4">
                                    <div class="form-group col-5">
                                        <div class="flex-row">
                                            <label for="delivery_report"> {{ __('Upload Service Delivery Report') }}</label>
                                        </div>
                                        <div class="custom-file mb-3">
                                            <input type="file" id="delivery_report" :name="`invoiceTerms[${index}][delivery_report]`" class="custom-file-input" @change="handleFileUpload($event, index)">
                                            <label for="delivery_report" class="custom-file-label overflow-hidden">Upload New Report</label>
                                            <div v-if="invoiceTerm.delivery_report" class="indicator" style="margin-top: 3px">
                                                <span class="mr-1 underline theme-info fz-16">File: {{ $project->name }}_invoice_term_@{{ index + 1 }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1 d-flex align-items-center">
                                    <button v-on:click="removeProjectInvoiceTerm(index)" type="button" class="btn btn-danger btn-sm text-white fz-14">Remove</button>
                                </div>
                                <hr class="my-3 bg-dark">
                            </div>
                        </div>
                        <div class="ml-9">
                            @if($project->status == 'active')
                                <span id="add-row-btn" v-on:click="addNewProjectInvoiceTerm()" class="btn btn-light btn-sm text-dark ml-6 mt-2">
                                    <i class="fa fa-plus"></i> 
                                    <span v-if="invoiceTerms.length === 0">Schedule An Invoice</span>
                                    <span v-else>Add Another</span>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div>
                    @if ($project->is_amc == 1)
                        AMC: <input type="checkbox" id="isamc" name="is_amc" checked>
                    @else
                        AMC: <input type="checkbox" id="isamc" name="is_amc">
                    @endif
                </div>
            </div>
            <div class="card-footer">
                <div data-id="he" type="button" v-on:click="updateProjectForm('updateProjectDetails')"
                    class="btn btn-primary save-btn">Save</div>
            </div>
        </div>
    </div>
</form>
