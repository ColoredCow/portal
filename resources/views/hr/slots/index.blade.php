@extends('layouts.app')
@section('content')
<div class="container" id='show_slots'>
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{route("hr.slots.create")}}">
                Add New Slot
            </a>
        </div>
    </div>   
    @include('status', ['errors' => $errors->all()])
<h3 class="page-title"></h3>
<input type="hidden" value="{{json_encode($slots)}}" id="slots_value"/>
<div class="card">
    <div class="card-header">
        System Calendar
    </div>
    <div class="card-body">
        <div id='calendar' ></div>
    </div>
</div> 
</div>
@endsection