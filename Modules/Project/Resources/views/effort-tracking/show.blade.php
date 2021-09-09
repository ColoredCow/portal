@extends('project::layouts.master')
@section('content')

<div class="project-effort-tracking-container container">
    <div class="card">
        <div class="card-header">
            <h4>{{$project->name}} - Effort Details</h4>
        </div>
        <div class="d-flex flex-row align-items-center justify-content-between p-3">
            <div>
                <h2 class="fz-18 leading-22">Current Hours: <span>32</span></h2>
                <h2 class="fz-18 leading-22">Expected Hours: <span>40</span></h2>
                <h2 class="fz-18 leading-22">FTE: <span class="text-danger">0.8</span></h2>
                <h2 class="fz-18 leading-22">Previous Month FTE: <span class="text-success">1</span></h2>
                <a class="fz-18 leading-22" href="#">Historical Data</a>
            </div>
            <div>Graph</div>
        </div>
    </div>
</div>
<div class="project-resource-effort-tracking-container"></div>

@endsection
