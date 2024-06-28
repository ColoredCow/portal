<div class="card">
    <div id="projectFinancialDetailsForm">
        <form action="{{ route('project.update', $project) }}" method="POST" id="updateProjectFinancialDetails"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="project_financial_details" name="update_section">
            <input type="hidden" name="currency" value="{{ optional($project->client->country)->currency }}">
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="service_rates">Service Rates</label>
                        <div class="d-flex justify-content-between">
                            <div class="input-group mr-5">
                                <input value="{{ optional($project->billingDetail)->service_rates }}"
                                    name="service_rates" type="number" step="0.01" class="form-control"
                                    placeholder="amount">
                                <div class="input-group-append">
                                    <span
                                        class="input-group-text">{{ optional($project->client->country)->currency }}</span>
                                </div>
                            </div>

                            <select name="service_rate_term" class="form-control">
                                @foreach (config('client.service-rate-terms') as $serviceRateTerm)
                                    <option
                                        {{ optional($project->billingDetail)->service_rate_term == $serviceRateTerm['slug'] ? 'selected=selected' : '' }}
                                        value="{{ $serviceRateTerm['slug'] }}">{{ $serviceRateTerm['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                {{-- <div class="mt-3">
                    <label for="invoice-schedule" class="font-weight-bold">Invoice Schedule</label>
                    <div class="row mt-2 fz-16 font-weight-bold align-items-center">
                      <div class="col-1 text text-center">
                        S. No.
                      </div>
                      <div class="col-3 text text-center">
                        Invoice Date
                      </div>
                      <div class="col-3 text text-center">
                        Amount
                      </div>
                    </div>
                    <div class="row mb-3 pt-2" v-for="(invoiceTerm, index) in invoiceTerms" :key="invoiceTerm.id">
                      <input type="hidden" name="invoiceTerm" value="">
                      <input type="hidden" :name="`invoiceTerms[${index}][id]`" v-model="invoiceTerm.id">
                      <div class="col-1 font-weight-bold text text-center" v-pre>
                        <div v-text="index + 1"></div>
                      </div>
                      <div class="col-3">
                        <input class="form-control" type="date" :name="`invoiceTerms[${index}][invoice_date]`" v-model="invoiceTerm.invoice_date">
                      </div>
                      <div class="input-group col-3">
                        <input v-model="invoiceTerm.amount" :name="`invoiceTerms[${index}][amount]`" type="number" step="0.01" class="form-control" placeholder="amount">
                        <div class="input-group-append">
                          <span class="input-group-text">{{ optional($project->client->country)->currency }}</span>
                        </div>
                      </div>
                      <div class="col-1">
                        <button v-on:click="removeProjectInvoiceTerm(index)" type="button" class="btn btn-danger btn-sm mt-1 ml-2 text-white fz-14">Remove</button>
                      </div>
                    </div>
                </div> --}}

            @if($project->status == 'active')
            <span id="add-row-btn" v-on:click="addNewProjectInvoiceTerm()" class="btn btn-outline-muted ml-4 mt-2"><i class="fa fa-plus"></i> Add More</span>
            @endif
        </div>
            </div>
            <div class="card-footer">
                <div type="button" v-on:click="updateProjectForm('updateProjectFinancialDetails')"
                    class="btn btn-primary save-btn">Save</div>
            </div>
        </form>
    </div>

</div>
