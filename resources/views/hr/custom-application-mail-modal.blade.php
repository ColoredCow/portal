<div class="modal fade hr_round_review" id="customApplicationMail" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="/hr/recruitment/application-round/{{ $application->id }}/sendmail" method="POST">
                @csrf
                <div class="modal-header">
                    <div class="d-block text-left">
                        <h5 class="modal-title">Send mail</h5>
                        <h6 class="text-secondary">{{ $application->applicant->name }} &mdash;
                            {{ $application->applicant->email }}</h6>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-left">
                    <div class="form-group">
                        <label class="leading-none" for="mail_action">Action</label>
                        <input type="text" class="form-control" id="mail_action" name="mail_action" required="required" placeholder="Action" value="">
                    </div>
                    <div class="form-group">
                        <label class="leading-none" for="subject">Mail subject</label>
                        <input type="text" class="form-control" id="subject" name="mail_subject" required="required" placeholder="Subject" value="">
                    </div>
                    <div class="form-group">
                        <label class="leading-none" for="mail_content">Mail body</label>
                        <textarea name="mail_body" id="mail_content" rows="10" class="richeditor form-control" placeholder="Body"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
