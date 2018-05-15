<div class="modal fade hr_round_review" id="autoresponder_mail" tabindex="-1" role="dialog" aria-labelledby="autoresponder_mail" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="autoresponder_mail">Mail sent to {{ $applicant->email }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <strong class="d-block mb-1">Mail subject:</strong>
                <p class="bg-light p-3">{{ $application->autoresponder_subject }}</p>
                <strong class="d-block mb-1">Mail body:</strong>
                <div class="bg-light p-3 mb-3 space-wrap">{!! $application->autoresponder_body !!}</div>
            </div>
        </div>
    </div>
</div>
