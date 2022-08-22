@extends('expense::layouts.master')

@section('content')
    <div class="container" id="expenses">
        <br />
        <div class="d-flex justify-content-between mb-2">
            <h4 class="mb-1 pb-1 fz-28">Expenses</h4>
            <span>
                <a href="{{ route('expense.recurring.index') }}" class="btn btn-info text-white">Setup Recurring Expense</a>
                <a href="" class="btn btn-success text-white">Add new expense</a>
            </span>
        </div>
    </div>
@endsection
