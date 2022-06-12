<div id="create_invoice_details_form">
    <div class="card-body">
        <div class="form-row mb-4">
            <div class="col-md-5">
                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <label for="client_id" class="field-required">Client</label>
                        <a href="{{ route('client.create') }}" for="client_id" class="text-underline">Add new client</a>
                    </div>
                    <select name="client_id" id="client_id" class="form-control" required="required"
                        @change="updateClientDetails()" v-model="clientId">
                        <option value="">Select Client</option>
                        <option v-for="client in clients" :value="client.id" v-text="client.name"
                            :key="client.id"></option>
                    </select>
                </div>
                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <div>
                            <label for="billing_for" class="field-required">
                                Project
                            </label>
                            <span 
                                data-toggle="tooltip" 
                                data-placement="right" 
                                title="Client Level Project will include all the projects having billing level set to client level. The primary project id is set as project id in this case."
                                class="ml-2"
                            >
                                <i class="fa fa-question-circle"></i>&nbsp;
                            </span>
                        </div>
                    </div>
                    <select name="billing_for" id="billing_for" class="form-control" required="required">
                        <option v-if="client && primaryProject" value="client_level" v-text="primaryprojectLabel"></option>
                        <option v-else="client" value="">Select Project</option>
                        <option v-for="project in projects" :value="project.id" v-text="project.name"
                            :key="project.id">
                        </option>
                    </select>
                </div>
                <div class="form-group ">
                    <label for="project_invoice_id" class="field-required">Upload file</label>
                    <div class="d-flex">
                        <div class="custom-file mb-3">
                            <input type="file" id="invoice_file" name="invoice_file" class="custom-file-input"
                                required="required">
                            <label for="customFile0" class="custom-file-label">Choose file</label>
                        </div>
                    </div>
                </div>
                <div class="form-group ">
                    <label for="comments">Comments</label>
                    <textarea name="comments" id="comments" rows="5" class="form-control"></textarea>
                </div>
            </div>
            <div class="col-md-5 offset-md-1">
                <div class="form-group">
                    <label for="project_invoice_id" class="field-required">Status</label>
                    <select class="form-control" name="status">
                        {{-- <option value="pending">Pending</option> --}}
                        <option value="sent">Sent</option>
                        <option value="paid">Paid</option>
                    </select>
                </div>
                <div class="form-group mb-0">
                    <label for="amount" class="field-required">Amount</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <select name="currency" v-model="currency" id="currency" class="input-group-text"
                                required="required">
                                @foreach ($countries as $country)
                                    <option value="{{ $country->currency }}">{{ $country->currency }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input v-model="amount" type="number" class="form-control" name="amount" id="amount"
                            placeholder="Invoice Amount" required="required" step=".01" min="0">
                    </div>
                </div>
                <div class="form-group" v-if="currency == 'INR'">
                    <label for="gst">GST</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">INR</span>
                        </div>
                        <input v-model="gst" type="number" class="form-control" name="gst" id="gst" placeholder="GST"
                            step=".01" min="0">
                    </div>
                </div>
                <div class="text-danger fz-14" v-if="currency == 'INR' ">Total Amount : @{{ tot }}</div>
                <div class="text-danger fz-14" v-if="currency == 'USD' ">Total Amount : @{{ amt }}</div>
                <div class="text-danger fz-14 my-0" id="container"></div>
                <div class="form-group mt-2">
                    <label for="term" class="field-required">Invoice for term</label>
                    <input type="month" class="form-control" name="term" id="term" required="required" value='{{ old('term', '') }}'>
                </div>
                <div class="form-group">
                    <label for="sent_on" class="field-required">Sent on</label>
                    <input type="date" class="form-control" name="sent_on" id="sent_on" required="required"
                        value="{{ now()->format('Y-m-d') }}">
                </div>
                <div class="form-group">
                    <label for="due_on" class="field-required">Due date</label>
                    <input type="date" class="form-control" name="due_on" id="due_on" required="required"
                        value="{{ now()->addDays(6)->format('Y-m-d') }}">
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="button" class="btn btn-primary" onclick="saveInvoice(this)">Create</button>
        <a class="btn btn-secondary" id="generate_invoice_link" @click.prevent="generateInvoice($event)" href="">Generate Invoice</a>
    </div>
</div>


@section('scripts')
    <script>
        const saveInvoice = (button) => {
            button.disabled = true;
            if (!validateFormData(button.form)) {
                button.disabled = false;
                return;
            }
            button.form.submit();
        }
        
        const validateFormData = (form) => {
            if (!form.checkValidity()) {
                form.reportValidity();
                return false;
            }
            return true;
        }

        new Vue({
            el: '#create_invoice_details_form',

            data() {
                return {
                    clients: @json($clients),
                    primaryProject: {},
                    primaryprojectLabel: '',
                    projects: {},
                    groups: {},
                    clientId: '',
                    client: null,
                    currency: '',
                    amount: '',
                }
            },

            methods: {
                updateClientDetails: function() {
                    this.projects = {};
                    this.client = null;
                    for (var i in this.clients) {
                        let client = this.clients[i];
                        if (client.id == this.clientId) {
                            this.client = client;
                            this.primaryProject = client.primary_project;
                            if (this.primaryProject) {
                                this.primaryprojectLabel = 'Client Level (' + client.primary_project.name + ')';
                            }
                            this.currency = client.currency;
                            this.projects = _.orderBy(client.project_level_billing_projects, 'name', 'asc');
                        }
                    }
                },

                generateInvoice: function(event) {
                    if(this.checkValidity()) {
                        var element = $("#generate_invoice_link");
                        element.attr("disabled", true);
                        var form = $("#invoice_form");
                        var oldUrl = form.attr("action");
                        var url = "{{ route('invoice.generate-invoice') }}";
                        form.attr("target", "_blank");
                        form.attr("action", url);
                        form.submit();
                        form.attr("action", oldUrl);
                        form.removeAttr("target");
                        element.attr("disabled", false);
                    }
                },

                checkValidity: function() {
                    $('#invoice_file, [name="currency"], [name="amount"]').attr("required", false);
                    var isValidated = validateFormData(document.getElementById('invoice_form'));
                    $('#invoice_file, [name="currency"], [name="amount"]').attr("required", true);
                    
                    return isValidated;
                },
            },

            mounted() {},

            computed: {
                gst: function() {
                    return (this.amount * 0.18).toFixed(2);
                },
                tot: function() {
                    let total = this.amount * 0.18 + 1 * this.amount;
                    return (total);
                },
                amt: function() {
                    return (this.amount);
                },
            }
        });
    </script>
@endsection
