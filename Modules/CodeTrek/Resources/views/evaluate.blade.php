@extends('codetrek::layouts.master')
 @section('content')
     @foreach ($roundDetails as $applicantDetail)
         <div class="container d-flex justify-content-around position-relative" id="update_details ">
            @includeWhen(session('success'), 'toast', ['message' => session('success')])
             <div class="accordion col-9" id="accordionExample">
                 <div class="card">
                     <div class="card-header" id="headingOne">
                         <div class="d-flex align-items-center">
                             @foreach (config('codetrek.rounds') as $round)
                                 @if ($applicantDetail->latest_round_name == $round['slug'])
                                     <button class="btn btn-link float-left" type="button" data-toggle="collapse"
                                         data-target="#collapse_{{ $loop->parent->iteration }}" aria-expanded="true"
                                         aria-controls="collapse">
                                         {{ $round['slug'] }} <i class="fa fa-info-circle"></i> {{ $applicant->first_name }}
                                         {{ $applicant->last_name }}
                                     </button>
                                 @endif
                             @endforeach
                             <div class="ml-auto">Started at:-{{ $applicantDetail->start_date }}</div>
                         </div>
                     </div>
                     <div id="collapse_{{ $loop->iteration }}"
                         class="collapse {{ $applicantDetail->id ? ($loop->last ? 'show' : '') : '' }}"
                         aria-labelledby="headingOne" data-parent="#accordionExample">
                         <div class="card-body">
                             <h5 class="mb-3">Applicant Details</h5>
                             <div class="form-row">
                                 <div class="form-group col-md-5">
                                     <label class="text-secondary fz-14 leading-none mb-0.16">Name</label>
                                     <h5>{{ $applicant->first_name }} {{ $applicant->last_name }}</h5>
                                 </div>
                                 <div class="form-group offset-md-1 col-md-5">
                                     <label class="text-secondary fz-14 leading-none mb-0.16">Phone</label>
                                     <h5>{{ $applicant->phone }}</h5>
                                 </div>
                             </div>
                             <div class="form-row">
                                 <div class="form-group col-md-5">
                                     <label class="text-secondary fz-14 leading-none mb-0.16">Email</label>
                                     <h5>{{ $applicant->email }}</h5>
                                 </div>
                                 <div class="form-group offset-md-1 col-md-5">
                                     <label class="text-secondary fz-14 leading-none mb-0.16">University</label>
                                     <h5>{{ $applicant->university }}</h5>
                                 </div>
                             </div>
                             <form action="{{ route('codetrek.update-feedback', $applicantDetail) }}" method="POST">
                                 @csrf
                                 <div class="form-group row">
                                     <div class="col-md-12">
                                         @foreach (config('codetrek.rounds') as $round)
                                             @if ($applicantDetail->latest_round_name == $round['slug'])
                                                 <input type="hidden" name="latest_round_name" value="{{ $round['slug'] }}">
                                                 <textarea class="form-control" id="feedbackTextarea1" name="feedback" rows="6" placeholder="Enter comments">{{ $applicantDetail->feedback }}</textarea>
                                                 <br>
                                                 <button type="submit" class="btn btn-primary float-right">Update
                                                     Feedback</button>
                                             @endif
                                         @endforeach
                                     </div>
                                 </div>
                             </form>
                         </div>
                         @if ($loop->last)
                             <form class = "{{(($applicant->status == 'inactive') || ($applicant->status == 'completed')) ? 'd-none': '' }}" action="{{ route('codetrek.action', $applicant->id) }}" method="POST">
                                 @csrf
                                 <div class="card-footer">
                                     <div class="d-flex align-items-center">
                                         <select name="round" id="rounds" class="w-22p">
                                             @foreach (config('codetrek.rounds') as $round)
                                                 <option value="{{ $round['slug'] }}">Move to {{ $round['label'] }}
                                                 </option>
                                             @endforeach
                                         </select>
                                         <button type="submit" class="btn btn-success ml-2">Take Action</button>
                             </form>
                             <form class = "{{($applicant->status == 'completed') ? 'd-none': '' }}" action="{{ route('codetrek.updateStatus', $applicant->id) }}" method="POST">
                                 @csrf
                                 <button type="submit" name="action" value="completed" class="btn btn-dark ml-2 {{$applicant->latest_round_name != 'onboarded' ? 'd-none': '' }}">Start
                                     Internship</button>
                                <button type="submit" name="action" value="{{ $applicant->status == "active"? "inactive" : "active" }}" class="btn btn-{{ $applicant->status == "active" ? "danger" : "info" }} ml-1">
                                    Mark {{ ucfirst($applicant->status == "active" ? "inactive" : "active") }} </button>  
                             </form>
                     </div>
                 </div>
     @endif
     </div>
     </div>
     <br>
     </div>
     </div>
     @endforeach
 @endsection
