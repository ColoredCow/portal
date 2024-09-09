<div class="modal fade" id="saveAsIncrementModal" tabindex="-1" role="dialog" aria-labelledby="saveAsIncrementModalLabel" aria-hidden="true">
    <form action="{{ route('salary.employee.store', $employee) }}" id="appraisalForm" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="saveAsIncrementModalLabel">Salary Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="d-flex">
                    <div class="form-group pl-6 mb-0 col-md-6 mt-4">
                        <label class="leading-none fz-24 d-flex align-items-center" for="proposedCtc">
                            <span class="mr-1">{{ __('New CTC') }}</span>
                            <span><i class="fa fa-rupee"></i></span>
                            <small class="fz-12 ml-2">{{ __(' (including Health Insurance)') }}</small>
                        </label>
                        <input v-model="proposedCtc" type="number" step="0.01" id="proposedCtc" class="form-control bg-light" placeholder="Enter CTC" min="0" @input="onEnteringCtc" required>
                        <small class="d-none text-danger" id="proposedCtcErrorMessage"><strong >CTC Required</strong></small>
                    </div>
                    <div class="form-group pl-6 mb-0 col-md-6 mt-4">
                        <label class="leading-none fz-24 d-flex align-items-center" for="proposedCtc">
                            <span class="mr-1">{{ __('Percentage') }}</span>
                        </label>
                        <input v-model="percentage" type="text" id="percentage" class="form-control bg-light" placeholder="Enter Increased Percentage" @input="calculateCtcFromPercentage" >
                    </div>
                </div>
                <gross-calculation-section
                    :ctc-increase-suggestions="{{ json_encode($ctcIncreaseSuggestions)}}"
                    :ctc-suggestions="{{ json_encode($ctcSuggestions) }}"
                    :ctc-percentages="{{ json_encode($ctcPercentages)}}"
                    :yearly-gross-salary="{{json_encode($yearlyGrossSalary)}}"
                    :salary-configs="{{ json_encode($salaryConfigs) }}"
                    :gross-calculation-data="{{ $grossCalculationData }}"
                    :proposed-ctc="proposedCtc"
                    v-on:update-ctc="updateProposedCtc"
                    :tds="{{ optional($employee->getLatestSalary())->tds ?: 0  }}"
                    :loan-deduction="{{ $employee->loan_deduction_for_month ?: 0 }}"
                    :insurance-tenants="{{ optional($employee->user->profile)->insurance_tenants ?? 1 }}"
                ></gross-calculation-section>
                <div class="d-md-flex">
                    <div class="form-group pl-6 col-md-5">
                        <label class="leading-none fz-24 d-flex align-items-center" for="tds">
                            <span class="mr-1 mb-1">{{ __('TDS') }}</span>
                            <span class="fz-12">{{ __('(optional)') }}</span>
                        </label>
                        <input type="number" step="0.01" name="tds" id="tds" value="0" class="form-control bg-light" placeholder="Enter TDS">
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
                    <div class="form-group pl-6 col-md-10">
                        <label class="leading-none fz-24 d-flex align-items-center" for="cc_emails">
                            <span class="mr-1 mb-1">{{ __('CC emails') }}</span>
                        </label>
                        <input type="email" name="ccemails" id="ccemails" class="form-control bg-light" placeholder="Comma separated emails">
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
        var yearlyGrossSalary = @json($yearlyGrossSalary);
        new Vue({
            el: '#appraisalForm',
            data() {
                return {
                    proposedCtc: "{{ 0 }}",
                    yearlyGrossSalary: yearlyGrossSalary,
                    percentage: ''
                }
            },
            methods: {
                updateProposedCtc(newProposedCtc) {
                    this.proposedCtc = newProposedCtc;
                },
                onEnteringCtc() {
                    const ctcValue = parseFloat(this.proposedCtc);
                    const currentCtc = parseFloat(this.yearlyGrossSalary);

                    if (currentCtc !== 0) {
                        const increasePercentage = ((ctcValue - currentCtc) / currentCtc) * 100;
                        this.percentage = increasePercentage.toFixed(2);
                    } else {
                        this.percentage = '';
                    }
                },
                calculateCtcFromPercentage() {
                    const percentageIncrease = parseFloat(this.percentage);
                    const currentCtc = parseFloat(this.yearlyGrossSalary);

                    if (!isNaN(percentageIncrease) && currentCtc !== 0) {
                        const ctcValue = currentCtc * (1 + percentageIncrease / 100);
                        this.proposedCtc = Math.round(ctcValue);
                    } else {
                        this.proposedCtc = '';
                    }
                }
            }
        });

        function generatePdf() {
            event.preventDefault();
            if (validateForm()) {
                var button = document.getElementById("generatePdfButton");
                if(button){
                    var url = button.getAttribute("data-url");
                    var form = document.getElementById("appraisalForm");
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
                    var form = document.getElementById("appraisalForm");
                    form.removeAttribute('target', '_blank');
                    form.setAttribute("action", url);
                    form.submit();
                }
            }
        }

        function validateForm() {
            let proposedCtc = $('#proposedCtc');
            let percentage = $('#percentage');
            let commencementDate = $('#commencementDate');
            let signature = $('#signature');
            let proposedCtcErrorMessage = $('#proposedCtcErrorMessage');
            let commencementDateErrorMessage = $('#commencementDateErrorMessage');
            let signatureErrorMessage = $('#signatureErrorMessage');
            let isValid = true;

            commencementDateErrorMessage.addClass('d-none')
            signatureErrorMessage.addClass('d-none')
            proposedCtcErrorMessage.addClass('d-none')

            if (commencementDate.val().trim() === '') {
                commencementDateErrorMessage.removeClass('d-none')
                isValid = false;
            }

            if (proposedCtc.val().trim() === '') {
                proposedCtcErrorMessage.removeClass('d-none')
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
