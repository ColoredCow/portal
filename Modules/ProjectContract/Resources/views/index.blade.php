@extends('projectcontract::layouts.master')

@section('content')
<div class="container" id="vueContainer">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class='d-none d-md-flex justify-content-end'>
        <span class='mt-4'>
            <a href= "{{ route('projectcontract.create') }}" class="btn btn-info text-white">{{ __('Add new project contract') }}</a>
        </span>
    </div>
    <div class="mb-2 mt-2">
        <form class="d-md-flex justify-content-between ml-md-3">
            <div class='d-flex justify-content-between align-items-md-center mb-2 mb-xl-0'>
                <h4 class="">Project Contracts</h4>
            </div>
            <div class="d-flex align-items-center">
                <input type="text" name="name" class="form-control" id="name" placeholder="Project name"
                value={{request()->get('name')}}>
                <button class="btn btn-info ml-2 text-white">Search</button>
            </div>
        </form>
    </div>
    <div class='d-md-none mb-2'>
        <div class="d-flex flex-row-reverse">
            <a href= "{{ route('projectcontract.create') }}" class="btn btn-info text-white">{{ __('Add new project contract') }}</a>
        </div>
    </div>
    <div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th class="w-33p sticky-top">Client/Project Name</th>
                    <th class="sticky-top">Team Members</th>
                    <th class="sticky-top">Tags</th>
                    <th class="sticky-top">Velocity (Hours)</th>
                </tr>
            </thead>
            <tbody>
                @can('projects.view')
                    @forelse($clients as $client)
                        <tr class="bg-theme-warning-lighter">
                            <td colspan=4 class="font-weight-bold">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        {{ $client->name }}
                                    </div>
                                    <div class="">{{ __('Total Hours Booked: ') . $client->current_hours_in_projects }}</div>
                                </div>
                            </td>
                        </tr>
                        @foreach($client->projects as $project)
                            <tr>
                                @can('projects.update')
                                    <td class="w-33p"><div class="pl-2 pl-xl-3"><a href="{{ route('project.show', $project) }}">{{ $project->name }}</a></div></td>
                                @else
                                    <td class="w-33p"><div class="pl-2 pl-xl-3">{{ $project->name }}</div></td>
                                @endcan
                                <td class="w-20p">
                                    @foreach($project->getTeamMembers ?:[] as $teamMember)
                                        <span class="content tooltip-wrapper"  data-html="true" data-toggle="tooltip"  title="{{ $teamMember->user->name }} - {{ config('project.designation')[$teamMember->designation]}} <br>    Efforts: {{$teamMember->current_actual_effort}} Hours" >
                                        
                                            <a href={{ route('employees.show', $teamMember->user->employee) }}><img src="{{ $teamMember->user->avatar }}" class="w-35 h-30 rounded-circle mb-1 mr-0.5 {{ $teamMember->current_actual_effort >= $teamMember->current_expected_effort ? 'border border-success' : 'border border-danger' }} border-2"></a>
                                        </span>
                                    @endforeach
                                </td>
                                <td>
                                    @if(empty($project->projectContracts->first()->contract_file_path))
                                        <span class="badge badge-light border border-dark rounded-0">No Contract</span>
                                    @endif
                                </td>
                                <td class="w-20p">
                                    @php
                                        $textColor = $project->velocity >= 1 ? 'text-success' : 'text-danger'
                                    @endphp
                                    <a class="{{ $textColor }}" href="{{route('project.effort-tracking', $project)}}"><i class="mr-0.5 fa fa-external-link-square"></i></a>
                                    <span class="{{ $textColor }} font-weight-bold">{{ $project->velocity . ' (' . $project->current_hours_for_month . ' Hrs.)' }}</span>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="3">
                                <p class="my-4 text-left"> No {{ config('project.status')[request()->input('status', 'active')] }} projects found.</p>
                            <td>
                        </tr>
                    @endforelse
                @else
                <tr>
                    <td colspan="3">
                        <p class="my-4 text-left"> You don't have permission to see projects.</p>
                    <td>
                </tr>
                @endcan
            </tbody>
        </table>
    </div>
</div>
@endsection
