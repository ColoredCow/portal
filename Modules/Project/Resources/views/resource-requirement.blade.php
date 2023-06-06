@extends('project::layouts.master')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
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
                <a href ="{{ route('project.resource-requirement')}}" >
                    <button class="btn btn-danger ml-2 pt-1.5 pb-1.5 text-white">Clear</button>
                </a> 
            </div>
        </div>

        <br>

        <div>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th class="w-30p sticky-top">Client/Project Name</th>
                        <th class="sticky-top">Resouce Needed</th>
                        <th class="sticky-top">Resource Deployed</th>
                        <th class="sticky-top" colspan="2">Additional Resource Required</th>
                    </tr>
                </thead>
                <tbody>
                    @can('projects.view')
                        @forelse ($resourceData['data'] as $clientName =>$clientProjectsData)
                            <tr class="bg-theme-warning-lighter">
                                <td colspan="4" class="font-weight-bold">
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
                                    @foreach ($projectData['countByDesignation'] as $designationName => $count)
                                        <div> {{ $designationName }} : {{ $count }} </div>
                                    @endforeach
                                </td> 
                            </tr>
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

        