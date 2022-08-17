<div class="card">
    <div id="client_projects_container" class="collapse show">
        <div class="card-body">
            <div class="d-flex px-5">
                <div class="w-33p ml-2">
                    <h5 class="font-muli-bold">Name</h5>
                </div>
                <div class="w-40p ml-2">
                    <h5 class="font-muli-bold">Team Members</h5>
                </div>
                <div class="w-20p mr-10">
                    <h5 class="font-muli-bold">Project Status</h5>
                </div>
                <div class="w-20p ml-15">
                    <h5 class="font-muli-bold">Actions</h5>
                </div>
            </div>
            <hr class="mt-0 mx-4">
            @foreach ($projects as $project)
                <div class="d-flex px-5 mt-5">
                    <div class="w-33p ml-2">
                        <a href="{{route('project.show', $project )}}">
                            {{ $project->name }}
                        </a>
                    </div>
                    <div class="w-30p w-md-40p ml-2">
                        @foreach($project->teamMembers ?:[] as $teamMember)
                            <span class="tooltip-wrapper" data-html="true" data-toggle="tooltip" title="{{ $teamMember->name }} - {{ config('project.designation')[$teamMember->pivot->designation] }}">
                                <img src="{{ $teamMember->avatar }}" class="w-35 h-30 rounded-circle mr-1 mb-1">
                            </span>
                        @endforeach 
                    </div>
                    <div class="w-30p mr-10">
                        <h5>{{ config('project.status')[$project->status] }}</h5>
                    </div>
                        <div class="w-10p mr-10">
                            <button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">Remove</button>
                            <div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">REMOVE</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('project.destroy', $project) }}" method="POST" id="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <div class="form-group">
                                                    <label for="name"><span>Reason for Deletion</span></label>
                                                    <input type="text" class="form-control" name="comment">
                                                </div>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                                <button class="btn btn-primary" onclick="">Yes</button> 
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="card-footer">
                <a href="{{ route('client.index') }}" class="btn btn-primary btn-theme-gray-lighter mr-3">Exit</a>
            </div>
        </div>

    </div>