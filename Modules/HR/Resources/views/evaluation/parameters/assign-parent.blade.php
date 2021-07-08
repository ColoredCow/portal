<div class="modal fade" id="assignParentParameterModal" tabindex="-1" role="dialog"
    aria-labelledby="assignParentParameterModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="assignParentParameterForm" method="POST" :action="updateParentRoute">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createSegmentModal" v-text="selectedParameter.name"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="field-required">Select Parameter</label>
                        <select name="parent_parent_id" class="form-control" id="parentParameterID"
                            v-model="selectedParentParameter" v-on:change="onSelectParentParameter">
                            <option value="">Select Parameter</option>
                            @foreach($parameters as $parameter)
                            <option data-parameter="{{ $parameter }}" :value="{{ $parameter->id }}">
                                {{ $parameter->name  }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="name" class="field-required">Select Option</label>
                        <select name="parent_option_id" class="form-control" id="parentOptionID"
                            v-model="selectedParentParameterOption">
                            <option value="">Select Option</option>
                            <option v-for="(option, index) in selectedParentParameterOptions" :key="option.id"
                                :value="option.id" v-text="option.value" />
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>