<div class="modal fade" id="ModalCenter" tabindex="-1"
role="dialog" aria-labelledby="ModalCenterTitle"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLongTitle">NOTE
                </h5>
                <button type="button" class="close"
                    data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Do you want to put this application on Hold?</p>
            </div>
            <div class="form-group col-md-12 d-flex align-items-center">
            <div class="py-0.67">
                <div class="custom-control custom-switch">
                <input type="checkbox" name="send_mail_to_applicant[hold]" class="custom-control-input show" id="SendmailforonHold">
                <label class="custom-control-label" for="SendmailforonHold" >Send email</label>
                </div>
            </div>
            </div>
            <div class="container">
                <div>
                    <ul class="nav nav-tabs menu">
                        <li class="nav-item "><a data-toggle="tab" href="#option1" class="nav-link opt" data-key-subject='application_on_hold_subject' data-key-body='application_on_hold_body' >Option 1</a></li>
                        <li class="nav-item"><a data-toggle="tab" href="#option2" class="nav-link opt" data-key-subject='application_on_hold_subject_2' data-key-body='application_on_hold_body_2'>Option 2</a></li>
                    </ul>
                    <div class="tab-content" id="tabs">
                        <div class="tab-pane" id="option1">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Subject</label>
                                            <input name="subject_option_1" type="text" class="form-control option-subject" id="option1subject">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Mail body:</label>
                                            <textarea name="body_option_1" id="option1body" rows="10" class="richeditor form-control option-body"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="option2">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Subject</label>
                                            <input name="subject_option_2" type="text" class="form-control" id="option2subject">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Mail body:</label>
                                            <textarea name="body_option_2" rows="10" class="richeditor form-control" id="option2body"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success px-4 round-submit" data-action="on-hold">Confirm</button>
            </div>
        </div>
    </div>
</div>