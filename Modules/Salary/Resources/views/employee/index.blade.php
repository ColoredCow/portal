@extends('salary::layouts.master')
@section('content')
<div class="container">
    <br>
        @include('hr.employees.sub-views.menu')
    <br>
    <form action="{{ route('salary.employee.store', $employee) }}" method="POST">
        @csrf
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        @endif
        <div class="mt-4 card">
            <div class="card-header pb-lg-5 fz-28">
                <div class="mt-4 ml-5">Employee Salary</div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mx-5 align-items-end">
                    <h1>{{$employee->name}}</h1>
                    @if(optional($employee->user()->withTrashed())->first()->avatar)
                        <img src="{{ $employee->user()->withTrashed()->first()->avatar }}" class="w-100 h-100 rounded-circle">
                    @endif
                </div>

                <hr class='bg-dark mx-4 pb-0.5'>
                <br>
                <div class="form-group">
                    <label class="leading-none ml-5" for="grossSalary">{{ __('Monthly Gross Salary') }}</label>
                    <input type="number" step ="0.01" name="grossSalary" id="grossSalary" placeholder="Enter Monthly Gross Salary" value="{{ optional($employee->employeeSalary->first())->monthly_gross_salary }}" required>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
</div>
@endsection