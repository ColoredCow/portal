<div id="edit_invoice_details_form">
    <div class="card-body">
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

                <div class="form-group" v-if="currency == 'INR'">
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
                            <p>{{ $invoice->sent_on->format(config('invoice.default-date-format')) }}</p>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-flex">
                        <label for="client_id" class="mr-5">Due on:</label>
                        <span>
                            <p>{{ $invoice->due_on->format(config('invoice.default-date-format'))}}</p>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="receivable_date" class="field-required">Receivable date</label>
                    <input type="date" class="form-control" name="receivable_date" id="receivable_date" required="required"
                        value="{{ $invoice->receivable_date->format('Y-m-d') }}">
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

                <div class="form-group ">
                    <label for="comments">Comments</label>
                    <textarea name="comments" id="comments" rows="5" class="form-control" v-model="comments"></textarea>
                </div>

            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary mr-4">Save</button>
        <span class="btn btn-danger" @click="deleteInvoice()" >Delete</span>
    </div>
</div>


@section('js_scripts')
<script>
    new Vue({
    el:'#edit_invoice_details_form',

    methods: {
        deleteInvoice: async function() {
            if(!confirm("Are you sure?")) {
                return true;
            }
            await axios.delete("{{ route('invoice.delete', $invoice) }}")
            window.location.href =  "{{ route('invoice.index') }}";
        }
    },

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