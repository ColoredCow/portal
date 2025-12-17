@extends('invoice::layouts.master')
@section('content')
<div class="container">
    @includeWhen(session('success'), 'toast', ['message' => session('success')])
    @include('back-to-previous-page', ['url' => route('employee-loan.index'), 'text' => 'Back to Loan List'])
    <h2 class="mt-4">Edit Loan</h2>
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
                    <div class="form-group col-md-11">
                        <label class="field-required">Description</label>
                        <textarea class="form-control" name="description" required="required">{{ old('description') ?: $employeeLoan->description }}</textarea>
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
                    <div class="form-group offset-md-1 col-md-5">
                        <label class="field-required">Loan End Month</label>
                        <select class="form-control" name="status" required="required">
                            @foreach (config('invoice.loan.status') as $status)
                                <option value="{{ $status['slug'] }}" {{ $employeeLoan->status === $status['slug'] ? 'selected' : '' }}> {{ $status['label'] }} </option>
                            @endforeach
                        </select>   
                    </div>
                </div>
            </div> 
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
    <div class="card mt-3">
            <div class="card-header">
                <span>Loan Breakdown</span>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark ">
                        <th>No.</th>
                        <th>Month</th>
                        <th>Amount Deducted</th>
                        <th>Remaining Amount</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        @php
                            $installmentMonth = null;
                            $remainingAmount = $employeeLoan->total_amount;
                            $indexForFutureBreakdowns = 0
                        @endphp
                        @foreach ($installments as $index => $installment)
                            @php
                                $installmentMonth = $installment->installment_date;
                                $remainingAmount = $installment->remaining_amount;
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $installment->installment_date->format('F Y') }}</td>
                                <td>{{ $installment->installment_amount }}</td>
                                <td>{{ $installment->remaining_amount }}</td>
                                <td><i class="fa fa-check-circle text-success fz-20">{{ __(' Deducted from Salary') }}</i> </td>
                            </tr>
                        @endforeach
                        @while ($remainingAmount > 0)
                            @php
                                if ($installmentMonth === null) {
                                    $installmentMonth = today()->endOfMonth();
                                } else {
                                    $installmentMonth->endOfMonth()->addDay();
                                }
                                $remainingAmount -= $employeeLoan->monthly_deduction;
                                $indexForFutureBreakdowns++;
                            @endphp
                            <tr>
                                <td>{{ $installments->count() + $indexForFutureBreakdowns }}</td>
                                <td>{{ $installmentMonth->format('F Y') }}</td>
                                <td>{{ $remainingAmount < 0 ? $employeeLoan->monthly_deduction + $remainingAmount : $employeeLoan->monthly_deduction }}</td>
                                <td>{{ $remainingAmount < 0 ? 0 : $remainingAmount; }}</td>
                                <td><i class="fa fa-calendar text-theme-orange fz-20">{{ __(' Future Installment') }}</i> </td>
                            </tr>
                        @endWhile
                    </tbody>
                </table>
            </div>
    </div>
</div>
@endsection