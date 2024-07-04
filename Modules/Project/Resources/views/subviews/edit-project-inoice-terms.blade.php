<div class="bg-theme-gray-light p-2 rounded">
    <div class="row" v-for="(invoiceTerm, index) in invoiceTerms" :key="invoiceTerm.id">
        <input type="hidden" name="invoiceTerm" value="">
        <input type="hidden" :name="`invoiceTerms[${index}][id]`" v-model="invoiceTerm.id">
        <input type="hidden" :name="`invoiceTerms[${index}][status]`" v-model="invoiceTerm.status">
        <div class="row col-12">
            <div class="card-body ml-4">
                <div class="form-row">
                    <div class="form-check">
                        <input type="checkbox" id="report_required" :name="`invoiceTerms[${index}][report_required]`" v-model="invoiceTerm.report_required" :value="1" style="width: 15px; height: 15px;">
                        <label class="form-check-label" for="report_required">{{ __('Delivery Report Required') }}</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" id="client_acceptance_required" :name="`invoiceTerms[${index}][client_acceptance_required]`" v-model="invoiceTerm.client_acceptance_required" :value="1" style="width: 15px; height: 15px;">
                        <label class="form-check-label" for="client_acceptance_required">{{ __('Client Acceptance Required') }}</label>
                    </div>
                    <div v-if="invoiceTerm.client_acceptance_required == 1">
                        <div class="form-check">
                            <input type="checkbox" id="is_accepted" :name="`invoiceTerms[${index}][is_accepted]`" v-model="invoiceTerm.is_accepted" :value="1" style="width: 15px; height: 15px;">
                            <label class="form-check-label" for="is_confirmed_yes">{{ __('Accepted From Client') }}</label>
                        </div>
                    </div>
                </div>
                <div class="form-row mt-4">
                    <div class="col-3">
                        <label class="text-center" for="invoice_date">{{ __('Invoice Date') }}</label>
                        <input id="invoice_date" class="form-control" type="date" :name="`invoiceTerms[${index}][invoice_date]`" v-model="invoiceTerm.invoice_date">
                    </div>
                    <div class="col-3">
                        <label for="invoice_amount">{{ __('Invoice Amount') }}</label>
                        <div class="input-group">
                            <input id="invoice_amount" v-model="invoiceTerm.amount" :name="`invoiceTerms[${index}][amount]`" type="number" step="0.01" class="form-control" placeholder="Amount">
                            <div class="input-group-append">
                                <span class="input-group-text">{{ optional($project->client->country)->currency }}</span>
                            </div>
                        </div>
                    </div>
                    <div v-if="invoiceTerm.report_required == 1" class="form-group col-4">
                        <div class="flex-row">
                            <label for="delivery_report">{{ __('Upload Service Delivery Report') }}</label>
                        </div>
                        <div class="custom-file mb-3">
                            <input type="file" id="delivery_report" :name="`invoiceTerms[${index}][delivery_report]`" class="custom-file-input" @change="handleFileUpload($event, index)">
                            <label for="delivery_report" class="custom-file-label overflow-hidden">Upload Report</label> <div v-if="invoiceTerm.delivery_report" class="indicator" style="margin-top: 3px">
                                <a :id="`delivery_report_${index}`" :href="getDeliveryReportUrl(invoiceTerm.id)" target="_blank">
                                    <span class="mr-1 underline theme-info fz-16">@{{ getFileName(invoiceTerm.delivery_report) }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row mt-1">
                    <div class="col-6" v-if="toggleDelayInput(index)">
                        <label>{{ __('Add Reason For Delay') }}</label>
                        <textarea id="comment"
                        :name="`invoiceTerms[${index}][comment][body]`"
                        class="form-control"
                        placeholder="Please submit the reason of delay here.."
                        ></textarea>
                    </div>
                    <div  class="col-6">
                        <div v-if="toggleDelayReason(index)">
                            <div>
                                <div class="bg-light rounded p-2">
                                    <div class="text small mb-3">
                                        {{'Last updated at ' }} @{{formatDate(invoiceTerm.updated_at)}}
                                    </div>
                                    <div>
                                        <strong>{{_('Reaseon for delay')}}</strong>
                                    </div>
                                    <div>@{{ invoiceTerm.comment?.body }}</div>
                                    <div class="text small text-muted d-flex justify-content-end">
                                        <strong>{{ "- " }} @{{invoiceTerm.comment?.user.name}}</strong> (@{{invoiceTerm.comment?.created_at}})
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-row justify-content-between mr-3 mt-3">
                    <div class="col-1">
                        <button v-on:click="removeProjectInvoiceTerm(index)" type="button" class="btn btn-danger btn-sm text-white fz-14">Remove</button>
                    </div>
                    <div v-if="['sent', 'paid'].includes(invoiceTerm.status)" class="ml-3 row">
                        <span class="text-success">
                            <i class="fa fa-check-circle fa-lg"></i>
                        </span>
                        <div class="text small ml-1">
                            Invoice has been proceeded for this term.
                        </div>
                    </div> 
                </div>
                <hr class="bg-dark border-dark">
            </div>
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