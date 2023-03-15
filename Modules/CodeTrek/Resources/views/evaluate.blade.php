 @extends('codetrek::layouts.master')
@section('content')
<div class="container d-flex justify-content-center" id="update_details ">
    <div class="accordion col-9" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <h6>Level-1  <i class="fa fa-info-circle"></i>  {{$applicant->first_name}} {{$applicant->last_name}}</h6>
                    <button class="btn btn-link float-right" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <i class="fa fa-pencil"></i>
                    </button>
                </h2>
            </div>
            <div id="collapseOne" class="collapse {{ $applicant->round_name == 'level-1' ? 'show' : '' }}" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <h4 class="mb-3">Applicant Details</h4>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label>Name</label>
                                <h6>{{$applicant->first_name}} {{$applicant->last_name}}</h6>
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                            <label>Phone</label>
                                <h6>{{$applicant->phone}}</h6>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label>Email</label>
                            <h6>{{$applicant->email}}</h6>
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                            <label>University</label>
                            <h6>{{$applicant->university}}</h6>
                        </div>
                    </div>
                    <form action="{{ route('update-feedback', $applicant->id) }}" method="POST">
                        @csrf
                            <div class="form-group row">
                                <div class="col-sm-9">
                                    <input type="hidden" name="round_name" value="level-1">
                                    @php
                                        $feedback = '';
                                        foreach ($roundDetails as $roundDetail) {
                                            if ($roundDetail->round_name == 'level-1') {
                                                $feedback = $roundDetail->feedback;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <textarea class="form-control" id="feedbackTextarea1" name="feedback" rows="5" placeholder="Enter comments">{{$feedback }}</textarea>-
                                    <br>
                                    <button type="submit" class="btn btn-primary float-right">Update Feedback</button>
                                </div>
                            </div>
                    </form>
                    <form action="{{ route('action', $applicant->id) }}" method="POST">
                        @csrf
                        @if ($applicant->round_name == 'level-1')
                            <div class="card-footer">
                                <select name="round" id="rounds" class="col-sm-4">
                                    <option value="{{ config('codetrek.rounds.level-2.slug') }}">{{ config('codetrek.rounds.level-2.label') }}</option>
                                    <option value="{{ config('codetrek.rounds.level-3.slug') }}">{{ config('codetrek.rounds.level-3.label') }}</option>
                                </select>
                                <button type="submit" class="btn btn-success">Take Action</button>
                                <button type="button" class="btn btn-danger">Dropped</button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        @if($applicant->round_name =='level-2' ||$applicant->round_name == 'level-3')
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h2 class="mb-0">
                        <h6>Level-2  <i class="fa fa-info-circle"></i>  {{$applicant->first_name}} {{$applicant->last_name}}</h6>
                        <button class="btn btn-link float-right" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            <i class="fa fa-pencil"></i>
                        </button>
                    </h2>
                </div>
                <div id="collapseTwo" class="collapse {{ $applicant->round_name == 'level-2' ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body">
                        <form action="{{ route('update-feedback', $applicant->id) }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-9">
                                    <input type="hidden" name="round_name" value="level-2">
                                    @php
                                        $feedback = '';
                                        foreach ($roundDetails as $roundDetail) {
                                            if ($roundDetail->round_name == 'level-2') {
                                                $feedback = $roundDetail->feedback;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <textarea class="form-control" id="feedbackTextarea1" name="feedback" rows="5" placeholder="Enter comments">{{ $feedback }}</textarea>
                                    <br>
                                    <button type="submit" class="btn btn-primary float-right">Update Feedback</button>
                                </div>
                            </div>
                        </form>
                        <form action="{{ route('action', $applicant->id) }}" method="POST">
                            @csrf
                            @if ($applicant->round_name == 'level-2')
                                <div class="card-footer">
                                    <select name="round" id="rounds" class="col-sm-4">
                                        <option value="level-3">Move to Level-3</option>
                                    </select>
                                    <button type="submit" class="btn btn-success">Take Action</button>
                                    <button type="button" class="btn btn-danger">Dropped</button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        @endif
        @if($applicant->round_name == 'level-3')
            <div class="card">
                <div class="card-header" id="headingThree">
                    <h2 class="mb-0">
                        <h6>Level-3  <i class="fa fa-info-circle"></i>  {{$applicant->first_name}} {{$applicant->last_name}}</h6>
                        <button class="btn btn-link float-right" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                            <i class="fa fa-pencil"></i>
                        </button>
                    </h2>
                </div>
                <div id="collapseThree" class="collapse {{ $applicant->round_name == 'level-3' ? 'show' : '' }}" aria-labelledby="headingThree" data-parent="#accordionExample">
                    <div class="card-body">
                        <form action="{{ route('update-feedback', $applicant->id) }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-9">
                                    <input type="hidden" name="round_name" value="level-3">
                                    @php
                                        $feedback = '';
                                        foreach ($roundDetails as $roundDetail) {
                                            if ($roundDetail->round_name == 'level-3') {
                                                $feedback = $roundDetail->feedback;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <textarea class="form-control" id="feedbackTextarea1" name="feedback" rows="5" placeholder="Enter comments">{{ $feedback }}</textarea>
                                    <br>
                                    <button type="submit" class="btn btn-primary float-right">Update Feedback</button>
                                </div>
                            </div>
                        </form>
                        <form action="{{ route('action', $applicant->id) }}" method="POST">
                            @csrf
                            @if ($applicant->round_name == 'level-3')
                                <div class="card-footer">
                                    <button type="button" class="btn btn-danger">Dropped</button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 
