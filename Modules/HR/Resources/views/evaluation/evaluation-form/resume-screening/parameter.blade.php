@php
    $parameterName = \Str::slug($parameter['name'], '-');
    $parentName = \Str::slug($parent['name'] ?? '', '-');
    $parentOptionName = "$parentName-" . \Str::slug($parameter['parent_option']['name'] ?? '' );
    $showParameter = sizeof($parent) ? 'd-none' : '';
    if (isset($parent['evaluation']) && $parent['evaluation'] && $parent['evaluation_detail']['option'] == $parameter['parent_option']['name']) {
        $showParameter = '';
    }
    $leftMargin = sizeof($parent) ? 'ml-4' : '';
@endphp
<div class="{{ "$parentName $parentOptionName $leftMargin $showParameter" }}  ">
    <div class="row my-3">
        <div class="col-12">
            <strong class="mb-1 d-block">{{ $parameter['name'] }}</strong>
            <div class="form-check form-check-inline">
                @foreach ($parameter['option_detail'] ?? [] as $index => $option)
                    @php
                        $checked = isset($parameter['evaluation_detail']['option']) && $parameter['evaluation_detail']['option'] == $option['name'] ? 'checked' : '';
                        $optionName = "$parameterName-" . \Str::slug($option['name'] ?? '' );
                    @endphp
                    <input class="toggle-button section-toggle" type="radio" name="evaluation[{{ $parameter['id'] }}][option_id]" id="{{ $optionName }}" data-target-parent="{{ $parameterName }}" data-target-option="{{ $optionName }}" value="{{ $option['id'] }}" {{ $checked }}>
                    <label for="{{ $optionName }}" class="btn btn-outline-primary btn-sm px-2 mr-2 shadow-sm fz-14 abcd">{{ $option['name'] }}</label>
                @endforeach
                <input type="hidden" name="evaluation[{{ $parameter['id'] }}][evaluation_id]" value="{{ $parameter['id'] }}">
            </div>
        </div>
    </div>
    {{-- TODO: hardcoded block below. need to make dynamic --}}
    @if ($parameter['name'] == 'Proceed to next round?')
        <div class="row my-4">
            <div class="col-12">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input section-toggle-checkbox" id="matchForCodeTrek" data-show-on-checked="#assignMatchForCodetrek">
                    <label class="custom-control-label" for="matchForCodeTrek">Match for CodeTrek</label>
                </div>
            </div>
            <div class="col-4 d-none my-1" id="assignMatchForCodetrek">
                <select class="custom-select custom-select-sm fz-14 set-segment-assignee" data-target-segment="#segment-{{ \Str::slug('CodeTrek eligibility') }}">
                    <option selected>Assign</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif
    @foreach ($parameter['children'] as $childParameter)
        @include('hr::evaluation.evaluation-form.resume-screening.parameter', ['parameter' => $childParameter, 'parent' => $parameter])
    @endforeach
</div>

