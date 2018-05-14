@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('hr.menu', ['active' => 'applicants'])
    <br><br>
    <h1>Applicants</h1>
    <table class="table table-striped table-bordered" id="applicants_table">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Applied for</th>
            <th>Applied on</th>
            <th>Status</th>
        </tr>
        @foreach ($applicants as $applicant)
        <tr>
            <td>
                <a href="/hr/applicants/{{ $applicant->id }}/edit">{{ $applicant->name }}</a>
            </td>
            <td>{{ $applicant->email }}</td>
            <td>
                @foreach($applicant->applications as $application)
                    {{ $application->job->title }}
                @endforeach
            </td>
            <td>{{ $applicant->created_at->format(config('constants.display_date_format')) }}</td>
            <td>
                <span class="d-flex justify-content-start">
                    @if (in_array($applicant->status, ['in-progress', 'new']))
                        <span class="badge badge-warning badge-pill">{{ $applicant->applicantRounds->last()->round->name }}</span>
                        @if ($applicant->applicantRounds->count() > 1)
                            <span class="badge badge-info badge-pill ml-1 px-2">Completed: {{ $applicant->applicantRounds->count() - 1 }}</span>
                        @else
                            <span class="badge badge-info badge-pill ml-1 px-2">New</span>
                        @endif
                    @else
                        <span class="{{ config("constants.hr.status.$applicant->status.class") }} badge-pill">{{ config("constants.hr.status.$applicant->status.title") }}</span>
                    @endif
                </span>
            </td>
        </tr>
        @endforeach
    </table>
    {{ $applicants->links() }}
</div>
@endsection
