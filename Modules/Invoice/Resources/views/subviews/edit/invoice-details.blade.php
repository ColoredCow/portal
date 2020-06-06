<div class="card-body" id="create_invoice_details_form">
    <div class="form-row mb-4">
        <div class="col-md-5">
            <div class="form-group">
                <div class="d-flex">
                    <label for="client_id font-weight-bold" class="mr-5">Client:</label>
                    <span>
                        <p>{{ $invoice->client->name }}</p>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <div class="d-flex">
                    <label for="client_id" class="mr-5">Project:</label>
                    <span>
                        <p>{{ $invoice->project->name }}</p>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <div class="d-flex">
                    <label for="client_id" class="mr-5">Amount:</label>
                    <span>
                        <p>{{ $invoice->display_amount }}</p>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <div class="d-flex">
                    <label for="client_id" class="mr-5">GST:</label>
                    <span>
                        <p>{{ $invoice->gst . " ₹" }}</p>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <div class="d-flex">
                    <label for="client_id" class="mr-5">Sent on:</label>
                    <span>
                        <p>{{ $invoice->sent_on->format('d-m-Y') }}</p>
                    </span>
                </div>
            </div>
            <div class="form-group ">
                <div class="d-flex">
                    <a class="text-underline" target="_blank" href="{{ route('invoice.get-file', $invoice->id) }}">View invoice PDF
                        here</a>
                </div>
            </div>

        </div>

        <div class="col-md-5 offset-md-1">
            <div class="form-group">
                <label for="project_invoice_id" class="field-required">Status</label>
                <select class="form-control" name="status" v-model="status">
                    {{-- <option value="pending">Pending</option> --}}
                    <option value="sent">Sent</option>
                    <option value="paid">Paid</option>
                </select>
            </div>

            <div class="form-group">
                <label for="due_on" class="field-required">Due date</label>
                <input v-model="due_on" type="date" class="form-control" name="due_on" id="due_on" required="required"
                    value="{{ now()->addDays(6)->format('Y-m-d') }}">
            </div>

            <div class="form-group ">
                <label for="comments">Comments</label>
                <textarea name="comments" id="comments" rows="5" class="form-control" v-model="comments"></textarea>
            </div>

        </div>
    </div>
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-primary">Save</button>
</div>



@section('js_scripts')
<script>
    new Vue({
    el:'#create_invoice_details_form',

    data() {
        return {
            clients: @json($clients),
            invoice:@json($invoice),
            projects:@json( $invoice->client->projects),
            clientId:"{{ $invoice->client_id  }}",
            projectId:"{{ $invoice->project_id  }}",
            client:@json( $invoice->client),
            currency:"{{ $invoice->currency }}",
            comments:"{{ $invoice->comments }}",
            status:"{{ $invoice->status }}",
            amount:"{{ $invoice->amount }}",
            sent_on:"{{ $invoice->sent_on->format('Y-m-d') }}",
            due_on:"{{ $invoice->due_on->format('Y-m-d') }}",
        }
    },

    methods: {
        updateClientDetails: function() {
            this.projects =  {};
            for (var i in this.clients) {
                let client = this.clients[i];
                if (client.id == this.clientId) {
                    this.client = client;
                    this.currency = client.currency;
                    this.projects = client.projects;
                    break;
                }
            }

        }
    },

    mounted() {
    },

    computed: {
        gst: function () {
            return (this.amount * 0.18).toFixed(2);
        }
    }
});

</script>

@endsection