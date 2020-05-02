<div class="card">
    <div id="prospect_requirements" class="collapse show" data-parent="#edit_client_form_container">
        <div v-for="(requirement, index) in requirements">

            <input v-if="!requirement.temp" type="hidden" :name="`requirements[${index}][id]`" :value="requirement.id">
            <hr v-if="index > 0">

            <div v-if="index < 1"  v-on:click="addNewRequirementForm()" class="text-right mr-3 font-weight-bold c-pointer mt-2">
                <span >Add more requirements</span>
            </div>

            <div class="card-body">
                <div class="form-row">
                    <div class=" col-md-5">
                        <div class="form-group">
                            <label :for="`requirements[${index}][project_brief]`" class="field-required">Project brief</label>
                            <textarea required="required" :name="`requirements[${index}][project_brief]`" class="form-control" id="" cols="30" rows="4" v-model="requirement.project_brief"></textarea>
                        </div>
                        <br>

                        <div class="form-group">
                            <label :for="`requirements[${index}][excepted_launch_date]`" >Timeframe</label>
                            <input :name="`requirements[${index}][excepted_launch_date]`" class="form-control"  type="date" id="" v-model="requirement.excepted_launch_date"/>
                        </div>

                
                        <div class="form-group">
                            <label :for="`requirements[${index}][resource_required_count]`" >Number of resources needed</label>
                            <input :name="`requirements[${index}][resource_required_count]`" class="form-control" type="number" id="" v-model="requirement.resource_required_count"/>
                        </div>

                    </div>

                    <div class=" offset-md-1 col-md-5">
               
                        <div class="form-group">
                            <label :for="`requirements[${index}][skills]`" class="d-flex justify-content-between">
                                <span>Skills Set </span>
                                <span style="text-decoration:underline">Add new skill</span>
                            </label>
                            <select class="form-control" :name="`requirements[${index}][skills][]`" multiple="multiple" v-model="requirement.skills">
                                <option value="php">PHP</option>
                                <option value="python">Python</option>
                                <option value="javascript">Javascript</option>
                                <option value="html">HTML</option>
                                <option value="kafka">Kafka</option>
                                <option value="testing">Testing</option>
                            </select>
                        </div>

                        <br>

                        <div class="form-group">
                            <label :for="`requirements[${index}][notes]`" >Notes</label>
                            <textarea :name="`requirements[${index}][notes]`" class="form-control" rows="5" v-model="requirement.notes"/></textarea>
                        </div>

                    </div>
                </div>
            </div>
            <div v-if="requirements.length > 1" v-on:click="removeRequirementForm(index)" class="text-right mr-3 font-weight-bold c-pointer mt-2">
                <span class="btn btn-danger my-3">Remove this requirement</span>
            </div>
        </div>

   
    
        <div class="card-footer">
            @include('prospect::subviews.edit.edit-prospect-form-submit-buttons')
        </div>
    </div>
</div>


@section('js_scripts')
<script>
    new Vue({
        el:'#prospect_requirements',

        data() {
            return {
                requirements:@json($prospectRequirements)
            }
        },

        methods: {

            newRequirementForm() {
                return {
                    id: new Date().getTime(),
                    temp:true,
                }
            },

            addNewRequirementForm() {
                this.requirements.push(this.newRequirementForm());
                this.requirements.reverse();
            },

            removeRequirementForm(index) {
                this.requirements.splice(index, 1);
            }

        },

        mounted() {
            if(!this.requirements.length) {
                this.addNewRequirementForm();
            }
        }
    })
</script>
@endsection