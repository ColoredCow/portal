<div id="applicant-sidebar" class="position-fixed bg-white p-1">
    <h5 class="fw-bold border-bottom pb-2">CodeTrek Applicants</h5>
    <ul class="applicant-list list-unstyled">
        @foreach ($codeTrekApplicants as $codeTrekApplicant)
            @if ($codeTrekApplicant->status == 'active')
                <li data-id="{{ $codeTrekApplicant->id }}" class="d-flex align-items-center">
                    <i class="fa fa-user mr-1"></i>
                    <h6 class="ml-1">
                        {{ $codeTrekApplicant->first_name }} {{ $codeTrekApplicant->last_name }}
                    </h6>
                </li>
            @endif
        @endforeach
    </ul>
</div>
