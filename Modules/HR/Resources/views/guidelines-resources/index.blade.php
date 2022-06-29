@extends('hr::layouts.master')
@section('content')
<div class="mx-9">
    <h3>Guidelines And Resources</h3>
</div>
<div class="row mt-2 d-flex mx-3 text-center">
    @foreach($jobs as $job)
    <div class="col-sm-2 mt-2 mx-3">
        <div class="card h-130 w-200">
            <div class="card-body">
                <a href="{{ route('resources.show') }}" class="card-text">{{$job->title}}</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection