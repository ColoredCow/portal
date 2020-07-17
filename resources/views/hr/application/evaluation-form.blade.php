<div class="card border-success mb-3">
	<div class="card-body">
	    {{-- <p class="card-text"><b>Candidate Name -</b> {{ $applicationRound->application->applicant->name }}</p> --}}
	    <p class="card-text"><strong>{{ $applicationRound->round->name }}</strong></p>
	</div>
</div>
<form method="POST" action="/hr/applications/evaluation/{{ $applicationRound->id }}">
	@method('PATCH')
    @csrf
    <div class="row mb-3 d-none evaluation-result">
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
    </div>
	<div class="row">
        <div class="col-12">
            <b>Does the resume match our needs?</b>
            <br><br>
            <div class="form-check form-check-inline">
                <div>
                    <input class="toggle-button input-section-toggler" type="radio" name="toggle" id="relevantResume-Yes" data-target="relevantResume-Yes">
                    <label for="relevantResume-Yes" class="btn btn-outline-primary btn-lg px-4 mr-4 shadow-sm">Yes</label>
                </div>
                <div>
                    <input class="toggle-button" type="radio" name="toggle" id="relevantResume-No">
                    <label for="relevantResume-No" class="btn btn-outline-primary btn-lg px-4 mx-4 shadow-sm">No</label>
                </div>
            </div>
        </div>
    </div>
    <div class="row d-none" data-show="relevantResume-Yes">
        <div class="col-12">
            <div class="d-flex flex-wrap">
                @foreach($segment as $evaluation_segment)
                    @include('hr::evaluation.applicationround-segment-evaluation')
                @endforeach
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <button class="btn btn-success">Save evaluation</button>
        </div>
    </div>

</form>
