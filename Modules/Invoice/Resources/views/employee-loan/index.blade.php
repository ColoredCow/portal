@extends('invoice::layouts.master')
@section('content')
<div class="container" id="vueContainer">
    @includeWhen(session('success'), 'toast', ['message' => session('success')])
    <div class="row">
        <div class="col-md-6"><h2>Employee Loans</h2></div>
        @can('employee_loan.create')
            <div class="col-md-6"><a href="{{ route('employee-loan.create') }}" class="btn btn-success float-right">Add New Loan</a></div>
        @endcan
    </div>
    <div class="mt-5">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr class="sticky-top">
                    <th>Employee Name</th>
                    <th>Loan Amount</th>
                    <th>Monthly Deduction</th>
                    <th>End Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employeeLoans as $loan)
                    <tr>
                        <td>{{ optional($loan->employee->user)->name ?? "User Deleted" }}</td>
                        <td>{{ $loan->total_amount . " INR"}}</td>
                        <td>{{ $loan->monthly_deduction . " INR"}}</td>
                        <td>{{ $loan->end_date->format('d M Y') }}</td>
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