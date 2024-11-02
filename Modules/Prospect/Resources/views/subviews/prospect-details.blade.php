<div class="card-header d-flex" data-toggle="collapse" data-target="#prospect-details">
    <h5 class="font-weight-bold">Prospect Details</h5>
    <span class="arrow ml-auto">&#9660;</span>
</div>
<div id="prospect-details" class="collapse card mt-3 show">
    <div class="panel-body">
        <br>
        <div class="form-row">
            <div class="col-md-6">
                <div class="form-group col-md-12">
                    <label for="org_name" class="font-weight-bold">Organization Name:</label>
                    <span class="ml-2">{{ $prospect->getProspectDisplayName() }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group col-md-12">
                    <label for="poc_user_id" class="font-weight-bold">ColoredCow POC:</label>
                    <span class="ml-2">{{ $prospect->pocUser->name ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-6">
                <div class="form-group col-md-12">
                    <label for="org_name" class="font-weight-bold">Project Name:</label>
                    <span class="ml-2">{{ $prospect->project_name ?? 'N/A' }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group col-md-12">
                    <label for="proposal_sent_date" class="font-weight-bold">Proposal Sent Date:</label>
                    <span
                        class="ml-2">{{ $prospect->proposal_sent_date ? $prospect->getFormattedDate($prospect->proposal_sent_date) : 'N/A' }}</span>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-6">
                <div class="form-group col-md-12">
                    <label for="domain" class="font-weight-bold">Domain:</label>
                    <span class="ml-2">{{ $prospect->domain ?? 'N/A' }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group col-md-12">
                    <label for="customer_type" class="font-weight-bold">Customer Type:</label>
                    <span
                        class="ml-2">{{ config('prospect.customer-types')[$prospect->customer_type] ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-6">
                <div class="form-group col-md-12">
                    <label for="budget" class="font-weight-bold">Budget:</label>
                    <span class="ml-2">
                        {{ isset($prospect->currency) && isset($currencySymbols[$prospect->currency]) ? $currencySymbols[$prospect->currency] : '' }}
                        {{ $prospect->budget ? round($prospect->budget, 2) : 'N/A' }}
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group col-md-12">
                    <label for="last_followup_date" class="font-weight-bold">Last Followup Date:</label>
                    <span
                        class="ml-2">{{ $prospect->last_followup_date ? $prospect->getFormattedDate($prospect->last_followup_date) : 'N/A' }}</span>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-6">
                <div class="form-group col-md-12">
                    <label for="introductory_call" class="font-weight-bold">Introductory Date:</label>
                    <span
                        class="ml-2">{{ $prospect->introductory_call ? $prospect->getFormattedDate($prospect->introductory_call) : 'N/A' }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group col-md-12">
                    <label for="proposal_status" class="font-weight-bold">Proposal Status:</label>
                    <span class="ml-2">{{ config('prospect.status')[$prospect->proposal_status] ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-6">
                <div class="form-group col-md-12">
                    <label for="proposal_url" class="font-weight-bold">Proposal Link:</label>
                    @if ($prospect->proposal_link)
                        <a href="{{ $prospect->proposal_link }}" target="_blank" class="ml-2">View <i
                                class="fa fa-external-link"></i></a>
                    @else
                        <span class="ml-2">N/A</span>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group col-md-12">
                    <label for="rfp_url" class="font-weight-bold">RFP Link:</label>
                    @if ($prospect->rfp_link)
                        <a href="{{ $prospect->rfp_link }}" target="_blank" class="ml-2">View <i
                                class="fa fa-external-link"></i></a>
                    @else
                        <span class="ml-2">N/A</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
