@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <div class="d-flex justify-content-start row flex-wrap">
        <div class="col-md-3 card mx-5 my-3">
            <a class="card-body no-transition" href="{{ route('applications.job.index') }}">
                <br><h2 class="text-center">Recruitment</h2><br>
            </a>
        </div>
        <div class="col-md-3 card mx-5 my-3">
            <a class="card-body no-transition" href="{{ route('employees') }}">
            	<br><h2 class="text-center">Employees</h2><br>
            </a>
        </div>
    </div>
</div>
@endsection
