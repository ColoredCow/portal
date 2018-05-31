@php
	$round->load(['evaluationParameters', 'evaluationParameters.options']);
@endphp
<h5><b>Round Evaluation Parameters</b></h5>
@foreach($round->evaluationParameters as $evaluationParameter)
	<div class="form-group col-md-12">
		<div><b>{{ $evaluationParameter->name }}</b></div>
		@foreach($evaluationParameter->options as $option)
		    <div class="form-check form-check-inline">
		      <input class="form-check-input" type="radio" name="roundReviewEvaluation[{{ $evaluationParameter->id }}]" id="inlineRadio1" value="{{ $option->id }}" required>
		      <label class="form-check-label" for="{{ $evaluationParameter->name }}">{{ $option->value }}</label>
		    </div>
	    @endforeach
	    <input type="" name="" placeholder="Comment" class="form-control">
</div>
@endforeach