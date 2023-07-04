@extends('layouts.app')

@section('content')
    <div class="container">
        <br>
        @include('hr.employees.menu')
        <br><br>
        <div class="d-flex">
            <h1>{{ request()->get('name') }} ({{ count($employees) }})</h1>
            <form id="employeeFilterForm" class="d-md-flex justify-content-between ml-md-3">
                <input type="hidden" name="status" value="{{ request()->input('status', 'current') }}">
                <div class='form-group w-130' class="d-inline">
                    <select class="form-control bg-info text-white ml-3" name="status"
                        onchange="document.getElementById('employeeFilterForm').submit();">
                        <option {{ $filters['status'] == 'current' ? 'selected=selected' : '' }} value="current">Current
                        </option>
                        <option {{ $filters['status'] == 'previous' ? 'selected=selected' : '' }} value="previous">Previous
                        </option>
                    </select>
                </div>
                <div class="d-flex align-items-center ml-35">
                    <input type="text" name="employeename" class="form-control" id="name"
                        placeholder="Enter the Employee" value="{{ request()->get('employeename') }}">
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
                    <th>Send Mail</th>
                </tr>
                @foreach ($employees as $key => $employee)
                    <tr>
                        <td>
                            <a href={{ route('employees.show', $employee->id) }}>{{ $employee->name }}</a>
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
                                <span>{{ $employee->joined_on->format('d M, Y') }}</span>
                                <span style="font-size: 10px;">&nbsp;&#9679;&nbsp;</span>
                                <span>{{ $employee->employmentDuration }}</span>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if ($employee->user == null)
                                0
                            @else
                                {{ $employee->project_count }}
                            @endif
                        </td>
                        <td>
                            @if ($employee->user == null)
                                <span
                                    class="text-danger font-weight-bold">{{ $employee->user ? $employee->user->ftes['main'] : 'NA' }}</span>
                            @elseif ($employee->user->ftes['main'] > 1 && $employee->domain_id != null)
                                <a class="text-success font-weight-bold"
                                    href={{ route('employees.alert', ['domain_id' => $employee->domain_id]) }}
                                    style="text-decoration: none;">
                                    {{ $employee->user->ftes['main'] }} &nbsp;&nbsp;&nbsp;<span class="text-danger"><i
                                            class="fa fa-warning fa-lg"></i></span>
                                </a>
                            @elseif ($employee->user->ftes['main'] >= 1)
                                <span class="text-success font-weight-bold">{{ $employee->user->ftes['main'] }}</span>
                            @else
                                <span
                                    class="text-danger font-weight-bold">{{ $employee->user ? $employee->user->ftes['main'] : 'NA' }}</span>
                            @endif
                        </td>
                        <td>
                            <span
                                class="{{ $employee->user ? ($employee->user->ftes['amc'] > 1 ? 'text-success' : 'text-danger') : 'text-secondary' }} font-weight-bold">{{ $employee->user ? $employee->user->ftes['amc'] : 'NA' }}</span>
                        </td>
                        <td>
                            <a class="ml-6" data-toggle="modal" data-target="#reviewModal-{{ $key }}">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                            </a>
                            <div class="modal fade" id="reviewModal-{{ $key }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Self review - Software Engineer
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="GET"
                                            action="{{ route('employees.sendMail', $employee->user_id) }}">
                                            <div class="form-group pl-4 pr-4 py-4">
                                                <input type="url" class="form-control" name="self_review_link"
                                                    placeholder="Enter Self Review Sheet Link" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
        </table>
    </div>
@endsection
