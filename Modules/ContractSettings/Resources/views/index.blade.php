@extends('client::layouts.master')

@section('content')
<div class="container"><br>
    <div class="d-flex justify-content-between">
        <div>
            <h2 class="mb-3">Contract Templates</h2>
        </div>
        <div>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#designationformModal"><i class="fa fa-plus mr-1"></i> Add Contract Links</button>
        </div>
    </div>
    <div class="modal fade" id="designationformModal" tabindex="-1" role="dialog" aria-labelledby="designationformModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="designationformModalLabel">Add Contract Template Link</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="spinner-border text-primary d-none" id="designationFormSpinner"></div>
                </div>
                <div class="designation modal-body">
                    <form action="{{ route('contractsettings.store')}}" method="POST" id="designationForm" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" id="contract_type" name="contract_type" value="">
                            <div class='form-group'>
                                <label class="field-required" for="designationfield">Contract Type</label><br>
                                <select name="contractsettings" class="form-control" >
                                    <option value="">Select Contract Type</option>
                                    @foreach(config('contractsettings.billing_level') as $billingType)
                                        <option value="{{$billingType}}">{{$billingType}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="designationfield">Add Link</label><strong class="text-danger">*</strong></label>
                            <input type="text" name="contract_template" class="form-control"  id="contract_template" aria-describedby="Help" placeholder="Link" >
                            <div class="d-none text-danger" name="error" id="designationerror"></div>
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
            <th>{{ __('Billing Type') }}</th>
            <th>{{ __('Links') }}</th>
            <th>{{ __('Actions') }}</th>
        </tr>
        @foreach($contracts as $contract)
        <tr>
            <td>{{ $contract->contract_type }}</td>
            <td>
                {{ $contract->contract_template}}
            </td>
            <td class="d-flex justify-content-around">
                <a type="button" class="pr-1 btn btn-link" data-toggle="modal" data-target="#contractEditformModal{{$contract->id}}"  ><i class="text-success fa fa-edit fa-lg"></i></a>
                <button type="submit" class="pl-1 btn btn-link" onclick="return confirm('Are you sure you want to delete?')"><i class="text-danger fa fa-trash fa-lg"></i></button>
            </td>
        </tr>
        @include('contractsettings::edit')
        @endforeach
    </table>
</div>
@endsection
