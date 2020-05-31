@extends('salary::layouts.master')

@section('content')
<div class="container">

    <h1>{{ "Mohit Gusai" }}</h1>
    <br>

    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label for="">Basic Salary:</label>
                <span>{{ $salaryCalculation->basicSalary() }}</span>
            </div>

            <div class="form-group">
                <label for="">HRA:</label>
                <span>{{ $salaryCalculation->hra() }}</span>
            </div>

            <div class="form-group">
                <label for="">Transport allowance:</label>
                {{-- <span>{{ $salaryCalculation->basicSalary() }}</span> --}}
            </div>

            <div class="form-group">
                <label for="">Medical Allowance:</label>
                {{-- <span>{{ $salaryCalculation->basicSalary() }}</span> --}}
            </div>

            <div class="form-group">
                <label for="">Other Allowance:</label>
                {{-- <span>{{ $salaryCalculation->basicSalary() }}</span> --}}
            </div>

            <div class="form-group">
                <label for="">Employer Esi:</label>
                {{-- <span>{{ $salaryCalculation->basicSalary() }}</span> --}}
            </div>


        </div>
    </div>
</div>
@endsection