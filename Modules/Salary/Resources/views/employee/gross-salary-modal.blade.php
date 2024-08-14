<div class="modal fade" id="appraisalModal" tabindex="-1" role="dialog" aria-labelledby="appraisalModalLabel" aria-hidden="true">
    <form action="{{ route('salary.employee.store', $employee) }}" id="appraisalForm" method="POST" enctype="multipart/form-data"> 
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="appraisalModalLabel">Salary Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="form-group pl-6 mb-0 col-md-6 mt-4">
                    <label class="leading-none fz-24 d-flex align-items-center" for="proposedCtc">
                        <span class="mr-1">{{ __('New CTC') }}</span>
                        <span><i class="fa fa-rupee"></i></span>
                        <small class="fz-12 ml-2">{{ __(' (including Health Insurance)') }}</small>
                    </label>
                    <input v-model="proposedCtc" type="number" step="0.01" id="proposedCtc" class="form-control bg-light" placeholder="Enter CTC" min="0" required>
                    <small class="d-none text-danger" id="proposedCtcErrorMessage"><strong >CTC Required</strong></small>
                </div>
                <gross-calculation-section
                    :ctc-suggestions="{{ json_encode($ctcSuggestions) }}"
                    :salary-configs="{{ json_encode($salaryConfigs) }}"
                    :gross-calculation-data="{{ $grossCalculationData }}"
                    :proposed-ctc="proposedCtc"
                    v-on:update-ctc="updateProposedCtc"
                    :tds="{{ optional($employee->getLatestSalary())->tds ?: 0  }}"
                    :loan-deduction="{{ $employee->loan_deduction_for_month ?: 0 }}"
                    :insurance-tenants="{{ optional($employee->user->profile)->insurance_tenants ?? 1 }}"
                ></gross-calculation-section>
                <div class="d-md-flex {{ count($ctcSuggestions) > 0 ? '' :  'mt-4' }}">
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
                @if ($employee->payroll_type === 'contractor')
                <div class="d-md-flex flex-wrap mt-2">
                    <div class="form-group pl-6 col-md-5">
                        <label class="leading-none fz-24 d-flex align-items-center" for="newDesignationId">
                            <span class="mr-1 mb-1">{{ __('New Designation') }}</span>
                        </label>
                        <select name="newDesignationId" id="newDesignationId" class="form-control bg-light">
                            @foreach ($designations as $designation)
                                <option value="{{ $designation->id }}" {{ $employee->designation_id === $designation->id ? 'selected' : '' }}> {{ $designation->designation }}</option>
                            @endforeach
                        </select>
                    </div>
                    @php
                        $user = $employee->user()->withTrashed()->first();
                        $userProfile = $user ? $user->profile : '';
                    @endphp
                    @if (!$userProfile || $userProfile->date_of_birth === '0000-00-00')
                        <div class="form-group pl-6 col-md-5">
                            <label class="leading-none fz-24 d-flex align-items-center" for="dateOfBirthId">
                                <span class="mr-1 mb-1">{{ __('Date of Birth') }}</span>
                            </label>
                            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control bg-light" required value="{{$userProfile ? $userProfile->date_of_birth : '' }}">
                            <small class="d-none text-danger" id="dateOfBirthErrorMessage"><strong>Date Required</strong></small>
                        </div>
                    @endif
                    @php
                        $user = $employee->user()->withTrashed()->first();
                        $userProfile = $user ? $user->profile : '';
                    @endphp
                    @if (! $userProfile || ! $userProfile->pan_details)
                        <div class="form-group pl-6 col-md-5">
                            <label class="leading-none fz-24 d-flex align-items-center" for="panDetailsId">
                                <span class="mr-1 mb-1">{{ __('PAN Number') }}</span>
                            </label>
                            <input type="text" name="pan_details" id="pan_details" class="form-control bg-light" required value="{{$userProfile ? $userProfile->pan_details : '' }}">
                        </div>
                    @endif
                </div>
                @endif
                <div class="d-md-flex mt-2">
                    <div class="form-group pl-6 col-md-10">
                        <label class="leading-none fz-24 d-flex align-items-center" for="cc_emails">
                            <span class="mr-1 mb-1">{{ __('CC emails') }}</span>
                        </label>
                        <input type="email" name="ccemails" id="ccemails" class="form-control bg-light" placeholder="Comma separated emails">
                    </div>
                </div>

                <div class="modal-footer">
                    <input hidden name="submitType" value="send_appraisal_letter"/>
                    <button id="generatePdfButton" class="btn btn-primary text-white" data-url ="{{route('salary.employee.generate-appraisal-letter', $employee)}} "onclick="generatePdf()">{{ $employee->payroll_type === 'contractor' ? 'View Onboarding Letter' : 'View Appraisal Letter' }}</button>
                    <input type="submit" id="modalSaveButton" class="btn btn-primary ml-2 px-4" value="{{ $employee->payroll_type === 'contractor' ? 'Send Onboarding Letter' : 'Send Appraisal Letter' }}" data-url ="{{ route('salary.employee.store', $employee) }}" onclick="submitAppraisalForm()"/>
                </div>
            </div>
        </div>
    </form>
</div>

@section('js_scripts')
    @parent
    <script>
        new Vue({
            el: '#appraisalForm',
            data() {
                return {
                    proposedCtc: "{{ 0 }}",
                }
            },
            methods: {
                updateProposedCtc(newProposedCtc) {
                    this.proposedCtc = newProposedCtc;
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

        function submitAppraisalForm() {
            event.preventDefault();
            if (validateForm()) {
                var button = document.getElementById("modalSaveButton");
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
            let commencementDate = $('#commencementDate');
            let dateOfBirth = $('#date_of_birth');
            let signature = $('#signature');
            let proposedCtcErrorMessage = $('#proposedCtcErrorMessage');
            let commencementDateErrorMessage = $('#commencementDateErrorMessage');
            let signatureErrorMessage = $('#signatureErrorMessage');
            let dateOfBirthErrorMessage = $('#dateOfBirthErrorMessage');
            let isValid = true;

            commencementDateErrorMessage.addClass('d-none')
            signatureErrorMessage.addClass('d-none')
            dateOfBirthErrorMessage.addClass('d-none')
            proposedCtcErrorMessage.addClass('d-none')

            if (commencementDate.val().trim() === '') {
                commencementDateErrorMessage.removeClass('d-none')
                isValid = false;
            }
            if (dateOfBirth.val() === '' && dateOfBirth.val().trim() === '') {
                dateOfBirthErrorMessage.removeClass('d-none')
                isValid = false;
            }
            
            if (proposedCtc.val().trim() === '') {
                proposedCtcErrorMessage.removeClass('d-none')
                isValid = false;
            }

            return isValid
        }
    </script>
@endsection
