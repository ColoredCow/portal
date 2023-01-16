<div class="card">
    <div class="card-header">
    </div>

    <div>
            <div class="card-body">
                        <div class="container m-5">Total Team Members Required:</div>
                        <table class="table text-justify">
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
                                <td>{{ $designation }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table> 
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-primary save-btn" v-on:click="updateProjectForm('update_project_repository_form')">Save</button>
            </div>
    </div>
</div>