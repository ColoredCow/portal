<div id="applicant-sidebar" class="position-fixed bg-white p-1">
    <h5 class="fw-bold border-bottom pb-2">CodeTrek Applicants</h5>
    <ul class="applicant-list list-unstyled">
        @foreach ($codeTrekApplicants as $codeTrekApplicant)
            <li data-id="{{ $codeTrekApplicant->id }}" class="d-flex align-items-center">
                <i class="fa fa-user mr-1"></i>
                <a class="applicant-name" data-toggle="modal" data-target="#candidateFeedback{{ $codeTrekApplicant->id }}">
                    {{ $codeTrekApplicant->first_name }} {{ $codeTrekApplicant->last_name }}
                </a>
            </li>
            @include('codetrek::modals.sidebar-feedback-modal')
        @endforeach
    </ul>
</div>
