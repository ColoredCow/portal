<div class="card-body" id="create_invoice_details_form">
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
                    <label for="client_id" class="field-required">Project</label>
                    <a href="{{ route('project.create') }}" class="text-underline">Add new project</a>
                </div>
                <select name="project_id" id="project_id" class="form-control" required="required">
                    <option value="">Select project</option>
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

            <div class="form-group">
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
            <p class="text-danger" v-if="currency == 'INR' ">Total Amount : @{{ tot }}</p>
            <p class="text-danger" v-if="currency == 'USD' ">Total Amount : @{{ amt }}</p>
            <div class="text-danger" id="container"></div><br />

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



@section('scripts')
    <script>
        const saveInvoice = (button) => {
            button.disabled = true;
            if (!button.form.checkValidity()) {
                button.disabled = false;
                button.form.reportValidity();
                return;
            }
            button.form.submit();
        }

        new Vue({
            el: '#create_invoice_details_form',

            data() {
                return {
                    clients: @json($clients),
                    projects: {},
                    clientId: "",
                    client: null,
                    currency: '',
                    amount: '',
                }
            },

            methods: {
                updateClientDetails: function() {
                    this.projects = {};
                    for (var i in this.clients) {
                        let client = this.clients[i];
                        if (client.id == this.clientId) {
                            this.client = client;
                            this.currency = client.currency;
                            this.projects = client.projects.sort((project1, project2) => {
                                let projectName1 = project1.name.toLowerCase(), projectName2 = project2.name.toLowerCase();
                                if (projectName1 < projectName2) {
                                    return -1
                                }
                                if (projectName1 > projectName2) {
                                    return 1
                                }
                                return 0
                            });
                            break;
                        }
                    }

                }
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
