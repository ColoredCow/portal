<div class="modal fade hr_round_review" id="{{ $data['modal-id'] }}" tabindex="-1" role="dialog" aria-labelledby="{{ $data['modal-id'] }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $data['modal-id'] }}">Mail sent to {{ $data['mail-to'] }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <strong class="d-block mb-1">Mail subject:</strong>
                <p class="bg-light p-3">{{ $data['mail-subject'] }}</p>
                <strong class="d-block mb-1">Mail body:</strong>
                <div class="bg-light p-3 mb-3 space-wrap">{!! $data['mail-body'] !!}</div>
                <strong class="d-block mb-1">Mail triggered by:</strong>
                <p class="bg-light p-3">{{ $data['mail-sender'] }}</p>
                <strong class="d-block mb-1">Mail sent at:</strong>
                <p class="bg-light p-3">{{ $data['mail-date'] }}</p>
            </div>
        </div>
    </div>
</div>
