<div class="card-body" id="edit_prospect_details_form">
    <div class="form-row">
        <div class=" col-md-5">
            <div class="form-group">
                <label for="name" class="field-required">Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" required="required" value="{{ $prospect->name }}">
            </div> 

            <div class="form-group">
                <label for="brief_info" class="field-required">Brief information about the prospect </label>
                <textarea rows="6" class="form-control" name="brief_info" id="brief_info" placeholder="Brief information" required="required">{{ $prospect->brief_info }}</textarea>
            </div> 
        </div>

        <div class=" offset-md-1 col-md-5">
            <div class="form-group">
                <label for="status" class="field-required">Status</label>
                <select name="status" class="form-control" id="">
                    @foreach(config('prospect.status') as $status => $label)
                    <option {{ ($prospect->status == $status) ? 'selected=selected' : '' }} value="{{ $status }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

           <div class="form-group">
                <div class="d-flex justify-content-between">
                    <label for="coming_from" class="field-required">Source</label>
                    <span style="text-decoration:underline">Add new source</span>
                </div>
                <select v-model="comingFrom" name="coming_from" class="form-control" id="">
                    <option value="marketing">Marketing</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="name" >Assignee To</label>
            <select name="assign_to" class="form-control" id="">
                <option value="">Select Assignee</option>
                @foreach($assigneeData as $assignee)
                    <option {{ ($assignee->id == $prospect->assign_to ) ? 'selected=selected' : '' }} value="{{ $assignee->id }}">{{ $assignee->name }}</option>
                @endforeach
            </select>
        </div>

        </div>
    </div>


</div>
<div class="card-footer">
    @include('prospect::subviews.edit.edit-prospect-form-submit-buttons')
</div>




@section('js_scripts')
<script>
new Vue({
    el:'#edit_prospect_details_form',

    data() {
        return {
            comingFrom: '{{ $prospect->coming_from }}',
            comingFromID: '{{ $prospect->coming_from_id }}'
        }
    },

    mounted() {
    }
});

</script>

@endsection