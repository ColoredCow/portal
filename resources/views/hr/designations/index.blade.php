@extends('layouts.app')

@section('content')
<div class="container"><br>
    <div class="d-flex justify-content-between">
        <div>
            <h2 class="mb-3">New Designations</h2>
        </div>
        <div class="col-md-5">
            <form class="d-flex" method="GET" action="{{route('designation')}}">
                <input type="text" name="search" class="form-control" placeholder="Search Desingnation">
                <button type="submit" class="btn btn-info ml-1" >Search</button>
            </form>
        </div>
        <div>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#designationformModal"><i class="fa fa-plus mr-1"></i> Add Desingnation</button>
        </div>
    </div>
    <div class="d-none alert alert-success " id="successMessage" role="alert">
        <strong>Updated</strong> Submitted successfully!
        <button type="button" class="close" id="closeSuccessMessage" aria-label="Close">
        </button>
    </div><br>
    <div class="modal fade" id="designationformModal" tabindex="-1" role="dialog" aria-labelledby="designationformModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="designationformModalLabel">Designation Name</h5> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="spinner-border text-primary d-none" id="designationFormSpinner"></div>
                </div>
                <div class="designation modal-body">
                    <form action="{{ route('hr-job-designation.storeJobDesignation')}}" method="POST" id="designationForm" >
                        @csrf
                        <div class="form-group">
                            <label for="designationfield">name</label><strong class="text-danger">*</strong></label>
                            <input type="text" name="name" class="form-control"  id="name" aria-describedby="Help" placeholder="name" > 
                            <div class="d-none text-danger" name="error" id="designationerror"></div>
                        </div> 
                        <input type="hidden" name="domainName" id="domainName" value="">
                        <div class='form-group'>
                            <label class="field-required" for="designationfield">domain</label><br>
                            <select name="domain" class="form-control" >
                                <option value="">Select Domain</option>
                                @foreach($domains as $domain)
                                    <option value="{{$domain->id}}">{{$domain->domain}}</option>
                                @endforeach
                            </select>
                        </div>   
                        <div class="d-none text-danger" name="error" id="domainerror"></div>   
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="designation">Save changes</button>  
                    </form>
                </div>
            </div>
        </div>
    </div>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
        <tr>
            <th>{{ __('Designation') }}</th>
            <th>{{ __('Edit') }}</th>
            <th>{{ __('Delete') }}</th>
        </tr>
        @foreach ($designations as $designation)
        <tr>
            <td>
                <span class="d-flex text-justify-center">{{ $designation->designation }}</span>
            </td>
            <td>
                <button type="button" class="pr-1 btn btn-link" data-toggle="modal" data-target="#designationEditFormModal{{$designation->id}}" data-json="{{$designation}}" ><i class="text-success fa fa-edit fa-lg"></i></button>
            </td>
            <td>
                <form action="{{ route('designation.delete', ['id' => $designation->id]) }}" method="post">
                    @csrf
                    <button type="submit" class="pl-1 btn btn-link" onclick="return confirm('Are you sure you want to delete?')"><i class="text-danger fa fa-trash fa-lg"></i></button>
                </form>
            </td>
        </tr>
        @include('hr.designations.edit')
        @endforeach
    </table>
</div>
@endsection
