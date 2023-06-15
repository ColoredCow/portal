<div id="applicant-sidebar" class="position-fixed bg-white p-1">
    <h5 class="fw-bold border-bottom pb-2">CodeTrek Applicants</h5>
    <ul class="applicant-list list-unstyled">
        @foreach ($codeTrekApplicants as $codeTrekApplicant)
            <li data-id="{{ $codeTrekApplicant->id }}" class="d-flex align-items-center">
                <i class="fa fa-user mr-1"></i>
                <a class="applicant-name" data-toggle="modal" data-target="#candidatefeedback{{ $codeTrekApplicant->id }}">
                    {{ $codeTrekApplicant->first_name }} {{ $codeTrekApplicant->last_name }}
                </a>
            </li>
            @include('codetrek::modals.sidebar-feedback-modal')
        @endforeach
    </ul>
</div>


<script>
    $('.positive').on('click', function(event) {
        event.preventDefault();
        $('.negative').removeClass('red');
        $(this).addClass('green');
        var feedbackType = 'positive';
        $(this).closest('.modal').find('input[name="feedback_type"]').val(feedbackType);
    });

    $('.negative').on('click', function(event) {
        event.preventDefault();
        $('.positive').removeClass('green');
        $(this).addClass('red');
        var feedbackType = 'negative';
        $(this).closest('.modal').find('input[name="feedback_type"]').val(feedbackType);
    });

    $('#applicant_form').on('submit', function(event) {
        event.preventDefault();
        var feedbackType = $(this).find('input[name="feedback_type"]').val();
        $(this).append('<input type="hidden" name="feedback_type" value="' + feedbackType + '">');
        this.submit();
    });
</script>
