 @extends('codetrek::layouts.master')
 @section('content')
     <div class="container d-flex justify-content-around" id="update_details ">
         <div class="accordion col-9" id="accordionExample">
             <div class="container">
                 <div class="card">
                     <div class="card-header" id="headingOne">
                         <h2 class="mb-0">
                             <button class="btn btn-link float-left" type="button" data-toggle="collapse"
                                 data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                 Level-1 <i class="fa fa-info-circle"></i> {{ $applicant->first_name }}
                                 {{ $applicant->last_name }}
                             </button>
                             <i class="fa fa-angle-down float-right"></i>
                         </h2>
                     </div>
                     <div id="collapseOne" class="collapse {{ $applicant->round_name == 'level-1' ? 'show' : '' }}"
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
                                         <textarea class="form-control" id="feedbackTextarea1" name="feedback" rows="6" placeholder="Enter comments">{{ $feedback }}</textarea>
                                         <br>
                                         <button type="submit" class="btn btn-primary float-right">Update Feedback</button>
                                     </div>
                                 </div>
                             </form>
                         </div>
                         <form action="{{ route('codetrek.action', $applicant->id) }}" method="POST">
                             @csrf
                             @if ($applicant->round_name == 'level-1')
                                 <div class="card-footer">
                                     <select name="round" id="rounds" class="w-22p">
                                         <option value="level-2">Move to Level 2</option>
                                         <option value="level-3">Move to Level 3</option>
                                     </select>
                                     <button type="submit" class="btn btn-success">Take Action</button>
                                     <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirm-delete">Dropped</button>
                                 </div>
                             @endif
                         </form>
                     </div>
                 </div>
                 <br>
             </div>
             <div class="container">
                 <div>
                     @if ($applicant->round_name == 'level-2' || $applicant->round_name == 'level-3')
                         <div class="card">
                             <div class="card-header" id="headingTwo">
                                 <h2 class="mb-0">
                                     <button class="btn btn-link float-left" type="button" data-toggle="collapse"
                                         data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                         Level-2 <i class="fa fa-info-circle"></i> {{ $applicant->first_name }}
                                         {{ $applicant->last_name }}
                                     </button>
                                     <i class="fa fa-angle-down float-right"></i>
                                 </h2>
                             </div>
                             <div id="collapseTwo" class="collapse {{ $applicant->round_name == 'level-2' ? 'show' : '' }}"
                                 aria-labelledby="headingTwo" data-parent="#accordionExample">
                                 <div class="card-body">
                                     <form action="{{ route('codetrek.update-feedback', $applicant->id) }}" method="POST">
                                         @csrf
                                         <div class="form-group row">
                                             <div class="col-md-12">
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
                                                 <textarea class="form-control" id="feedbackTextarea1" name="feedback" rows="5" placeholder="Enter comments">{{ $feedback }}</textarea><br>
                                                 <button type="submit" class="btn btn-primary float-right">Update
                                                     Feedback</button>
                                             </div>
                                         </div>
                                     </form>
                                 </div>
                                 <form action="{{ route('codetrek.action', $applicant->id) }}" method="POST">
                                     @csrf
                                     @if ($applicant->round_name == 'level-2')
                                         <div class="card-footer">
                                             <select name="round" id="rounds" class="w-10p">
                                                 <option value="level-1">Move to Level-1</option>
                                                 <option value="level-3">Move to Level-3</option>
                                             </select>
                                             <button type="submit" class="btn btn-success">Take Action</button>
                                             <button type="button" class="btn btn-danger">Dropped</button>
                                         </div>
                                     @endif
                                 </form>
                             </div>
                         </div>
                     @endif
                 </div>
                 <br>
             </div>
             <div class="container">
                 @if ($applicant->round_name == 'level-3')
                     <div class="card">
                         <div class="card-header" id="headingThree">
                             <h2 class="mb-0">
                                 <button class="btn btn-link float-left" type="button" data-toggle="collapse"
                                     data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                     Level-3 <i class="fa fa-info-circle"></i> {{ $applicant->first_name }}
                                     {{ $applicant->last_name }}

                                 </button>
                                 <i class="fa fa-angle-down float-right"></i>
                             </h2>
                         </div>
                         <div id="collapseThree" class="collapse {{ $applicant->round_name == 'level-3' ? 'show' : '' }}"
                             aria-labelledby="headingThree" data-parent="#accordionExample">
                             <div class="card-body">
                                 <form action="{{ route('codetrek.update-feedback', $applicant->id) }}" method="POST">
                                     @csrf
                                     <div class="form-group row">
                                         <div class="col-md-12">
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
                                             <button type="submit" class="btn btn-primary float-right">Update
                                                 Feedback</button>
                                         </div>
                                     </div>
                                 </form>
                             </div>
                             <form action="{{ route('codetrek.action', $applicant->id) }}" method="POST">
                                 @csrf
                                 @if ($applicant->round_name == 'level-3')
                                     <div class="card-footer">
                                         <select name="round" id="rounds" class="w-10p">
                                             <option value="level-1">Move to Level-1</option>
                                             <option value="level-2">Move to Level-2</option>
                                         </select>
                                         <button type="submit" class="btn btn-success">Take Action</button>
                                         <button type="button" class="btn btn-danger">Dropped</button>
                                     </div>
                         </div>
                 @endif
                 </form>
             </div>
             @endif
         </div>
     </div>
     </div>
 @endsection
