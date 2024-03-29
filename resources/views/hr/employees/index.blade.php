@extends('layouts.app')

@section('content')
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
                        <td>
                            <span class="text-success">
                                {{ $user->total_hours['billable'] }}
                            </span>
                            |
                            <span class="text-secondary">
                                {{ $user->total_hours['non_billable'] }}
                            </span>
                        </td>
                    </tr>
                @endforeach
        </table>
    </div>
@endsection
