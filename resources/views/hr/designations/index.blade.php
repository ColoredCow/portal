@extends('layouts.app')

@section('content')
<div class="container">
    <div class="text-primary">
        <h1><b> Designation Dashboard</b></h1>
    </div><br>
    <div class="d-flex justify-content-between">
        <div>
            <h2 class="mb-3 text-primary">New Designations</h2>
        </div>
        <div>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#designationformModal"> Add Desingnation</button>
        </div>
    </div>
    <div class="modal fade" id="designationformModal" tabindex="-1" role="dialog" aria-labelledby="designationformModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="designationformModalLabel">Designation Name </h5> 
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
                            <input type="text" name="name" class="form-control"  id="name" aria-describedby="Help" placeholder="name"> 
                            <div class="d-none text-danger" name="error" id="designationerror"></div>
                        </div>        
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="designation">Save changes</button>  
                    </form>
                </div>
            </div>
        </div>
    </div>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
        <tr class="sticky-top">
            <th>{{ __('Designation') }}</th>
            <th>{{ __('Edit') }}</th>
            <th>{{ __('Delete') }}</th>
        </tr>
        @foreach ($designations as $designation)
        <tr>
            <td>
                <span class="d-flex text-justify-center">
                {{$designation->designation}}
                </span>
            </td>
            <td>
                <a href="{{ route('designation.edit', ['id' => $designation->id]) }}"  class="pr-1 btn btn-link"  ><i class="text-success fa fa-edit fa-lg"></i></a>   
            </td>
            <td>
                <form action="{{ route('designation.delete', ['id' => $designation->id]) }}" method="post">
                    @csrf
                    <button type="submit" class="pl-1 btn btn-link" onclick="return confirm('Are you sure you want to delete?')"><i class="text-danger fa fa-trash fa-lg"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection

