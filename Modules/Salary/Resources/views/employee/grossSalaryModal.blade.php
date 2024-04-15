<div class="modal fade" id="saveAsIncrementModal" tabindex="-1" role="dialog" aria-labelledby="saveAsIncrementModalLabel" aria-hidden="true">
    <form action="{{ route('salary.employee.store', $employee) }}" method="POST" id ="salaryForm"  enctype="multipart/form-data"> 
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="saveAsIncrementModalLabel">Salary Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="d-md-flex mt-4">
                    <div class="form-group pl-6 col-md-5">
                        <label class="leading-none fz-24 d-flex align-items-center" for="grossSalary">
                            <span class="mr-1 mb-1">{{ __('Monthly Gross Salary') }}</span>
                            <span><i class="fa fa-rupee"></i></span>
                        </label>
                        <input type="number" step="0.01" name="grossSalary" id="grossSalary" class="form-control bg-light" placeholder="Enter Monthly Gross Salary" min="0" required>
                        <small class="d-none text-danger" id="grossSalaryErrorMessage"><strong >Gross Salary Required</strong></small>
                    </div>
                    <div class="form-group col-md-5">
                        <label class="leading-none fz-24 ml-4 d-flex align-items-center" for="grossSalary">
                            <span class="mr-1 mb-1">{{ __('Commencement Date') }}</span>
                        </label>
                        <input type="date" name="commencementDate" id="commencementDate" class="form-control ml-4 bg-light" required>
                        <small class="d-none ml-4 text-danger" id="commencementDateErrorMessage"><strong>Date Required</strong></small>
                    </div>
                </div>
                <div class="d-md-flex">
                    <div class="form-group pl-6 col-md-5">
                        <label class="leading-none fz-24 d-flex align-items-center" for="cc_emails">
                            <span class="mr-1 mb-1">{{ __('CC emails') }}</span>
                        </label>
                        <input type="email" step="0.01" name="ccemails" id="ccemails" class="form-control bg-light" placeholder="Comma separated emails">
                    </div>
                    <!-- <div class="form-group col-md-5">
                        <label class="leading-none fz-24 ml-4 d-flex align-items-center" for="signature">
                            <span class="mr-1 mb-1">{{ __('Upload Stamp') }} <small>(png/jpg only)</small></span>
                        </label>
                        <input type="file" accept="image/*" name="signature" id="signature" class="form-control ml-4 bg-light" required>
                        <small class="d-none ml-4 text-danger" id="signatureErrorMessage"><strong>File Required</strong></small>
                    </div> -->
                </div>

                <div class="modal-footer">
                    <input hidden name="submitType" value="send_appraisal_letter"/>
                    <button id="generatePdfButton" class="btn btn-primary text-white" data-url ="{{route('salary.employee.generate-appraisal-letter', $employee)}} "onclick="generatePdf()">View Appraisal Letter</button>
                    <input type="submit" id="saveButton" class="btn btn-primary ml-2 px-4" value="Send Appraisal Letter" data-url ="{{ route('salary.employee.store', $employee) }}" onclick="resetPath()"/>
                </div>
            </div>
        </div>
    </form>
</div>

@section('js_scripts')
    @parent
    <script>
        function generatePdf() {
            event.preventDefault();
            if (validateForm()) {
                var button = document.getElementById("generatePdfButton");
                if(button){
                    var url = button.getAttribute("data-url");
                    var form = document.getElementById("salaryForm");
                    form.setAttribute("action", url);
                    form.setAttribute('target', '_blank');
                    form.submit();
                    var newWindow = window.open(url);
                }
            }
        }

        function resetPath() {
            event.preventDefault();
            if (validateForm()) {
                var button = document.getElementById("saveButton");
                if(button){
                    var url = button.getAttribute("data-url");
                    var form = document.getElementById("salaryForm");
                    form.removeAttribute('target', '_blank');
                    form.setAttribute("action", url);
                    form.submit();
                }
            }
        }

        function validateForm() {
            let grossSalary = $('#grossSalary');
            let commencementDate = $('#commencementDate');
            let signature = $('#signature');
            let grossSalaryErrorMessage = $('#grossSalaryErrorMessage');
            let commencementDateErrorMessage = $('#commencementDateErrorMessage');
            let signatureErrorMessage = $('#signatureErrorMessage');
            let isValid = true;

            grossSalaryErrorMessage.addClass('d-none')
            commencementDateErrorMessage.addClass('d-none')
            signatureErrorMessage.addClass('d-none')

            if (grossSalary.val().trim() === '') {
                grossSalaryErrorMessage.removeClass('d-none')
                isValid = false;
            }

            // Validate commencement date
            if (commencementDate.val().trim() === '') {
                commencementDateErrorMessage.removeClass('d-none')
                isValid = false;
            }

            // // Validate signature
            // if (signature.val().trim() === '') {
            //     signatureErrorMessage.removeClass('d-none')
            //     isValid = false;
            // }

            return isValid
        }
    </script>
@endsection
