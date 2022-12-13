<form action="{{ route('project.update', $project) }}" method="POST" id="updateProjectTechstack" enctype="multipart/form-data">
    <div class="card">

        <div id="project_techstack_form">
            @csrf
            <input type="hidden" value="project_techstack" name="update_section">
            <div class="form-group row m-5">
                <label for="language" class="col-sm-4 col-form-label m-4">Language</label>
                <div class="col-sm-6 m-4">
                    <input type="text" name="language" class="form-control" id="language" placeholder="Language">
                </div>
            </div>
            <div class="form-group row m-5">
                <label for="framework" class="col-sm-4 col-form-label m-4">Framework</label>
                <div class="col-sm-6 m-4">
                    <input type="text" name="framework" class="form-control" id="framework" placeholder="Framework">
                </div>
            </div>
            <div class="form-group row m-5">
                <label for="database" class="col-sm-4 col-form-label m-4">Database</label>
                <div class="col-sm-6 m-4">
                    <input type="text" name="database" class="form-control" id="database" placeholder="Database">
                </div>
            </div>
            <div class="form-group row m-5">
                <label for="hosting" class="col-sm-4 col-form-label m-4">Hosting</label>
                <div class="col-sm-6 m-4">
                    <input type="text" name="hosting" class="form-control" id="hosting" placeholder="Hosting">
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" v-on:click="updateProjectForm('updateProjectTechstack')" class="btn btn-primary save-btn">Save</button>
           </div>  
        
    </div>
</form>
