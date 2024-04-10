@extends('layouts.app')
@section('content')

<!-- As of now we have hardCoded the earningValue until we unable to fetch the real data -->
@php
    $routeName = Route::getCurrentRoute()->getName();
    $earningValue  = 0;
@endphp
    <div class="container">
        <br>
        @include('hr.employees.menu')
        <br><br>
        <div class="d-flex">
            <h1>{{ request()->get('staff_type') }} ({{ count($employees) }})</h1>
            <form id="employeeFilterForm" class="d-md-flex justify-content-between ml-md-3">
                <input type="hidden" name="status" value="{{ request()->input('status', 'current') }}">
                <div class='form-group w-200' class="">
                    <select class="form-control bg-info text-white ml-3" name="status"
                        onchange="document.getElementById('employeeFilterForm').submit();">
                        <option {{ $filters['status'] == 'current' ? 'selected=selected' : '' }} value="current">Current
                        </option>
                        <option {{ $filters['status'] == 'previous' ? 'selected=selected' : '' }} value="previous">Previous
                        </option>
                    </select>
                </div>
                <div class="d-flex align-items-center ml-35">
                    <input type="text" name="employee_name" class="form-control" id="name"
                        placeholder="Enter the Employee" value="{{ request()->get('employee_name') }}">
                    <button class="btn btn-info ml-2 text-white">Search</button>
                </div>
                <input type="hidden" name="staff_type" value="{{ request()->input('staff_type', 'Employee') }}">
            </form>
        </div>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr class="sticky-top">
                    <th>Name</th>
                    @if($routeName === "employee")
                    <th>Active Projects Count</th>
                    <th>
                        Overall FTE
                        <span class="tooltip-wrapper" data-html="true" data-toggle="tooltip" title="Total FTE for the current month">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                        </span>
                    </th>
                    <th>
                        Billable | Non Billable
                        <span class="tooltip-wrapper" data-html="true" data-toggle="tooltip" title="In Hours">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                        </span>
                    </th>
                @else
                    <th>
                        Employee Earning
                        <span class="tooltip-wrapper" data-html="true" data-toggle="tooltip" title="Rate">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                        </span>
                    </th>
                @endif
                </tr>
                @foreach ($employees as $employee)
                    <tr>
                        @php
                            $user = $employee->user()->withTrashed()->first();
                            $totalFTE = $user->ftes['main'] + $user->ftes['amc']
                        @endphp
                        <td>
                            <a href="{{ route('employees.show', $employee->id) }}">
                                @if ($employee->overall_status === 'pending' && $filters['status'] == 'current')
                                    {{ $employee->name }} <span
                                        class="{{ config('constants.review-tags.pending.class') }} badge-pill mr-1 mb-1">{{ config('constants.review-tags.pending.title') }}</span>
                                @elseif ($employee->overall_status === 'in-progress' && $filters['status'] == 'current')
                                    {{ $employee->name }} <span
                                        class="{{ config('constants.review-tags.in-progress.class') }} badge-pill mr-1 mb-1">{{ config('constants.review-tags.in-progress.title') }}</span>
                                @elseif ($employee->overall_status === 'completed' && $filters['status'] == 'current')
                                    {{ $employee->name }} <span
                                        class="{{ config('constants.review-tags.completed.class') }} badge-pill mr-1 mb-1">{{ config('constants.review-tags.completed.title') }}</span>
                                @else
                                    {{ $employee->name }}
                                @endif
                            </a>
                        </td>
                        @if($routeName === "employee")
                        <td>
                            @if ($employee->user == null)
                                0
                            @else
                                {{ $employee->active_project_count }}
                            @endif
                        </td>
                        <td class={{ $totalFTE > 1 ? 'text-success' : 'text-danger' }}>
                            {{ $totalFTE }}
                        </td>
                        if
                        <td>
                            <span class="text-success">
                                {{ $user->total_hours['billable'] }}
                            </span>
                            |
                            <span class="text-secondary">
                                {{ $user->total_hours['non_billable'] }}
                            </span>
                        </td>
                        @else
                        <td>
                        @if($earningValue >= 0)
                            <span class="text-success">
                                {{$earningValue}}
                                <span class="d-inline-block pr-2 h-30 w-30">{!! file_get_contents(public_path('icons/green-tick.svg')) !!}</span>
                            </span>
                            @else
                            <span class="text-secondary pl-2">
                                {{$earningValue}}
                                <span class="d-inline-block h-30 w-30">{!! file_get_contents(public_path('icons/warning-symbol.svg')) !!}</span>
                            </span>
                            @endif
                        </td>
                        @endif
                    </tr>
                @endforeach
        </table>
    </div>
@endsection
