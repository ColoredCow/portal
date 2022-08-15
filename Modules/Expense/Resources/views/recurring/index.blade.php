@extends('expense::layouts.master')

@section('content')
    <div class="container" id="expenses">
        <br />
        <div class="d-flex justify-content-between mb-2">
            <h4 class="mb-1 pb-1 fz-28">Recurring Expenses</h4>
            <span>
                <a href="{{ route('expense.recurring.create') }}" class="btn btn-info text-white">Add new</a>
            </span>
        </div>

        <table class="table table-striped table-bordered">
            <tr>
                <th>Name</th>
                <th>Frequency</th>
                <th>Amount</th>
                <th>Currency</th>
                <th>Due date</th>
            </tr>
            @foreach ($recurringExpenses as $recurringExpense)
                <tr>
                    <td>{{ $recurringExpense->name }}</td>
                    <td>{{ Str::title($recurringExpense->frequency) }}</td>
                    <td>{{ $recurringExpense->amount }}</td>
                    <td>{{ $recurringExpense->currency }}</td>
                    <td>{{ $recurringExpense->due_date->format('m/d/Y') }}</td>
                </tr>
            @endforeach
        </table>
        {{ $recurringExpenses->links() }}
    </div>
@endsection
