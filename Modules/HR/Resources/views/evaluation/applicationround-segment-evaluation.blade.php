@php
    $modalId = "modal{$evaluation_segment['round_id']}{$evaluation_segment['id']}"
@endphp
<div class="shadow my-3 mr-4 py-4 px-6 rounded c-pointer flex-center flex-column bg-theme-blue-chalk hover-bg-theme-fog" id="segment-{{ \Str::slug($evaluation_segment['name']) }}" data-toggle="modal" data-target="#{{ $modalId }}">
    <span>{{ $evaluation_segment['name'] }}</span>
    <small class="mt-1 d-none assignee"><span class="text-theme-orange fz-20">•</span>&nbsp;<span class="name"></span></small>
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
                        @php
                            $commentBlockId = "evaluation_{$evaluation_parameter['id']}_comments";
                        @endphp
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-11">
                                    <b>{{ $evaluation_parameter['name'] }}</b>
                                </div>
                                @if (!isset($evaluation_parameter['evaluation_detail']['comment']) || !$evaluation_parameter['evaluation_detail']['comment'])
                                    <div class="col-1">
                                        <span class="fz-14 show-comment c-pointer hover-bg-theme-gray-lighter rounded-circle d-inline-flex p-1" data-block-id="#{{ $commentBlockId }}">
                                            <i class="fa fa-comment-o" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="form-check form-check-inline mt-2 evaluation-form {{ $evaluation_parameter['slug'] ?? '' }}">
                                @foreach($evaluation_parameter['option_detail'] as $option)
                                    @php
                                        $optionLabel = $option['name'];
                                        if (in_array($option['name'], ['yes', 'Yes', 'y'])) {
                                            $optionLabel = '<i class="fa fa-thumbs-up text-theme-gray-light hover-text-success checked-text-success" aria-hidden="true"></i>';
                                        }
                                        if (in_array($option['name'], ['no', 'No', 'n'])) {
                                            $optionLabel = '<i class="fa fa-thumbs-down text-theme-gray-light hover-text-danger checked-text-danger" aria-hidden="true"></i>';
                                        }
                                        $checked = $evaluation_parameter['evaluation'] && $evaluation_parameter['evaluation_detail']['option'] == $option['name'] ? 'checked' : '';
                                    @endphp
                                    <input type="radio" class="toggle-button" id="evaluation[{{ $evaluation_parameter['id'] }}][{{$option['id']}}]" name="evaluation[{{ $evaluation_parameter['id'] }}][option_id]" value="{{ $option['id'] }}" {{ $checked }}>
                                    <label for="evaluation[{{ $evaluation_parameter['id'] }}][{{$option['id']}}]" class="mr-2 c-pointer thumb">{!! $optionLabel !!}</label>
                                @endforeach
                            </div>
                            @if (isset($evaluation_parameter['evaluation_detail']['comment']) && $evaluation_parameter['evaluation_detail']['comment'])
                                <div>
                                    <small><i class="fa fa-comment-o" aria-hidden="true"></i>&nbsp;{{ $evaluation_parameter['evaluation_detail']['comment'] }}</small>
                                </div>
                            @endif
                            <input type="hidden" name="evaluation[{{ $evaluation_parameter['id'] }}][evaluation_id]" value="{{ $evaluation_parameter['id'] }}">
                            <div class="d-none" id="{{ $commentBlockId }}">
                                <input type="text" name="evaluation[{{ $evaluation_parameter['id'] }}][comment]" placeholder="Enter comment..." class="form-control fz-14">
                            </div>
                        </li>
                    @endforeach
                    <li class="list-group-item">
                        @php
                            $commentBlockId = "evaluation_segment_{$evaluation_segment['id']}_comments";
                        @endphp
                        <div id="{{ $commentBlockId }}">
                            <b>Overall comments</b>
                            <textarea name="evaluation_segment[{{ $evaluation_segment['id'] }}][comments]" class="form-control" rows="5" placeholder="Enter comments...">{{ $evaluation_segment['applicationEvaluations']['comments'] }}</textarea>
                        </div>
                        <input type="hidden" name="evaluation_segment[{{ $evaluation_segment['id'] }}][evaluation_segment_id]" value="{{ $evaluation_segment['id'] }}">
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
