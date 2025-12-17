@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center">
    <h1>Project Contract</h1>
    <a class="btn btn-success" href="{{route('projectcontract.view-form')}}"><i class="fa fa-plus mr-1" ></i>Add New Contract</a>
</div>
<br>
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th class="w-30p sticky-top">Contract Name</th>
            <th class="sticky-top">Contract Link</th>
            <th class="sticky-top">Contract status</th>
            <th class="sticky-top">Action</th>
        </tr>
        @foreach ($projects as $project)
        <tr>
            <td>
                {{$project->contract_name}}
                <div class="d-flex flex-row">
                @foreach ($project->internalReviewers()->get() as $internal)
                    @if ($internal->status == 'approved')
                    <span class="d-flex flex-column align-items-start">
                        <span class="badge badge-success badge-pill mr-1 mb-1 fz-12"> {{ $internal->user_type }} - {{$internal->status }}</span>
                    </span>
                    @else
                    <span class="d-flex flex-column align-items-start">
                        <span class="badge badge-warning badge-pill mr-1 mb-1 fz-12"> {{ $internal->user_type }} - {{$internal->status }}</span>
                    </span>
                    @endif
                @endforeach
                @foreach ($project->contractReviewers()->get() as $external)
                    @if ($external->status == 'approved')
                        <span class="badge badge-success badge-pill mr-1 mb-1 fz-12"> Client - {{ $external->status }}</span>
                    @else
                        <span class="badge badge-warning badge-pill mr-1 mb-1 fz-12"> Client - {{ $external->status }}</span>
                    @endif
                @endforeach
                </div>
            </td>
            <td>{{$project->contract_link}}</td>
            <td>{{$project->status}}</td>
            <td>
                <a class="btn btn-success btn-sm pl-1" href="{{route('projectcontract.view-contract', $project->id)}}"><i class="fa fa-file-pdf-o mr-1" ></i>View</a>
            </td>
        </tr>
        @endforeach
    </thead>
</table>

@endsection
