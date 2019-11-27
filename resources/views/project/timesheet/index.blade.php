@extends('layouts.app')
@section('content')
<div class="container">
    <br>
    @include('finance.menu', ['active' => 'projects'])
    <br><br>
    <div class="row">
        <div class="col-md-6 pl-0"><h1>Time sheets</h1></div>
        <div class="col-md-6 pr-0"><a href="{{ route('project.timesheet.create', $project) }}" class="btn btn-success float-right">Setup new timesheet</a></div>

        @if (! empty($timesheets))
            <div class="accordion w-100" id="accordionExample">
                @foreach($timesheets as $timesheet)
                    <div class="card">
                        <div class="card-header" id="timesheet_{{ $timesheet->id }}">
                            <h2 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse_{{ $timesheet->id }}" aria-expanded="true" aria-controls="collapse_{{ $timesheet->id }}">
                                    {{ $project->name }}: {{ $timesheet->start_date }} - {{ $timesheet->end_date }}
                                </button>
                            </h2>
                        </div>

                        <div id="collapse_{{ $timesheet->id }}" class="collapse {{ $loop->index ? '' : 'show' }}" aria-labelledby="timesheet_{{ $timesheet->id }}" data-parent="#accordionExample">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Modules</th>
                                        <th>Status</th>
                                        <th>Subtask</th>
                                    </tr>
                                   {{-- @foreach($timesheet->efforts as $effort)
                                   @endforeach --}}
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection