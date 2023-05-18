<div id="applicant-sidebar">
    <h5 style="font-weight: bold;">CodeTrek Applicants</h5>
    <ul class="applicant-list">
        @foreach ($applicants as $applicant)
            <li data-id="{{ $applicant->id }}">
                <h6>{{ $applicant->first_name }} {{ $applicant->last_name }}</h6>
            </li>
        @endforeach
    </ul>
</div>
