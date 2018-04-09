<div class="modal fade" id="round_{{ $applicant_round->id }}" tabindex="-1" role="dialog" aria-labelledby="round_{{ $applicant_round->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/hr/applicant-round/{{ $applicant_round->id }}/sendmail" method="POST">

                {{ csrf_field() }}

                <div class="modal-header">
                    <h5 class="modal-title" id="round_{{ $applicant_round->id }}">Send mail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 class="mb-4">Sending to: {{ $applicant_round->applicant->email }}</h6>
                    <div class="form-group">
                        <label for="subject">Mail subject:</label>
                        <input type="text" class="form-control" name="mail_subject" required="required" placeholder="Subject">
                    </div>
                    <div class="form-group">
                        <label for="mail_content">Mail body:</label>
                        <textarea name="mail_body" rows="10" class="form-control" required="required" placeholder="Body"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
