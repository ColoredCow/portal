 @extends('codetrek::layouts.master')
 @section('content')
     @foreach ($roundDetails as $roundDetail)
         <div class="container d-flex justify-content-around position-relative" id="update_details ">
             <div class="accordion col-9" id="accordionExample">
                 <div class="card">
                     <div class="card-header" id="headingOne">
                         <div class="d-flex align-items-center">
                             @if ($roundDetail->round_name == config('codetrek.rounds.level-1.slug'))
                                 <button class="btn btn-link float-left" type="button" data-toggle="collapse"
                                     data-target="#collapse_{{ $loop->iteration }}" aria-expanded="true"
                                     aria-controls="collapseOne">
                                     Level-1 <i class="fa fa-info-circle"></i> {{ $applicant->first_name }}
                                     {{ $applicant->last_name }}
                                 </button>
                             @elseif ($roundDetail->round_name == config('codetrek.rounds.level-2.slug'))
                                 <button class="btn btn-link float-left" type="button" data-toggle="collapse"
                                     data-target="#collapse_{{ $loop->iteration }}" aria-expanded="true"
                                     aria-controls="collapseOne">
                                     Level-2 <i class="fa fa-info-circle"></i> {{ $applicant->first_name }}
                                     {{ $applicant->last_name }}
                                 </button>
                             @elseif ($roundDetail->round_name == config('codetrek.rounds.level-3.slug'))
                                 <button class="btn btn-link float-left" type="button" data-toggle="collapse"
                                     data-target="#collapse_{{ $loop->iteration }}" aria-expanded="true"
                                     aria-controls="collapseOne">
                                     Level-3 <i class="fa fa-info-circle"></i> {{ $applicant->first_name }}
                                     {{ $applicant->last_name }}
                                 </button>
                             @elseif ($roundDetail->round_name == config('codetrek.rounds.onboard.slug'))
                                 <button class="btn btn-link float-left" type="button" data-toggle="collapse"
                                     data-target="#collapse_{{ $loop->iteration }}" aria-expanded="true"
                                     aria-controls="collapseOne">
                                     Onboard <i class="fa fa-info-circle"></i> {{ $applicant->first_name }}
                                     {{ $applicant->last_name }}
                                 </button>
                             @endif
                             <div class="ml-auto">Started at:-{{ $roundDetail->start_date }}</div>
                         </div>
                     </div>
                     <div id="collapse_{{ $loop->iteration }}"
                         class="collapse {{ $roundDetail->id ? ($loop->last ? 'show' : '') : '' }}"
                         aria-labelledby="headingOne" data-parent="#accordionExample">
                         <div class="card-body">
                             <h4 class="mb-3">Applicant Details</h4>
                             <div class="form-row">
                                 <div class="form-group col-md-5">
                                     <label class="text-secondary fz-14 leading-none mb-0.16">Name</label>
                                     <h4>{{ $applicant->first_name }} {{ $applicant->last_name }}</h4>
                                 </div>
                                 <div class="form-group offset-md-1 col-md-5">
                                     <label class="text-secondary fz-14 leading-none mb-0.16">Phone</label>
                                     <h4>{{ $applicant->phone }}</h4>
                                 </div>
                             </div>
                             <div class="form-row">
                                 <div class="form-group col-md-5">
                                     <label class="text-secondary fz-14 leading-none mb-0.16">Email</label>
                                     <h4>{{ $applicant->email }}</h4>
                                 </div>
                                 <div class="form-group offset-md-1 col-md-5">
                                     <label class="text-secondary fz-14 leading-none mb-0.16">University</label>
                                     <h4>{{ $applicant->university }}</h4>
                                 </div>
                             </div>
                             <form action="{{ route('codetrek.update-feedback', $applicant->id) }}" method="POST">
                                 @csrf
                                 <div class="form-group row">
                                     <div class="col-md-12">
                                         @if ($roundDetail->round_name == config('codetrek.rounds.level-1.slug'))
                                             <input type="hidden" name="round_name" value="level-1">
                                             <input type="hidden" name="primary_id" value="{{ $roundDetail->id }}">
                                             <textarea class="form-control" id="feedbackTextarea1" name="feedback" rows="6" placeholder="Enter comments">{{ $roundDetail->feedback }}</textarea>
                                         @elseif ($roundDetail->round_name == config('codetrek.rounds.level-2.slug'))
                                             <input type="hidden" name="round_name" value="level-2">
                                             <input type="hidden" name="primary_id" value="{{ $roundDetail->id }}">
                                             <textarea class="form-control" id="feedbackTextarea1" name="feedback" rows="6" placeholder="Enter comments">{{ $roundDetail->feedback }}</textarea>
                                         @elseif ($roundDetail->round_name == config('codetrek.rounds.level-3.slug'))
                                             <input type="hidden" name="round_name" value="level-3">
                                             <input type="hidden" name="primary_id" value="{{ $roundDetail->id }}">
                                             <textarea class="form-control" id="feedbackTextarea1" name="feedback" rows="6" placeholder="Enter comments">{{ $roundDetail->feedback }}</textarea>
                                         @elseif ($roundDetail->round_name == config('codetrek.rounds.onboard.slug'))
                                             <input type="hidden" name="round_name" value="onboard">
                                             <input type="hidden" name="primary_id" value="{{ $roundDetail->id }}">
                                             <textarea class="form-control" id="feedbackTextarea1" name="feedback" rows="6" placeholder="Enter comments">{{ $roundDetail->feedback }}</textarea>
                                         @endif
                                         <br>
                                         <button type="submit" class="btn btn-primary float-right">Update
                                             Feedback</button>
                                     </div>
                                 </div>
                             </form>
                         </div>
                         @if ($loop->last)
                             <form action="{{ route('codetrek.action', $applicant->id) }}" method="POST">
                                 @csrf
                                 <div class="card-footer">
                                     <select name="round" id="rounds" class="w-22p">
                                         <option value="{{ config('codetrek.rounds.level-1.slug') }}">
                                             {{ config('codetrek.rounds.level-1.label') }}</option>
                                         <option value="{{ config('codetrek.rounds.level-2.slug') }}">
                                             {{ config('codetrek.rounds.level-2.label') }}</option>
                                         <option value="{{ config('codetrek.rounds.level-3.slug') }}">
                                             {{ config('codetrek.rounds.level-3.label') }}</option>
                                         <option value="{{ config('codetrek.rounds.onboard.slug') }}">
                                             {{ config('codetrek.rounds.onboard.label') }}</option>
                                     </select>
                                     <button type="submit" class="btn btn-success">Take Action</button>
                                     <button type="button" class="btn btn-danger">Marked Inactive</button>
                                 </div>
                             </form>
                         @endif
                     </div>
                 </div>
                 <br>
             </div>
         </div>
     @endforeach
 @endsection
