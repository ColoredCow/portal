@extends('layouts.app')

@section('content')

<div class="container" id="home_page">
    @include('status', ['errors' => $errors->all()])
    <br>

    <div class="d-flex justify-content-start row flex-wrap">
        @if(auth()->user()->hasAnyPermission(['hr_recruitment_applications.view', 'hr_employees.view', 'hr_volunteers_applications.view']))
        <div class="col-md-4">
            <div class="card h-75 mx-4 mt-3 mb-5 ">
                <a class="card-body no-transition" href="{{ route('settings.hr') }}">
                    <br><h2 class="text-center">HR</h2><br>
                </a>
            </div>
        </div>
        @endif

       @role('super-admin')
       <div class="col-md-4 d-none">
            <div class= "card h-75 mx-4 mt-3 mb-5">
                <a class="card-body no-transition" href="{{ route('permissions.module.index', ['module' => 'users']) }}">
                    <br><h2 class="text-center">Permissions</h2><br>
                </a>
            </div>
        </div>
       @endrole
    </div>
</div>

@endsection
