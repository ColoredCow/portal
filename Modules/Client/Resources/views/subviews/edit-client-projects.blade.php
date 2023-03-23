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
                            @include('client::subviews.create-client-projects-modal')
                            <button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal{{$project->id}}">Remove</button>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="card-footer">
                <a href="{{ route('client.index') }}" class="btn btn-primary btn-theme-gray-lighter mr-3">Exit</a>
            </div>
        </div>
    </div>
</div>
