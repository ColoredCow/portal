@extends('layouts.app')

@section('content')

<form>
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
                        <input type="text" class="form-control w-300" name="name" required="required">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="preffered_name" class="fz-14 leading-none text-secondary mb-1">Preferred Name</label>
                        <p class="fz-14 leading-none text-secondary mb-1">Other name that you prefer. If not applicable, write NA.</p>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="contact_number" class="field-required fz-14 leading-none text-secondary mb-1">Personal Contact Number</label>
                        <p class="fz-14 leading-none text-secondary mb-1">Format- DD/MM/YYYY</p>
                        <input type="number" class="form-control w-300" name="contact_number" required="required">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="father_name" class="field-required fz-14 leading-none text-secondary mb-1">Father's Name</label>
                        <input type="text" class="form-control w-300 mt-3" name="father_name" required="required">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="mother_name" class="field-required fz-14 leading-none text-secondary mb-1">Mother's Name</label>
                        <input type="text" class="form-control w-300 mt-3" name="mother_name" required="required">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="current_address" class="field-required  fz-14 leading-none text-secondary mb-1">Current Address</label>
                        <input type="text" class="form-control w-300 mt-3" name="Current_address" required="required">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="permanent_address" class="field-required  fz-14 leading-none text-secondary mb-1">Permanent Address</label>
                        <p class=" fz-14 leading-none text-secondary mb-1">As per Address Proof</p>
                        <input type="number" class="form-control w-300" name="permanent_address" required="required">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="emergency_contact_address" class="field-required  fz-14 leading-none text-secondary mb-1">Emergency Contact Number</label>
                        <p class=" fz-14 leading-none text-secondary mb-1">Other than personal contact number</p>
                        <input type="text" class="form-control w-300" name="emergency_contact_address" required="required">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="blood_group" class="field-required fz-14 leading-none text-secondary mb-1">Blood Group</label>
                        <input type="number" class="form-control w-300 mt-3" name="blood_group" required="required">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="illness" class="field-required fz-14 leading-none text-secondary mb-1">Any illness related from past, that you would like to share?</label>
                        <input type="number" class="form-control w-300" name="illness" required="required">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="head_shot_image" class="field-required fz-14 leading-none text-secondary mb-1">Upload a head shot image</label>
                        <div class="d-flex">
                            <div class="custom-file mb-3">
                                <input type="file" name="head_shot_image" class="custom-file-input"
                                    required="required">
                                <label for="customFile0" class="custom-file-label overflow-hidden w-300">Add File</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="aadhar_card_number" class="field-required fz-14 leading-none text-secondary mb-1">Aadhar Card Number</label>
                        <input type="number" class="form-control w-300 mt-3" name="aadhar_card_number" required="required">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="aadhar_card_scanned" class="field-required fz-14 leading-none text-secondary mb-1">Upload a scanned copy of Aadhaar Card</label>
                        <p class="fz-14 leading-none text-secondary mb-1">(Both Front and Back)</p>
                        <div class="d-flex">
                            <div class="custom-file mb-3">
                                <input type="file" name="aadhar_card_scanned" class="custom-file-input"
                                    required="required">
                                <label for="customFile0" class="custom-file-label overflow-hidden w-300">Add File</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="pan_card_number" class="field-required fz-14 leading-none text-secondary mb-1">Pan Card Number</label>
                        <input type="number" class="form-control w-300 mt-3" name="mother_name" required="required">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="scanned_copy_pan_card" class="field-required fz-14 leading-none text-secondary mb-1">Upload a scanned copy of Pan Card
                        </label>
                        <div class="d-flex">
                            <div class="custom-file mb-3">
                                <input type="file" id="invoice_file" name="scanned_copy_pan_card" class="custom-file-input"
                                    required="required">
                                <label for="customFile0" class="custom-file-label overflow-hidden w-300">Add File</label>
                            </div>
                        </div>
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
                        <input type="number" class="form-control w-300" name="acc_holder_name" required="required">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="bank_name" class="field-required fz-14 leading-none text-secondary mb-1">Bank Name</label>
                        <input type="number" class="form-control w-300" name="bank_name" required="required">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="acc_number" class="field-required fz-14 leading-none text-secondary mb-1">Account Number</label>
                        <input type="number" class="form-control w-300" name="acc_number" required="required">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="ifsc_code" class="field-required fz-14 leading-none text-secondary mb-1 mt-2">IFSC Code</label>
                        <input type="number" class="form-control w-300 mt-6" name="mother_name" required="required">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="passbook_first_page_IMG" class="field-required fz-14 leading-none text-secondary mb-1 mt-2">Image of cancelled cheque/ Passbook First page with bank details</label>
                        <p></p>
                        <div class="d-flex">
                            <div class="custom-file mb-3">
                                <input type="file" name="passbook_first_page_IMG" class="custom-file-input" required="required">
                                <label for="customFile0" class="custom-file-label overflow-hidden w-300 mt-1">Add File</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="uan_number" class="field-required fz-14 leading-none text-secondary mb-1 mt-2">PF account/ UAN Number</label>
                        <p class="fz-14 leading-none text-secondary mb-1">Please write NA if there is no pf account yet.</p>
                        <input type="number" class="form-control w-300" name="uan_number" required="required">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="form-row">
            <div class="form-group col-md-12">
                <button type="button" class="btn btn-success round-submit">Submit</button>
                <button type="reset" value="Reset" class="btn btn-danger float-right">Clear form</button>
            </div>
        </div>
    </div>
</form>

@endsection
