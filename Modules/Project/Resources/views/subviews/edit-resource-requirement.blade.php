<div class="card">
    <div class="card-header">
    </div>

    <div id="resource_requirement_form">
      <form  action="{{ route('project.update', $project) }}" method="POST" id="form_project">
        @csrf
        <input type="hidden" value="project_resource_requirement" name="update_section">
        <input type="hidden" value="{{ $project->id }}" name="project_id">
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
                              @if ($requirements->count() == 0)
                                @foreach ($posts as $post)
                                <tr>
                                  <td><input type="text" name="designation[]" class="form-control" value="{{ $post }}" readonly></td>
                                  <td><input type="text" name="needed[]" class="form-control"></td>
                                  <td><input type="text" name="deployed" class="form-control" disabled></td>
                                  <td><input type="text" name="to-be-deployed" class="form-control" disabled></td>
                                </tr>
                                @endforeach
                              @else
                                @foreach ($requirements as $requirement)
                                  <tr>
                                    <td><input type="text" name="designation[]" class="form-control" value="{{ $requirement->designation }}" readonly></td>
                                    <td><input type="text" name="needed[]" class="form-control" value="{{ $requirement->total_requirement }}"></td>
                                    <td><input type="text" name="deployed" class="form-control" disabled></td>
                                    <td><input type="text" name="to-be-deployed" class="form-control" disabled></td>
                                  </tr>
                                @endforeach
                              @endif
                            </tbody>
                          </table> 
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-primary save-btn" v-on:click="updateProjectForm('form_project')">Save</button>
            </div>
      </form>
    </div>
</div>