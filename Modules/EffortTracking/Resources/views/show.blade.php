@extends('efforttracking::layouts.master')
@section('content')
    <div class="project-effort-tracking-container container py-10">
        <a href="{{ route('project.index') }}"
            class="text-theme-body text-decoration-none mb-2 mb-xl-4 align-items-center">
            <span class="mr-1 d-inline-flex w-8 h-8 w-xl-12 h-xl-12">
                {!! file_get_contents(public_path('icons/prev-icon.svg')) !!}
            </span>
            <span>All Projects</span>
        </a>

        <div class="card mt-4">
            <div class="card-header d-flex flex-row justify-content-between">
                <h2>{{ $project->name }} - Effort Details for {{ $currentMonth }}</h4>
                    <div>
                        <h2 class="fz-18 leading-22">Hours Booked: <span>{{ $project->current_hours_for_month }}</span>
                        </h2>
                        <h2 class="fz-18 leading-22" id="projectHours">Expected Hours:
                            <span>{{ $project->current_expected_hours }}</span>
                        </h2>
                        <h2 class="fz-18 leading-22">Expected Hours Till Today:
                            <span>{{ $project->expected_hours_till_today }}</span>
                        </h2>
                        <h2 class="fz-18 leading-22" id="projectVelocity">Velocity: <span>{{ $project->velocity }}</span>
                        </h2>
                    </div>
            </div>
            <div class="effort-tracking-data">
                <div class="d-flex flex-row p-5 d-flex justify-content-center">
                    <div class="d-flex flex-column mr-3 form-group">
                        <label>Start date</label>
                        <input type="date" name="start_date" disabled="disabled"
                            value="{{ $startDate->toDateString() }}">
                    </div>
                    <div class="d-flex flex-column ml-3">
                        <label>End date</label>
                        <input type="date" name="end_date" disabled="disabled" value="{{ $endDate->toDateString() }}">
                    </div>
                </div>
                @if ($project->current_hours_for_month === 0)
                    <h2 class="text-center pb-6 font-weight-bold text-uppercase text-danger">No data available</h2>
                @else
                    <div class="mt-4">
                        <input type="hidden" name="team_members_effort" value="{{ $teamMembersEffort }}">
                        <input type="hidden" name="workingDays" value="{{ $workingDays }}">
                        <input type="hidden" name="users" value="{{ $users }}">
                        <canvas class="w-full" id="effortTrackingGraph"></canvas>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="project-resource-effort-tracking-container container mt-4 pb-10">
        <div class="card">
            <div class="card-header">
                <div>
                    <h4>{{ $project->name }} - Members
                        <i class="fa fa-spinner fa-spin ml-2 d-none"></i>
                        <i class="ml-2 font-weight-bold fa fa-refresh c-pointer" aria-hidden="true"
                            data-url="{{ route('effort-tracking.refresh', $project) }}"></i>
                        @if ($project->last_updated_at)
                            <div class="fz-14 float-right mr-3 mt-1">
                                {{ config('project.meta_keys.last_updated_at.value') . __(': ') . $project->last_updated_at }}
                            </div>
                        @endif
                    </h4>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="pb-lg-4">Name</th>
                            <th scope="col" class="pb-lg-4">Hours Booked</th>
                            <th scope="col" class="pb-lg-4">Expected Hours</th>
                            <th scope="col" class="w-lg-200">Expected Hours Till Today</th>
                            <th scope="col" class="pb-lg-4">Hours To Add</th>
                            <th scope="col" class="pb-lg-4">Velocity <span data-toggle="tooltip" data-placement="right"
                                    title="Velocity is the ratio of current hours in project and expected hours."><i
                                        class="fa fa-question-circle"></i>&nbsp;</span></th>
                            <th scope="col" class="pb-lg-4">
                                FTE
                                <span data-toggle="tooltip" data-placement="right"
                                    title="{{ __('This is portion of the overall FTE that contributed to this projects by employee till ') .(now(config('constants.timezone.indian'))->format('H:i:s') < config('efforttracking.update_date_count_after_time')? today(config('constants.timezone.indian'))->subDay()->format('d M'): today(config('constants.timezone.indian'))->format('d M')) .'.' }}">
                                    <i class="fa fa-question-circle"></i>&nbsp;
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($project->getTeamMembers as $teamMember)
                            <tr>
                                <th scope="row" id="user-name<?php echo $teamMember->user->id; ?>">{{ $teamMember->user->name }}</th>
                                <td
                                    class="{{ $teamMember->current_actual_effort >= $teamMember->expected_effort_till_today ? 'text-success' : ($teamMember->current_actual_effort < $teamMember->current_expected_effort ? 'text-danger' : '') }}">
                                    {{ $teamMember->current_actual_effort }}</td>
                                <td>{{ $teamMember->current_expected_effort }}</td>
                                <td>{{ $teamMember->expected_effort_till_today }}</td>
                                <td>{{ $teamMember->expected_effort_till_today - $teamMember->current_actual_effort }}
                                </td>
                                <td class="{{ $teamMember->velocity >= 1 ? 'text-success' : 'text-danger' }}">
                                    {{ $teamMember->velocity }}</td>
                                <td>{{ $teamMember->fte }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-message" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Refresh Effort</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body py-5">
                    <div class="text-danger">
                        <p>
                            Something went wrong while refreshing the efforts. <br>
                            Please check if the effortsheet formatting is correct.
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
