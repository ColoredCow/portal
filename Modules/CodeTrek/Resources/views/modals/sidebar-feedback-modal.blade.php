<div class="feedback-modal modal fade" id="candidateFeedback{{ $codeTrekApplicant->id }}" tabindex="-1" z-index="1"
    role="dialog" aria-labelledby="candidateFeedback{{ $codeTrekApplicant->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('codetrek.store-feedback') }}" method="POST" id='feedbackForm'>
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Feedback Form</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                        <div class="d-flex justify-content-center justify-content-around">
                            <div class="form-group col-md-6 text-break">
                                <h6 class="fw-bold" for="firstName">{{__('Name')}}</h6>
                                <h5>{{ $codeTrekApplicant->first_name }} {{ $codeTrekApplicant->last_name }}</h5>
                                <input type="hidden" name="latest_round_name" value="{{ $codeTrekApplicant->latest_round_name }}">
                                <input type="hidden" name="candidate_id" value="{{ $codeTrekApplicant->id }}">
                            </div>
                            <div class="form-group col-md-6 text-break">
                                <h6 for="email">{{__('Email')}}</h6>
                                <h5>{{ $codeTrekApplicant->email }}</h5>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center justify-content-between">
                            <div class="form-group col-md-6 text-break">
                                <h6 for="university">{{__('University')}}</h6>
                                <h5>{{ $codeTrekApplicant->university }}</h5>
                            </div>
                            <div class="form-group col-md-6 text-break">
                                <h6 for="graduationYear">{{__('Graduation Year')}}</h6>
                                <h5>{{ $codeTrekApplicant->graduation_year }}</h5>
                            </div>
                        </div>
                    <hr>
                    <div class="d-flex justify-content-start">
                        <div class="form-group col-lg-6 col-md-5">
                            <div class="mb-2">
                                <label for="feedbackCategories">{{__('Feedback Categories')}}</label>
                            </div>
                            <select name="feedback_category" id="feedbackCategory" class="form-control" required>
                                <option value="">{{ __('Select Category') }}</option>
                                @foreach ($feedbackCategories as $feedbackCategory)
                                    <option value="{{ $feedbackCategory->id }}">{{ $feedbackCategory->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="justify-content-center">
                            <div class="mb-1 text-center">
                                <label for="feedbackType">{{__('Feedback Type')}}</label>
                            </div>
                            <div class="d-flex col-md-5">
                                <div class="d-flex flex-column text-center mr-3">
                                    <label>
                                        <input class="thumbs-radio-button position-absolute" type="radio" name="feedback_type" value="positive" required>
                                        <span class="thumbs-up">
                                            <i class="fa fa-thumbs-up fa-2x mb-1" aria-hidden="true"></i>
                                        </span>
                                        <h6>Positive</h6>
                                    </label>
                                </div>
                                <div class="d-flex flex-column text-center">
                                    <label>
                                        <input class="thumbs-radio-button position-absolute" type="radio" name="feedback_type" value="negative" required>
                                        <span class="thumbs-down">
                                            <i class="fa fa-thumbs-down fa-2x mb-1" aria-hidden="true"></i>
                                        </span>
                                        <h6>Negative</h6>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mt-3 col-md-12">
                        <label for="floatingTextarea">{{__('Share your Feedback')}}</label>
                        <textarea class="form-control" name="feedback" id="feedback" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit Feedback</button>
                </div>
            </div>
        </form>
    </div>
</div>