@extends('layouts.app')
@section('content')
<div class="container">
@include('status', ['errors' => $errors->all()])
<div class="card">
    <div class="card-header">
       Create New Slot
    </div>
    <div class="card-body">
        <form action="{{ route("hr.slots.store") }}" method="POST" >
            @csrf
            <div class="row">
                <div class="form-group col ">
                    <label for="start_time">Start Time<span class="text-danger">*</span></label>
                    <input type="datetime-local" id="start_time" name="start_time" class="form-control " value="{{ old('start_time')}}" required>
                </div>
    
                <div class="form-group col">
                    <label for="end_time">End Time<span class="text-danger">*</span></label>
                    <input type="datetime-local" id="end_time" name="end_time" class="form-control " value="{{ old('end_time') }}" required>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                <label for="recurrence">Recurrence<span class="text-danger">*</span></label>
                    <select class="form-control" name="recurrence" id="recurrence" onclick="javascript:showEndDateField();">
                        <option value="none" {{ old('recurrence') === 'none' ? 'selected' : '' }}>None</option>
                        <option value="weekly" {{ old('recurrence') === 'weekly' ? 'selected' : '' }}>Weekly</option>
                        <option value="monthly"{{ old('recurrence') === 'monthly' ? 'selected' : '' }} >Monthly</option>
                    </select>
                </div>

                <div class="form-group col" id="repeat_date_field" style="display:none;" >
                    <label for="repeat_till">Repeat slot till<span class="text-danger">*</span></label>
                    <input type="date" id="repeat_till" name="repeat_till" class="form-control" value="{{ old('repeat_till', isset($slot) ? $slot->repeat_till : '') }}" >
                </div>
            </div>

            <div>
                <input class="btn btn-success" type="submit" value="Save">
            </div>
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
    const repeat_till_input=document.getElementById('repeat_date_field');
    const recurrence_input=document.getElementById('recurrence');
    start_time_input.addEventListener('blur',runEvent);
    function runEvent(e){
        end_time_input.value=moment(e.target.value).add(30, 'm').format('YYYY-MM-DDTHH:mm');
    }
    
    function showEndDateField(){
        if(recurrence_input.value=='none'){
            repeat_till_input.style.display='none';
        }else{
            repeat_till_input.style.display='block';
        }
    }
</script>
@endsection