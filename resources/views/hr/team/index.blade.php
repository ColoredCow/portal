@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('hr.team.menu')
    <br><br>
    <h1>Team</h1>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Name</th>
            <th>Designation</th>
            <th>Joined</th>
            <th>Current projects</th>
            <th>Feedback</th>
        </tr>
        @foreach ($team as $member)
        <tr>
            <td>{{ $member->name }}</td>
            <td>Software Developer</td>
            <td>{{ date('d/m/Y') }}</td>
            <td>Employee Portal</td>
            <td><a href="#">View feedback</a></td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
