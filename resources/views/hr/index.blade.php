@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <div class="row d-flex justify-content-start flex-wrap">
        @can('hr_recruitment_applications.view')
                <div class="col-md-4">
    <div class="card h-75 mx-4 mt-3 mb-5 ">
            <a class="card-body no-transition" href="{{ route('applications.job.index') }}">
                <br><h2 class="text-center">Recruitment</h2><br>
            </a>
        </div>
    </div>
        @endcan
        @can('hr_employees.view')
                <div class="col-md-4">
    <div class="card h-75 mx-4 mt-3 mb-5 ">
            <a class="card-body no-transition" href="{{ route('employees') }}">
            	<br><h2 class="text-center">Employees</h2><br>
            </a>
        </div>
    </div>

        @endcan
        @can('hr_volunteers_applications.view')
                <div class="col-md-4">
    <div class="card h-75 mx-4 mt-3 mb-5 ">
            <a class="card-body no-transition" href="{{ route('applications.volunteer.index') }}">
                <br><h2 class="text-center">Volunteer</h2><br>
            </a>
        </div>
    </div>
        @endcan
    </div>
</div>
@endsection
