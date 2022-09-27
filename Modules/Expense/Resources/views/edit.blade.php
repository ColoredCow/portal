@extends('expense::layouts.master')

@section('content')
    <div class="container" id="expenses">
        <br/>
        <div class="d-flex justify-content-between mb-2">
            <h4 class="mb-1 pb-1 fz-28">Editn Expense</h4>
        </div>
        <div class="card">
            <form action="{{ route('expense.update',$expense[0]['id']) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-header">
                    <span>Expenses Details</span>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="name" class="field-required">Name</label>
                            <input type="text" class="form-control" value="{{$expense[0]['name']}}" name="name" id="name" required>
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                            <label for="status" class="field-required">Status</label>
                            <select class="form-control" name="status">
                                <option value="pending"{{$expense[0]['status'] == 'pending' ? 'selected' : '' }}>Pending</option> 
                                <option value="paid"{{$expense[0]['status'] == 'paid' ? 'selected' : '' }}>Paid</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row ">

                        <div class="form-group  col-md-5">
                            <label class="field-required">Amount</label>
                            <div class="input-group">
                                <div class=" input-group-prepend">
                                    <select name="currency" name="currency" class="input-group-text">
                                        @foreach (config('constants.countries') as $country => $countryDetails)
                                            <option value="{{ $countryDetails['currency'] }}"{{$expense[0]['currency'] == $countryDetails['currency']  ? 'selected' : '' }}>
                                                {{ $countryDetails['currency'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="number" required  value="{{$expense[0]['amount']}}" 
                                class="form-control" name="amount">
                            </div>
                        </div>

                        <div class="form-group offset-md-1 col-md-5">
                            <label for="paid_on">Paid On</label>
                            <input type="date" class="form-control" name="paid_at" id="paidAt"
                                value={{ date('Y-m-d') }}>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="category" class="field-required">Category</label>
                            <select class="form-control"  value="{{$expense[0]['category']}}" name="category">
                                <option value="">Select Category</option>
                                @foreach (config('expense.categories') as $key => $value)
                                    <option value="{{ $key }}"{{$expense[0]['category'] == $key ? 'selected' : '' }}>
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                            <label for="location" class="field-required">Location</label>
                            <select class="form-control"  value="{{$expense[0]['location']}}" name="location">
                                <option value="disabled">Select Location</option>
                                @foreach (config('constants.office_locations') as $office => $location)
                                    <option value="{{ $office }}"{{$expense[0]['location'] == $office ? 'selected' : '' }}>
                                        {{ $location }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <hr> 
                    @foreach ($expenseFile as $document )
                        <div class="documents">
                            <div class="row mb-3 bg bg-grey pt-2">
                                <div class="col-5">
                                    <label for="document"> {{ __('Upload Document') }}</label>
                                    <div class="custom-file mb-3">
                                        <input type="file" id="document_file" name="documents[{{$document->id}}][file]" class="custom-file-input">
                                        <label for="customFile0" value="}" class="custom-file-label overflow-hidden">Choose file</label>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <label for="document"> {{ __('Document Type') }}</label>
                                    <select class="form-control" name="documents[{{$document->id}}][type]">
                                        <option value="">Select Type</option>
                                        @foreach (config('expense.type_of_documents') as $key => $value)
                                            <option value="{{ $key }}" {{ $document['file_type'] == $key ? 'selected' : '' }}>
                                                {{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-1 mt-5 mr-1">
                                    <button type="button" id="remove" 
                                    class="btn btn-danger btn-sm remove_btn mt-1 ml-2 text-white fz-14">Remove</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div>
                        <span class="text-underline add_btn btn" id="add">Add More Documents</span>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary" id="save-btn-action">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
