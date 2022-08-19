@extends('layouts.app')

@section('content')

<div class="container" id="home_page">
    @include('status', ['errors' => $errors->all()])
    <br>

    <div class="d-flex justify-content-start row flex-wrap">
        @can('hr_settings.view')
            <div class="col-md-4">
                <div class="card h-75 mx-4 mt-3 mb-5 ">
                    <a class="card-body no-transition" href="{{ route('settings.hr') }}">
                        <br><h2 class="text-center">HR</h2><br>
                    </a>
                </div>
            </div>
        @endcanany

        @can('nda_settings.view')
            <div class="col-md-4">
                <div class="card h-75 mx-4 mt-3 mb-5 ">
                    <a class="card-body no-transition" href="{{ route('setting.agreement.nda') }}">
                        <br><h2 class="text-center">NDA</h2><br>
                    </a>
                </div>
            </div>
        @endcanany

        @can('finance_invoices_settings.view')
            <div class="col-md-4">
                <div class="card h-75 mx-4 mt-3 mb-5 ">
                    <a class="card-body no-transition" href="{{ route('setting.invoice') }}">
                        <br><h2 class="text-center">Invoice</h2><br>
                    </a>
                </div>
            </div>
        @endcan
        @can('employee_salary_settings.view')
            <div class="col-md-4">
                <div class="card h-75 mx-4 mt-3 mb-5 ">
                    <a class="card-body no-transition" href="{{ route('salary.settings') }}">
                        <br><h2 class="text-center">Salary</h2><br>
                    </a>
                </div>
            </div>
        @endcan
        
        @can('organization_settings.view')
        <div class="col-md-4">
            <div class="card h-75 mx-4 mt-3 mb-5 ">
                <a class="card-body no-transition" href="{{ route('setting.organization') }}">
                    <br><h2 class="text-center">Organization</h2><br>
                </a>
            </div>
        </div>
        @endcan
            
    </div>
</div>

@endsection
