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
        <span>
            <a  href= "{{ route('project.create') }}" class="btn btn-info text-white"> Add new project</a>
        </span>
    </div>

    <div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Reference Id</th>
                    <th>Client</th>
                    <th>Team Members</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                    <tr>
                        <td> <a href="{{ route('project.edit', $project) }}">{{ $project->name }}</a> </td>
                        <td> {{ $project->client_project_id }} </td>
                        <td>{{ $project->client->name }}</td>
                        <td>
                            <ul class="ml-0 pl-3">
                                @foreach($project->teamMembers ?:[] as $teamMember)
                                <li>{{ $teamMember->name }} - {{ config('project.designation')[$teamMember->pivot->designation] }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3"> 
                            <p class="my-4 text-left"> No {{ config('project.status')[request()->input('status', 'active')] }} projects found.</p>  
                        <td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
    
</div>





@endsection
