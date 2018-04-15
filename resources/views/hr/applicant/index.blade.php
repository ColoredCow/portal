@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <h1>Applicants</h1>
    <br>
    <a class="btn btn-info" href="/hr/jobs">See all jobs</a>
    <br><br>
    <table class="table table-striped table-bordered" id="applicants_table">
        <tr>
            <th>Name</th>
            <th>Contact</th>
            <th>Applied for</th>
            <th>Date of application</th>
            <th>Resume</th>
            <th>Status</th>
        </tr>
        @foreach ($applicants as $applicant)
        <tr>
            <td>
                <a href="/hr/applicants/{{ $applicant->id }}/edit">{{ $applicant->name }}</a>
            </td>
            <td>{{ $applicant->email }}<br>{{ $applicant->phone }}</td>
            <td>{{ $applicant->job->title }}</td>
            <td>{{ $applicant->created_at }}</td>
            <td>
                @if ($applicant->resume)
                    <a href="{{ $applicant->resume }}" class="d-flex justify-content-center" target="_blank"><i class="fa fa-file fa-2x"></i></a>
                @else
                    <span class="d-flex justify-content-center">–</span>
                @endif
            </td>
            <td>
                <span class="d-flex justify-content-center">
                    <span class="{{ config("constants.hr.status.$applicant->status.class") }} badge-pill">{{ config("constants.hr.status.$applicant->status.title") }}</span>
                </span>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
