@extends('hr::layouts.master')
@section('content')
<div class="container">
    <br>
    <div class="d-flex justify-content-start row flex-wrap">
        @can('hr_recruitment_applications.view')
        <div class="col-md-4">
            <div class="card h-75 mx-4 mt-3 mb-5 ">
                <a class="card-body no-transition" href="{{ route('applications.job.index') }}">
                    <br>
                    <h2 class="text-center">Jobs</h2><br>
                </a>
            </div>
        </div>
        @endcan
    </div>
</div>
@endsection