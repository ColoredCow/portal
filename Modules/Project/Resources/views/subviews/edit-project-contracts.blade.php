<div class="card">
    <div class="card-header" data-toggle="collapse" data-target="#project_contract_form">
        <h4>Project contracts</h4>
    </div>

    <div id="project_contract_form" class="collapse hide">
        <form  action="{{ route('project.store', $project) }}" enctype="multipart/form-data" method="POST" id="update_project_contract_form">
            @csrf
            <input type="hidden" value="project_contracts" name="update_section">
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="field-required">Contract</label>
                        <input type="file" id="contract_file" name="contract_file" class="form-control" required="required" accept="application/pdf">
                    </div>
                    <div class="col-4">
                        <button v-on:click="removeProjectContract()" type="button" class="btn btn-danger btn-sm mt-6 ml-2 text-white fz-14">Remove</button>
                    </div>
                </div>
                <div>
                    <span v-on:click="addNewProjectContract()" style="text-decoration: underline;" class="text-underline btn" >Add new contract</span>
                </div>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-primary" v-on:click="updateProjectForm('update_project_contract_form')">Update contract details</button>
            </div>
        </form>
    </div>
</div>