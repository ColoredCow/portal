@extends('layouts.app')

@section('content')
<div class="container pb-6">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Details</h5>
        </div>
        <div class="card-body">
            <div class="form-row">
                 <div class="col-md-4 form-group">
                    <p>Name:  {{$applicant[0]['name']}}</p>
                </div>
                <div class="col-md-4 form-group">
                    <p>Preffered Name:  {{$applicantMeta['Preferred Name']['value']}}</p>
                </div>
                <div class="col-md-4 form-group">
                    <p>Date Of Birth:  {{$applicantMeta['Date Of Birth']['value']}}</p>
                </div>
                <div class="col-md-4 form-group">
                    <p>Personal Contact:  {{$applicant[0]['phone']}}</p>
                </div>
                <div class="col-md-4 form-group">
                    <p>Father Name :  {{$applicantMeta['Father Name']['value']}}</p>
                </div>
                <div class="col-md-4 form-group">
                    <p>Mother Name :  {{$applicantMeta['Mother Name']['value']}}</p>
                </div>
                <div class="col-md-4 form-group">
                    <p>Current Address :  {{$applicantMeta['Current Address']['value']}}</p>
                </div>
                <div class="col-md-4 form-group">
                    <p>Permanent Address :  {{$applicantMeta['Permanent Address']['value']}}</p>
                </div>
                <div class="col-md-4 form-group">
                    <p>Emergency Contact Number :  {{$applicantMeta['Emergency Contact Number']['value']}}</p>
                </div>
                <div class="col-md-4 form-group">
                    <p>Blood Group :  {{$applicantMeta['Blood Group']['value']}}</p>
                </div>
                <div class="col-md-4 form-group">
                    <p>Illness :  {{$applicantMeta['Illness']['value']}}</p>
                </div>
                <div class="col-md-4 form-group">
                    <p>Account Holder Name :  {{$applicantMeta['Account Holder Name']['value']}}</p>
                </div>
                <div class="col-md-4 form-group">
                    <p>Bank Name :  {{$applicantMeta['Bank Name']['value']}}</p>
                </div>
                <div class="col-md-4 form-group">
                    <p>PF account/ UAN Number :  {{$applicantMeta['PF account/ UAN Number']['value']}}</p>
                </div>
                <div class="col-md-4 form-group">
                    <p>Aadhar Card Number :  {{decrypt($applicantMeta['Aadhar Card Number']['value'])}}</p>
                </div>
                <div class="col-md-4 form-group">
                    <p>Pan Card Number :  {{decrypt($applicantMeta['Pan Card Number']['value'])}}</p>
                </div>
                <div class="col-md-4 form-group">
                    <p>Account Number :  {{decrypt($applicantMeta['Account Number']['value'])}}</p>
                </div>
                <div class="col-md-4 form-group">
                    <p>IFSC Code :  {{decrypt($applicantMeta['IFSC Code']['value'])}}</p>
                </div>
                <div class="col-md-4 form-group">
                    <p>Head Shot Image :<a target="_blank" href="{{ asset('storage/Employee-Documents-Details/'.$applicantMeta['Head shot image']['value']) }}">Preview</a></a>
                </div>
                <div class="col-md-4 form-group">
                    <p>Scanned copy of Aadhaar Card :<a target="_blank" href="{{ asset('storage/Employee-Documents-Details/'.$applicantMeta['Scanned copy of Aadhaar Card']['value']) }}">Preview</a></p>
                </div>
                <div class="col-md-4 form-group">
                    <p>scanned copy of Pan Card :  <a target="_blank" href="{{ asset('storage/Employee-Documents-Details/'.$applicantMeta['scanned copy of Pan Card']['value']) }}">Preview</a></p>
                </div>
                <div class="col-md-4 form-group">
                    <p>Passbook First page IMG :  <a target="_blank" href="{{ asset('storage/Employee-Documents-Details/'.$applicantMeta['Passbook First page IMG']['value']) }}">Preview</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection