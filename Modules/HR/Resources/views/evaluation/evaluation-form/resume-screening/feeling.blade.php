@php
    $resumeFeeling = collect($segment)->where('name', 'Resume feeling')->first();
@endphp

@foreach ($resumeFeeling['parameters'] as $parameter)
    @includeWhen(sizeof($parameter['children']), 'hr::evaluation.evaluation-form.resume-screening.parameter', ['parameter' => $parameter, 'parent' => []])
@endforeach
