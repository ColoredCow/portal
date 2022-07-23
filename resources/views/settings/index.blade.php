@extends('layouts.app')

@section('content')

<div class="container" id="home_page">
    @include('status', ['errors' => $errors->all()])
    <br>

    <div class="d-flex justify-content-start row flex-wrap">
        @if( auth()->user()->canAny(['hr_recruitment_applications.view', 'hr_employees.view', 'hr_volunteers_applications.view']))
        <div class="col-md-4">
            <div class="card h-75 mx-4 mt-3 mb-5 ">
                <a class="card-body no-transition" href="{{ route('settings.hr') }}">
                    <br><h2 class="text-center">HR</h2><br>
                </a>
            </div>
        </div>
        @endif

        @if(auth()->user()->canAny(['hr_recruitment_applications.view', 'hr_employees.view', 'hr_volunteers_applications.view']))
            <div class="col-md-4">
                <div class="card h-75 mx-4 mt-3 mb-5 ">
                    <a class="card-body no-transition" href="{{ route('setting.agreement.nda') }}">
                        <br><h2 class="text-center">NDA</h2><br>
                    </a>
                </div>
            </div>
        @endif

        @if(auth()->user()->canAny(['finance_invoices.view', 'finance_invoices.update', 'finance_invoices.delete', 'finance_invoices.create']))
            <div class="col-md-4">
                <div class="card h-75 mx-4 mt-3 mb-5 ">
                    <a class="card-body no-transition" href="{{ route('setting.invoice') }}">
                        <br><h2 class="text-center">Invoice</h2><br>
                    </a>
                </div>
            </div>
        @endif

        @if(auth()->user()->canAny(['employee_salary.view', 'employee_salary.update', 'employee_salary.delete', 'employee_salary.create']))
            <div class="col-md-4">
                <div class="card h-75 mx-4 mt-3 mb-5 ">
                    <a class="card-body no-transition" href=" {{ route('setting.salary')}}">
                        <br><h2 class="text-center">Salary</h2><br>
                    </a>
                </div>
            </div>
        @endif

    </div>
</div>

@endsection
