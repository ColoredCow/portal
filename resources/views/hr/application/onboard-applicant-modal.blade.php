<div class="modal fade" id="onboard_applicant" tabindex="-1" role="dialog" aria-labelledby="onboard_applicant" aria-hidden="true" v-if="selectedAction == 'onboard'">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-block">
                    <h5 class="modal-title">Onboard</h5>
                    <h6 class="text-secondary">{{ $applicant->name }} &mdash; {{ $applicant->email }}</h6>
                </div>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="onboard_email">Email</label>
                        <div class="input-group">
                            <input type="text" name="onboard_email" id="onboard_email" class="form-control" placeholder="username" autocomplete="off">
                            <div class="input-group-append">
                                <span class="input-group-text">{{ '@' . env('GOOGLE_CLIENT_HD') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="onboard_password">Password</label>
                        <input type="password" class="form-control" name="onboard_password" id="onboard_password" required="required" autocomplete="off">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="designation">Designation</label>
                        <input type="text" class="form-control" name="designation" id="designation" value="{{ $application->job->title }}" required="required">
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="form-group col-md-12">
                        <button type="button" class="btn btn-success px-4 round-submit" data-action="onboard">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
