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
                <div class="mt-4 ml-5">Employee Salary ( <i class="fa fa-rupee"></i>&nbsp;)</div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mx-5 align-items-end">
                    <h1>{{$employee->name}}</h1>
                    @if(optional($employee->user()->withTrashed())->first()->avatar)
                    <span class="content tooltip-wrapper"  data-html="true" data-toggle="tooltip"  title="{{ $employee->name }}">
                        <img src="{{ $employee->user()->withTrashed()->first()->avatar }}" class="w-100 h-100 rounded-circle">
                    </span>
                    @endif
                </div>
                <hr class='bg-dark mx-4 pb-0.5'>
                <br>
                <div class="input-group col-md-9 fz-24 ml-3"><b>Current Monthly Gross Salary:&nbsp;</b>{{ optional($employee->employeeSalary->first())->monthly_gross_salary }}</div>
                <br>
                <br>
                <div class="form-group col-md-12">
                    <label class="leading-none fz-24 ml-4" for="grossSalary">{{ __('Monthly Gross Salary') }}</label>
                    <input type="number" step="0.01" name="grossSalary" id="grossSalary" class="form-control w-500 ml-4" placeholder="Enter Monthly Gross Salary"  value ="" required>
                </div>
                <br>
            </div>
        </div>
        <div class="card-footer bg-light">
            <button type="submit" class="btn  btn-primary ml-7">Save </button>
        </div>
    </form>
</div>
@endsection