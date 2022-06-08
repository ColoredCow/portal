<div class="modal fade" id="updateParameterModal" tabindex="-1" role="dialog"
    aria-labelledby="updateParameterModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="updateParameterForm" method="Post" :action="updateRoute">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createSegmentModal" v-text="selectedParameter.name"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="field-required">Parameter name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                            required="required" v-model="selectedParameter.name">
                    </div>

                    <div class="form-group">
                        <label for="name" class="field-required">Parameter marks</label>
                        <input type="text" class="form-control" name="marks" id="marks" placeholder="Marks"
                            required="required" v-model="selectedParameter.marks">
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

                    <div class="row my-1" v-for="(updateParameterOption, index ) in this.updateParameterOptions"
                        :key="updateParameterOption.id">
                        <div class="col-5">
                            <input v-if="!updateParameterOption.new" class="form-control" :name="`parameter_options[${index}][id]`"
                                type="hidden" :value="updateParameterOption.id">
                            <input v-model="updateParameterOption.value" class="form-control"
                                :name="`parameter_options[${index}][label]`" text="text">
                        </div>
                        <div class="col-4">
                            <input v-model="updateParameterOption.marks" class="form-control"
                                :name="`parameter_options[${index}][marks]`" type="number">
                        </div>

                        <div class="col-3">
                            <button v-on:click="removeUpdateParameterOption(index)" type="button"
                                class="btn btn-sm text-danger">
                                remove
                            </button>
                        </div>
                    </div>

                    <div class="text-right mt-3 mr-3">
                        <h5 v-on:click="addUpdateParameterOption()" class="text-underline c-pointer">Add option</h5>
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