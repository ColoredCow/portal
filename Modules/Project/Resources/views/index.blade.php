@extends('project::layouts.master')
@section('content')

<div class="container" id="vueContainer">
    @include('project::menu_header')
    <br>
    <div class="d-flex justify-content-between mb-2 align-items-center">
       <div class="d-md-flex">
            <h4 class="">{{ config('project.status')[request()->input('status', 'active')] }} Projects
                ({{ $projects ? $projects->count() : ''}})</h4>
            <form class="mx-md-3" action="{{ route('project.index', ['status' => 'active'])  }}">
                <input type="hidden" name="status" value="{{ request()->input('status', 'active') }}">
                <select class="fz-14 fz-lg-16 p-1 bg-info text-white rounded border-0" name="projects"
                    onchange="this.form.submit()">
                    <option value="my-projects" {{ request()->get('projects') == 'all-projects' ? '' : 'selected' }}>
                        {{ __('My Projects') }} </option>
                    <option value="all-projects" {{ request()->get('projects') == 'all-projects' ? 'selected' : '' }}>
                        {{ __('All Projects') }} </option>
                </select>
            </form>
        </div>
        @can('projects.create')
        <span>
            <a  href= "{{ route('project.create') }}" class="btn btn-info text-white"> Add new project</a>
        </span>
        @endcan
    </div>

    <div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Reference Id</th>
                    <th>Client</th>
                    <th>Team Members</th>
                    <th>FTE</th>
                </tr>
            </thead>
            <tbody>
                @can('projects.view')
                @forelse($projects as $project)
                    <tr>
                        @can('projects.update')
                        <td> <a href="{{ route('project.edit', $project) }}">{{ $project->name }}</a> </td>
                        @else
                        <td> {{ $project->name }} </td>
                        @endcan
                        <td> {{ $project->client_project_id }} </td>
                        <td>{{ $project->client->name }}</td>
                        <td>
                            @foreach($project->teamMembers ?:[] as $teamMember)
                                <span class="tooltip-wrapper" data-toggle="tooltip" title="{{ $teamMember->name}} - {{config('project.designation')[$teamMember->pivot->designation] }}">
                                    <img src="{{ $teamMember->avatar }}" class="w-35 h-30 rounded-circle mr-1">
                                </span>
                            @endforeach 
                        </td>
                        <td>
                            <a href="{{route('project.effort-tracking', $project )}}">Click Here</a>
                        </td>
                    </tr>
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
