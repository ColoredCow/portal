@section('popup', ' Add new Centre')

<button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#addCentreModal">
    <i class="fa fa-plus"></i>@yield('popup')
</button>

<div id="add_centre_details_form">
    <div class="modal fade" id="addCentreModal" tabindex="-1" role="dialog" aria-labelledby="addCentreModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg mx-auto" role="document">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title"><strong>Add new Centre</strong></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="centreName" class="field-required">Centre Name</label>
                                <input type="text" class="form-control" name="centre_name" id="centreName" placeholder="Centre Name" required="required" value="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="centreHead" class="field-required">Centre Head</label>
                                <select v-model="location" name="centre_head" id="centreHead" class="form-control" required>
                                    <option value="">Select centre head</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="capacity" class="field-required">Capacity</label>
                                <input type="number" class="form-control" name="capacity" id="capacity" placeholder="Enter Capacity" required="required" value="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="currentPeopleCount" class="field-required">Current People Count</label>
                                <input type="number" class="form-control" name="current_people_count" id="currentPeopleCount" placeholder="Enter current people" required="required" value="">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" id="save-btn-action">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
