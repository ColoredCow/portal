@extends('client::layouts.master')

@section('content')
<div class="container"><br>
    <div class="d-flex justify-content-between">
        <div>
            <h2 class="mb-3">Add Contract Links</h2>
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
                    <!-- <form action="{{ route('hr-job-designation.storeJobDesignation')}}" method="POST" id="designationForm" > -->
                        <!-- @csrf -->
                        <div class="form-group">
                            <label for="designationfield">Add Link</label><strong class="text-danger">*</strong></label>
                            <input type="text" name="name" class="form-control"  id="name" aria-describedby="Help" placeholder="Link" >
                            <div class="d-none text-danger" name="error" id="designationerror"></div>
                        </div>
                        <div class="d-none text-danger" name="error" id="domainerror"></div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="designation">Save changes</button>
                    <!-- </form> -->
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
        @foreach(config('contractsettings.billing_level') as $billingType)
        <tr>
            <td>{{ $billingType }}</td>
            <td>

            </td>
            <td class="d-flex justify-content-around">
                <button type="button" class="pr-1 btn btn-link" data-toggle="modal" data-target="#designationformModal" ><i class="text-success fa fa-edit fa-lg"></i></button>
                <button type="submit" class="pl-1 btn btn-link" onclick="return confirm('Are you sure you want to delete?')"><i class="text-danger fa fa-trash fa-lg"></i></button>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
