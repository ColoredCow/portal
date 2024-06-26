@extends('invoice::layouts.master')
@section('content')
<div class="container" id="vueContainer">
    @includeWhen(session('success'), 'toast', ['message' => session('success')])
    @php
        $loanStatus = request()->input('status', 'active')
    @endphp
    <div class="row mb-3">
        <div class="col-md-6"><h2>Employee Loans</h2></div>
        @can('employee_loan.create')
            <div class="col-md-6"><a href="{{ route('employee-loan.create') }}" class="btn btn-success float-right">Add New Loan</a></div>
        @endcan
    </div>
    <ul class="nav nav-pills">
        <li class="nav-item mr-2">
            <a class="nav-link {{ $loanStatus == config('invoice.loan.status.active.slug') ? 'active' : '' }}"
                href="{{ route('employee-loan.index', ['status' => config('invoice.loan.status.active.slug')]) }}">{{ config('invoice.loan.status.active.label') }}</a>
        </li>
        <li class="nav-item mr-2">
            <a class="nav-link {{ $loanStatus == config('invoice.loan.status.completed.slug') ? 'active' : '' }}"
                href="{{ route('employee-loan.index', ['status' => config('invoice.loan.status.completed.slug')]) }}">{{ config('invoice.loan.status.completed.label') }}</a>
        </li>
    </ul>
    <div class="mt-4">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr class="sticky-top">
                    <th>Employee Name</th>
                    <th>Description</th>
                    <th>Loan Amount</th>
                    <th>Monthly Deduction</th>
                    <th>Balance</th>
                    <th>Start Month</th>
                    <th>Loan Tenure (Months)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employeeLoans as $loan)
                    <tr>
                        <td>{{ optional($loan->employee->user)->name ?? "User Deleted" }}</td>
                        <td>{{ strlen($loan->description) <= 20 ? $loan->description : substr($loan->description,0,20).'...' }}</td>
                        <td>{{ $loan->total_amount . " INR"}}</td>
                        <td>{{ $loan->monthly_deduction . " INR"}}</td>
                        <td>{{ $loan->remaining_balance . " INR"}}</td>
                        <td>{{ $loan->start_date->format('M Y') }}</td>
                        <td>{{ $loan->tenure_in_months . " Months"}}</td>
                        <td>
                            @if($loan->employee->user)
                                <a class="c-pointer" href="{{ route('employee-loan.edit', $loan) }}">
                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection