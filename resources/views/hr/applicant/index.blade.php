@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <h1>Applicants</h1>
    <br>
    {{-- <a class="btn btn-primary" href="/hr/applicants/create"><i class="fa fa-plus"></i>&nbsp;&nbsp;New applicant</a> --}}
    <a class="btn btn-info" href="/hr/jobs">See all jobs</a>
    <br>
    <br>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Name</th>
            <th>Contact</th>
            <th>Applied for</th>
            <th>Current Round</th>
            <th>Resume</th>
            <th>Date of application</th>
        </tr>
        @foreach ($applicants as $applicant)
        <tr>
            <td>{{ $applicant->name }}</td>
            <td>{{ $applicant->email }}<br>{{ $applicant->phone }}</td>
            <td>{{ $applicant->job->title }}</td>
            <td>Round 3: Detailed Tech</td>
            <td>{{ $applicant->resume }}</td>
            <td>{{ $applicant->created_at }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
