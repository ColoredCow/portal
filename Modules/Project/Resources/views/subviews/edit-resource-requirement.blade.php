<div class="card">
    <div class="card-header">
    </div>

    <div id="resource_requirement_form">
      <form  action="{{ route('project.store')}}" method="POST" id="form_project">
        @csrf
        <input type="hidden" value="{{ $project->id }}" name="project_id">
            <div class="card-body form-body">
                        <div class="container m-5">Total Team Members Required:</div>
                        <table class="table table-bordered text-justify">
                            <h4 class="mb-3 ml-7 text-bold">Requirement Details</h4>
                            <thead>
                              <tr>
                                <th>Designation</th>
                                <th>Needed</th>
                                <th>Deployed</th>
                                <th>To Be Deployed</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($designations as $designation)
                              <tr>
                                <td><input type="text" name="designation[]" class="form-control" value="{{ $designation }}" readonly></td>
                                <td><input type="text" name="needed[]" class="form-control"></td>
                                <td><input type="text" name="deployed" class="form-control"></td>
                                <td><input type="text" name="to-be-deployed" class="form-control"></td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table> 
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-primary save-btn" id="save-btn-action">Save</button>
            </div>
      </form>
    </div>
</div>