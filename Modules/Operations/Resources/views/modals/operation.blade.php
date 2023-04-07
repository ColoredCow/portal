@section('popup',' Add new centre')

<button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#photoGallery">
    <a><i class="fa fa-plus"></i>@yield('popup')</a>
</button>

<div class="modal fade" id="photoGallery" tabindex="-1" role="dialog" aria-labelledby="photoGalleryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong>Add new center</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="centre_name" class="field-required">Center Name</label>
                            <input type="text" class="form-control" name="center_name" id="centretName" placeholder="Enter Center name" required="required" value="">
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                            <label for="centre_head" class="field-required">Center Head</label>
                            <select class="form-control" name="center_head" id="centerHead" required="required">
                                <option value="">Select Center Head</option>
                                <option value="Ranchi">Ranchi</option>
                                <option value="Tehri">Tehri</option>
                                <option value="Gurugram">Gurgaon</option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="capacity" class="field-required">Capacity</label>
                            <input type="number" class="form-control" name="capacity_" id="capacity" placeholder="Enter Capacity" required="required" value="">
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                            <label for="phone">Current people count</label>
                            <input type="number" class="form-control" name="current_people" id="currentPeopleCount" placeholder="Enter Current People" maxlength="10" value="">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary" id="save-btn-action">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
