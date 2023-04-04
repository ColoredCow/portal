@extends('project::layouts.master')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Project Resource</h1>
        </div>

        <br>

        <h3 class="font-weight-bold">
            Additional Resources Required in all Projects : {{ $resourceData['totalCount'] }}
        </h3>

        <br>

        <div>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th class="w-30p sticky-top">Client/Project Name</th>
                        <th class="sticky-top">Resouce Needed</th>
                        <th class="sticky-top">Resource Deployed</th>
                        <th class="sticky-top">Additional Resource Required</th>
                    </tr>
                </thead>
                <tbody>
                    @can('projects.view')
                        @foreach ($resourceData['data'] as $clientName =>$clientProjectsData)
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
                                            $projectId = (DB::table('projects')->where('name', $projectName)->get('id')->first())->id;
                                            $team_members = DB::table('project_team_members')->where('project_id', $projectId)->pluck('team_member_id')->toArray();
                                        @endphp
                                        @if(in_array(auth()->user()->id, $team_members))
                                            <a href="{{ route('project.show', $projectId) }}">{{ $projectName }}</a>
                                        @else
                                            {{$projectName}}
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
                            </tr>
                            @endforeach
                        @endforeach
                    @endcan  
                </tbody>
            </table>
        </div>
    </div>    
@endsection

        