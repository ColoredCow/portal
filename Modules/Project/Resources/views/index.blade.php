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
                <a href= "{{ route('project.create') }}" class="btn btn-success text-white"> <i class="fa fa-plus mr-1"></i>{{ __('Add new project') }}</a>
            </span>
        @endcan
    </div>
    <div class="mb-2">
        <form class="d-md-flex justify-content-between ml-md-3" action="{{ route('project.index', ['status' => 'active'])  }}">
            <div class='d-flex justify-content-between align-items-md-center mb-2 mb-xl-0'>
                <h4 class="">{{ config('project.status')[request()->input('status', 'active')] }} Projects</h4>
                <input type="hidden" name="status" value="{{ request()->input('status', 'active') }}">
                <select class="fz-14 fz-lg-16 p-1 bg-info ml-3 my-auto text-white rounded border-0" name="projects"
                    onchange="this.form.submit()">
                    <option value="my-projects" {{ (request()->get('projects') == 'my-projects' || !request()->has('projects')) ? 'selected' : '' }}>
                        {{ __('My Projects') }} </option>
                    <option value="all-projects" {{ request()->get('projects') == 'all-projects' ? 'selected' : '' }}>
                        {{ __('All Projects') }} </option>
                </select>
            </div>
            <div class="d-flex align-items-center">
                <input type="text" name="name" class="form-control" id="name" placeholder="Enter the project name"
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
                    <th class="w-33p sticky-top">Client/Project Name</th>
                    <th class="sticky-top">Team Members</th>
                    <th class="sticky-top">Tags</th>
                    <th class="sticky-top">Velocity (Hours)</th>
                </tr>
            </thead>
            <tbody id="clientList">
                @include('project::client-project')
            </tbody>
        </table>
    </div>
</div>
@endsection
