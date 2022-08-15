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
    </div>
@endsection
