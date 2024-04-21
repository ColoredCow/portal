@extends('invoice::layouts.master')
@section('content')
<div class="container">
    <h2>Edit Loan</h2>
    <div class="card mt-3">
        <form action="{{ route('employee-loan.update', $employeeLoan) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="card-header">
                <span>Edit Loan</span>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="employee_id" class="field-required">Employee</label>
                        <input class="form-control" value="{{ optional($employeeLoan->employee->user)->name ?? 'User Deleted' }}" disabled>
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label class="field-required">Loan Amount (INR)</label>
                        <input type="number" class="form-control" name="total_amount" placeholder="Enter Loan Amount"
                            required="required" step=".01" min="0" value="{{ old('total_amount') ?: $employeeLoan->total_amount }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label class="field-required">Loan Start Month</label>
                        <input type="month" class="form-control" name="start_date" required="required" value="{{ $employeeLoan->start_date->format('Y-m') }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label class="field-required">Loan End Month</label>
                        <input type="month" class="form-control" name="end_date" required="required" value="{{ $employeeLoan->end_date->format('Y-m') }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label class="field-required">Monthly Deduction (INR)</label>
                        <input type="number" class="form-control" name="monthly_deduction" placeholder="Enter Amount"
                            required="required" step=".01" min="0" value="{{ old('monthly_deduction') ?: $employeeLoan->monthly_deduction }}">
                    </div>
                </div>
            </div> 
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection