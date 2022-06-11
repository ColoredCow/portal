@extends('layouts.app')
@section('content')
<div class="container">
    <div class="mt-4 card">
        <div class="card-header pb-lg-5 fz-28"><div class="mt-4 ml-5">Employee Details</div></div>
        <div class="d-flex flex-row bd-highlight mb-3">
        <div class="d-flex justify-content-start mt-5 ml-9"><h1>{{$employee->name}}</h1></div>
        <img src="{{ $employee->user->avatar }}" class="d-flex justify-content-end w-100 h-100 rounded-circle ml-20 mr-1 mb-1 mt-4 float:right">
        </div>
        <hr class='bg-dark mx-7 my-7'>
        <div class="font-weight-bold fz-24 pl-9 mt-4 ml-2 !important;">Project Details</div>
        <div class="card-body">
            <div class="mx-7 !important">
                <table class="table">
                    <thead>
                        <tr class="bg-theme-gray text-light">
                            <th scope="col" class="pb-lg-4"><div class="ml-7">Project Name</div></th>
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
                    </thead>
                    <thead>
                        @if(optional($employee->user)->activeProjectTeamMembers == null)
                            </table>
                            <div class="fz-lg-28 text-center mt-2"><div class="mb-4">Not in any project</div></div>
                        @else
                            @foreach($employee->user->activeProjectTeamMembers as $activeProjectTeamMember)
                                <tr>
                                    <td class="c-pointer"><div class="ml-10"><a href={{ route('project.show', $activeProjectTeamMember->project) }}>{{$activeProjectTeamMember->project->name}}</a></div></td>
                                    <td><div class="ml-9">{{$activeProjectTeamMember->daily_expected_effort * count($activeProjectTeamMember->project->getWorkingDaysList(today(config('constants.timezone.indian'))->startOfMonth(), today(config('constants.timezone.indian'))->endOfMonth()))}}</div></td>
                                    <td><div class="ml-9">{{$activeProjectTeamMember->current_actual_effort}}</div></td>
                                    <td><div class="ml-7"><div class="{{$activeProjectTeamMember->getVelocityAttribute() >= 1 ? 'text-success' : 'text-danger' }}">{{$activeProjectTeamMember->getVelocityAttribute()}}</div></td>
                                    <td><div class="ml-15">{{$activeProjectTeamMember->fte}}</td>
                                </tr>
                            @endforeach
                        @endif
                    </thead>
                </table>    
            </div>
        </div>
    </div>
</div>    
@endsection
