@extends('layouts.app')
@section('content')
<div class="container" id="create_slots">
    @include('status', ['errors' => $errors->all()])
    <div class="card">
        <div class="card-header">
            Create New Slot
        </div>
        <div class="card-body">
            <form action="{{route("hr.slots.store") }}" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col ">
                        <label for="starts_at">Start Time<span class="text-danger">*</span></label>
                        <input type="datetime-local" id="starts_at" name="starts_at" class="form-control "
                            value="{{ old('starts_at')}}" required>
                    </div>

                    <div class="form-group col">
                        <label for="ends_at">End Time<span class="text-danger">*</span></label>
                        <input type="datetime-local" id="ends_at" name="ends_at" class="form-control "
                            value="{{ old('ends_at') }}" required>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="recurrence">Recurrence<span class="text-danger">*</span></label>
                        <select class="form-control" name="recurrence" id="recurrence"
                            >
                            <option value="none" {{ old('recurrence')==='none' ? 'selected' : '' }}>None</option>
                            <option value="weekly" {{ old('recurrence')==='weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="monthly" {{ old('recurrence')==='monthly' ? 'selected' : '' }}>Monthly
                            </option>
                        </select>
                    </div>

                    <div class="form-group col" id="repeat_date_field" style="display:none;">
                        <label for="repeat_till">Repeat slot till<span class="text-danger">*</span></label>
                        <input type="date" id="repeat_till" name="repeat_till" class="form-control"
                            value="{{ old('repeat_till', isset($slot) ? $slot->repeat_till : '') }}">
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