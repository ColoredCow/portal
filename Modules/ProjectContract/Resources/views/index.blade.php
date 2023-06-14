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
            <th class="w-30p sticky-top">Client Name</th>
            <th class="sticky-top">Authority Name</th>
            <th class="sticky-top">Contract Date for Effective</th>
            <th class="sticky-top">Contract Expiry Date</th>
            <th class="sticky-top">Status</th>
            <th class="sticky-top">Action</th>
        </tr>
        @foreach ($projects as $project)
        <tr>
            <td>{{$project->client->name}}</td>
            <td>{{$project->authority_name}}</td>
            <td>{{$project->contract_date_for_effective}}</td>
            <td>{{$project->contract_expiry_date}}</td>
            <td></td>
            <td>
                <a href="{{route('projectcontract.edit', $project->id)}}" class="pl-1 btn btn-link" ><i class="text-success fa fa-edit fa-lg"></i></a>
                <a href="{{route('projectcontract.delete', $project->id)}}" class="pl-1 btn btn-link" ><i class="text-danger fa fa-trash fa-lg"></i></a>
            </td>
        </tr>
        @endforeach
    </thead>
</table>
@endsection
