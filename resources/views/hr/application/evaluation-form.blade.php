<div class="card border-success mb-3">
	<div class="card-header text-white bg-success">
		Evaluation Info
	</div>
	<div class="card-body">
	    <p class="card-text"><b>Candidate Name -</b> {{ $applicationRound->application->applicant->name }}</p>
	    <p class="card-text"><b>Review Round -</b> {{ $applicationRound->round->name }}</p>
	</div>
</div>
<form method="POST" action="/hr/applications/evaluation/{{ $applicationRound->id }}">
	@method('PATCH')
	@csrf
	<div class="row">
	    <div class="col-4">
	    	@php
				$round_segment = '';
				$non_round_segment = '';
			@endphp
	        <div class="list-group" id="list-tab" role="tablist">
	            @foreach($segment as $evaluation_segment)
	            	@if($evaluation_segment['round_id'] == $applicationRound->hr_round_id)
	            		@php
	            			$round_segment .= '<a class="list-group-item list-group-item-action bg-warning text-white" id="list-' . $evaluation_segment['id'] . '-list" data-toggle="list" href="#list-' . $evaluation_segment['id'] . '" role="tab" aria-controls="' . $evaluation_segment['id'] . '">' . $evaluation_segment['name'] . '</a>';
	            		@endphp
	            	@else
	            		@php
	            			$non_round_segment .= '<a class="list-group-item list-group-item-action" id="list-' . $evaluation_segment['id'] . '-list" data-toggle="list" href="#list-' . $evaluation_segment['id'] . '" role="tab" aria-controls="' . $evaluation_segment['id'] . '">' . $evaluation_segment['name'] . '</a>';
	            		@endphp
	                @endif
	            @endforeach
	            {!! $round_segment !!}
	            {!! $non_round_segment !!}
	            <br>
	            <input type="submit" class="btn btn-success" value="Save Evaluation">
	        </div>
	    </div>
	    <div class="col-8">
	        <div class="tab-content" id="nav-tabContent">
	            @foreach($segment as $evaluation_segment)
	                <div class="tab-pane fade show" id="list-{{ $evaluation_segment['id'] }}" role="tabpanel" aria-labelledby="list-{{ $evaluation_segment['id'] }}-list">
	                    <ul class="list-group">
	                    @foreach($evaluation_segment['parameters'] as $evaluation_parameter)
	                        <li class="list-group-item {{ $evaluation_parameter['evaluation'] ? 'list-group-item-success' : '' }}">
	                            <b>{{ $evaluation_parameter['name'] }}</b>
	                            <br>
	                            @if($evaluation_parameter['evaluation'])
	                                <span><i>Comment: </i>{{ $evaluation_parameter['evaluation_detail']['comment'] }}</span>
	                                <br>
	                                <span><i>Option: </i>{{ $evaluation_parameter['evaluation_detail']['option'] }}</span>
	                            @else
	                                @foreach($evaluation_parameter['option_detail'] as $option)
	                                    <div class="form-check form-check-inline">
	                                        <input class="form-check-input" type="radio" name="evaluation[{{ $evaluation_parameter['id'] }}][option_id]" value="{{ $option['id'] }}">
	                                        <label class="form-check-label" for="">{{ $option['name'] }}</label>
	                                    </div>
	                                @endforeach
	                                <input type="hidden" name="evaluation[{{ $evaluation_parameter['id'] }}][evaluation_id]" value="{{ $evaluation_parameter['id'] }}">
	                                <input type="text" name="evaluation[{{ $evaluation_parameter['id'] }}][comment]" placeholder="Comment" class="form-control">
	                            @endif
	                        </li>
	                    @endforeach
	                    </ul>
	                </div>
	            @endforeach
	        </div>
	    </div>
	</div>
</form>