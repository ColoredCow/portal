@extends('operations::layouts.master')

@section('content')
    <div class="container">
        <div id="editCentreModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editCentreModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg mx-auto" role="document">
                <div class="modal-content">
                    <form action="{{ route('office-location.update', $centre->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCentreModalLabel"><strong>Edit Centre</strong></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="centreName" class="field-required">Centre Name</label>
                                    <input type="text" class="form-control" name="centre_name" id="centreName" placeholder="Centre Name" required="required" value="{{ $centre->centre_name }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="centreHead" class="field-required">Centre Head</label>
                                    <select v-model="location" name="centre_head" id="centreHead" class="form-control" required>
                                        <option value="">Select centre head</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ $user->id == $centre->centre_head->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="capacity" class="field-required">Capacity</label>
                                    <input type="number" class="form-control" name="capacity" id="capacity" placeholder="Enter Capacity" required="required" value="{{ $centre->capacity }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="currentPeopleCount" class="field-required">Current People Count</label>
                                    <input type="number" class="form-control" name="current_people_count" id="currentPeopleCount" placeholder="Enter current people" required="required" value="{{ $centre->current_people_count }}">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="redirectToIndex()">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#editCentreModal').modal('show');
        });

        function redirectToIndex() {
            window.location.href = "{{ route('office-location.index') }}";
        }
    </script>
@endsection
