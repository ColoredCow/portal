@extends('expense::layouts.master')

@section('content')
    <div class="container" id="expenses">
        <br />
        <div class="d-flex justify-content-between mb-2">
            <h4 class="mb-1 pb-1 fz-28">Add New Expense</h4>
        </div>
        <div class="card">
            <form action="{{ route('expense.store') }}" method="POST">
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
                            <label for="status" class="field-required">Status</label>
                            <select class="form-control" name="status">
                                <option value="pending">Pending</option>
                                <option value="paid">Paid</option>
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
                                            <option value="{{ $countryDetails['currency'] }}">
                                                {{ $countryDetails['currency'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="number" required class="form-control" name="amount">
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
                            <select class="form-control" name="category">
                                <option value="">Select Category</option>
                                @foreach (config('expense.categories') as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach

                            </select>

                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                            <label for="location" class="field-required">Location</label>
                            <select class="form-control" name="location">
                                <option value="">Select Location</option>
                                @foreach (config('constants.office_locations') as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach

                            </select>
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
