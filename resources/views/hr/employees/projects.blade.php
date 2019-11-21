@extends('layouts.app')

@section('content')
<div class="container" id="employee_projects">
	<div class="row">
        <div class="col-md-12">
            <br>
            @include('hr.employees.menu')
            <br><br>
        </div>
        <div class="col-md-12">
            @include('status', ['errors' => $errors->all()])
        </div>
        <div class="col-md-12">
            <h1>Employee Projects</h1>
            <p><strong>Employee Name: {{$employee->name}}</strong></p>
        </div>
        <div class="col-md-12">
        	<table class="table table-striped table-bordered">
		        <tr>
		            <th>Name</th>
		            <th>Status</th>
		        </tr>
                @foreach($employee->projects as $project)
		        <tr>
		        	<td>
                        <a href="{{ route('projects.show', $project->id) }}">{{ $project->name }}</a>
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
        </div>
</div>

@endsection