@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <div class="d-flex justify-content-start row flex-wrap">
        @can('hr_recruitment_applications.view')
        <div class="col-md-3 card mx-5 mt-3 mb-5">
            <a class="card-body no-transition" href="{{ route('applications.job.index') }}">
                <br><h2 class="text-center">Recruitment</h2><br>
            </a>
        </div>
        @endcan
        @can('hr_employees.view')
        <div class="col-md-3 card mx-5 mt-3 mb-5">
            <a class="card-body no-transition" href="{{ route('employees') }}">
            	<br><h2 class="text-center">Employees</h2><br>
            </a>
        </div>
        @endcan
        @can('hr_volunteers_applications.view')
        <div class="col-md-3 card mx-5 mt-3 mb-5">
            <a class="card-body no-transition" href="{{ route('applications.volunteer.index') }}">
                <br><h2 class="text-center">Volunteer</h2><br>
            </a>
        </div>
        @endcan
    </div>
</div>
@endsection
