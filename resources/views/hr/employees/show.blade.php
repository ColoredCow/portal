@extends('layouts.app')
@section('content')

<div class="container">
    <br>
        @include('hr.employees.sub-views.menu', $employee)
    <br>
    <div class="mt-4 card">
        <div class="card-header pb-lg-5 fz-28"><div class="mt-4 ml-5">Employee Details</div></div>
        <div class="card-body">
            <div class="d-flex justify-content-between mx-5 align-items-end">
                <div class="col">
                    <div class="mt-2"><h1>{{$employee->name}}</h1>
                      <span class="ml-1"><a href={{ route('employees.employeeWorkHistory', $employee->id) }}>Work History</a></span>
                    </div>
                    @if ($employee->designation_id && $employee->domain_id != null)
                        <div class="row ml-1">
                            <span class="font-weight-bold">Designation:</span>&nbsp;<p>{{$employee->hrJobDesignation->designation}}</p>
                        </div> 
                        <div class="row ml-1">
                            <span class="font-weight-bold">Domain:</span>&nbsp;<p>{{$employee->hrJobDomain->domain}}</p>            
                        </div>
                    @endif
                </div>
                @if(optional($employee->user()->withTrashed())->first()->avatar)
                    <img src="{{ $employee->user()->withTrashed()->first()->avatar }}" class="w-100 h-100 rounded-circle">
                @endif
            </div>
            <hr class='bg-dark mx-4 pb-0.5'>
            <div class="font-weight-bold fz-24 pl-5 mt-5 mb-3 d-flex justify-content-inline">{{__('Current FTE: ')}}<div class=" ml-1 {{ $employee->user ? ($employee->user->ftes['main'] > 1 ? 'text-success' : 'text-danger') : 'text-secondary'}} font-weight-bold">{{ $employee->user ? $employee->user->ftes['main']  :'NA' }}</div></div>
            <div class="font-weight-bold fz-24 pl-5 mt-5 mb-3 d-flex justify-content-inline">{{__('FTE(AMC): ')}}<div class=" ml-1 {{ $employee->user ? ($employee->user->ftes['amc'] > 1 ? 'text-success' : 'text-danger') : 'text-secondary'}} font-weight-bold">{{ $employee->user ? $employee->user->ftes['amc']  :'NA' }}</div></div>
            <div class="font-weight-bold fz-24 pl-5 mt-5 mb-3">Project Details</div>
            <div class="mx-5">
                <table class="table">
                    <thead>
                        <tr class="bg-theme-gray text-light">
                            <th scope="col" class="pb-lg-4"><div class="ml-7">Project Name</div></th>
                            <th scope="col" class="pb-lg-4">Expected Monthly Hrs.</th>
                            <th scope="col" class="pb-lg-4">Hours Booked <span data-toggle="tooltip" data-placement="right" title="Hours in effortsheet for the current month."><i class="fa fa-question-circle"></i>&nbsp;</span></th>
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
                        @if(optional($employee->user)->activeProjectTeamMembers == null || ($employee->user)->activeProjectTeamMembers->isEmpty())
                            </table>
                            <div class="fz-lg-28 text-center mt-2"><div class="mb-4">Not in any project</div></div>
                        @else
                            @foreach($employee->user->activeProjectTeamMembers as $activeProjectTeamMember)
                                @if($activeProjectTeamMember->project->status == 'active')
                                    <tr>
                                        <td class="c-pointer"><div class="ml-7"><a href={{ route('project.show', $activeProjectTeamMember->project) }}>{{$activeProjectTeamMember->project->name}} @if($activeProjectTeamMember->project->is_amc)
                                            <div class="badge badge-pill badge-success mr-1  mt-1">AMC</div>
                                        @endif
                                        </a></div></td>
                                        <td><div>{{$activeProjectTeamMember->daily_expected_effort * count($activeProjectTeamMember->project->getWorkingDaysList(today(config('constants.timezone.indian'))->startOfMonth(), today(config('constants.timezone.indian'))->endOfMonth()))}}</div></td>
                                        <td><div>{{$activeProjectTeamMember->current_actual_effort}}</div></td>
                                        <td><div><div class="{{$activeProjectTeamMember->velocity >= 1 ? 'text-success' : 'text-danger' }}">{{$activeProjectTeamMember->velocity}}</div></td>
                                        <td><div>{{$activeProjectTeamMember->fte}}</td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    </thead>
                </table>    
            </div>
        </div>
    </div>
</div>    
@endsection
