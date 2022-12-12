@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('hr.employees.menu')
    <br><br>
    <div class="d-flex">
        <h1>{{request()->get('name')}} ({{count($employees)}})</h1>
        <form id="employeeFilterForm" class="d-md-flex justify-content-between ml-md-3">
            <input type="hidden" name="status" value="{{ request()->input('status', 'current') }}">
            <div class='form-group w-130' class="d-inline">
                <select class="form-control bg-info text-white ml-3" name="status"  onchange="document.getElementById('employeeFilterForm').submit();">
                    <option {{ $filters['status'] == 'current' ? "selected=selected" : '' }} value="current">Current</option>
                    <option {{ $filters['status'] == 'previous' ? "selected=selected" : '' }} value="previous">Previous</option>
                </select>
            </div>
            <div class="d-flex align-items-center ml-35">
                    <input type="text" name="employeename" class="form-control" id="name" placeholder="Enter the Employee" value="{{ request()->get('employeename') }}">
                    <button class="btn btn-info ml-2 text-white">Search</button>
                </div>
            <input type="hidden" name="name" value="{{ request()->input('name', 'Employee') }}">
        </form>
    </div>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
        <tr class="sticky-top">
            <th>Name</th>
            <th>Designation</th>
            <th>Joined on</th>
            <th>Projects Count</th>
            <th>Current FTE</th>
            <th>AMC FTE</th>
        </tr>
        @foreach ($employees as $employee)
            <tr>
                <td>
                    <div><a href={{ route('employees.show', $employee->id) }}>{{ $employee->name }}</a></div>
                    <small><a href={{ route('employees.employeeWorkHistory', $employee->id) }}>Work History</a></small>
                </td>
                <td>
                    @if ($employee->designation_id)
                        {{ $employee->hrJobDesignation->designation }}
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
                        {{$employee->project_count}}
                    @endif
                </td>
                <td>
                    @if ($employee->user == null)
                        <span class="text-danger font-weight-bold">{{ $employee->user ? $employee->user->ftes['main'] :'NA' }}</span>
                    @elseif ($employee->user->ftes['main'] > 1 && $employee->domain_id != null)
                        <a class="text-success font-weight-bold" href={{ route('employees.alert',['domain_id' => $employee->domain_id]) }} style="text-decoration: none;">
                            {{ $employee->user->ftes['main'] }} &nbsp;&nbsp;&nbsp;<span class="text-danger"><i class="fa fa-warning fa-lg"></i></span>
                        </a>
                    @elseif ($employee->user->ftes['main'] >= 1)
                        <span class="text-success font-weight-bold">{{ $employee->user->ftes['main'] }}</span>
                    @else
                        <span class="text-danger font-weight-bold">{{ $employee->user ? $employee->user->ftes['main'] :'NA' }}</span>
                    @endif
                </td>
                <td>
                    <span class="{{ $employee->user ? ($employee->user->ftes['amc'] > 1 ? 'text-success' : 'text-danger') : 'text-secondary'}} font-weight-bold">{{ $employee->user ? $employee->user->ftes['amc']  :'NA' }}</span>
                </td>
            </tr>
        @endforeach
    </table>
</div>
@endsection

