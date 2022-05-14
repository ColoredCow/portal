<div class="card-body" id="create_prospect_details_form">
    <div class="form-row">
        <div class=" col-md-5">
            <div class="form-group">
                <label for="name" class="field-required">Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" required="required"
                    value="{{ old('name') }}">
            </div> 

            <div class="form-group">
                <label for="brief_info" class="field-required">Brief information about the prospect </label>
                <textarea rows="6" class="form-control" name="brief_info" id="brief_info" placeholder="Brief information" required="required"></textarea>
            </div>
        </div>

        <div class=" offset-md-1 col-md-5">
           <div class="form-group">
                <div class="d-flex justify-content-between">
                    <label for="coming_from" class="field-required">Source</label>
                    <span style="text-decoration:underline">Add new source</span>
                </div>
             
                <select v-model="comingFrom" name="coming_from" class="form-control" id="">
                    <option value="marketing">Marketing</option>
                    {{-- <option value="lead">Existing Lead</option>
                    <option value="client_contact">Existing Client contact</option> --}}
                </select>
           </div>

            <div class="form-group" v-if="comingFrom == 'lead'">
                <label for="coming_from_id_lead" >Lead</label>
                <select name="coming_from_id_lead" class="form-control" id="">
                    <option value="">Select lead</option>
                    @foreach([] as $lead)
                        <option value="{{ $lead->id }}">{{ $lead->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" v-if="comingFrom == 'client_contact'">
                <label for="coming_from_id_client_contact" >Client Contact</label>
                <select name="coming_from_id_client_contact" class="form-control" id="">
                    <option value="">Select contact</option>
                    @foreach($clientContactPersons ?:[] as $contact)
                        <option value="{{ $contact->id }}">{{ $contact->name }} ({{ $contact->client->name }})</option>
                    @endforeach
                </select>
            </div>

           <div class="form-group">
                <label for="name" >Assignee To</label>
                <select name="assign_to" class="form-control" id="">
                    <option value="">Select Assignee</option>
                    @foreach($assigneeData as $assignee)
                    <option {{ ($assignee->id == auth()->user()->id ) ? 'selected=selected' : '' }} value="{{ $assignee->id }}">{{ $assignee->name }}</option>
                    @endforeach
                </select>
            </div>

        </div>
    </div>
 

</div>
<div class="card-footer">
    <button type="button" class="btn btn-primary" id="save-btn-action">Create</button>
</div>

@section('js_scripts')
<script>
    new Vue({
        el:'#create_prospect_details_form',

        data() {
            return {
                comingFrom: 'marketing'
            }
        },

        mounted() {
        
        }
    });
</script>

@endsection