<div class="modal fade" id="createSlotsModal">
    <div class="modal-dialog">
        <div class="modal-content" id="create_slots">
            <form action="{{route("userappointmentslots.store") }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h4>Create New Slot</h4>
                    <div  class="{{(auth()->id()!=$user->id)?'d-none':''}}">
                        <a id="google-calendar-link" value="{{config('appointmentslots.google_calendar.url')}}"target="_blank">Google Calendar</a>
                    </div>
                </div>
                <div class="modal-body">
                <div id="create_errors">
                    @include('status', ['errors' => $errors->all()])
                </div>
                    <div class="row">
                    <div class="form-group col ">
                        <label for="start_time">Start Time<span class="text-danger">*</span></label>
                        <input type="datetime-local" id="start_time" name="start_time" class="form-control "
                            value="{{ old('start_time')}}" required>
                    </div>


                    <div class="form-group col">
                        <label for="end_time">End Time<span class="text-danger">*</span></label>
                        <input type="datetime-local" id="end_time" name="end_time" class="form-control "
                            value="{{ old('end_time') }}" required>
                    </div>

                </div>
                <input type="hidden" value="{{$user->id}}" id="user_id" name="user_id"/>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="recurrence">Recurrence<span class="text-danger">*</span></label>
                        <select class="form-control" name="recurrence" id="recurrence">
                            <option value="none" {{ old('recurrence')==='none' ? 'selected' : '' }}>None</option>
                            <option value="daily" {{ old('recurrence')==='daily' ? 'selected' : '' }}>Daily</option>
                            <option value="weekly" {{ old('recurrence')==='weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="monthly" {{ old('recurrence')==='monthly' ? 'selected' : '' }}>Monthly</option>
                        </select>
                    </div>

                    <div class="form-group col d-none" id="repeat_date_field">
                        <label for="repeat_till">Repeat slot till<span class="text-danger">*</span></label>
                        <input type="date" id="repeat_till" name="repeat_till" class="form-control"
                            value="{{ old('repeat_till') }}">
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
