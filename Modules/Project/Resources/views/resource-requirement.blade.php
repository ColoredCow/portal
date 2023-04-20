@extends('project::layouts.master')
@section('content')
    <div class="container">
        <div>
            <h1>Project Resource</h1>
        </div>
        <br>
        <div class="d-md-flex justify-content-between ml-md-3">
            <div>
                <h3 class="font-weight-bold">
                    Additional Resources Required in all Projects : {{ $resourceData['totalCount'] }}
                </h3>
            </div>
            <div class="d-flex align-items-center">
                <form  class="d-md-flex justify-content-between ml-md-3" action="{{ route('project.resource-requirement')}}", method="get", role="Search">
                    <input type="text" name="name" class="form-control" id="name"
                        placeholder="Enter the project name" value="{{ request()->get('name') }}">
                    <button class="btn btn-info ml-2 text-white">Search</button>
                </form>
            </div>
        </div>
        <br>

        <div>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th class="w-40p sticky-top">Client/Project Name</th>
                        <th class="w-25p sticky-top">Resouce Needed</th>
                        <th class="w-20p sticky-top">Resource Deployed</th>
                        <th class="w-20p sticky-top">Additional Resource Required</th>
                        <th class="sticky-top">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @can('projects.view')
                        @forelse ($resourceData['data'] as $clientName =>$clientProjectsData)
                            <tr class="bg-theme-warning-lighter">
                                <td colspan="5" class="font-weight-bold">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            {{ $clientName }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @foreach ($clientProjectsData as $projectName => $projectData)
                            <tr>
                                <td class="w-33p">
                                    <div class="pl-1 pl-xl-2">
                                        @php
                                            $project = $projectData['object'];
                                            $team_member_ids = $project->getTeamMembers->pluck('team_member_id')->toArray();
                                        @endphp
                                        @if (in_array(auth()->user()->id, $team_member_ids))
                                            <a href="{{ route('project.show', $project->id) }}">{{ $projectName }}</a> 
                                        @else
                                            {{ $projectName }}
                                        @endif
                                    </div>
                                </td>
                                <td> 
                                    @foreach ($projectData['teamMemberNeededByDesignation'] as $designationName => $count)
                                        <div> {{ $designationName }} : {{ $count }} </div>
                                    @endforeach 
                                </td>
                                <td> 
                                    @foreach ($projectData['currentTeamMemberCountByDesignation'] as $designationName => $count)
                                        <div> {{ $designationName }} : {{ $count }} </div>
                                    @endforeach
                                </td>  
                                <td> 
                                    <div class="d-flex justify-content-center"> {{ $projectData['additionalResourceRequired'] }} </div>
                                </td> 
                                <td>
                                    <div>
                                        <button type="button" class="btn btn-success text-truncate" data-toggle="modal" data-target="#requisitionModal">
                                          <i class="fa fa-plus mr-1"></i>Add Requisition
                                        </button>
                                    </div>
                                </td>
                            @endforeach
                            @empty
                            <tr>
                                <td colspan="4">
                                    <p class="my-4 text-left">
                                        No such projects found.
                                    </p>
                                <td>
                            </tr>
                        @endforelse
                    @endcan  
                </tbody>
            </table>
        </div>
    </div>    
@endsection

        