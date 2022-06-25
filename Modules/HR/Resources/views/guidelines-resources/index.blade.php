@extends('hr::layouts.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h3>Guidelines And Resources</h3>
        </div>
    </div> 
</div>
<div class="row mt-2 d-flex mx-4 text-center">
    @foreach($jobs as $job)
    <div class="col-sm-2 mt-2 mx-3">
        <div class="card" style="width:14rem; height: 8rem;">
            <div class="card-body">
                <a href="{{ route('resources.show') }}" class="card-text">{{$job->title}}</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection