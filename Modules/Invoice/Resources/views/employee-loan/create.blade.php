@extends('invoice::layouts.master')
@section('content')
<div class="container">
    <h2>Add new Loan</h2>
    <div class="card mt-3">
        <form action="{{ route('employee-loan.store') }}" method="POST">
            @csrf
            <div class="card-header">
                <span>Add Loan</span>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="employee_id" class="field-required">Employee</label>
                        <select name="employee_id" id="employee_id" class="form-control" required="required">
                            <option value="">Select Employee</option>
                            @foreach ($allEmployees as $employee)
                                @if($employee->user)
                                    <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label class="field-required">Loan Amount (INR)</label>
                        <input type="number" class="form-control" name="total_amount" placeholder="Enter Loan Amount"
                            required="required" step=".01" min="0" value="{{ old('total_amount') }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label class="field-required">Loan Start Month</label>
                        <input type="month" class="form-control" name="start_date" required="required" value="{{ now()->format('Y-m') }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label class="field-required">Loan End Month</label>
                        <input type="month" class="form-control" name="end_date" required="required" value="{{ now()->format('Y-m') }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label class="field-required">Monthly Deduction (INR)</label>
                        <input type="number" class="form-control" name="monthly_deduction" placeholder="Enter Amount"
                            required="required" step=".01" min="0" value="{{ old('monthly_deduction') }}">
                    </div>
                </div>
            </div> 
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection