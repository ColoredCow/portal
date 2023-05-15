@foreach ($applicants as $applicant)
    <li data-id="{{ $applicant->id }}">
        <h6>{{ $applicant->first_name }} {{ $applicant->last_name }}</h6>
    </li>
@endforeach
