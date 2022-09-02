@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm card">
                <div class="card-header"><h1> Job Requisition</h1></div><br>
                <form action="{{ route('employees.store') }}" method="post">
                    @csrf
                    <div class="">
                        <label for="domain_dropdown">select Domain</label>
                        <select class="form-control" name="domain" id="domain "> 
                            @foreach ($DomainName as $DomainName)
                                <option value="{{ $DomainName->id }}">{{ $DomainName->domain }}</option>
                            @endforeach 
                        </select><br>
                    </div>
                    <div>
                        <label for="job_apportunity">select Job</label>
                        <select class="form-control" name="job" id="job"> 
                            @foreach ($jobName as $jobName)
                                <option value="{{ $jobName->id }}">{{ $jobName->title }}</option>
                            @endforeach 
                        </select><br>
                    </div><br>
                    <button type="submit" class="btn btn-primary" data-action="SendHiringMail">Submit</button>
                </form>
            </div>
            <div class="col-sm card">
                <h1>Recommended Resource</h1><br>
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                    <tr class="sticky-top">
                        <th>Name</th>
                        <th>Projects Count</th>
                        <th>Current FTE</th>
                    </tr>
                    @foreach ($employees as $employee)
                    <tr>
                        <td>
                            <a href={{ route('employees.show', $employee->id) }}>{{ $employee->name }}</a>
                        </td>
                        <td>
                            @if($employee->user == null)
                                0
                            @else
                                {{count($employee->user->activeProjectTeamMembers)}}
                            @endif
                        </td>
                        <td>
                            <span class="{{ $employee->user ? ($employee->user->fte < 0.7 ? 'text-success' : 'text-danger') : 'text-secondary'}} font-weight-bold">{{ $employee->user ? $employee->user->fte :'NA' }}</span>
                        </td>

                        </tr>
                        
                    @endforeach
                </table> 
            </div>
        </div>
    </div>
@endsection
