@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('hr.employees.menu')
    <br><br>
    <div class="d-flex">
        <h1>Employees</h1>
        <form id="employeeFilterForm">
            <input type="hidden" name="status" value="{{ request()->input('status', 'current') }}">
            <div class='form-group w-130' class="d-inline">
                <select class="form-control bg-info text-white ml-3" name="status"  onchange="document.getElementById('employeeFilterForm').submit();">
                    <option {{ $filters['status'] == 'current' ? "selected=selected" : '' }} value="current">Current</option>
                    <option {{ $filters['status'] == 'previous' ? "selected=selected" : '' }} value="previous">Previous</option>
                </select>
            </div>
        </form>
    </div>
    <table class="table table-striped table-bordered">
        <tr class="sticky-top">
            <th>Name</th>
            <th>Designation</th>
            <th>Joined on</th>
            <th>Projects Count</th>
            <th>Current FTE</th>
        </tr>

        @foreach ($employees as $employee)
        <tr>
            <td>
                <a href={{ route('employees.show', $employee->id) }}>{{ $employee->name }}</a>
            </td>
            <td>
                @if ($employee->designation)
                    {{ $employee->designation }}
                @else
                    -
                @endif
            </td>
            <td>
            @if ($employee->joined_on)
                <span>{{$employee->joined_on->format('d M, Y') }}</span>
                <span style="font-size: 10px;">&nbsp;&#9679;&nbsp;</span>
                <span>{{$employee->employmentDuration }}</span>
            @else
                -
            @endif
            </td>
            <td>
                @if($employee->user == null)
                    0
                @else
                    {{count($employee->user->activeProjectTeamMembers)}}
                @endif
            </td>
            <td class="{{ $employee->user ? ($employee->user->fte > 1 ? 'text-success' : 'text-danger') : 'text-secondary'}} font-weight-bold">{{ $employee->user ? $employee->user->fte :'NA' }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
