@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('finance.menu', ['active' => 'projects'])
    <br><br>
    <div class="row">
        <div class="col-md-6"><h1>Projects</h1></div>
        <div class="col-md-6"><a href="/projects/create" class="btn btn-success float-right">Create </a></div>
    </div>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Name</th>
            <th>Client</th>
            <th>Started On</th>
            <th>Status</th>
        </tr>
        @foreach ($projects as $project)
        	<tr>
        		<td>
        			<a href="/projects/{{ $project->id }}/edit/">{{ $project->name }}</a>
        		</td>
        		<td>{{ $project->client->name }}</td>
        		<td>
        			@if ($project->started_on)
        			<span>{{ date(config('constants.display_date_format'), strtotime($project->started_on)) }}</span>
        			@else
        			<span>-</span>
        			@endif
        		</td>
                <td>
                @switch ($project->status)
                    @case('active')
                        <span class="badge badge-pill badge-success">
                        @break
                    @case('inactive')
                        <span class="badge badge-pill badge-danger">
                        @break
                @endswitch
                {{ $project->status }}</span>
                </td>
        	</tr>
        @endforeach
    </table>
    {{ $projects->links() }}
</div>
@endsection
