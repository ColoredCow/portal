@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="text-center">Reports</h21>
    <br>
    <div class="d-flex justify-content-start row flex-wrap">

        <div class="col-md-4">
            <div class="card h-75 mx-6 mt-5 mb-5 ">
                <a class="card-body no-transition" href="{{ route('recruitment.reports') }}" >
                    <br><h2 class="text-center">Daily application count</h2><br>
                </a>
            </div>
        </div>
    </div>

@endsection


