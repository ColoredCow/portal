<div id="applicant-sidebar" class="position-fixed top-0 start-0 bg-white">
    <h5 class="fw-bold" style="border-bottom: 1px solid black;">CodeTrek Applicants</h5>
    <ul class="applicant-list">
        @foreach ($applicants as $applicant)
            <li data-id="{{ $applicant->id }}">
                <h6><i class="fa fa-user"></i> {{ $applicant->first_name }} {{ $applicant->last_name }}</h6>
            </li>
        @endforeach
    </ul>
</div>