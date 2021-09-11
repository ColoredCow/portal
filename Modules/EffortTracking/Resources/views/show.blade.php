@extends('efforttracking::layouts.master')
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
                <a class="fz-18 leading-22" href="{{route('project.effort-tracking-history', $project )}}">Historical Data</a>
            </div>
            <div>Graph</div>
        </div>
    </div>
</div>
<div class="project-resource-effort-tracking-container container mt-4">
    <div class="card">
        <div class="card-header">
            <h4>{{$project->name}} - Members</h4>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Actual Effort</th>
                        <th scope="col">Expected Effort</th>
                        <th scope="col">FTE</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">Kuldeep Upreti</th>
                        <td class="text-danger">32</td>
                        <td>40</td>
                        <td class="text-danger">0.8</td>
                    </tr>
                    <tr>
                        <th scope="row">Abhishek Pokhriyal</th>
                        <td class="text-success">40</td>
                        <td>40</td>
                        <td class="text-success">1</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
