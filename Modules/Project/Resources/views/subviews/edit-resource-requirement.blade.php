<div class="card">
  <div id="projectResourceRequirementForm">
    <form  action="{{ route('project.update', $project) }}" method="POST" id="updateProjectResourceRequirement" enctype="multipart/form-data">
      @csrf
      <input type="hidden" value="project_resource_requirement" name="update_section">
        <div class="card-body form-body">
          <h3 class="mb-7 font-weight-bold">Requirement Details</h3>
            <table class="table table-bordered text-justify">
              <h4 class="mb-3 font-weight-bold">Additional Team Members Required: {{ $project->getTotalToBeDeployedCount() }}</h4>
                <thead>
                  <tr>
                    <th>Designation</th>
                    <th>Needed</th>
                    <th>Deployed</th>
                    <th>To Be Deployed</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($designationKeys as $designationName)
                    <tr>
                      <td><input type="text" name="designation[]" class="form-control" value="{{ $designations[$designationName]}}" readonly></td>
                      <td><input type="text" name="needed[{{$designationName}}]" class="form-control" value="{{ optional($project->getResourceRequirementByDesignation($designationName))->total_requirement ?? 0 }}"></td>
                      <td><input type="text" name="deployed{{$designationName}}" class="form-control" value="{{ $project->getDeployedCountForDesignation($designationName) ?? 0 }}" disabled></td>
                      <td><input type="text" name="to-be-deployed[{{$designationName}}]" class="form-control" value="{{ $project->getToBeDeployedCountForDesignation($designationName) ?? 0 }}" disabled></td>
                    </tr>
                  @endforeach
                </tbody>
            </table> 
        </div>
          <div class="card-footer">
            <button type="button" class="btn btn-primary save-btn" v-on:click="updateProjectForm('updateProjectResourceRequirement')">Save</button>
          </div>
    </form>
  </div>
</div>






