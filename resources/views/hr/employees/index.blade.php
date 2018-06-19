@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('hr.employees.menu')
    <br><br>
    <h1>Employees</h1>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Name</th>
            <th>Designation</th>
            <th>Joined</th>
            <th>Projects</th>
        </tr>
        @foreach ($team as $member)
        <tr>
            <td>
                <a href="#">{{ $member->name }}</a>
            </td>
            <td>Software Developer</td>
            <td>{{ date('d/m/Y') }}</td>
            <td>Employee Portal</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
