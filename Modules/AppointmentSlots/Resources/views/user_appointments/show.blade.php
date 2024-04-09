@extends('appointmentslots::layouts.master')

@section('content')
<div class="container" id='show_slots'>
    <div  class="justify-content-between d-flex mb-3">
        <div class="p-2">
            @if($user->id!=auth()->id())
             <a class="text-secondary" href="{{route("userappointmentslots.show",auth()->id())}}"><i class="fa fa-backward"></i> See Your Appointments</a>
            @endif
        </div>
        <div class="p-2 dropdown">
        @can('employee_appointmentslots.view')
            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Employee Slots
            </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        @foreach($users as $notLoggedInUser)
                            @if($notLoggedInUser->id != auth()->id())
                                <a class="dropdown-item" href="{{route("userappointmentslots.show",$notLoggedInUser->id)}}">{{$notLoggedInUser->name}}</a>
                            @endif
                        @endforeach

                </div>
        </div>
        @endcan
    </div>

@includeWhen($errors->has('edit_start_time') || $errors->has('edit_end_time'),'status',['errors'=>$errors->all()])

<input type="hidden" value="{{json_encode($slots)}}" id="slots_value"/>
<div class="card">
    <div class="card-header">
    <strong>
       @if($user->id==auth()->id())
            Your
        @else
           <img src="{{$user->avatar}}" class="user-avatar w-25 h-25 rounded-circle mr-1">
            {{$user->name}}
       @endif
       </strong>
       Calendar
    </div>
    <div class="card-body">
       <div class="mt-2" id='calendar' ></div>
    </div>
</div>
</div>
@include('appointmentslots::user_appointments.create-modal')
@include('appointmentslots::user_appointments.edit-modal')
@if($errors->has('start_time') || $errors->has('end_time') || $errors->has('repeat_till') || $errors->has('recurrence') || $errors->has('user_id'))
   <input type="hidden" id="show_create_modal">
@endif
@endsection
