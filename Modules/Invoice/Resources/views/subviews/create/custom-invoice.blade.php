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
                    <label for="comments">Comments</label>
                    <textarea name="comments" id="comments" rows="5" class="form-control"></textarea>
                </div>
                <small>Note: Please fill the email details to generate the invoice.</small>
            </div>
            <div class="col-md-5 offset-md-1">
                <div class="form-group">
                    <label for="term" class="field-required">Invoice Period Start Date</label>
                    <input type="date" class="form-control" name="period_start_date" id="term" required="required" value='{{ old('period_start_date', '') }}'>
                </div>
                <div class="form-group mt-2">
                    <label for="term" class="field-required">Invoice Period End Date</label>
                    <input type="date" class="form-control" name="period_end_date" id="term" required="required" value='{{ old('period_end_date', '') }}'>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#invoiceMailPreview">Create</button>
        <button type="button" class="btn btn-primary" data-url="{{ route('invoice.generate-invoice') }}" onclick="previewInvoice(this)">Preview Invoice</button>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#invoiceMailPreview">Email Details</button>
    </div>
</div>
@include('invoice::modals.custom-invoice-email-preview')


@section('scripts')
    <script>
        const saveInvoice = (button) => {
            button.disabled = true;
            form = document.getElementById('invoiceForm');
            if (!validateFormData(form)) {
                button.disabled = false;
                return;
            }
            form.submit();
        }
        
        const previewInvoice = (button) => {
            button.disabled = true;
            $('.not-required-in-preview').map(function() {
                return $(this).attr('required', false);
            });
            if (!validateFormData(button.form)) {
                button.disabled = false;
                $('.not-required-in-preview').map(function() {
                    return $(this).attr('required', true);
                });
                return;
            }
            var oldUrl = button.form.action
            button.form.setAttribute('target', '_blank');
            button.form.action = button.dataset.url
            button.form.submit();
            $('.not-required-in-preview').map(function() {
                return $(this).attr('required', true);
            });
            button.form.removeAttribute('target');
            button.disabled = false;
            button.form.action = oldUrl;
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
                    previewInvoiceUrl: "{{ route('invoice.preview-custom-invoice') }}"
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
