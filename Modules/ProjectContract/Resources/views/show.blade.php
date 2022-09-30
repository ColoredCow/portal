@extends('project::layouts.master')
@section('content')

<div class="container">
    <br>
    <div class="card mt-5">
        <div class="card-header" data-toggle="collapse">
            <h1>Project Details </h1>
        </div>
        <br>
        <div class="form-row">
            <div class="form-group col-md-4 pl-4 mb-7">
                <h4 class="d-inline-block">
                    <label for="name" class="font-weight-bold mb-6 mt-2 ml-1">Client Name:</label>
                </h4>
                <span class="text-capitalize ml-2 fz-lg-22">{{ $project->client->name }} &nbsp;</span>
                <span data-html="true" data-toggle="tooltip" title="{{ $project->client->name}}" class="content tooltip-wrapper">&nbsp;
            </div>
            <div class="form-group offset-md-1 pl-4 col-md-5 mt-3">
                <h4 class="d-inline-block">
                    <label for="name" class="font-weight-bold mb-1">Contract Date For Signing:</label>
                </h4>
                <span class="text-capitalize ml-2 fz-lg-22">{{ date('d-M-Y', strtotime($project->contract_date_for_signing))}}</span>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4 pl-4 mb-7">
                <h4 class="d-inline-block">
                    <label for="name" class="font-weight-bold mb-6 ml-1">Website URL:</label>
                </h4>
                <span class="text-capitalize ml-2 fz-lg-22"><a href="{{$project->website_url}}"><button class="btn btn-success fa fa mr-1">URL</button></a></span>
            </div>
            <div class="form-group offset-md-1 pl-3 col-md-5">
                <h4 class="d-inline-block">
                    <label for="name" class="font-weight-bold mb-3">Contract Date For Effective:</label>
                </h4>
                <span class="text-capitalize ml-2 fz-lg-22">{{ date('d-M-Y', strtotime($project->contract_date_for_effective))}}</span>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4 pl-4">
                <h4 class="d-inline-block">
                    <label for="name" class="font-weight-bold mb-6 ml-1">Authority Name:</label>
                </h4>
                <span class="text-capitalize ml-2 fz-lg-22">{{ $project->authority_name }}</span>
            </div>
            <div class="form-group offset-md-1 pl-4 col-md-5">
                <h4 class="d-inline-block">
                    <label for="name" class="font-weight-bold mt-0 mb-2">Contract Expiry Date:</label>
                </h4>
                <span class="text-capitalize ml-2 fz-lg-22">{{ date('d-M-Y', strtotime($project->contract_expiry_date))}}</span>
            </div>
            <div class="form-group col-md-4 pl-4 mb-7">
                <h4 class="d-inline-block">
                    <label for="name" class="font-weight-bold mb-6 mt-2 ml-1">Client Logo:</label>
                </h4>
                <span data-html="true" data-toggle="tooltip" title="{{ $project->client->name}}" class="content tooltip-wrapper">&nbsp;
                <img src="{{ asset('storage/contractlogo/'.$project->logo_img) }}"  class="w-40 h-40 rounded-circle mb-1 " class="w-35 h-30 rounded-circle mb-1"><a target="_blank" href="{{ asset('storage/contractlogo/'.$project->logo_img) }}" class="w-150 h-130 mb-1">View</a></a>
            </div>
        </div>
    </div>
</div>
@endsection
