<div class="overflow-x-scroll card min-w-660">
    <div id="client_projects_container" class="collapse show">
        <div class="card-body">
            <div class="d-flex px-5">
                <div class="w-33p ml-2">
                    <h5 class="font-muli-bold">Name</h5>
                </div>
                <div class="w-40p ml-2">
                    <h5 class="font-muli-bold">Team Members</h5>
                </div>
                <div class="w-30p ml-2">
                    <h5 class="font-muli-bold">Project Status</h5>
                </div>
                <div class="w-20p ml-2">
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
                    <div class="w-40p w-md-40p ml-2">
                        @foreach($project->teamMembers ?:[] as $teamMember)
                            <span class="tooltip-wrapper" data-html="true" data-toggle="tooltip" title="{{ $teamMember->name }} - {{ config('project.designation')[$teamMember->pivot->designation] }}">
                                <img src="{{ $teamMember->avatar }}" class="w-35 h-30 rounded-circle mr-1 mb-1">
                            </span>
                        @endforeach 
                    </div>
                    <div class="w-30p ml-2">
                        <h5>{{ config('project.status')[$project->status] }}</h5>
                    </div>
                        <div class="w-20p ml-2">
                            @include('client::subviews.create-client-projects-modal')
                            <button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal{{$project->id}}">Remove</button>
                        </div>
                    </div>
                @endforeach
                
                <div class="ml-7 mb-5 mt-20 font-muli-bold fz-20">Project Review Details</div>
                <div class="d-flex px-5">
                <div class="w-33p ml-2">
                    <h5 class="font-muli-bold">Client Name</h5>
                </div>
                <div class="w-40p ml-2">
                    <h5 class="font-muli-bold">Project Reviewer</h5>
                </div>
                <div class="w-30p ml-2">
                    <h5 class="font-muli-bold">Next Review Date</h5>
                </div>
                <div class="w-20p ml-2">
                    <h5 class="font-muli-bold">Actions</h5>
                </div>
            </div>
            <hr class="mt-0 mx-4">
            <div class="d-flex px-5 my-5">
                <div class="w-33p ml-2">
                    {{ $client->name }}
                </div>
                <div class="w-40p w-md-40p ml-2">
                    @if($client->latest_project_review && $client->latest_project_review->user)
                        <span class="tooltip-wrapper" data-html="true" data-toggle="tooltip" title="{{ $client->latest_project_review->user->name  }}">
                            <img src="{{ $client->latest_project_review->user->avatar }}" class="w-35 h-30 rounded-circle mr-1 mb-1">
                        </span>
                    @else
                        NA
                    @endif
                </div>
                <div class="w-30p ml-2">
                @if($client->latest_project_review && $client->latest_project_review->meeting_datetime)
                        <p>{{$client->latest_project_review->meeting_datetime}}</p>
                    @else
                        NA
                    @endif
                </div>
                    <div class="w-20p ml-2">
                        <button type="button" class="btn btn-info text-white" data-toggle="modal" data-target="#projectReviewModal">Update</button>
                        @include('client::subviews.project-review-modal')
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('client.index') }}" class="btn btn-primary btn-theme-gray-lighter mr-3">Exit</a>
            </div>
        </div>
    </div>
</div>
