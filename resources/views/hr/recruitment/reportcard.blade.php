@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="text-center">Reports</h1>
    <br>
    <div class="d-flex justify-content-start row flex-wrap">

        <div class="col-md-4">
            <div class="card h-75 mx-6 mt-5 mb-5 ">
                <a class="card-body no-transition" href="{{ route('recruitment.daily-applications-count') }}" >
                    <br><h2 class="text-center">Daily Application Count</h2><br>
                </a>
            </div>
        </div>
     <div class="col-md-4">
        <div class="card h-75 mx-6 mt-5 mb-5 ">
            <a class="card-body no-transition" href="{{ route('applications.job-Wise-Applications-Graph') }}" >
                <br><h2 class="text-center">Job Role Engagement</h2><br>   
            </a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-75 mx-6 mt-5 mb-5 ">
            <a class="card-body no-transition" href="{{ route('recruitment.rejected-applications') }}" >
                <br><h2 class="text-center">Daily Application Count</h2><br>
            </a>
        </div>
    </div>

@endsection
