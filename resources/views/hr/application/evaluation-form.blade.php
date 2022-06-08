<form id="applicationEvaluation" method="POST" action="/hr/evaluation/{{ $applicationRound->id }}">
	@method('PATCH')
    @csrf
    {{-- <div class="row mb-3 d-none evaluation-result">
        <div class="col-12">
            <h4>
                <span>Result: </span>
                @if($evaluationScores['score'] >= config('hr.applicationEvaluation.cutoffScore'))
                    <span class="text-success">Passing</span>
                @else
                    <span class="text-danger">Failing</span>
                @endif
            </h4>
        </div>
    </div> --}}
    {{-- this depends on the application round. currently hard-coded for resume-screening --}}
    <div class="evaluation-stage" id="evaluationStage1">
        @include('hr::evaluation.evaluation-form.resume-screening.feeling')
        <div class="row py-4">
            <div class="col-12">
                {{-- TODO: save form on click using AJAX --}}
                <button class="btn btn-success show-evaluation-stage" data-target="#evaluationStage2" type="button">Next</button>
            </div>
        </div>
    </div>
    <div class="d-none evaluation-stage" id="evaluationStage2">
        @include('hr::evaluation.evaluation-form.resume-screening.review')
        {{-- TODO: hardcoded block below. Need to make it functional --}}
        <div class="row my-3">
            <div class="col-12">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input section-toggle-checkbox" id="SendForReview" data-show-on-checked="#assignSendForReview">
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
				{{-- TODO: save form on click using AJAX --}}
                <button type="button" class="btn btn-light border mr-2 show-evaluation-stage" data-target="#evaluationStage1">Back</button>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>
    </div>
</form>
