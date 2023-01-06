<div class="modal fade" id="editLocationsModal" tabindex="-1" role="dialog" aria-labelledby="editLocationsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLocationsModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <div class="modal-body">
            <form class="needs-validation" novalidate action="">
                <div class="form-group">
                    <label for="locationName">Location</label>
                    <input type="text" class="form-control" id="locationName" placeholder="Enter location">
                </div>
                <div class="form-group">
                    <label for="locationCenterHead">Center Head</label>
                    <select class="custom-select" name="locationCenterHead" id="locationCenterHead">
                        <option selected="">Choose a center head</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="locationCapacity">Capacity</label>
                    <input type="number" class="form-control" id="locationCapacity" placeholder="Enter capacity">
                </div>
            </form>

        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>
