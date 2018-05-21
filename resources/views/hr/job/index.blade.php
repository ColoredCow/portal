@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('hr.menu')
    <br><br>
    <h1>Jobs</h1>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Job title</th>
            <th>Type</th>
            <th>Job description</th>
            <th>Total applicants</th>
        </tr>
        @foreach ($jobs as $job)
       
        <tr>
            <td>
                <a href="/hr/jobs/{{ $job->id }}/edit">{{ $job->title }}</a>
            </td>
            <td>
                {{ ucfirst($job->type) }}
            </td>
            <td>
                <a href="{{ $job->link }}" target="_blank">See</a>
            </td>
            <td>
            @if ($job->applications->count())
                <a href="{{ route('applications.' . $job->type . '.index') }}?hr_job_id={{$job->id }}">{{ $job->applications->count() }}</a>
            @else
                {{ $job->applications->count() }}
            @endif
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
