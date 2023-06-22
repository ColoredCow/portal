@extends('layouts.app')

@section('content')
<div class=" ml-15">
    <h1>Review Contract - {{$reviewer['name']}} - {{$reviewer['email']}}</h1>   
</div>
<br>
<form action="{{ route('projectcontract.clientupdate')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="form-row mb-4">
                    <div class="col-md-5">
                        <input type="hidden" id="id" name="id" value={{$contracts['id']}}>
                        <input type="hidden" id="rid" name="rid" value={{$reviewer['id']}}>
                        <div class="form-group">
                            <label for="client_name" class="field-required">Client Name</label>
                            <input type="text" class="form-control" name="client_name" id="client_name"
                            placeholder="Enter Client Name" value="{{$contracts['contract_name']}}">
                            <span class="text-danger">
                                @error('client_name')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="form-row mb-4">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="contract_name" class="field-required">Contract Name</label>
                            <input type="text" class="form-control" name="contract_name" id="contract_name"
                            placeholder="Enter Contract Name" value="{{$contractsmeta[0]['value']}}">
                            <span class="text-danger">
                                @error('contract_name')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="contract_date_for_effective" class="field-required">Contract Date for Effective</label>
                            <input type="date" class="form-control" name="contract_date_for_effective" id="contract_date_for_effective" value={{$contractsmeta[1]['value']}}>
                            <span class="text-danger">
                                @error('contract_date_for_effective')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="col-md-5 offset-md-1">
                        <div class="form-group">
                            <label for="contract_date_for_signing" class="field-required">Contract Date for signing</label>
                            <input type="date" class="form-control" name="contract_date_for_signing" id="contract_date_for_signing" value={{$contractsmeta[2]['value']}}>
                            <span class="text-danger">
                                @error('contract_date_for_signing')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="contract_expiry_date" class="field-required">Contract Expiry Date</label>
                            <input type="date" class="form-control" name="contract_expiry_date" id="contract_expiry_date" value={{$contractsmeta[3]['value']}}>
                            <span class="text-danger">
                                @error('contract_expiry_date')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>
    </div>
    <br>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="form-row mb-4">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="authority_name" class="field-required">Authority Name</label>
                            <input type="text" class="form-control" name="authority_name" id="authority_name"
                            placeholder="Enter Authority Name" value="{{$contractsmeta[4]['value']}}">
                            <span class="text-danger">
                                @error('authority_name')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="designation" class="field-required">Authority Designation</label>
                            <input type="text" class="form-control" name="designation" id="designation" placeholder="Enter Authority Designation" value="{{$contractsmeta[6]['value']}}">
                            <span class="text-danger">
                                @error('designation')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="col-md-5 offset-md-1">
                        <div class="form-group">
                            <label for="phonenumber" class="field-required">Phone number</label>
                            <input type="text" class="form-control" name="phonenumber" id="phonenumber" placeholder="Enter Authority phone number" value="{{$contractsmeta[5]['value']}}">
                            <span class="text-danger">
                                @error('phonenumber')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="contract_expemailiry_date" class="field-required">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Enter Authority Email" value="{{$contractsmeta[7]['value']}}">
                            <span class="text-danger">
                                @error('email')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="form-row mb-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="summary" class="field-required">Project Summary</label>
                            <textarea type="text" class="form-control" name="summary" id="summary" 
                            placeholder="Add a summary of the project. 2-5 lines to set the context of what the project is about and aims to do." 
                            rows="5" required>{{$contractsmeta[8]['value']}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="form-row mb-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cost" class="field-required">Project Cost</label>
                            <textarea type="text" class="form-control" name="cost" id="cost" 
                            placeholder="Add details about the estimated project cost. The estimated variation can be given. Also, add details of any risk/factors that need to be highlighted which might cause significant disruption to the estimated project costs." 
                            rows="5" required>{{$contractsmeta[9]['value']}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="form-row mb-4">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="currency" class="field-required">Payment Currency</label>
                            <select name="currency" id="currency" class="form-control">
                                @foreach ($countries ?? [] as $country)
                                    <option value="{{ $country->currency }}">{{ $country->currency }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                        <label for="source" class="field-required">Source of Payment</label>
                            <select name="source" id="source" class="form-control">
                                <option value="indian">Indian</option>
                                <option value="international">International</option>
                            </select>
                            <span class="badge badge-info mr-1 mb-1 fz-12">Bank charges will be applied to international payments.</span>
                        </div>
                    </div>
                    <div class="col-md-5 offset-md-1">
                        <div class="form-group">
                            <label for="methodology" class="field-required">Payment methodology</label>
                            <select name="methodology" id="methodology" class="form-control">
                                <option value="cheque">Cheque</option>
                                <option value="bank-transfer">Bank Transfer</option>
                                <option value="others">Others</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="gst" class="field">GST Number</label>
                            <input type="text" class="form-control" name="gst" id="gst"
                            placeholder="Enter GST Number" value="{{$contractsmeta[13]['value']}}">
                            <span class="badge badge-info mr-1 mb-1 fz-12">Indian organizations required GST number.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="form-row mb-4">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="client_name" class="field-required">Comments</label>
                                <textarea type="text" class="form-control" name="comment" id="comment"
                                placeholder="Enter Comment" rows="5" cols="50" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </div>
        <div class="container">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <a href="{{route('projectcontract.clientresponse', $contractsmeta[0]['contract_id'])}}" class="pl-1 btn btn-success" ><i class="text-primary fa fa-check fa-lg"></i>Finalise</a>
                    <button type="submit" class="btn btn-primary round-submit">Update</button>
                </div>
            </div>
        </div>
</form>
@if ($comments)
<div class="container">
        <h3>Comments</h3>
        @foreach ($comments as $comment)
        <div class="card">
            <div class="card-body text-center">
                <div class="d-flex flex-row-reverse">
                    <a href="{{ route('projectcontract.commenthistory',$comment['id'])}}" target="_blank"><i class="fa fa-history"></i> View History</a>
                </div>
                <div class="d-flex flex-row mb-3">
                    <div>By: </div>
                    <div>
                        @if (str_contains($comment['comment_type'],'Reviewer'))
                            <h4>Client Team</h4>
                        @else
                            <h4>Internal Team</h4>
                        @endif
                    </div>
                </div>
                <div class="d-flex flex-row mb-3">
                    <div><h4>Date: </h4></div>
                    <div><h4>{{$comment['created_at']}}</h4></div>
                </div>
                <div class="d-flex flex-row mb-3">
                    <div><h4>Comment: </h4></div>
                    <div><h4>{{$comment['comment']}}</h4></div>
                </div>
            </div>
        </div>
        <br>
        @endforeach
    </div>
@endif
@endsection