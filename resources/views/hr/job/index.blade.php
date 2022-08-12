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
            <th>Resources Required</th>
            <th>Actions</th>
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
                {{$job->resources_required}}
            </td>
            <td>
                <a type="button" class="fa fa-edit text-theme-green" data-toggle="modal" data-target="#exampleModal{{ $job->id }}"></a>
                <form action="{{route('recruitment.opportunities.updateResources', $job->id)}}" method="POST" >
                    @csrf
                    <div class="modal fade" id="exampleModal{{ $job->id }}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">EDIT</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="name"><span>Resources Required</span></label>
                                    <input type="number" class="form-control" name="resources_required" id="resources_required" value={{$job->resources_required}}>
                                </div>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button> 
                            </div>
                          </div>
                        </div>
                    </div>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    {{ $jobs->links() }}
</div>
@endsection
