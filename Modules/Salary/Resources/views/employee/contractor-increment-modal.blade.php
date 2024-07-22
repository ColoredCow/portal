<div class="modal fade" id="incrementModal" tabindex="-1" role="dialog" aria-labelledby="incrementModalLabel" aria-hidden="true">
    <form action="{{ route('salary.contractor.store', $employee) }}" id="contractorIncrementForm" method="POST" enctype="multipart/form-data"> 
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="incrementModalLabel">Increment Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="form-group pl-6 mb-0 col-md-6 mt-4">
                    <label class="leading-none fz-24 d-flex align-items-center" for="newMonthlyFee">
                        <span class="mr-1">{{ __('New Monthly Fee') }}</span>
                        <span><i class="fa fa-rupee"></i></span>
                    </label>
                    <input type="number" step="0.01" name="contractorFee" id="newMonthlyFee" class="form-control bg-light" onkeyup="onUpdateNewMonthlyFee(this.value)" placeholder="Enter Monthly Fee" min="0" required>
                    <small class="d-none text-danger" id="monthlyFeeErrorMessage"><strong >Monthly Fee Required</strong></small>
                </div>
                <div class="d-md-flex mt-3">
                    <div class="form-group pl-6 col-md-5">
                        <label class="leading-none fz-24 d-flex align-items-center" for="contractorTdsErrorMessage">
                            <span class="mr-1 mb-1">{{ __('TDS') }}</span>
                        </label>
                        <input type="number" step="0.01" name="tds" id="contractorNewTds" value="0" class="form-control bg-light" required placeholder="Enter TDS">
                        <small class="d-none text-danger" id="contractorTdsErrorMessage"><strong >TDS Required</strong></small>
                    </div>
                    <div class="form-group col-md-5">
                        <label class="leading-none fz-24 ml-4 d-flex align-items-center" for="incrementCommencementDate">
                            <span class="mr-1 mb-1">{{ __('Commencement Date') }}</span>
                        </label>
                        <input type="date" name="commencementDate" id="incrementCommencementDate" class="form-control ml-4 bg-light" required>
                        <small class="d-none ml-4 text-danger" id="incrementCommencementDateErrorMessage"><strong>Date Required</strong></small>
                    </div>
                </div>
                <div class="d-md-flex mt-2">
                    <div class="form-group pl-6 col-md-10">
                        <label class="leading-none fz-24 d-flex align-items-center" for="incrementCcemails">
                            <span class="mr-1 mb-1">{{ __('CC emails') }}</span>
                        </label>
                        <input type="email" name="ccemails" id="incrementCcemails" class="form-control bg-light" placeholder="Comma separated emails">
                    </div>
                </div>

                <div class="modal-footer">
                    <input hidden name="submitType" value="send_contractor_increment_letter"/>
                    <button id="generateIncrementPdfButton" class="btn btn-primary text-white" data-url ="{{route('salary.employee.generate-appraisal-letter', $employee)}} "onclick="generateContractorIncrementPdf()">View Increment Letter</button>
                    <input type="submit" id="contractorIncrementModalSaveButton" class="btn btn-primary ml-2 px-4" value="Send Increment Letter" data-url ="{{ route('salary.contractor.store', $employee) }}" onclick="submitIncrementForm()"/>
                </div>
            </div>
        </div>
    </form>
</div>

@section('scripts')
    <script>
        function generateContractorIncrementPdf() {
            event.preventDefault();
            if (validateContractorIncrementForm()) {
                var button = document.getElementById("generateIncrementPdfButton");
                if(button){
                    var url = button.getAttribute("data-url");
                    var form = document.getElementById("contractorIncrementForm");
                    form.setAttribute("action", url);
                    form.setAttribute('target', '_blank');
                    form.submit();
                    var newWindow = window.open(url);
                }
            }
        }

        function submitIncrementForm() {
            event.preventDefault();
            if (validateContractorIncrementForm()) {
                var button = document.getElementById("contractorIncrementModalSaveButton");
                if(button){
                    var url = button.getAttribute("data-url");
                    var form = document.getElementById("contractorIncrementForm");
                    form.removeAttribute('target', '_blank');
                    form.setAttribute("action", url);
                    form.submit();
                }
            }
        }

        function validateContractorIncrementForm() {
            let newMonthlyFee = $('#newMonthlyFee');
            let incrementCommencementDate = $('#incrementCommencementDate');
            let contractorTds = $('#contractorNewTds');
            let monthlyFeeErrorMessage = $('#monthlyFeeErrorMessage');
            let incrementCommencementDateErrorMessage = $('#incrementCommencementDateErrorMessage');
            let contractorTdsErrorMessage = $('#contractorTdsErrorMessage');
            let isValid = true;

            incrementCommencementDateErrorMessage.addClass('d-none')
            contractorTdsErrorMessage.addClass('d-none')
            monthlyFeeErrorMessage.addClass('d-none')

            if (incrementCommencementDate.val().trim() === '') {
                incrementCommencementDateErrorMessage.removeClass('d-none')
                isValid = false;
            }
            
            if (newMonthlyFee.val().trim() === '') {
                monthlyFeeErrorMessage.removeClass('d-none')
                isValid = false;
            }

            if (contractorTds.val().trim() === '') {
                contractorTdsErrorMessage.removeClass('d-none')
                isValid = false;
            }

            return isValid
        }

        function onUpdateNewMonthlyFee(value) {
            var tds = document.getElementById('contractorNewTds')
            tds.value = Math.floor(value * 0.02)
        }
    </script>
@endsection
