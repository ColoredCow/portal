<div class="modal fade" id="editReason{{$data->id, $data->value , $data->hr_job_id}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Give Reason:</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('response.edit', [$data->id, $data->hr_job_id]) }}" method="POST" id="responseForm">
                @csrf
                <div class="modal-body">
                    <textarea name="body" rows="10" class="form-control"
                        placeholder="Why do you think this is a desired resume?" value="" required>{{$data->value ??='';}}</textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="responseBtn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
placeholder="{{$data->value ??='Why do you think this is a desired resume?';}}" required></textarea>
