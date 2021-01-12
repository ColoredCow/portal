<div class="modal fade hr_round_review" id="round_{{ $applicationRound->id }}" tabindex="-1" role="dialog" aria-labelledby="round_{{ $applicationRound->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/hr/recruitment/application-round/{{ $applicationRound->id }}/sendmail" method="POST">

                {{ csrf_field() }}

                @php
                    $mailTemplate = $applicationRound->round_status . '_mail_template';
                @endphp

                <div class="modal-header">
                    <h5 class="modal-title" id="round_{{ $applicationRound->id }}">Send mail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 class="mb-4">Sending to: {{ $application->applicant->email }}</h6>
                    <div class="form-group">
                        <label for="subject">Mail subject:</label>
                        <input type="text" class="form-control" name="mail_subject" required="required" placeholder="Subject" value="{{ $applicationRound->round->{$mailTemplate}['subject'] ?? null }}">
                    </div>
                    <div class="form-group">
                        <label for="mail_content">Mail body:</label>
                        <textarea name="mail_body" id="mail_body" rows="10" class="richeditor form-control" placeholder="Body">
                            {{ $applicationRound->round->{$mailTemplate}['body'] ?? null }}
                        </textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
