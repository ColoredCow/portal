@php
    $codeTrekService = new \Modules\CodeTrek\Services\CodeTrekService();
    $applicants = $codeTrekService->getApplicants();
@endphp

@foreach ($applicants as $applicant)
    <li data-id="{{ $applicant->id }}">
        <h6>{{ $applicant->first_name }} {{ $applicant->last_name }}</h6>
    </li>
@endforeach
