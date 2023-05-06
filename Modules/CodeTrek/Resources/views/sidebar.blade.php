<ul>
    @php
        $applicants = \Modules\CodeTrek\Entities\CodeTrekApplicant::all();
    @endphp
    @foreach($applicants as $applicant)
        <li>{{ $applicant->first_name }} {{ $applicant->last_name }}</li>
    @endforeach
</ul>
