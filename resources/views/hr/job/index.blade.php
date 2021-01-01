@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @includeWhen($type == 'volunteer', 'hr.volunteers.menu')
    @includeWhen($type == 'recruitment', 'hr.menu')
    <br><br>
    <div class="d-flex justify-content-between align-items-center">
        <h1>{{ $type == 'volunteer' ? 'Projects' : 'Opportunities' }}</h1>
        <a href="{{ route('recruitment.opportunities.create') }}" class="btn btn-primary"><i class="fa fa-plus mr-1"></i>New Opportunity</a>
    </div>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Title</th>
            <th>Type</th>
        </tr>
        @foreach ($jobs as $job)
        <tr>
            <td>
                <div>
                    @if ($type == 'volunteer')
                        <a href="{{ route('volunteer.opportunities.edit', $job->id) }}">{{ $job->title }}</a>
                    @else
                        <a href="{{ route('recruitment.opportunities.edit', $job->id) }}">{{ $job->title }}</a>
                    @endif
                </div>
                <div class="mb-0 text-secondary fz-14 d-flex">
                    <p class="mb-0">
                        <i class="fa fa-users"></i>
                        <span>{{ $job->applications->count() }}</span>
                    </p>
                    @if ($job->applications->count())
                        <p class="mb-0 mx-1">•</p>
                        <a href="{{ route('applications.' . $job->type . '.index') }}?hr_job_id={{$job->id }}" class="fz-14 d-flex align-items-center">
                            <span>View open <i class="fa fa-external-link w-10 h-10"></i></span>
                        </a>
                    @endif
                </div>
            </td>
            <td>{{ ucfirst($job->type) }}</td>
        </tr>
        @endforeach
    </table>
    {{ $jobs->links() }}
</div>
@endsection
