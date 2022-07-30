<div id="create_invoice_details_form">
    <div class="card-body">
        <div class="form-row mb-4">
            <div class="col-md-5">
                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <label for="clientId" class="field-required">Client</label>
                        <a href="{{ route('client.create') }}" for="clientId" class="text-underline">Add new client</a>
                    </div>
                    <select name="client_id" id="clientId" class="form-control" required="required"
                        @change="updateClientDetails()" v-model="clientId">
                        <option value="">Select Client</option>
                        <option v-for="client in clients" :value="client.id" v-text="client.name"
                            :key="client.id"></option>
                    </select>
                </div>
                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <div>
                            <label for="billingLevel" class="field-required">
                                Billing Level
                            </label>
                            <span
                                data-toggle="tooltip"
                                data-placement="right"
                                title="Client Level Billing will include all the projects of client having billing level set to client."
                                class="ml-2"
                            >
                                <i class="fa fa-question-circle"></i>&nbsp;
                            </span>
                        </div>
                    </div>
                    <select @change="updateShowProjects($event)" name="billing_level" id="billingLevel" class="form-control" required="required">
                        <option value="{{ config('project.meta_keys.billing_level.value.client.key') }}">{{ config('project.meta_keys.billing_level.value.client.label') }}</option>
                        <option value="{{ config('project.meta_keys.billing_level.value.project.key') }}">{{ config('project.meta_keys.billing_level.value.project.label') }}</option>
                    </select>
                </div>
                <div v-if="showProjects" class="form-group">
                    <div class="d-flex justify-content-between">
                        <div>
                            <label for="projects" class="field-required">
                                Project
                            </label>
                        </div>
                    </div>
                    <select name="project_id" id="projects" class="form-control" required="required">
                        <option value="">Select Project</option>
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
                    <input type="month" class="form-control" name="term" id="term" required="required" value='{{ old('term', now(config('constants.timezone.indian'))->subMonth()->format('Y-m')) }}'>
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
                    projects: {},
                    groups: {},
                    clientId: '',
                    client: null,
                    currency: '',
                    amount: '',
                    showProjects: false,
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
                            this.currency = client.currency;
                            this.projects = _.orderBy(client.projects, 'name', 'asc');
                        }
                    }
                },

                updateShowProjects: function(event) {
                    if (event.target.value == 'project') {
                        this.showProjects = true;
                    } else {
                        this.showProjects = false;
                    }
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
