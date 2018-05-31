@php
	$round->load(['evaluationParameters', 'evaluationParameters.options']);
@endphp
<h5><b>Round Evaluation Parameters</b></h5>
@foreach($round->evaluationParameters as $evaluationParameter)
	<div class="form-group col-md-12">
		<div><b>{{ $evaluationParameter->name }}</b></div>
		@php
			$roundEvaluation = $evaluation->where('evaluation_id', $evaluationParameter->id)->first();
		@endphp
		@foreach($evaluationParameter->options as $option)
			@php
				$roundEvaluationOption = $roundEvaluation ? $roundEvaluation->where('option_id', $option->id)->first() : null	;
			@endphp
		    <div class="form-check form-check-inline">
		      <input class="form-check-input" type="radio" name="roundEvaluation[{{ $evaluationParameter->id }}][option_id]" id="inlineRadio1" value="{{ $option->id }}" {{ $roundEvaluationOption ? "checked" : "" }}>
		      <label class="form-check-label" for="{{ $evaluationParameter->name }}">{{ $option->value }}</label>
		    </div>
	    @endforeach
	    <input type="text" name="roundEvaluation[{{ $evaluationParameter->id }}][comment]" placeholder="Comment" class="form-control" value="{{ $roundEvaluation ? $roundEvaluation->first()->comment : "" }}">
	</div>
@endforeach