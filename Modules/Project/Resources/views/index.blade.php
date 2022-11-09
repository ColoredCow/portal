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
                    <a href="{{ route('project.create') }}" class="btn btn-success text-white ml-1"><i class="fa fa-plus"></i>
                        {{ __('Add new project') }}</a>
                </span>
            @endcan
        </div>
        <div class="mb-2">
            <form class="d-md-flex justify-content-between ml-md-3"
                action="{{ route('project.index', ['status' => 'active']) }}">
                <div class='d-flex justify-content-between align-items-md-center mb-2 mb-xl-0'>
                    <h4 class="">
                        {{ config('project.status')[request()->input('status', 'active')] }}
                        {{ ' ' }}
                        {{ request()->input('is_amc', '0') == '1' ? 'AMC' : 'Main' }}
                        Projects
                    </h4>
                    <input type="hidden" name="status" value="{{ request()->input('status', 'active') }}">
                    <input type="hidden" name="is_amc" value="{{ request()->input('is_amc', 0) }}">
                    <select class="fz-14 fz-lg-16 p-1 bg-info ml-3 my-auto text-white rounded border-0" name="projects"
                        onchange="this.form.submit()">
                        <option value="my-projects"
                            {{ request()->get('projects') == 'my-projects' || !request()->has('projects') ? 'selected' : '' }}>
                            {{ __('My Projects') }} </option>
                        <option value="all-projects" {{ request()->get('projects') == 'all-projects' ? 'selected' : '' }}>
                            {{ __('All Projects') }} </option>
                    </select>
                </div>
                <div class="d-flex align-items-center">
                    <input type="text" name="name" class="form-control" id="name"
                        placeholder="Enter the project name" value={{ request()->get('name') }}>
                    <button class="btn btn-info ml-2 text-white">Search</button>
                </div>
            </form>
        </div>
        <div class='d-md-none mb-2'>
            @can('projects.create')
                <div class="d-flex flex-row-reverse">
                    <a href="{{ route('project.create') }}" class="btn btn-info text-white">{{ __('Add new project') }}</a>
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
                <tbody>
                    @can('projects.view')
                        @forelse($clients as $client)
                            <tr class="bg-theme-warning-lighter">
                                <td colspan=4 class="font-weight-bold">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            {{ $client->name }}
                                        </div>
                                        <div class="">
                                            {{ __('Total Hours Booked: ') . $client->current_hours_in_projects }}</div>
                                    </div>
                                </td>
                            </tr>
                            @foreach ($client->projects as $project)
                                <tr>
                                    @can('projects.update')
                                        <td class="w-33p">
                                            <div class="pl-2 pl-xl-3"><a
                                                    href="{{ route('project.show', $project) }}">{{ $project->name }}</a></div>
                                        </td>
                                    @else
                                        <td class="w-33p">
                                            <div class="pl-2 pl-xl-3">{{ $project->name }}</div>
                                        </td>
                                    @endcan
                                    <td class="w-20p">
                                        @foreach ($project->getTeamMembers ?: [] as $teamMember)
                                            <span class="content tooltip-wrapper" data-html="true" data-toggle="tooltip"
                                                title="{{ $teamMember->user->name }} - {{ config('project.designation')[$teamMember->designation] }} <br>    Efforts: {{ $teamMember->current_actual_effort }} Hours">

                                                <a href={{ route('employees.show', $teamMember->user->employee) }}><img
                                                        src="{{ $teamMember->user->avatar }}"
                                                        class="w-35 h-30 rounded-circle mb-1 mr-0.5 {{ $teamMember->border_color_class }} border-2"></a>
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        @if (empty($project->projectContracts->first()->contract_file_path))
                                            <span class="badge badge-pill badge-secondary">No Contract</span>
                                        @endif
                                    </td>
                                    <td class="w-20p">
                                        @php
                                            $textColor = $project->velocity >= 1 ? 'text-success' : 'text-danger';
                                        @endphp
                                        <a class="{{ $textColor }}"
                                            href="{{ route('project.effort-tracking', $project) }}"><i
                                                class="mr-0.5 fa fa-external-link-square"></i></a>
                                        <span
                                            class="{{ $textColor }} font-weight-bold">{{ $project->velocity . ' (' . $project->current_hours_for_month . ' Hrs.)' }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="3">
                                    <p class="my-4 text-left"> No
                                        {{ config('project.status')[request()->input('status', 'active')] }}
                                        {{ ' ' }}
                                        {{ request()->input('is_amc', '0') == '1' ? 'AMC' : 'Main' }}
                                        projects found.
                                    </p>
                                <td>
                            </tr>
                        @endforelse
                    @else
                        <tr>
                            <td colspan="3">
                                <p class="my-4 text-left">
                                    No
                                    {{ config('project.status')[request()->input('status', 'active')] }}
                                    {{ ' ' }}
                                    {{ request()->input('is_amc', '0') == '1' ? 'AMC' : 'Main' }}
                                    projects found.
                                </p>
                            <td>
                        </tr>
                    @endcan
                </tbody>
            </table>
        </div>
        {{ $clients->withQueryString()->links() }}
    </div>
@endsection
