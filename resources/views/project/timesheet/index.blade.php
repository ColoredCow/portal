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
            <div class="accordion w-100" id="accordionExample">
                @foreach($timesheets as $timesheet)
                    <timesheet-component
                        :timesheet="{{ $timesheet }}"
                        :project="{{ $project }}"
                        :subtasks="{{ json_encode(config('constants.project.timesheet.module.subtasks')) }}"
                        ></timesheet-component>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection