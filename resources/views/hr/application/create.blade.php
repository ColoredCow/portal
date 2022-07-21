@extends('layouts.app')
@include('hr.application.excel-import')

@section('content')
<div class="container" id="page_hr_applicant_create">
    <div class="row">
        <div class="col-md-12">
            <br>
            @include('hr.menu')
            <br><br>
        </div>
    </div>
    <div class="d-flex justify-content-between">
    <h1>Add new application</h1>
    <button data-toggle="modal" data-target="#excelImport" class="btn btn-primary text-white">Import excel file</button>
</div>
    <div>
        @include('status', ['errors' => $errors->all()])
        <div class="card">
            <form action="{{ route('hr.applicant.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-row mb-4">
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="d-flex justify-content-between">
                                    <label for="job_title" class="field-required">Job</label>
                                </div>
                                <select name="job_title" id="job_title" class="form-control" required="required" value={{ old('job_title') }}>
                                    <option value="">Select Job</option>
                                    @foreach($hrJobs as $hrJob)
                                    <option value="{{ $hrJob->title }}" {{ old('job_title') == $hrJob->title ? 'selected' : '' }}>{{ $hrJob->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="name" class="field-required">First Name</label>
                                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name"
                                    required="required" value="{{ old('first_name') }}">
                            </div>

                            <div class="form-group">
                                <label for="name" class="field-required">Last Name</label>
                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name"
                                    required="required" value="{{ old('last_name') }}">
                            </div>

                            <div class="form-group">
                                <label for="name" class="field-required">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required="required"
                                    value="{{ old('email') }}">
                            </div>

                            <div class="form-group">
                                <label for="name">Phone</label>
                                <input type="tel" class="form-control" name="phone" id="phone" placeholder="Phone" value="{{ old('Phone') }}">
                            </div>

                            <div class="form-group ">
                                <label for="resume_file" class="field-required">Resume</label>
                                <div class="d-flex">
                                    <div class="custom-file mb-3">
                                        <input type="file" id="resume_file" name="resume_file" class="custom-file-input" required="required" accept="application/pdf">
                                        <label for="resume" class="custom-file-label">Choose file</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name">Whatsapp Optin At</label>
                                <input type="datetime-local" id="wa_optin_at" class="form-control" name="wa_optin_at" placeholder="Whatsapp Optin At" value={{old('wa_optin_at')}}>
                            </div>
                        </div>
                    
                        <div class="col-md-5 offset-md-1">
                            <div class="form-group">
                                <label for="name">College</label>
                                <input type="text" class="form-control" name="college" id="college" placeholder="College"
                                    value="{{ old('college') }}">
                            </div>
                            
                            <div class="form-group">
                                <label for="name">Graduation Year</label>
                                <input type="number" class="form-control" name="graduation_year" id="graduation_year" placeholder="Graduation Year"
                                    value="{{ old('graduation_year') }}">
                            </div>
                            
                            <div class="form-group">
                                <label for="name">Course</label>
                                <input type="text" class="form-control" name="course" id="course" placeholder="Course" value="{{ old('course') }}">
                            </div>

                        
                            <div class="form-group">
                                <label for="name">Linkedin</label>
                                <input type="text" class="form-control" name="linkedin" id="linkedin" placeholder="Linkedin"
                                    value="{{ old('linkedin') }}">
                            </div>

                            <div class="form-group">
                                <label for="name">Reason For Eligibility</label>
                                <textarea type="text" class="form-control" rows="5" name="form_data[Why Should We Pick You?]"
                                    placeholder="Reason For Eligibility">{{ old('form_data[Why Should We Pick You?]') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="name">Reference</label>
                                <input type="text" class="form-control" name="reference" id="reference" placeholder="reference"
                                    value="{{ old('reference') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary text-white">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection