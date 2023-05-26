<div id="applicant-sidebar" class="position-fixed top-0 start-0 bg-white">
    <h5 class="fw-bold border-bottom pb-2">CodeTrek Applicants</h5>
    <ul class="applicant-list list-unstyled">
        @foreach ($codeTrekApplicants as $codeTrekApplicant)
            <li data-id="{{ $codeTrekApplicant->id }}">
                <h6><i class="fa fa-user me-1"></i> {{ $codeTrekApplicant->first_name }} {{ $codeTrekApplicant->last_name }}</h6>
            </li>
        @endforeach
    </ul>
</div>
