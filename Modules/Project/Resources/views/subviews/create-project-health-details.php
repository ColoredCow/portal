<div class="card">
    <div class="card-header" data-toggle="collapse" data-target="#project_health_form">
        <h4>Project health details</h4>
    </div>

    <div id="project_health_form" class="collapse hide">
        <form action="{{ route('project.update', $project) }}" method="POST" id="update_project_health_form">
            <input type="hidden" value="project_health" name="update_section"> 
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-12 d-flex mt-2">
                        <label for="projectHealth"><h4>Staging URL</h4></label>
                        <input type="url" class="form-control col-md-6 ml-5" name="staging_url" id="staging_url">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12 d-flex mt-3">
                        <label for="projectHealth" class="lb-md"><h4>Training & Onboarding Documents</h4></label>
                        <input type="url" class="form-control col-md-6 ml-5" name="onboarding_documents_url" id="staging_url">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-check mt-2">
                        <input type="hidden" class="h-20 w-20" name="has_issue_templates" value="0" />
                        <input type="checkbox" class="h-20 w-20" name="has_issue_templates" value="1" />
                        <label for="flexCheckDefault"><h4 class="ml-3">Issue templates</h4></label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-check mt-2">
                        <input type="hidden" class="h-20 w-20" name="has_unit_testing" value="0" />
                        <input type="checkbox" class="h-20 w-20" name="has_unit_testing" value="1" />
                        <label for="flexCheckDefault"><h4 class="ml-3">Unit testing</h4></label>
                    </div> 
                </div>
                <div class="form-row">
                    <div class="form-check mt-2">
                        <input type="hidden" class="h-20 w-20" name="has_ci_check" value="0" />
                        <input type="checkbox" class="h-20 w-20" name="has_ci_check" value="1" />
                        <label for="flexCheckDefault"><h4 class="ml-3">CI</h4></label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-check mt-2">
                        <input type="hidden" class="h-20 w-20" name="has_site_monitoring" value="0" />
                        <input type="checkbox" class="h-20 w-20" name="has_site_monitoring" value="1" />
                        <label for="flexCheckDefault"><h4 class="ml-3">Site monitoring</h4></label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-check mt-2">
                        <input type="hidden" class="h-20 w-20" name="has_error_logging" value="0" />
                        <input type="checkbox" class="h-20 w-20" name="has_error_logging" value="1" />
                        <label for="flexCheckDefault"><h4 class="ml-3">Error logging</h4></label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-check mt-2">
                        <input type="hidden" class="h-20 w-20 " name="has_error_reporting" value="0" />
                        <input type="checkbox" class="h-20 w-20 " name="has_error_reporting" value="1" />
                        <label for="flexCheckDefault"><h4 class="ml-3">Error reporting</h4></label>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-primary" v-on:click="updateProjectForm('update_project_health_form')">Update Project Health Details</button>
            </div>
        </form>
    </div>
</div>