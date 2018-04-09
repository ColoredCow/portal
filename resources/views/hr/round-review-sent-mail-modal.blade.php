<div class="modal fade" id="round_mail_{{ $applicant_round->id }}" tabindex="-1" role="dialog" aria-labelledby="round_mail_{{ $applicant_round->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="round_mail_{{ $applicant_round->id }}">Mail sent to {{ $applicant_round->applicant->email }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <strong class="d-block mb-1">Mail subject:</strong>
                <p class="bg-light p-3">{{ $applicant_round->mail_subject }}</p>
                <strong class="d-block mb-1">Mail body:</strong>
                <p class="bg-light p-3 space-wrap">{{ $applicant_round->mail_body }}</p>
                <strong class="d-block mb-1">Mail triggered by:</strong>
                <p class="bg-light p-3">{{ $applicant_round->mailSender->name }}</p>
                <strong class="d-block mb-1">Mail sent at:</strong>
                <p class="bg-light p-3">{{ $applicant_round->mail_sent_at }}</p>
            </div>
        </div>
    </div>
</div>
