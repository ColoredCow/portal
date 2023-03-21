@extends('project::layouts.master')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Project Resource</h1>
        </div>

        <br>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <h3 class="font-weight-bold">
            Additional Resources Required in all Projects : {{ $additionalResourceRequired }}
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
                        @forelse($clients as $client)
                            @php
                                $totalToBeDeployedCount = 0;
                                foreach ($client->projects as $project) {
                                    $totalToBeDeployedCount += $project->getTotalToBeDeployedCount();
                                }
                            @endphp

                            @if ($totalToBeDeployedCount > 0)
                                <tr class="bg-theme-warning-lighter">
                                    <td colspan="4" class="font-weight-bold">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                {{ $client->name }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @foreach ($client->projects as $project)
                                    @if ($project->getTotalToBeDeployedCount() > 0)
                                        <tr>
                                            <td class="w-33p">
                                                <div class="pl-1 pl-xl-2">
                                                    {{ $project->name }}
                                                </div>
                                            </td>
                                            <td>
                                                @php
                                                    $totalResourceRequiredCount = 0;
                                                    foreach ($designationKeys as $designationName) {
                                                        $count = $project->getResourceRequirementByDesignation($designationName)->total_requirement;
                                                        if ($count > 0){
                                                            $totalResourceRequiredCount += $count;
                                                        }
                                                    }
                                                @endphp

                                                <div> Total Resource Required : {{ $totalResourceRequiredCount }} </div>
                                                <div> Additional Resource Required : {{ $project->getTotalToBeDeployedCount()}}</div>
                                            </td>
                                            <td> 
                                                @foreach ($designationKeys as $designationName)
                                                    @php
                                                        $deployedCount = $project->getDeployedCountForDesignation($designationName);
                                                    @endphp

                                                    @if ($deployedCount > 0)
                                                        <div> {{ $designations[$designationName] }} : {{ $deployedCount }}
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </td>  
                                            <td> 
                                                @foreach ($designationKeys as $designationName)
                                                    @php
                                                        $resourceRequirementCount = $project->getResourceRequirementByDesignation($designationName)->total_requirement;
                                                    @endphp

                                                    @if ($resourceRequirementCount > 0)
                                                        <div> {{ $designations[$designationName] }} : {{ $resourceRequirementCount }}
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </td>  
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        @empty
                            <tr>
                                <td colspan="4">
                                    <p class="my-4 text-left"> No
                                        {{ config('project.status')[request()->input('status', 'active')] }}
                                        {{ ' ' }}
                                        {{ request()->input('is_amc', '0') == '1' ? 'AMC' : 'Main' }}
                                        projects found.
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
        