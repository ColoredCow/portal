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
            <td>{{$project->contract_name}}</td>
            <td>{{$project->contract_link}}</td>
            <td>{{$project->status}}</td>
            <td>
                <a href="{{route('projectcontract.view-contract', $project->id)}}" class="pl-1 btn btn-link" ><i class="fa fa-eye"></i></a>
            </td>
        </tr>
        @endforeach
    </thead>
</table>
@if (count($internal) >= 1)
<h4>Review Pendings</h4>
<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th class="w-30p sticky-top">Contract Name</th>
            <th class="sticky-top">Contract Link</th>
            <th class="sticky-top">Contract status</th>
            <th class="sticky-top">Action</th>
        </tr>
        @foreach ($internal as $inter)
        <tr>
            <td>{{$inter->contract_name}}</td>
            <td>{{$inter->contract_link}}</td>
            <td>{{$inter->status}}</td>
            <td>
                <a href="{{route('projectcontract.view-contract', $inter->contract_id)}}" class="pl-1 btn btn-link" ><i class="text-primary fa fa-eye fa-lg"></i></a>
            </td>
        </tr>
        @endforeach
    </thead>
</table>
@endif
@endsection
