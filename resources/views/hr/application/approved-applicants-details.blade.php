@extends('layouts.app')

@section('content')

@if( session('status'))
@endif
<form action="{{route('hr.applicant.store-approved-applicants-details')}}" enctype="multipart/form-data" method="POST">
    @csrf
    <div class="container col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="row ml-6">
                    <h2><b>Starting a new journey with ColoredCow!</b><h2>
                </div><br>
                <div class="text-center pre-warp">
                    <h6>
                        Congratulations on being one of us, a ColoredCow. We are on a mission to createa place <br>
                        for creatives, nerds, rockstars, underdogs, extroverts, introverts, outliers and ( whoever <br>
                        you believe you are), to do your best work. To fulfill your ambition, with a community <br>
                        that supports it and would like to be supported by it.To do it happily, impactfully and <br>
                        remarkably. Thank you for supporting us in this journey of ours.<br>
                    </h6>
                </div>
            </div>
        </div>
    </div><br>
    <div class="container pb-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Personal Details</h5>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-5 form-group">
                        <label for="name" class="field-required fz-14 leading-none text-secondary mb-1">Full Name</label>
                        <p class="fz-14 leading-none text-secondary mb-1">As Per Pan Card</p>
                        <input type="text" class="form-control w-300" name="name" value="" required="required" >
                        <span class="text-danger">
                            @error('name')
                                {{$message}}
                                @enderror
                        </span>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="preferred_name" class="fz-14 leading-none text-secondary mb-1">Preferred Name</label>
                        <p class="fz-14 leading-none text-secondary mb-1">Other name that you prefer. If not applicable, write NA.</p>
                        <input type="text" class="form-control" name="preferred_name" value={{$applicant['Preferred Name']['value'] ?? ""}}>
                        <span class="text-danger">
                            @error('preferred_name')
                                {{$message}}
                                @enderror
                        </span>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="date_of_birth" class="field-required fz-14 leading-none text-secondary mb-1">Date Of Birth</label>
                        <p class="fz-14 leading-none text-secondary mb-1">Format- MM/DD/YYYY</p>
                        <input type="date" class="form-control w-300" name="date_of_birth" required="required" value={{$applicant['Date Of Birth']['value'] ?? ""}}>
                        <span class="text-danger">
                            @error('date_of_birth')
                                {{$message}}
                                @enderror
                        </span>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="contact_number" class="field-required fz-14 leading-none text-secondary mb-1">Personal Contact Number</label>
                        <input type="number" class="form-control w-300 mt-3" name="contact_number" required="required">
                        <span class="text-danger">
                            @error('contact_number')
                                {{$message}}
                                @enderror
                        </span>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="father_name" class="field-required fz-14 leading-none text-secondary mb-1">Father's Name</label>
                        <input type="text" class="form-control w-300 mt-3" name="father_name" required="required" value={{$applicant['Father Name']['value'] ?? ""}}>
                        <span class="text-danger">
                            @error('father_name')
                                {{$message}}
                                @enderror
                        </span>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="mother_name" class="field-required fz-14 leading-none text-secondary mb-1">Mother's Name</label>
                        <input type="text" class="form-control w-300 mt-3" name="mother_name" required="required" value={{$applicant['Mother Name']['value'] ?? ""}}>
                        <span class="text-danger">
                            @error('mother_name')
                                {{$message}}
                                @enderror
                        </span>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="current_address" class="field-required  fz-14 leading-none text-secondary mb-1">Current Address</label>
                        <input type="text" class="form-control w-300 mt-3" name="current_address" required="required" value={{$applicant['Current Address']['value'] ?? ""}}>
                        <span class="text-danger">
                            @error('current_address')
                                {{$message}}
                                @enderror
                        </span>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="permanent_address" class="field-required  fz-14 leading-none text-secondary mb-1">Permanent Address</label>
                        <p class=" fz-14 leading-none text-secondary mb-1">As per Address Proof</p>
                        <input type="text" class="form-control w-300" name="permanent_address" required="required" value={{$applicant['Permanent Address']['value'] ?? ""}}>
                        <span class="text-danger">
                            @error('permanent_address')
                                {{$message}}
                                @enderror
                        </span>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="emergency_contact_number" class="field-required  fz-14 leading-none text-secondary mb-1">Emergency Contact Number</label>
                        <p class=" fz-14 leading-none text-secondary mb-1">Other than personal contact number</p>
                        <input type="number" class="form-control w-300" name="emergency_contact_number" required="required" value={{$applicant['Emergency Contact Number']['value'] ?? ""}}>
                        <span class="text-danger">
                            @error('emergency_contact_number')
                                {{$message}}
                                @enderror
                        </span>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="blood_group" class="field-required fz-14 leading-none text-secondary mb-1">Blood Group</label>
                        <input type="text" class="form-control w-300 mt-3" name="blood_group" required="required" value={{$applicant['Blood Group']['value'] ?? ""}}>
                        <span class="text-danger">
                            @error('blood_group')
                                {{$message}}
                                @enderror
                        </span>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="illness" class="field-required fz-14 leading-none text-secondary mb-1">Any illness related from past, that you would like to share?</label>
                        <input type="text" class="form-control w-300 mt-1" name="illness" required="required" value={{$applicant['Illness']['value'] ?? ""}}>
                        <span class="text-danger">
                            @error('illness')
                                {{$message}}
                                @enderror
                        </span>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="head_shot_image" class="field-required fz-14 leading-none text-secondary mb-1">Upload a head shot image</label>
                        <div class="d-flex">
                            <div class="custom-file mb-3">
                                <input type="file" name="head_shot_image" class="custom-file-input" required="required" value={{$applicant['Head shot image']['value'] ?? ""}}>
                                <label for="customFile" class="custom-file-label overflow-hidden w-300">Add File</label>
                            </div>
                        </div>
                        <span class="text-danger">
                            @error('head_shot_image')
                                {{$message}}
                                @enderror
                        </span>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="aadhar_card_number" class="field-required fz-14 leading-none text-secondary mb-1">Aadhar Card Number</label>
                        <input type="number" class="form-control w-300 mt-3" name="aadhar_card_number" required="required">
                        <span class="text-danger">
                            @error('aadhar_card_number')
                                {{$message}}
                                @enderror
                        </span>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="aadhar_card_scanned" class="field-required fz-14 leading-none text-secondary mb-1">Upload a scanned copy of Aadhaar Card</label>
                        <p class="fz-14 leading-none text-secondary mb-1">(Both Front and Back)</p>
                        <div class="d-flex">
                            <div class="custom-file mb-3">
                                <input type="file" name="aadhar_card_scanned" class="custom-file-input" required="required">
                                <label for="customFile" class="custom-file-label overflow-hidden w-300">Add File</label>
                            </div>
                        </div>
                        <span class="text-danger">
                            @error('aadhar_card_scanned')
                                {{$message}}
                                @enderror
                        </span>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="pan_card_number" class="field-required fz-14 leading-none text-secondary mb-1">Pan Card Number</label>
                        <input type="number" class="form-control w-300 mt-3" name="pan_card_number" required="required">
                        <span class="text-danger">
                            @error('pan_card_number')
                                {{$message}}
                                @enderror
                        </span>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="scanned_copy_pan_card" class="field-required fz-14 leading-none text-secondary mb-1">Upload a scanned copy of Pan Card
                        </label>
                        <div class="d-flex">
                            <div class="custom-file mb-3">
                                <input type="file" name="scanned_copy_pan_card" class="custom-file-input" required="required">
                                <label for="customFile" class="custom-file-label overflow-hidden w-300 mt-2">Add File</label>
                            </div>
                        </div>
                        <span class="text-danger">
                            @error('scanned_copy_pan_card')
                                {{$message}}
                                @enderror
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container pb-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Bank Details</h5>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-4 form-group">
                        <label for="acc_holder_name" class="field-required fz-14 leading-none text-secondary mb-1">Account Holder Name</label>
                        <input type="text" class="form-control w-300" name="acc_holder_name" required="required" value={{$applicant['Account Holder Name']['value'] ?? ""}}>
                        <span class="text-danger">
                            @error('scanned_copy_pan_card')
                                {{$message}}
                                @enderror
                        </span>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="bank_name" class="field-required fz-14 leading-none text-secondary mb-1">Bank Name</label>
                        <input type="text" class="form-control w-300" name="bank_name" required="required" value={{$applicant['Bank Name']['value'] ?? ""}}>
                        <span class="text-danger">
                            @error('bank_name')
                                {{$message}}
                                @enderror
                        </span>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="acc_number" class="field-required fz-14 leading-none text-secondary mb-1">Account Number</label>
                        <input type="number" class="form-control w-300" name="acc_number" required="required">
                        <span class="text-danger">
                            @error('acc_number')
                                {{$message}}
                                @enderror
                        </span>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="ifsc_code" class="field-required fz-14 leading-none text-secondary mb-1 mt-2">IFSC Code</label>
                        <input type="text" class="form-control w-300 mt-6" name="ifsc_code" required="required">
                        <span class="text-danger">
                            @error('ifsc_code')
                                {{$message}}
                                @enderror
                        </span>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="passbook_first_page_img" class="field-required fz-14 leading-none text-secondary mb-1 mt-2">Image of cancelled cheque/ Passbook First page with bank details</label>
                        <p></p>
                        <div class="d-flex">
                            <div class="custom-file mb-3">
                                <input type="file" name="passbook_first_page_img" class="custom-file-input" required="required">
                                <label for="customFile" class="custom-file-label overflow-hidden w-300 mt-1">Add File</label>
                            </div>
                        </div>
                        <span class="text-danger">
                            @error('passbook_first_page_img')
                                {{$message}}
                                @enderror
                        </span>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="uan_number" class="field-required fz-14 leading-none text-secondary mb-1 mt-2">PF account/ UAN Number</label>
                        <p class="fz-14 leading-none text-secondary mb-1">Please write NA if there is no pf account yet.</p>
                        <input type="number" class="form-control w-300" name="uan_number" required="required" value={{$applicant['PF account/ UAN Number']['value'] ?? ""}}>
                        <span class="text-danger">
                                @error('uan_number')
                                    {{$message}}
                                @enderror
                        </span>
                    </div>
                    <input type="hidden" name="hr_applicant_id" value={{$hr_applicant_id}}>
                    <input type="hidden" name="hr_applicant_email" value={{$hr_applicant_email}}>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="form-row">
            <div class="form-group col-md-12">
                <button type="submit"  href="{{route('hr.applicant.form-submitted',[$hr_applicant_id , $hr_applicant_email])}}" class="btn btn-success round-submit" id="formSubmit">Submit</button>
                <button type="reset" value="Reset" class="btn btn-danger float-right">Clear form</button>
            </div>
        </div>
    </div>
</form>

@endsection
