<div class="card">
    <div class="card-header" data-toggle="collapse" data-target="#project_resource_form">
        <h4>Project resources</h4>
    </div>

    <div id="project_resource_form" class="collapse hide">
        <form  action="{{ route('project.update', $project) }}" method="POST" id="update_project_resource_form">
            @csrf
            <input type="hidden" value="project_resources" name="update_section"> 

            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        Resources
                    </div>
                    <div class="col-4">
                        Designations
                    </div>
                </div>

                <div class="row mb-3" v-for="(projectResource, index) in projectResources" :key="projectResource.id">
                    <div class="col-4">
                        <select v-model="projectResource.id" :name="`project_resource[${index}][resource_id]`" class="form-control">
                            <option value="">Select Resource</option>
                            <option v-for="(resource) in allResources" :value="resource.id" :key="resource.id">@{{ resource.name }}</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <select v-model="projectResource.pivot.designation" :name="`project_resource[${index}][designation]`" class="form-control">
                            <option value="">Select Designations</option>

                            <option v-for="(resourcesDesignation, key) in resourcesDesignations" :value="key">@{{ resourcesDesignation }}</option>
                        </select>
                    </div>

                    <div class="col-4">
                        <button v-on:click="removeProjectResource(index)" type="button" class="btn btn-danger btn-sm mt-1 ml-2"> - </button>
                    </div>
                </div>

                <div>
                    <span v-on:click="addNewProjectResource()" style="text-decoration: underline;" class="text-underline btn" >Add new resource</span>
                </div>

            </div>
    
            <div class="card-footer">
                <button type="button" class="btn btn-primary" v-on:click="updateProjectForm('update_project_resource_form')">Update resources</button>
            </div>
        </form>
    </div>
   
</div>
