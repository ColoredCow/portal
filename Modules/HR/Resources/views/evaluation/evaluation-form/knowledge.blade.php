@php
$technicalKnowledge = collect($segment)
    ->where('name', 'Telephonic Interview Segment')
    ->first();
@endphp
@foreach ($technicalKnowledge['parameters'] as $parameter)
    @if (empty($parameter['children']))
        @includeWhen(sizeof($parameter['children']),
            'hr::evaluation.evaluation-form.resume-screening.parameter',
            [
                'parameter' => $parameter,
                'parent' => [],
            ])
    @endif
    @includeWhen(sizeof($parameter), 'hr::evaluation.evaluation-form.resume-screening.parameter', [
        'parameter' => $parameter,
        'parent' => [],
    ])
@endforeach
