@extends('efforttracking::layouts.master')
@section('content')

<div class="project-effort-tracking-container container">
    <div class="card">
        <div class="card-header">
            <h4>{{$project->name}} - Effort Details for September</h4>
        </div>
        <div class="d-flex flex-row align-items-center justify-content-between p-3">
            <div>
                <h2 class="fz-18 leading-22">Current Hours: <span>32</span></h2>
                <h2 class="fz-18 leading-22">Expected Hours: <span>{{$project->monthly_estimated_hours}}</span></h2>
                <h2 class="fz-18 leading-22">FTE: <span class="text-danger">0.8</span></h2>
                <h2 class="fz-18 leading-22">Previous Month FTE: <span class="text-success">1</span></h2>
                <a class="fz-18 leading-22" href="{{route('project.effort-tracking-history', $project )}}">Historical Data</a>
            </div>
            <div class="effort-tracking-data">
                <input type="hidden" name="team_members_effort" value="{{$teamMembersEffort}}">
                <input type="hidden" name="workingDays" value="{{$workingDays}}">
                <input type="hidden" name="users" value="{{$users}}">
                <canvas id="effortTrackingGraph" style="width:100%;"></canvas>
            </div>
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
                    @php $users = json_decode($users) @endphp
                    @foreach($users as $user)
                        <tr>
                            <th scope="row" style="color: <?php echo $user->color; ?>">{{$user->name}}</th>
                            <td>{{$user->actual_effort}}</td>
                            <td>40</td>
                            <td class="text-danger">0.8</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
