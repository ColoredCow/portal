@extends('layouts.app')
@section('content')
<div class="container containermodified">
    <h1>
            {{$employee->name}}
    </h1>
    <div class="mt-4 card">
        <div class="card-header font-weight-bold pl-6">
            Projects
        </div>
        <table class="table">
            <thead>
                <tr class="bg-theme-gray text-light">
                    <th scope="col" class="pb-lg-4"><div class="ml-6">Project Name</div></th>
                    <th scope="col" class="pb-lg-4">Expected Monthly Hrs.</th>
                    <th scope="col" class= "pb-lg-4">Hours Booked <span data-toggle="tooltip" data-placement="right" title="Hours in effortsheet for the current month."><i class="fa fa-question-circle"></i>&nbsp;</span></th>
                    <th scope="col" class="pb-lg-4">Velocity <span data-toggle="tooltip" data-placement="right" title="Velocity is the ratio of current hours in project and expected hours."><i class="fa fa-question-circle"></i>&nbsp;</span></th>
                    <th scope="col" class="pb-lg-4">
                        FTE Covered
                        <span data-toggle="tooltip" data-placement="right" title="{{ __('This is portion of the overall FTE that contributed to this projects by employee till ') . (now(config('constants.timezone.indian'))->format('H:i:s') < config('efforttracking.update_date_count_after_time') ?  today(config('constants.timezone.indian'))->subDay()->format('d M') : today(config('constants.timezone.indian'))->format('d M')). "." }}"  >
                            <i class="fa fa-question-circle"></i>&nbsp;
                        </span>
                    </th>
                </tr>
                <tbody>
                    @if(optional($employee->user)->activeProjectTeamMembers == null)
                        </table>
                        <div class="fz-lg-28 text-center mt-2"><div class="mb-2">Not in any project</div></div>
                    @else
                        @foreach($employee->user->activeProjectTeamMembers as $activeProjectTeamMember)
                            <tr>
                                <td class="c-pointer"><a class ="ml-4"href="http://portal.test/projects/1/show">{{$activeProjectTeamMember->project->name}}</a></td>
                                <td>{{$activeProjectTeamMember->daily_expected_effort * count($activeProjectTeamMember->project->getWorkingDaysList(today(config('constants.timezone.indian'))->startOfMonth(), today(config('constants.timezone.indian'))->endOfMonth()))}}</td>
                                <td>{{$activeProjectTeamMember->current_actual_effort}}</td>
                                <td class="{{$activeProjectTeamMember->getVelocityAttribute() >= 1 ? 'text-success' : 'text-danger' }}">{{$activeProjectTeamMember->getVelocityAttribute()}}</td>
                                <td>{{$activeProjectTeamMember->fte}}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </thead>    
        </table>
    </div>
</div>    
@endsection
