@extends('layouts.app')
@section('content')
<div class="container">
@include('status', ['errors' => $errors->all()])
<div class="card">
    <div class="card-header">
       Edit Slot
    </div>

    <div class="card-body">
        <form action="{{ route("hr.slots.update",$slot->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="row">
            <div class="form-group col">
                <label for="start_time">Start Time*</label>
                <input type="datetime-local" id="start_time" name="start_time" class="form-control " value="{{ $slot->starts_at}}" required>
            </div>
            <div class="form-group col">
                <label for="end_time">End time*</label>
                <input type="datetime-local" id="end_time" name="end_time" class="form-control" value="{{ $slot->ends_at }}" required>
            </div>
            </div>
            <div>
                <input class="btn btn-success" type="submit" value="Update">
            </div>
        </form><br>
        <form action="{{ route("hr.slots.delete",$slot->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('delete')
                    <input type="submit" class='btn btn-danger' value="Delete">
        </form>

    </div>
</div>
</div>
@endsection

@section('js_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" integrity="sha256-5YmaxAwMjIpMrVlK84Y/+NjCpKnFYa8bWWBbUHSBGfU=" crossorigin="anonymous"></script>
<script>

    const start_time_input=document.getElementById('start_time');
    const end_time_input=document.getElementById('end_time');
    window.onload = function() {
        start_time_input.value=moment('{!! $slot->starts_at!!}').format('YYYY-MM-DDTHH:mm')
        end_time_input.value=moment('{!! $slot->ends_at!!}').format('YYYY-MM-DDTHH:mm')
        };
</script>
@endsection