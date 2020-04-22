@extends('project::layouts.master')
@section('content')

<div class="container" id="vueContainer">
    @include('project::menu_header')
    <br>
    <div class="d-flex justify-content-between mb-2">
        <h4 class="mb-1 pb-1">Projects</h4>
        <span>
            <a  href= "{{ route('project.create') }}" class="btn btn-info text-white"> Add new project</a>
        </span>
    </div>

    <div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Client</th>
                    <th>Resources</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td> <a href="{{ route('project.edit', $project) }}">{{ $project->name }} ({{ $project->client_project_id }})</a> </td>
                        <td>{{ $project->client->name }}</td>
                        <td>
                            <ul class="ml-0 pl-3">
                                @foreach($project->resources ?:[] as $projectResource)
                                <li>{{ $projectResource->name }} - {{ config('project.resource_designations')[$projectResource->pivot->designation] }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ config('project.status')[$project->status] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    
</div>





@endsection

