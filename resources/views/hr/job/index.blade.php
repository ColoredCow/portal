@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @includeWhen($type == 'volunteer', 'hr.volunteers.menu')
    @includeWhen($type == 'recruitment', 'hr.menu')
    <br><br>
    <div class="d-flex justify-content-between align-items-center">
        <h1>{{ $type == 'volunteer' ? 'Projects' : 'Opportunities' }}</h1>
        <div class="col-md-4">
            <form class="offset-md-5 col-md-12 d-flex justify-content-end align-items-center" method="GET" action="{{ route('recruitment.opportunities', ['status' => 'published']) }}">
                <input type="hidden" name="status" value="{{ request()->input('status', 'published') }}">
                <div class="d-flex align-items-cente">
                    <input type="text" name="title" class="form-control" id="title" placeholder="Enter the opportunity" value="{{ request()->get('title') }}">
                    <button class="btn btn-info ml-2 text-white">Search</button>
                </div>
            </form>
        </div>
        <a href="{{ route('recruitment.opportunities.create') }}" class="btn btn-success"><i class="fa fa-plus mr-1"></i>New Opportunity</a>
    </div>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Title</th>
            <th>Type</th>
            <th>Resources Required</th>
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
                        <span>View applications</span>
                    </a>
                    @endif
                </div>
            </td>
            <td>{{ ucfirst($job->type) }}</td>
            <td>
                <span>{{$job->jobRequisition->count()}}</span>
            </td>
        </tr>
        @endforeach
    </table>
    {{ $jobs->links() }}
</div>
@endsection