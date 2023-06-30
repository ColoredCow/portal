@extends('codetrek::layouts.master')
@section('content')
    <div class="container vh-100 min-w-696 max-w-1044 bg-white px-5 py-5">
        <div class="accordion" id="FeedbacksAccordion">
            @foreach ($candidateFeedbacks as $candidateFeedback)
            <div class="accordion-item my-2">
                <div class="card">
                    <div class="card-header max-h-80" id="heading{{$candidateFeedback->id}}">
                        <h5 class="mb-0">
                            <button class="btn accordion-button w-100p" type="button" data-toggle="collapse" data-target="#collapse{{$candidateFeedback->id}}" aria-expanded="false" aria-controls="collapse{{$candidateFeedback->id}}">
                                <div class="row bg-light my-0 px-2 py-0">
                                    <div class="col-6 mx-0 d-flex justify-content-start align-items-center text-primary">
                                        <span class="font-weight-bold">{{$candidateFeedback->posted_by}}</span>
                                        <span class="mx-1">-</span>
                                        <span>{{$candidateFeedback->posted_on}}</span>
                                    </div>
                                    <div class="col-6 mx-0 d-flex justify-content-end">
                                        <span class="badge badge-primary pt-2">{{$candidateFeedback->feedback_category}}</span>
                                        <span>&nbsp &nbsp &nbsp</span>
                                        @if(strcmp($candidateFeedback->feedback_type, "positive") == 0)
                                            <span class="thumbs-up">
                                                <i class="fa fa-thumbs-up fa-2x mb-1" aria-hidden="true"></i>
                                            </span>
                                        @else
                                            <span class="thumbs-down">
                                                <i class="fa fa-thumbs-down fa-2x mb-1" aria-hidden="true"></i>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </button>
                        </h5>
                    </div>
                    <div id="collapse{{$candidateFeedback->id}}" class="accordian-collapse collapse" aria-labelledby="heading{{$candidateFeedback->id}}" data-parent="#FeedbacksAccordion">
                        <div class="accordian-body card-body">
                            <span class="w-100p min-h-50" placeholder="Your Feedback Here">{{$candidateFeedback->feedback}}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
