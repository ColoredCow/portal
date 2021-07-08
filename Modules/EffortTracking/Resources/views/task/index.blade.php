@extends('efforttracking::layouts.master')

@section('content')
<div class="container">
    <h1>Projects</h1>
    <div class="mt-4 table-responsive">
        <table class="table table-striped table-bordered">
            <tr>
                <th>Name</th>
                <th>Action</th>
            </tr>
            @foreach($projects as $project)
                <tr >
                    <td>
                        <h5 class="font-weight-bold">{{$project->name}}</h5>
                    </td>
                    <td>
                        <a href="{{route('task.show',$project)}}" class="btn btn-link">View Task</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection
