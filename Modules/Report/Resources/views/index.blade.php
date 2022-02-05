@extends('report::layouts.master')
@section('content')
<div class="container" id="vueContainer">
    <br>
    <div class="d-flex">
        <h4 class="d-inline-block">Sales & Marketing Reports</h4>
        <button type="button" class="btn btn-primary ml-auto" data-bs-toggle="modal" data-bs-target="#Modal">
            Add Report
        </button>
        <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Report</h4>
                        <button type="button" class="btn-close ml-auto" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="#">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 col-form-label">Name<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" placeholder="Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="textarea" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="textarea" rows="3" placeholder="Description"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-sm-2 col-form-label">Type</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="type" id="type" value="Sales and Marketing">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="url" class="col-sm-6 col-form-label">
                                    Embedded URL<span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="url" class="form-control" id="url" placeholder="Embedded URL">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary mr-auto" data-bs-dismiss="modal">Submit</button>
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header" data-toggle="collapse">
            <h4>Sales and Marketing Reports <span>(Coming soon...)</span></h4>
        </div>
    </div>
</div>
@endsection