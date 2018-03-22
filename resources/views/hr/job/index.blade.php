@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <h1>Jobs</h1>
    <br>
    <a class="btn btn-info" href="/hr/applicants">See all applicants</a>
    <br><br>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Job title</th>
            <th>Job description</th>
            <th>Total applicants</th>
            {{-- <th>Accepted</th> --}}
            {{-- <th>Rejected</th> --}}
            {{-- <th>In Progress</th> --}}
        </tr>
        @foreach ($jobs as $job)
        <tr>
            <td><a href="/hr/jobs/{{ $job->id }}/edit">{{ $job->title }}</a></td>
            <td><a href="{{ $job->link }}" target="_blank">See</a></td>
            <td>{{ $job->applicants->count() }}</td>
            {{-- <td>{{ $job->applicants->where('status', 'accepted')->count() }}</td> --}}
            {{-- <td>2</td> --}}
            {{-- <td>2</td> --}}
            {{-- <td>2</td> --}}
        </tr>
        @endforeach
    </table>
</div>
@endsection
