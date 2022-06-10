@extends('layouts.app')
@section('content')

<div class="container containermodified">
    <h1>
        @if($employee->user == null)
            No Projects
        @else
            {{$employee->user->name}}
        @endif
    </h1>
    <div class="mt-4 card">
        <div class="card-header">
            Project Details
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="pb-lg-4">Project Name</th>
                    <th scope="col" class="pb-lg-4">Hours Booked</th>
                    <th scope="col" class="pb-lg-4">Expected Hours</th>
                    <th scope="col" class= "w-lg-200">Expected Hours Till Today</th>
                    <th scope="col" class= "pb-lg-4">Hours To Add</th>
                    <th scope="col" class="pb-lg-4">Velocity <span data-toggle="tooltip" data-placement="right" title="Velocity is the ratio of current hours in project and expected hours."><i class="fa fa-question-circle"></i>&nbsp;</span></th>
                    <th scope="col" class="pb-lg-4">
                        FTE 
                        <span data-toggle="tooltip" data-placement="right" title="{{ __('This is portion of the overall FTE that contributed to this projects by employee till ') . (now(config('constants.timezone.indian'))->format('H:i:s') < config('efforttracking.update_date_count_after_time') ?  today(config('constants.timezone.indian'))->subDay()->format('d M') : today(config('constants.timezone.indian'))->format('d M')). "." }}"  >
                            <i class="fa fa-question-circle"></i>&nbsp;
                        </span>
                    </th>
                </tr>
                <tbody>
                    @foreach($employee->user->activeProjectTeamMembers as $activeProjectTeamMember)
                        <tr>
                            <td></td>
                            <td class="{{ $activeProjectTeamMember->current_actual_effort >= $activeProjectTeamMember->expected_effort_till_today ? 'text-success' : ($activeProjectTeamMember->current_actual_effort < $activeProjectTeamMember->current_expected_effort ? 'text-danger' : '') }}">{{$activeProjectTeamMember->current_actual_effort}}</td>
                            <td>{{$activeProjectTeamMember->current_expected_effort}}</td>
                            <td>{{$activeProjectTeamMember->expected_effort_till_today}}</td>
                            <td>{{$activeProjectTeamMember->expected_effort_till_today - $activeProjectTeamMember->current_actual_effort}}</td>
                            <td class="{{$activeProjectTeamMember->getVelocityAttribute() >= 1 ? 'text-success' : 'text-danger' }}">{{$activeProjectTeamMember->getVelocityAttribute()}}</td>
                            <td>{{$activeProjectTeamMember->fte}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </thead>    
        </table>
    </div>
</div>    
@endsection
