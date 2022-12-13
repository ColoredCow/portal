{{-- <script src="{{ asset('js/app.js') }}">
                            $("label[for=resume-looks-good-no]").click(function(){ 
                                console.log("hihi");
                                $("#rejectButton").removeClass("d-none"); 
                                $("#nextButton").addClass("d-none");
                            });
</script> --}}
{{-- @push('scripts')
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
    @stack('page-scripts')
@endpush --}}

<form method="POST" action="/hr/evaluation/{{ $applicationRound->id }}>
    @method('PATCH')
    @csrf
    {{-- TODO: We can utilize this code in the future if needed --}}

    {{-- <div class="spinner d-none text-center">
        <div id="spinner-div" class="pt-3">
            <div class="spinner-border text-primary" role="status"></div>
        </div>
    </div>
    <div class="row mb-3 d-none evaluation-result">
        <div class="col-12">
            <h4>
                <span>Result: </span>
                @if ($evaluationScores['score'] >= 2)
                    <span class="text-success">Passing</span>
                @else
                    <span class="text-danger">Failing</span>
                @endif
            </h4>
        </div>
    </div> --}}
    {{-- this depends on the application round. currently hard-coded for resume-screening --}}
    @if ($applicationRound->round->name == "Telephonic Interview")
        @include('hr::evaluation.evaluation-form.knowledge')
        <div class="row py-4">
            <div class="col-12">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>
    @else
        <div class="evaluation-stage" id="evaluationStage1">
            @include('hr::evaluation.evaluation-form.resume-screening.feeling')
            <div class="row py-4">
                <div class="col-12">
                    {{-- TODO: save form on click using AJAX --}}
                    <button class="btn btn-success show-evaluation-stage" id="nextButton" data-target="#evaluationStage2"
                        type="button" >Next</button>
                    <button type="button" class="btn btn-outline-danger ml-2 d-none show-evaluation-stage1" id="rejectButton" @click="rejectApplication()">
                        Reject</button>
                        <script type="text/javascript">
                            // function  rejectApplication()    
                            // {
                            //     $("#application_reject_modal").modal("show");
                            //     loadTemplateMail("reject", (res) => {
                            //         $("#rejectMailToApplicantSubject").val(res.subject);
                            //         tinymce
                            //             .get("rejectMailToApplicantBody")
                            //             .setContent(res.body, { format: "html" });
                            //     });
                            // }
                            $("label[for=resume-looks-good-no]").click(function(){ 
                                $("#rejectButton").removeClass("d-none"); 
                                $("#nextButton").addClass("d-none");
                            });
                        </script>
                </div>
            </div>
        </div>
        <div class="d-none evaluation-stage" id="evaluationStage2">
            @include('hr::evaluation.evaluation-form.resume-screening.review')
            {{-- TODO: hardcoded block below. Need to make it functional --}}
            <div class="row my-3">
                <div class="col-12">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input section-toggle-checkbox" id="SendForReview"
                            data-show-on-checked="#assignSendForReview">
                        <label class="custom-control-label" for="SendForReview">Send for review</label>
                    </div>
                </div>
                <div class="col-4 d-none my-1" id="assignSendForReview">
                    <select name="reviewer" class="custom-select custom-select-sm fz-14">
                        <option selected>Select reviewer</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row py-4">
                <div class="col-12">
                    <button type="button" class="btn btn-light border mr-2 show-evaluation-stage"
                        data-target="#evaluationStage1">Back</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </div>
        </div>
        @endif
    </form>
    