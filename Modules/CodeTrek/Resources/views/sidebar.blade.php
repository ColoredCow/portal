<ul>
    @php
        $applicants = \Modules\CodeTrek\Entities\CodeTrekApplicant::orderBy('first_name', 'ASC')->get();
    @endphp
    @foreach ($applicants as $applicant)
        <li data-id="{{ $applicant->id }}">
            <a href="{{ url('/code-trek-applicants/' . $applicant->id) }}">
                <h6>{{ $applicant->first_name }} {{ $applicant->last_name }}</h6>
            </a>
        </li>
    @endforeach
</ul>
