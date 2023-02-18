@extends('layouts.app')

@section('content')
<div class=" ml-15">
    <h1>Add New Contract</h1>   
</div>
<br>
<form action="{{ route('projectcontract.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="form-row mb-4">
                    <div class="col-md-5">
                        <input type="hidden" name="create_project" value="create_project">
                        <div class="form-group">
                            <label for="client_id" class="field-required">Client</label>
                            <select name="client_id" id="client_id" class="form-control" required="required">
                                <option value="">Select client</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="authority_name" class="field-required">Authority Name</label>
                            <input type="text" class="form-control" name="authority_name" id="authority_name"
                            placeholder="Enter Authority Name">
                            <span class="text-danger">
                                @error('authority_name')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="website_url" class="field-required">Website URL</label>
                            <input type="url" class="form-control" name="website_url" id="website_url"
                            placeholder="Enter Website url">
                            <span class="text-danger">
                                @error('website_url')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="field-required">Attributes:</label>
                            <span data-toggle="tooltip" data-placement="right" title="You can add details like Address, Summary, Authority Phone Number, Authority Email, Authority Designation." class="ml-2">
                                <i class="fa fa-question-circle"></i>&nbsp;
                            </span>
                            <textarea id="attributes" name="attributes" rows="4" cols="50" placeholder="Address, Summary, Authority Phone Number, Authority Email, Authority Designation."></textarea>
                        </div>
                    </div>
                    <div class="col-md-5 offset-md-1">
                        <div class="form-group">
                            <label for="contract_date_for_signing" class="field-required">Contract Date for signing</label>
                            <input type="date" class="form-control" name="contract_date_for_signing" id="contract_date_for_signing">
                            <span class="text-danger">
                                @error('contract_date_for_signing')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="contract_date_for_effective" class="field-required">Contract Date for Effective</label>
                            <input type="date" class="form-control" name="contract_date_for_effective" id="contract_date_for_effective">
                            <span class="text-danger">
                                @error('contract_date_for_effective')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="contract_expiry_date" class="field-required">Contract Expiry Date</label>
                            <input type="date" class="form-control" name="contract_expiry_date" id="contract_expiry_date">
                            <span class="text-danger">
                                @error('contract_expiry_date')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="logo_img" class="field-required">Logo Image</label>
                            <input type="file" name="logo_img">
                            <span class="text-danger">
                                @error('logo_img')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>
        <div class="container">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-success round-submit">Submit</button>
                    <button type="reset" value="Reset" class="btn btn-danger float-right">Clear form</button>
                </div>
            </div>
        </div>
    </div> 
</form>
@endsection
