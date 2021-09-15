<div class="card">
    <div class="card-header" data-toggle="collapse" data-target="#project_repository_form">
        <h4>Project repositories</h4>
    </div>

    <div id="project_repository_form" class="collapse hide">
        <form  action="{{ route('project.update', $project) }}" method="POST" id="update_project_repository_form">
            @csrf
            <input type="hidden" value="project_repository" name="update_section"> 
            <div class="card-body">
                <div class="form-row" v-for="(projectRepository, index) in projectRepositories" >
                    <div class="form-group col-md-6">
                        <label for="projectRepository.id" class="field-required">Url</label>
                        <input type="url" class="form-control"
                            v-model="projectRepository.url"
                            id="projectRepository.id"
                            :name="`url[${index}]`"
                            placeholder="Enter project repository url" 
                            required="required"
                            :key="projectRepository.id">
                    </div>
                    <div class="col-4">
                        <button v-on:click="removeProjectRepository(index)" type="button" class="btn btn-danger btn-sm mt-6 ml-2 text-white fz-14">Remove</button>
                    </div>
                </div>
                <div>
                    <span v-on:click="addNewProjectRepository()" style="text-decoration: underline;" class="text-underline btn" >Add new repository</span>
                </div>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-primary" v-on:click="updateProjectForm('update_project_repository_form')">Update repository details</button>
            </div>
        </form>
    </div>
</div>