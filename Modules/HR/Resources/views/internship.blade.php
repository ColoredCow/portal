@extends('report::layouts.finance')
@section('content')
    <div class="d-flex justify-content-between mb-2">
        <h1 class="mb-1 pb-1">Internship Dashboard</h1>
    </div>
    <br>
    <div>
        <div class="d-flex justify-content-start row flex-wrap">
            <div class="col-md-3">
                <div class="card h-99 ">
                    <a class="card-body no-transition" href="{{ route('hr.internship.form') }}">
                        <h2 class="text-center">Internship Certificate</h2><br>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-99 ">
                    <a class="card-body no-transition" href="">
                        <h2 class="text-center">Experience Letter</h2><br>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
