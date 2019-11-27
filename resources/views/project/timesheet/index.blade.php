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
                                <button class="btn btn-link text-dark" type="button" data-toggle="collapse" data-target="#collapse_{{ $timesheet->id }}" aria-expanded="true" aria-controls="collapse_{{ $timesheet->id }}">
                                    {{ $project->name }}: <strong>{{ $timesheet->start_date->format('d-M-Y') }}</strong> - <strong>{{ $timesheet->end_date->format('d-M-Y') }}</strong>
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
                                        <th>Total</th>
                                        <th>Mon, 25 Nov</th>
                                        <th>Tue, 26 Nov</th>
                                        <th>Wed, 27 Nov</th>
                                        <th>Thu, 28 Nov</th>
                                        <th>Fri, 29 Nov</th>
                                    </tr>
                                    <tr>
                                        <td>Modules</td>
                                        <td>Status</td>
                                        <td>
                                            <select class="form-control" id="exampleFormControlSelect1">
                                                @foreach(config('constants.project.timesheet.module.subtasks') as $subtaskSlug => $subtaskTitle)
                                                    <option value="{{ $subtaskSlug }}">{{ $subtaskTitle }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="number" name="" class="form-control"></td>
                                        <td><input type="number" name="" class="form-control"></td>
                                        <td><input type="number" name="" class="form-control"></td>
                                        <td><input type="number" name="" class="form-control"></td>
                                        <td><input type="number" name="" class="form-control"></td>
                                        <td><input type="number" name="" class="form-control"></td>
                                    </tr>
                                    {{-- @foreach($timesheet->efforts as $effort)
                                   @endforeach --}}
                                </table>
                                <button class="btn btn-primary">Add effort</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection