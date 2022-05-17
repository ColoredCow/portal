@extends('project::layouts.master')
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
    <div class='d-none d-md-flex justify-content-between'>
        @include('project::menu_header')
        @can('projects.create')
            <span class='mt-4'>
                <a href= "{{ route('project.create') }}" class="btn btn-info text-white">{{ __('Add new project') }}</a>
            </span>
        @endcan
    </div>
    <div class="mb-2">
        <form class="d-md-flex justify-content-between ml-md-3" action="{{ route('project.index', ['status' => 'active'])  }}">
            <div class='d-flex justify-content-between align-items-md-center mb-2 mb-xl-0'>
                <h4 class="">{{ config('project.status')[request()->input('status', 'active')] }} Projects
                    ({{ $projects ? $projects->count() : ''}})</h4>
                <input type="hidden" name="status" value="{{ request()->input('status', 'active') }}">
                <select class="fz-14 fz-lg-16 p-1 bg-info ml-3 my-auto text-white rounded border-0" name="projects"
                    onchange="this.form.submit()">
                    <option value="my-projects" {{ request()->get('projects') == 'my-projects' ? 'selected' : '' }}>
                        {{ __('My Projects') }} </option>
                    <option value="all-projects" {{ (request()->get('projects') == 'all-projects' || !request()->has('projects')) ? 'selected' : '' }}>
                        {{ __('All Projects') }} </option>
                </select>
            </div>
            <div class="d-flex align-items-center">
                <input type="text" name="name" class="form-control" id="name" placeholder="Project name"
                value={{request()->get('name')}}>
                <button class="btn btn-info ml-2 text-white">Search</button> 
            </div>
        </form>
    </div>
    <div class='d-md-none mb-2'>
        @can('projects.create')
            <div class="d-flex flex-row-reverse">
                <a href= "{{ route('project.create') }}" class="btn btn-info text-white">{{ __('Add new project') }}</a>
            </div>
        @endcan
        @include('project::menu_header')
    </div>
    <div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th class="w-33p">Name</th>
                    <th class="w-33p">Client</th>
                    <th>Team Members</th>
                    <th>FTE</th>
                </tr>
            </thead>
            <tbody>
                @can('projects.view')
                @forelse($projects as $project)
                    <tr>
                        @can('projects.update')
                        <td class="w-33p"> <a href="{{ route('project.show', $project) }}">{{ $project->name }}</a> </td>
                        @else
                        <td class="w-33p"> {{ $project->name }} </td>
                        @endcan
                        <td class="w-33p">{{ $project->client->name }}</td>
                        <td>
                            @foreach($project->teamMembers ?:[] as $teamMember)
                                <span class="tooltip-wrapper" data-html="true" data-toggle="tooltip" title="{{ $teamMember->name }} - {{ config('project.designation')[$teamMember->pivot->designation] }}">
                                    <img src="{{ $teamMember->avatar }}" class="w-35 h-30 rounded-circle mr-1 mb-1">
                                </span>
                            @endforeach 
                        </td>
                        <td>
                            <a class="{{ $project->fte >= 1 ? 'text-success' : 'text-danger' }}" href="{{route('project.effort-tracking', $project)}}"><i class="mr-0.5 c-pointer fa fa-external-link-square"></i></a>
                            <a class="{{ $project->fte >= 1 ? 'text-success' : 'text-danger' }} font-weight-bold">{{ $project->fte }}</a>
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
