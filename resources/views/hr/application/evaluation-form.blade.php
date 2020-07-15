{{-- <div class="card border-success mb-3">
	<div class="card-header text-white bg-success">
		Evaluation Info
	</div>
	<div class="card-body">
	    <p class="card-text"><b>Candidate Name -</b> {{ $applicationRound->application->applicant->name }}</p>
	    <p class="card-text"><b>Review Round -</b> {{ $applicationRound->round->name }}</p>
	</div>
</div> --}}
<form method="POST" action="/hr/applications/evaluation/{{ $applicationRound->id }}">
	@method('PATCH')
    @csrf
    <div class="row mb-3">
        <div class="col-12">
            <h4>
                <span>Score: </span>
                <span><span class={{ $evaluationScores['total'] >= config('hr.applicationEvaluation.cutoffScore') ? 'text-success' : 'text-danger' }}>{{ $evaluationScores['total'] }}</span> out of 20</span>
            </h4>
        </div>
        <div class="col-12">
            <h4>
                <span>Result: </span>
                @if($evaluationScores['total'] >= config('hr.applicationEvaluation.cutoffScore'))
                    <span class="text-success">Passing</span>
                @else
                    <span class="text-danger">Failing</span>
                @endif
            </h4>
        </div>
    </div>
	<div class="row">
	    <div class="col-4">
	        <div class="list-group" id="list-tab" role="tablist">
                @foreach($segment as $evaluation_segment)
                    <a class="list-group-item list-group-item-action {{ $loop->first ? 'active' : '' }}" id="list-{{ $evaluation_segment['id'] }}-list" data-toggle="list" href="#list-{{ $evaluation_segment['id'] }}" role="tab" aria-controls="{{ $evaluation_segment['id'] }}">{{ $evaluation_segment['name'] }}</a>
	            @endforeach
	            <br>
	            <input type="submit" class="btn btn-success" value="Save Evaluation">
	        </div>
	    </div>
	    <div class="col-8">
	        <div class="tab-content" id="nav-tabContent">
	            @foreach($segment as $evaluation_segment)
                    <div class="tab-pane fade show {{ $loop->first ? 'active' : '' }}" id="list-{{ $evaluation_segment['id'] }}" role="tabpanel" aria-labelledby="list-{{ $evaluation_segment['id'] }}-list">
	                    <ul class="list-group">
	                    @foreach($evaluation_segment['parameters'] as $evaluation_parameter)
	                        <li class="list-group-item {{ $evaluation_parameter['evaluation'] ? 'list-group-item-success' : '' }}">
	                            <b>{{ $evaluation_parameter['name'] }}</b>
	                            <br>
                                @if($evaluation_parameter['evaluation'])
                                    @if($evaluation_parameter['evaluation_detail']['comment'])
                                        <span><i>Comment: </i>{{ $evaluation_parameter['evaluation_detail']['comment'] }}</span>
                                        <br>
                                    @endif
	                                <span><i>Option: </i>{{ $evaluation_parameter['evaluation_detail']['option'] }}</span>
	                            @else
	                                @foreach($evaluation_parameter['option_detail'] as $option)
	                                    <div class="form-check form-check-inline">
                                            <label class="form-check-label" for="evaluation[{{ $evaluation_parameter['id'] }}][{{$option['id']}}]">
                                                <input type="radio" id="evaluation[{{ $evaluation_parameter['id'] }}][{{$option['id']}}]" name="evaluation[{{ $evaluation_parameter['id'] }}][option_id]" value="{{ $option['id'] }}">
                                                <span>{{ $option['name'] }}</span>
                                            </label>
	                                    </div>
	                                @endforeach
	                                <input type="hidden" name="evaluation[{{ $evaluation_parameter['id'] }}][evaluation_id]" value="{{ $evaluation_parameter['id'] }}">
	                                <input type="text" name="evaluation[{{ $evaluation_parameter['id'] }}][comment]" placeholder="Comment" class="form-control">
	                            @endif
	                        </li>
	                    @endforeach
                            <li class="list-group-item">
                                @php
                                    $commentBlockId = "evaluation_segment_{$evaluation_segment['id']}_comments";
                                @endphp
                                <div>
                                    <button type="button" class="btn btn-sm btn-light border fz-14 segment-evaluation-show-comment" data-block-id="#{{ $commentBlockId }}">Add comments</button>
                                </div>
                                <div class="d-none" id="{{ $commentBlockId }}">
                                    <b>Comments</b>
                                    <textarea name="evaluation_segment[{{ $evaluation_segment['id'] }}][comments]" class="form-control" rows="5">{{ $evaluation_segment['applicationEvaluations']['comments'] }}</textarea>
                                </div>
                                <input type="hidden" name="evaluation_segment[{{ $evaluation_segment['id'] }}][evaluation_segment_id]" value="{{ $evaluation_segment['id'] }}">
                            </li>
                        </ul>
	                </div>
	            @endforeach
	        </div>
	    </div>
	</div>
</form>
