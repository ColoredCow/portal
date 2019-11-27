@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('finance.menu', ['active' => 'projects'])
    <br><br>
    <div class="row">
        <div class="col-md-6"><h1>TimeSheets</h1></div>
        <div class="col-md-6"><a href="{{ route('project.timesheet.create', $project) }}" class="btn btn-success float-right">Setup new timesheet</a></div>
    </div>

    <table class="table table-striped table-bordered">
        <tr>
            <th>Cycle</th>
            <th>Estimated effort</th>
            <th>Current Effort</th>
            <th>Action</th>
        </tr>


        @foreach ($project ?[]:[] as $project)
        	<tr>
        		<td>
        			<a href="{{ route('projects.show', $project->id) }}">{{ $project->name }}</a>
        		</td>
        		<td>{{ $project->client->name }}</td>
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
                <td>
                    <a href="{{ route('projects.edit', $project->id) }}">Edit</a>
                </td>
        	</tr>
        @endforeach
    </table>

</div>
@endsection