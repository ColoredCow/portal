<div class="modal fade" id="saveAsIncrementModal" tabindex="-1" role="dialog" aria-labelledby="saveAsIncrementModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="saveAsIncrementModalLabel">Salary Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="d-md-flex">
            <div class="form-group col-md-5">
                <label class="leading-none fz-24 ml-4 d-flex align-items-center" for="grossSalary">
                    <span class="mr-1 mb-1">{{ __('Monthly Gross Salary') }}</span>
                    <span><i class="fa fa-rupee"></i></span>
                </label>
                <input v-model="grossSalary" type="number" step="0.01" name="grossSalary" id="grossSalary" class="form-control ml-4 bg-light" placeholder="Enter Monthly Gross Salary" min="0" required>
            </div>
            <div class="form-group col-md-5">
                <label class="leading-none fz-24 ml-4 d-flex align-items-center" for="grossSalary">
                    <span class="mr-1 mb-1">{{ __('Commencement Date') }}</span>
                </label>
                <input v-model="commencementDate" type="date" name="commencementDate" id="commencementDate" class="form-control ml-4 bg-light" required>
            </div>
        </div>
        <div class="d-md-flex">
            <div class="form-group col-md-5">
                <label class="leading-none fz-24 ml-4 d-flex align-items-center" for="cc_emails">
                    <span class="mr-1 mb-1">{{ __('CC emails') }}</span>
                </label>
                <input v-model="cc_emails" type="email" step="0.01" name="ccemails" id="ccemails" class="form-control ml-4 bg-light" placeholder="Enter emails to be cced">
            </div>
            <div class="form-group col-md-5">
                <label class="leading-none fz-24 ml-4 d-flex align-items-center" for="signature">
                    <span class="mr-1 mb-1">{{ __('Upload Stamp') }}</span>
                </label>
                <input v-model="image" type="file" accept="image/*" name="signature" id="signature" class="form-control ml-4 bg-light" required>
            </div>
        </div>


        <div class="modal-footer">
        <button id="generatePdfButton" class="btn btn-primary text-white font-weight-bold" data-url ="{{route('salary.employee.generate-appraisal-letter', $employee)}}"onclick="generatePdf()">View Appraisal Letter</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input name="submitType" type="submit" id="saveButton" class="btn btn-primary ml-2 px-4" value="Save And Send" data-url ="{{ route('salary.employee.store', $employee) }}" onclick="resetPath()"/>
        </div>
    </div>
    </div>
</div>

@section('js_scripts')
    @parent
    <script>
        function generatePdf() {
            event.preventDefault();
            var button = document.getElementById("generatePdfButton");
            if(button){
                var url = button.getAttribute("data-url");
                var form = document.getElementById("salaryForm");
                const originalUrl = form.getAttribute('action');
                form.setAttribute("action", url);
                form.setAttribute('target', '_blank');
                form.submit();
                var newWindow = window.open(url);
            }
        }

        function resetPath(){
            event.preventDefault();
            var button = document.getElementById("saveButton");
            if(button){
                var url = button.getAttribute("data-url");
                var form = document.getElementById("salaryForm");
                form.removeAttribute('target', '_blank');
                form.setAttribute("action", url);
                form.submit();
            }
        }
    </script>
@endsection
