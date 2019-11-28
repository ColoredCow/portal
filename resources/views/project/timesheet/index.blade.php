@extends('layouts.app')
@section('content')
<div class="container" id="project_timesheets_container">
    <br>
    @include('finance.menu', ['active' => 'projects'])
    <br><br>
    <div class="row">
        <div class="col-md-6 pl-0"><h1>Time sheets</h1></div>
        <div class="col-md-6 pr-0"><a href="{{ route('project.timesheet.create', $project) }}" class="btn btn-success float-right">Setup new timesheet</a></div>

        @if (! empty($timesheets))
            <div id="project-timesheets-container" class="w-100">
                @foreach($timesheets as $timesheet)
                    <a href="{{ route('project.timesheet.show', [
                        'project' => $project,
                        'timesheet' => $timesheet
                    ]) }}" class="mb-3 d-block">
                        <div class="card">
                            <div class="card-body">
                                <h4>{{ $timesheet->start_date->format('d-M-Y')  }} - {{ $timesheet->end_date->format('d-M-Y') }}</h4>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection