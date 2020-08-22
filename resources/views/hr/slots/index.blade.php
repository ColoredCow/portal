@extends('layouts.app')
@section('css_scripts')
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />
@endsection
@section('content')
<div class="container">
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{route("hr.slots.create")}}">
                Add New Slot
            </a>
        </div>
    </div>   
    
<h3 class="page-title"></h3>
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

@section('js_scripts')
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
<script>
    $(document).ready(function () {
            events={!! json_encode($slots) !!};
            $('#calendar').fullCalendar({
                selectable: true,
                timeFormat:    'h:mmA',
                displayEventEnd: true,
                events: events,
            })
        });
</script>
@endsection