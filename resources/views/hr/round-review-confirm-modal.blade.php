<div class="modal fade" id="round_confirm" tabindex="-1" role="dialog" aria-labelledby="round_confirm"
    aria-hidden="true" v-if="selectedAction == 'round'">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-block">
                    <h5 class="modal-title" id="round_confirm">@{{ this.nextRoundName }}</h5>
                    <h6 class="text-secondary">{{ $applicationRound->application->applicant->name }} &mdash;
                        {{ $applicationRound->application->applicant->email }}</h6>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <div class="form-row">
                    <div class="form-group col-md-12">
                        <div class="form-check form-check-inline">
                            <input class="" type="checkbox" id="create_calendar_event" name="create_calendar_event"
                                v-model="createCalendarEvent">
                            <label class="form-check-label leading-none" for="create_calendar_event">Create a calendar event</label>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label class="leading-none" for="next_scheduled_start">Scheduled start date</label>
                        <input type="datetime-local" name="next_scheduled_start" id="next_scheduled_start"
                            class="form-control" required="required">
                    </div>
                    <div class="form-group offset-md-1 col-md-5" v-if="createCalendarEvent">
                        <label class="leading-none" for="next_scheduled_end">Scheduled end date</label>
                        <input type="datetime-local" name="next_scheduled_end" id="next_scheduled_end"
                            class="form-control" required="required">
                    </div>
                </div>
                <div class="form-row" v-if="createCalendarEvent">
                    <div class="form-group col-md-5">
                        <label class="leading-none" for="summary_calendar_event">Summary for calendar event</label>
                        <input type="text" name="summary_calendar_event" id="summary_calendar_event"
                            class="form-control" required="required">
                    </div>
                </div> --}}
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label class="fz-14 leading-none text-secondary" for="next_scheduled_person_id">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>{{ __('Assignee') }}</span>
                        </label>
                        <select name="next_scheduled_person_id" id="next_scheduled_person_id" class="form-control"
                            required="required">
                            @foreach ($interviewers as $interviewer)
                                @php
                                    $selected = $interviewer->id == auth()->id() ? 'selected' : '';
                                @endphp
                                <option value="{{ $interviewer->id }}" {{ $selected }}>{{ $interviewer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12 d-flex align-items-center">
                        <div class="py-0.67">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="send_mail_to_applicant[confirm]" class="custom-control-input send-mail-to-applicant" id="confirmSendMailToApplicant" data-target="#previewMailToApplicant" checked>
                                <label class="custom-control-label" for="confirmSendMailToApplicant">Send email</label>
                            </div>
                        </div>
                        <div class="toggle-block-display c-pointer rounded-circle bg-theme-gray-lightest hover-bg-theme-gray-lighter px-1 py-0.67 ml-1" id="previewMailToApplicant" data-target="#confirmMailToApplicantBlock" data-toggle-icon="true">
                            <i class="fa fa-eye toggle-icon d-none" aria-hidden="true"></i>
                            <i class="fa fa-eye-slash toggle-icon" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="form-row d-none" id="confirmMailToApplicantBlock">
                    <div class="form-group col-md-12">
                        <label class="leading-none" for="confirmMailToApplicantSubject">Subject</label>
                        <input type="text" name="mail_to_applicant[confirm][subject]" id="confirmMailToApplicantSubject"
                            class="form-control">
                    </div>
                    <div class="form-group col-md-12">
                        <label class="leading-none" for="confirmMailToApplicantBody">Body</label>
                        <textarea name="mail_to_applicant[confirm][body]" id="confirmMailToApplicantBody" class="form-control richeditor"></textarea>
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="form-group col-md-12">
                        <input type="hidden" name="next_round" id="next_round" :value="selectedNextRound">
                        <button type="button" class="btn btn-success px-4 round-submit" data-action="confirm">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>