@extends('codetrek::layouts.master')
@section('content')
    <div class="container h-100p min-w-696 max-w-1044 bg-white px-5 py-5">
        <div class="mb-5" id="FeedbackHeading">
            <h1 class="font-weight-bold">Feedbacks</h1>
        </div>
        <table class="table table-striped table-bordered border-primary rounded my-5 pb-5">
            <tr>
                <td class="font-weight-bold" width="35%"><span>Applicant Name </span></td>
                <td class="text-primary font-weight-bold">
                <span>{{ $applicantInfo->first_name }}</span>
                <span> {{$applicantInfo->last_name}}</span>
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold" width="35%"><span>Github Username</span></td>
                <td class="text-primary font-weight-bold"><span>{{$applicantInfo->github_user_name}}</span></td>
            </tr>
            <tr>
                <td class="font-weight-bold" width="35%"><span>University</span></td>
                <td class="text-primary font-weight-bold"><span>{{$applicantInfo->university}}</span></td>
            </tr>
            <tr>
                <td class="font-weight-bold" width="35%"><span>Branch</span></td>
                <td class="text-primary font-weight-bold"><span>{{$applicantInfo->course}}</span></td>
            </tr>
            <tr>
                <td class="font-weight-bold" width="35%"><span>Current Round</span></td>
                <td class="text-primary font-weight-bold"><span>{{$applicantInfo->latest_round_name}}</span></td>
            </tr>
            <tr>
                <td class="font-weight-bold" width="35%"><span>Email</span></td>
                <td class="text-primary font-weight-bold"><span>{{$applicantInfo->email}}</span></td>
            </tr>
            <tr>
                <td class="font-weight-bold" width="35%"><span>Phone Number</span></td>
                <td class="text-primary font-weight-bold"><span>{{$applicantInfo->phone}}</span></td>
            </tr>
        </table>
        <hr class="border-secondary mt-5 mb-5" size="10" width="100%" align="left">
        <div class="accordion mt-5" id="FeedbacksAccordion">
            @foreach ($candidateFeedbacks as $candidateFeedback)
            <div class="accordion-item my-2">
                <div class="card py-0">
                    <div class="card-header max-h-52  py-0" id="heading{{$candidateFeedback->id}}">
                        <h5 class="mb-1">
                            <button class="btn accordion-button w-100p" type="button" data-toggle="collapse" data-target="#collapse{{$candidateFeedback->id}}" aria-expanded="false" aria-controls="collapse{{$candidateFeedback->id}}">
                                <div class="row bg-light my-0">
                                    <div class="col-6 mx-0 d-flex justify-content-start align-items-center text-primary my-0">
                                        <span class="font-weight-bold">{{$candidateFeedback->posted_by}}</span>
                                        <span class="mx-1">-</span>
                                        <span>{{$candidateFeedback->posted_on}}</span>
                                    </div>
                                    <div class="col-6 mx-0 d-flex justify-content-end py-1">
                                        <span class="badge badge-primary max-h-25 mt-1 item-align-center">{{$candidateFeedback->feedback_category}}</span>
                                        <span>&nbsp &nbsp</span>
                                        @if(strcmp($candidateFeedback->feedback_type, "positive") == 0)
                                            <span class="thumbs-up pt-0 max-h-25">
                                                <i class="fa fa-thumbs-up thumbs-up fa-lg mt-1" aria-hidden="true"></i>
                                            </span>
                                        @else
                                            <span class="thumbs-down pt-0 max-h-25">
                                                <i class="fa fa-thumbs-down thumbs-down fa-lg mt-1" aria-hidden="true"></i>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </button>
                        </h5>
                    </div>
                    <div id="collapse{{$candidateFeedback->id}}" class="accordian-collapse collapse" aria-labelledby="heading{{$candidateFeedback->id}}" data-parent="#FeedbacksAccordion">
                        <div class="accordian-body card-body px-5">
                            <span class="w-100p min-h-50" placeholder="Your Feedback Here">{{$candidateFeedback->feedback}}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
