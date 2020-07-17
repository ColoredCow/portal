@php
    $modalId = "modal{$evaluation_segment['round_id']}{$evaluation_segment['id']}"
@endphp
<div class="shadow my-3 mr-4 py-4 px-6 rounded c-pointer flex-center bg-theme-blue-chalk hover-bg-theme-fog" data-toggle="modal" data-target="#{{ $modalId }}">
    <span>{{ $evaluation_segment['name'] }}</span>
</div>
<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="{{ $modalId }}Title" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="{{ $modalId }}Title">{{ $evaluation_segment['name'] }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
                                        <div class="mt-2">
                                            <input type="radio" class="toggle-button" id="evaluation[{{ $evaluation_parameter['id'] }}][{{$option['id']}}]" name="evaluation[{{ $evaluation_parameter['id'] }}][option_id]" value="{{ $option['id'] }}">
                                            <label for="evaluation[{{ $evaluation_parameter['id'] }}][{{$option['id']}}]" class="btn btn-outline-primary px-4 mr-4 shadow-sm">{{ $option['name'] }}</label>
                                        </div>
                                    </div>
                                @endforeach
                                <input type="hidden" name="evaluation[{{ $evaluation_parameter['id'] }}][evaluation_id]" value="{{ $evaluation_parameter['id'] }}">
                                <div>
                                    @php
                                        $commentBlockId = "evaluation_{$evaluation_parameter['id']}_comments";
                                    @endphp
                                    <span class="text-underline fz-14 show-comment c-pointer" data-block-id="#{{ $commentBlockId }}">Add comment</span>
                                    <div class="d-none" id="{{ $commentBlockId }}">
                                        <input type="text" name="evaluation[{{ $evaluation_parameter['id'] }}][comment]" placeholder="Comment" class="form-control">
                                    </div>
                                </div>
                            @endif
                        </li>
                    @endforeach
                    <li class="list-group-item">
                        @php
                            $commentBlockId = "evaluation_segment_{$evaluation_segment['id']}_comments";
                        @endphp
                        <div id="{{ $commentBlockId }}">
                            <b>Overall comments</b>
                            <textarea name="evaluation_segment[{{ $evaluation_segment['id'] }}][comments]" class="form-control" rows="5" placeholder="Overall comments">{{ $evaluation_segment['applicationEvaluations']['comments'] }}</textarea>
                        </div>
                        <input type="hidden" name="evaluation_segment[{{ $evaluation_segment['id'] }}][evaluation_segment_id]" value="{{ $evaluation_segment['id'] }}">
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
