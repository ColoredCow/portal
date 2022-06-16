<div class="modal fade" id="createNewParameterModal" tabindex="-1" role="dialog" aria-labelledby="createNewParameterModal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="createNewParameterForm" method="Post" action="{{ route('hr.evaluation.parameter.store', $segment) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createSegmentParameterModal">Add new Parameter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="field-required">Parameter name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" required="required" value="{{ old('name') }}">
                    </div>

                    <div class="form-group">
                        <label for="name" class="field-required">Parameter marks</label>
                        <input type="text" class="form-control" name="marks" id="marks" placeholder="Marks" required="required"
                            value="{{ old('marks') }}">
                    </div>

                    <div class="form-group">
                        <label for="name" class="field-required">Slug</label>
                        <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug" value="{{ old('slug') }}">
                    </div>

                    <br>
                    <br>
                    <h5>Options</h5>
                    <br>

                    <div class="row">
                        <div class="col-5">
                            &nbsp;Label
                        </div>
                        <div class="col-4">
                            &nbsp;Marks
                        </div>
                    </div>

                    <div class="row my-1" v-for="(parameterOption, index ) in this.parameterOptions" :key="parameterOption.id">
                        <div class="col-5">
                            <input v-model="parameterOption.label" class="form-control" :name="`parameter_options[${index}][label]`" text="text">
                        </div>
                        <div class="col-4">
                            <input v-model="parameterOption.marks" class="form-control" :name="`parameter_options[${index}][marks]`" type="number">
                        </div>

                        <div class="col-3">
                            <button v-on:click="removeParameterOption(index)" type="button" class="btn btn-sm text-danger"> 
                                remove
                            </button>
                        </div>
                    </div>

                    <div class="text-right mt-3 mr-3">
                        <h5 v-on:click="addNewParameterOption()" class="text-underline c-pointer">Add option</h5>
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