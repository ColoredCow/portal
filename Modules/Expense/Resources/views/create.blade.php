@extends('expense::layouts.master')

@section('content')
    <div class="container" id="expenses">
        <br />
        <div class="d-flex justify-content-between mb-2">
            <h4 class="mb-1 pb-1 fz-28">Add New Expense</h4>
        </div>
        <div class= "card">
            <form action="{{ route('expense.storeData') }}" method="Post">
                @csrf
                <div class="card-header">
                    <span>Expenses Details</span>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="name" class="field-required">Name</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                            <label for="amount" class="field-required">Amount</label>
                            <input type="number" class="form-control" name="amount" id="amount" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="status" class="field-required">Status</label>
                            <input type="text" class="form-control" name="status" id="status" required>
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                            <label for="paid_on">Paid On</label>
                            <input type="date" class="form-control" name="paid_on" id="paidOn">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="category" class="field-required">Category</label>
                            <input type="text" class="form-control" name="category" id="category" required>
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                            <label for="location" class="field-required">Location</label>
                            <input type="text" class="form-control" name="location" id="location" required>
                        </div>            
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="upload_image"> {{ __('Upload Image') }}</label>
                            <div class="custom-file">
                                <input type="file" id="upload_image" name="upload_image" class="custom-file-input">
                                <label for="image" class="custom-file-label">Choose image</label>
                            </div>
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                            <label for="upload_pdf"> {{ __('Upload Pdf') }}</label>
                            <div class="custom-file">
                                <input type="file" id="upload_pdf" name="upload_pdf" class="custom-file-input">
                                <label for="pdf" class="custom-file-label">Choose pdf</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="uploaded_by" class="field-required">Uploaded By</label>
                            <input type="text" class="form-control" name="uploaded_by" id="uploaded_by" required>
                        </div>
                    </div> 
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary" id="save-btn-action">Save</button>
                </div>    
            </form>
        </div>
    </div>
    @endsection
    