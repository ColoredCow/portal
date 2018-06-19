@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <div class="d-flex justify-content-start row flex-wrap">
        @can('library_books.view')
        <div class="col-md-3 card mx-5 my-3">
            <a class="card-body no-transition d-flex align-items-center justify-content-center py-5" href="{{ route('applications.job.index') }}">
                <h2 class="text-center">Recruitment</h2>
            </a>
        </div>
        @endcan
        @can('weeklydoses.view')
        <div class="col-md-3 card mx-5 my-3">
            <a class="card-body no-transition d-flex align-items-center justify-content-center py-5" href="{{ route('team') }}">
            	<h2 class="text-center">Team management</h2>
            </a>
        </div>
        @endcan
    </div>
</div>
@endsection
