<div class="feedback-modal modal fade" id="candidatefeedback{{ $codeTrekApplicant->id }}" tabindex="-1" z-index="1"
    role="dialog" aria-labelledby="candidatefeedback{{ $codeTrekApplicant->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('codetrek.storeFeedback') }}" method="POST" id='feedback_form'>
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong>Feedback Form</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="card-body">
                    <div class="">
                        <div class="d-flex justify-content-center justify-content-around">
                            <div class="form-group col-md-6 text-break">
                                <h6 class="fw-bold" for="first_name">Name</h6>
                                <h5>{{ $codeTrekApplicant->first_name }} {{ $codeTrekApplicant->last_name }}
                                </h5>

                                <input type="hidden" name="latest_round_name" id="latest_round_name"
                                    value="{{ $codeTrekApplicant->latest_round_name }}">
                                <input type="hidden" name="candidate_id" id="candidate_id"
                                    value="{{ $codeTrekApplicant->id }}">
                            </div>
                            <div class="form-group col-md-6 text-break">
                                <h6 for="email">Email</h6>
                                <h5>{{ $codeTrekApplicant->email }}</h5>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center justify-content-between">
                            <div class="form-group col-md-6 text-break">
                                <h6 for="university">University</h6>
                                <h5>{{ $codeTrekApplicant->university }}</h5>
                            </div>
                            <div class="form-group col-md-6 text-break">
                                <h6 for="graduation_year">Graduation Year</h6>
                                <h5>{{ $codeTrekApplicant->graduation_year }}</h5>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="d-flex justify-content-start">
                        <div class="form-group col-lg-6 col-md-5">
                            <div class="mb-2">
                                <label for="feedback_categories">Feedback Categories</label>
                            </div>
                            <select name="feedback_category" id="feedback_category" class="form-control" required>
                                <option value="">{{ __('Select Category') }}</option>
                                @foreach ($feedback_categories as $feedback_category)
                                    <option value="{{ $feedback_category->id }}">
                                        {{ $feedback_category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="justify-content-center">
                            <div class="mb-1 text-center">
                                <label for="feedback_type">Feedback Type</label>
                            </div>
                            <div class="d-flex col-md-5">
                                <div class="d-flex flex-column text-center mr-3">
                                    <a id="feedback-positive" name="positive-type" class="positive"
                                        onmouseover="this.style.color='green'; this.style.transform='scale(1.1)'"
                                        onmouseout="this.style.color=''; this.style.transform='none'">
                                        <i class="fa fa-thumbs-up fa-2x mb-1" aria-hidden="true"></i>
                                    </a>
                                    <h6>positive</h6>
                                </div>
                                <div class="d-flex flex-column text-center">
                                    <a id="feedback-negative" name="negative-type" class="negative"
                                        onmouseover="this.style.color='red'; this.style.transform='scale(1.1)'"
                                        onmouseout="this.style.color=''; this.style.transform='none'">
                                        <i class="fa fa-thumbs-down fa-2x mb-1" aria-hidden="true"></i>
                                    </a>
                                    <h6>negative</h6>
                                </div>
                            </div>
                            <input type="hidden" name="feedback_type" id="feedback-type" value="">
                        </div>
                    </div>

                    <div class="form-floating mt-3 col-md-12">
                        <label for="floatingTextarea">Share your Feedback</label>
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
