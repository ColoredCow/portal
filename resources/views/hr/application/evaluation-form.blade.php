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
    {{-- @dd($applicationRound); --}}
        @php
        $applicationRoundReview = $applicationRound->applicationRoundReviews->where('review_key', 'feedback')->first();
        $applicationRoundReviewValue = $applicationRoundReview ? $applicationRoundReview->review_value : '';
        @endphp
    <div class="evaluation-stage" id="evaluationStage1">
        @include('hr::evaluation.evaluation-form.resume-screening.feeling')
        {{-- @dd($applicationRound); --}}

            <div class="row py-4">
                
                <textarea name="testing_stage1" rows="3" class="form-control"
                placeholder="Enter comments....">{{$applicationRoundReview->review_value}}</textarea>

                <div class="col-12">
                    {{-- TODO: save form on click using AJAX --}}
                    <br>
                    <button class="btn btn-success show-evaluation-stage " data-target="#evaluationStage2"
                        type="button" data-action="update">Next</button>
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
            
            <textarea rows="5" class="form-control" name="feedback_submit"
            placeholder="Enter comments....">{{$applicationRoundReview->review_value}}</textarea>

            <div class="row py-4">
                <div class="col-12">
                    <button type="button" class="btn btn-light border mr-2 show-evaluation-stage"
                    data-target="#evaluationStage1">Back</button>
                    <button type="submit" class="btn btn-success" >Submit</button>
                </div>
            </div>
        </div>
        @endif
    </form>
    