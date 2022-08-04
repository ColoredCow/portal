@php
$technicalKnowledge = collect($segment)
    ->where('name', 'Telephonic Interview Segment')
    ->first();
@endphp
@foreach ($technicalKnowledge['parameters'] as $parameter)
    @includeWhen(sizeof($parameter['children']), 'hr::evaluation.evaluation-form.resume-screening.parameter', [
        'parameter' => $parameter,
        'parent' => [],
    ])
@endforeach
