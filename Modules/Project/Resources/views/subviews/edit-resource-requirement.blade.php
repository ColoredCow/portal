<div class="card">
  <div id="projectResourceRequirementForm">
    <form  action="{{ route('project.update', $project) }}" method="POST" id="updateProjectResourceRequirement" enctype="multipart/form-data">
      @csrf
      <input type="hidden" value="project_resource_requirement" name="update_section">
        <div class="card-body form-body">
          <h3 class="mb-7 font-weight-bold">Requirement Details</h3>
            <table class="table table-bordered text-justify">
              <h4 class="mb-3 font-weight-bold">Total Team Members Required:</h4>
                <thead>
                  <tr>
                    <th>Designation</th>
                    <th>Needed</th>
                    <th>Deployed</th>
                    <th>To Be Deployed</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($designationKeys as $index => $designationName)
                    <tr>
                      <td><input type="text" name="designation[]" class="form-control" value="{{ ($requirements->count() > 0) ? $designations[$requirements[$index]->designation] : $designations[$designationName]}}" readonly></td>
                      <td><input type="text" name="needed[{{$designationName}}]" class="form-control" value="{{ ($requirements->count() > 0) ? $requirements[$index]->total_requirement : '' }}"></td>
                      <td><input type="text" name="deployed" class="form-control" disabled></td>
                      <td><input type="text" name="to-be-deployed" class="form-control" disabled></td>
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