<div class="modal fade" id="excelImport" tabindex="-1" role="dialog" aria-labelledby="excelImport" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{ route('hr.applications.excel-import') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Excel File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group ">
                        <label for="excel_file" class="field-required">Job</label>
                        <select class="form-control" name="job_id" id="job_id" required="required">
                            <option value="">Select Job</option>
                            @foreach ($hrJobs as $hrJob)
                                <option value="{{ $hrJob->id }}">{{ $hrJob->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group ">
                        <label for="excel_file" class="field-required">Upload File</label>
                        <div class="d-flex">
                            <div class="custom-file mb-3">
                                <input type="file" id="excel_file" name="excel_file" class="custom-file-input"
                                    required="required">
                                <label for="resume" class="custom-file-label">Select excel file</label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto">
                        <a href="{{ url('/sample-files/resume_excel.xlsx') }}" class="text-underline"
                            href="">Download sample file </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-12 d-flex align-items-center">
                            <div class="py-0.67">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="ApplicantVerificationEmail[confirm]" class="custom-control-input applicant-verification-email" id="confirmApplicantVerificationEmail" data-target="#previewVerificationEmail" checked>
                                    <label class="custom-control-label" for="confirmApplicantVerificationEmail">Send email</label>
                                </div>
                            </div>
                            <div class="toggle-block-display c-pointer rounded-circle bg-theme-gray-lightest hover-bg-theme-gray-lighter px-1 py-0.67 ml-1" id="previewVerificationEmail" data-target="#confirmApplicantVerificationBlock" data-toggle-icon="true">
                                <i class="fa fa-eye toggle-icon d-none" aria-hidden="true"></i>
                                <i class="fa fa-eye-slash toggle-icon" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div> 
                </div>                      
                <div class="card-body d-none" id="confirmApplicantVerificationBlock">
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <input type="text" name="subject" class="form-control" value="{{ $verifyMail['applicant_verification_subject']->setting_value ? $verifyMail['applicant_verification_subject']->setting_value : '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="body">Mail body:</label>
                                <textarea name="body" rows="10" class="richeditor form-control" placeholder="Body">{{ $verifyMail['applicant_verification_body']->setting_value ? $verifyMail['applicant_verification_body']->setting_value : ''  }}</textarea>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Start Import</button>
                </div>
            </div>
        </form>
    </div>
</div>
