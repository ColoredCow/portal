<div class="modal fade" id="prospect_schedule_meeting_form">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Schedule a meeting with {{ $prospect->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <form action="{{ route('prospect.meeting.store', $prospect) }}" method="POST"> 
            @csrf
            <div class="modal-body">
            
                    <div class="form-row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="" class="field-required"> Start date</label>
                                <input type="datetime-local" value="" class="form-control" name="meeting_start_date">
                            </div>

                            <div class="form-group">
                                <label for="">Event Name</label>
                                <textarea value="" rows="1" class="form-control" name="meeting_summary"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="name" >Organiser:</label>
                                <div class="font-weight-bold">{{ optional($prospect->assignTo)->name }}</div>
                            </div> 

                        </div>

                        <div class="col-md-5 offset-md-1">
                            <div class="form-group">
                                <label for="" class="field-required"> End date</label>
                                <input type="datetime-local" value="" class="form-control" name="meeting_end_date">
                            </div>

                            <br>

                            <div class="form-group">
                                <label for="name" >Client contacts for meeting</label>
                                @foreach ($prospect->contactPersons as $contactPerson)
                                    <div>
                                        <input checked type="checkbox" name="prospect_contact_persons[]" value="{{ $contactPerson->id }}" >
                                        <span> {{ $contactPerson->name  }} <span class="text-muted">({{ $contactPerson->email }})</span></span>
                                    </div>
                                @endforeach
                            </div> 
                        </div>
                    </div>
             
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info text-white">Schedule</button>
                <button type="button" data-dismiss="modal" class="btn btn-light">Cancel</button>
            </div>
        </form>
        </div>
    </div>
</div>