@extends('salary::layouts.master')
@section('content')
    <div class="container" id="employee_salary_form">
        <br>
        @include('hr.employees.sub-views.menu')
        <br>
        <form action="{{ route('salary.employee.store', $employee) }}" method="POST">
            @csrf
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="mt-4 card">
                <div class="card-header pb-lg-5 fz-28">
                    <div class="mt-4 ml-5">Employee Salary ( <i class="fa fa-rupee"></i>&nbsp;)</div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mx-5 align-items-end">
                        <h1>{{ $employee->name }}</h1>
                        @if (optional($employee->user()->withTrashed())->first()->avatar)
                            <span class="content tooltip-wrapper" data-html="true" data-toggle="tooltip"
                                title="{{ $employee->name }}">
                                <img src="{{ $employee->user()->withTrashed()->first()->avatar }}"
                                    class="w-100 h-100 rounded-circle">
                            </span>
                        @endif
                    </div>
                    <hr class='bg-dark mx-4 pb-0.5'>
                    <br>
                    <div class="input-group col-md-9 fz-24 ml-3">Monthly Gross Salary:&nbsp; <i class="fa fa-rupee"></i>&nbsp; @{{ Math.ceil(grossSalary) }}</div>
                    <br>
                    <div class="input-group col-md-9 fz-24 ml-3">Basic Salary:&nbsp; <i class="fa fa-rupee"></i>&nbsp; @{{ Math.ceil(grossSalary * basicSalaryPercentage) }}</div>
                    <br>
                    <div class="input-group col-md-9 fz-24 ml-3">HRA:&nbsp; <i class="fa fa-rupee"></i>&nbsp; @{{ Math.ceil(grossSalary * hraPercentage) }}</div>
                    <br>
                    <div class="input-group col-md-9 fz-24 ml-3">Transport Allowance:&nbsp; <i class="fa fa-rupee"></i>&nbsp; @{{ transportAllowance }}</div>
                    <br>
                    <div class="input-group col-md-9 fz-24 ml-3">Other Allowance:&nbsp; <i class="fa fa-rupee"></i>&nbsp; @{{ Math.ceil(otherAllowance) }} </div>
                    <br>
                    <div class="input-group col-md-9 fz-24 ml-3">Food Allowance:&nbsp; <i class="fa fa-rupee"></i>&nbsp; @{{ foodAllowance }}</div>
                    <br>
                    <div class="input-group col-md-9 fz-24 ml-3">Total Salary:&nbsp; <i class="fa fa-rupee"></i>&nbsp; @{{ Math.ceil(totalSalary) }}</div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div class="form-group col-md-12">
                        <label class="leading-none fz-24 ml-4" for="grossSalary">{{ __('Monthly Gross Salary') }}</label>
                        <input v-model="grossSalary" @input="updateGrossSalary($event)" type="number" step="0.01"
                            name="grossSalary" id="grossSalary" class="form-control w-500 ml-4 bg-light"
                            placeholder="Enter Monthly Gross Salary" min="0" required>
                    </div>
                    <br>
                </div>
            </div>
            <div class="card-footer bg-light">
                <button type="submit" class="btn btn-primary ml-7">Save</button>
            </div>
        </form>
    </div>
@endsection

@section('js_scripts')
    <script>
        new Vue({
            el: '#employee_salary_form',

            data() {
                otherAllowances = parseInt("{{ ceil(optional($employee->employeeSalaries->last())->monthly_gross_salary - optional($employee->employeeSalaries->last())->monthly_gross_salary * ($data['hraPercentage'] + $data['basicSalaryPercentage']) - $data['foodAllowance'] - $data['transportAllowance'])}}")
                if("{{optional($employee->employeeSalaries->last())->monthly_gross_salary == null}}") {
                    return {
                        grossSalary: null,
                        hraPercentage: null,
                        basicSalaryPercentage: null,
                        otherAllowance: null,
                        totalSalary: null,
                        foodAllowance: null,
                        transportAllowance: null,
                    }
                } else {
                    return {
                        grossSalary: "{{ optional($employee->employeeSalaries->last())->monthly_gross_salary }}",
                        hraPercentage: "{{$data['hraPercentage']}}",
                        basicSalaryPercentage: "{{$data['basicSalaryPercentage']}}",
                        otherAllowance: otherAllowances,
                        totalSalary: parseInt("{{optional($employee->employeeSalaries->last())->monthly_gross_salary * ($data['hraPercentage'] + $data['basicSalaryPercentage']) + $data['foodAllowance'] + $data['transportAllowance']}}") + otherAllowances,
                        foodAllowance: parseInt("{{$data['foodAllowance']}}"),
                        transportAllowance: parseInt("{{$data['transportAllowance']}}"),
                    }
                }
            },

            methods: {
                updateGrossSalary: function($event) {
                    this.grossSalary = $event.target.value;
                    this.basicSalaryPercentage = "{{$data['basicSalaryPercentage']}}",
                    this.hraPercentage = "{{$data['hraPercentage']}}",
                    this.foodAllowance = parseInt("{{$data['foodAllowance']}}"),
                    this.transportAllowance = parseInt("{{$data['transportAllowance']}}")
                    this.otherAllowance = this.grossSalary - (this.grossSalary * this.basicSalaryPercentage) - (this.grossSalary * this.hraPercentage) - this.transportAllowance - this.foodAllowance;
                    this.totalSalary = (this.grossSalary * this.basicSalaryPercentage) + (this.grossSalary * this.hraPercentage) + this.transportAllowance + this.foodAllowance + this.otherAllowance;
                }
            }
        });
    </script>
@endsection
