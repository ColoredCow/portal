@extends('client::layouts.master')

@section('content')
<div class="container"><br>
    <div class="d-flex justify-content-between">
        <div>
            <h2 class="mb-3">Contract Templates</h2>
        </div>
        <div>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#contractformModal"><i class="fa fa-plus mr-1"></i> Add Contract Links</button>
        </div>
    </div>
    <div class="modal fade" id="contractformModal" tabindex="-1" role="dialog" aria-labelledby="contractformModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contractformModalLabel">Add Contract Template Link</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="spinner-border text-primary d-none" id="designationFormSpinner"></div>
                </div>
                <div class="contract modal-body">
                    <form action="{{ route('contractsettings.store')}}" method="POST" id="contractForm" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class='form-group'>
                                <label class="field-required" for="contractfield">Contract Type</label><br>
                                <select name = "contract_type"class="form-control">
                                    <option value="">Select Contract Type</option>
                                    @foreach(config('contractsettings.billing_level') as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="designationfield">Add Link</label><strong class="text-danger">*</strong></label>
                            <input type="text" name="contract_template" class="form-control"  id="contract_template" aria-describedby="Help" placeholder="Link" >
                            <div class="d-none text-danger" name="error" id="contractTypeerror"></div>
                        </div>
                        <div class="d-none text-danger" name="error" id="contractTemplateerror"></div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="contract">Save changes</button>
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
            <td>
                @foreach(config('contractsettings.billing_level') as $key => $value)
                @if($key == $contract->contract_type)
                    {{ $value }}
                @endif
                @endforeach
            </td>
            <td>
                {{ $contract->contract_template}}
            </td>
            <td class="d-flex justify-content-around">
                <a type="button" class="pr-1 btn btn-link" data-toggle="modal" data-target="#contractEditformModal{{$contract->id}}">
                    <i class="text-success fa fa-edit fa-lg"></i>
                </a>
                <form action="{{ route('contractsettings.delete', $contract->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="pl-1 btn btn-link" onclick="return confirm('Are you sure you want to delete?')"><i class="text-danger fa fa-trash fa-lg"></i></button>
                </form>
            </td>
        </tr>
        @include('contractsettings::edit')
        @endforeach
    </table>
</div>
@endsection
