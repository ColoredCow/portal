@extends('efforttracking::layouts.master')
@section('content')

<div class="project-resource-effort-tracking-container container mt-4">
    <div class="card">
        <div class="card-header">
            <h4>{{$project->name}} - Members</h4>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Month</th>
                        <th scope="col">Actual Effort</th>
                        <th scope="col">Expected Effort</th>
                        <th scope="col">FTE</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">August 2021</th>
                        <td class="text-danger">276</td>
                        <td>230</td>
                        <td class="text-success">1.21</td>
                    </tr>
                    <tr>
                        <th scope="row">July 2021</th>
                        <td class="text-danger">281</td>
                        <td>230</td>
                        <td class="text-success">1.22</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
