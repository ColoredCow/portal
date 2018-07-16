@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @includeWhen($type == 'volunteer', 'hr.volunteers.menu')
    @includeWhen($type == 'recruitment', 'hr.menu')
    <br><br>
    <h1>{{ $type == 'volunteer' ? 'Projects' : 'Jobs' }}</h1>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Title</th>
            <th>Type</th>
            <th>Open applications</th>
        </tr>
        @foreach ($jobs as $job)
        <tr>
            <td>
                @if ($type == 'volunteer')
                    <a href="{{ route('volunteer.opportunities.edit', $job->id) }}">{{ $job->title }}</a>
                @else
                    <a href="{{ route('recruitment.opportunities.edit', $job->id) }}">{{ $job->title }}</a>
                @endif
            </td>
            <td>
                {{ ucfirst($job->type) }}
            </td>

            <td>
            @if ($job->applications->count())
                @if($job->type === 'volunteer') 
                    <a href="{{ route($job->type . '.applications'. '.index') }}?hr_job_id={{$job->id }}">{{ $job->applications->count() }}</a>
                @else
                    <a href="{{ route('applications.' . $job->type . '.index') }}?hr_job_id={{$job->id }}">{{ $job->applications->count() }}</a>
                @endif
            @else
                {{ $job->applications->count() }}
            @endif
            </td>
        </tr>
        @endforeach
    </table>
    {{ $jobs->links() }}
</div>
@endsection
