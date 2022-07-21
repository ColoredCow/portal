@extends('hr::layouts.master')
@section('content')
<div class="container ">
<div class="mx-9 mt-2">
    <h3>Guidelines and Resources</h3>
</div>
<div class="row col-lg-12 mt-2 d-flex mx-3 text-center">
    @foreach($jobs as $job)
    <div class="col-sm-2 mr-4 mt-2 mx-1">
        <div class="card h-130 w-200">
            <div class="card-body">
                <a href="{{ route('resources.show', $job->id) }}" class="card-text">{{$job->title}}</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
</div>
@endsection