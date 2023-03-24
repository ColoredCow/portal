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
                        <th class="sticky-top">Additional Resource Required</th>
                        <th class="sticky-top">Resource Deployed</th>
                        <th class="sticky-top">Resource Needed</th>
                    </tr>
                </thead>
                <tbody>
                    @can('projects.view')
                        @foreach ($resourceData['data'] as $clientName =>$clients)
                            <tr class="bg-theme-warning-lighter">
                                <td colspan="4" class="font-weight-bold">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            {{ $clientName }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @foreach ($clients as $projectName => $projects)
                            <tr>
                                <td class="w-33p">
                                    <div class="pl-1 pl-xl-2">
                                        {{ $projectName }}
                                    </div>
                                </td>
                                <td> 
                                    <div> Total Resource Required : {{ $projects['totalResourceRequirement'] }} </div>
                                    <div> Additional Resource Required : {{ $projects['additionalResourceRequired'] }} </div>
                                </td>
                                <td> 
                                    @foreach ($projects['currentTeamMemberCountByDesignation'] as $designationName => $count)
                                        <div> {{ $designationName }} : {{ $count }} </div>
                                    @endforeach
                                </td>  
                                <td> 
                                    @foreach ($projects['teamMemberNeededByDesignation'] as $designationName => $count)
                                        <div> {{ $designationName }} : {{ $count }} </div>
                                    @endforeach 
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

        