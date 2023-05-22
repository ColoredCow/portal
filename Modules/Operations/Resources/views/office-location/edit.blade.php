<div class="modal fade" id="edit-center-modal-{{ $centre->id }}" tabindex="-1" role="dialog" aria-labelledby="edit-center-modal-label-{{ $centre->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-center-modal-label-{{ $centre->id }}">Edit Centre</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('office-location.update', $centre->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="centre-name">Centre Name</label>
                        <input type="text" class="form-control" id="centre-name" name="centre_name" value="{{ $centre->centre_name }}">
                    </div>
                    <div class="form-group">
                        <label for="centre-head">Centre Head</label>
                        <select class="form-control" id="centre-head" name="centre_head">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $user->id == $centre->centre_head_id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="capacity">Capacity</label>
                        <input type="number" class="form-control" id="capacity" name="capacity" value="{{ $centre->capacity }}">
                    </div>
                    <div class="form-group">
                        <label for="current-people-count">Current People Count</label>
                        <input type="number" class="form-control" id="current-people-count" name="current_people_count" value="{{ $centre->current_people_count }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
