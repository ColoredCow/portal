@php
    $clipboardLines = [];
    $clipboardLines[] = 'Candidate to evaluate:';
    $clipboardLines[] = $applicant->name . ', applied on ' . $application->created_at->format(config('constants.display_date_format'));

    if (isset($applicationFormDetails->value)) {
        $formFields = json_decode($applicationFormDetails->value);
        if ($formFields) {
            foreach ($formFields as $label => $value) {
                if (!empty($value)) {
                    $clipboardLines[] = $label;
                    $clipboardLines[] = $value;
                }
            }
        }
    }

    $clipboardText = implode("\n", $clipboardLines);
@endphp
<span class="c-pointer btn-clipboard btn btn-outline-secondary btn-sm"
    data-clipboard-text="{{ $clipboardText }}"
    data-toggle="tooltip"
    title="Click to copy candidate details for AI evaluation">
    <i class="fa fa-clone mr-1"></i>Copy for AI evaluation
</span>
