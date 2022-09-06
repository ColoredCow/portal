@extends('expense::layouts.master')

@section('content')
    <div class="container" id="expenses">
        <br />
        <div class="d-flex justify-content-between mb-2">
            <h4 class="mb-1 pb-1 fz-28">Setup New Recurring Expenses</h4>
        </div>
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <form action="{{ route('expense.recurring.store') }}" method="POST">
            @csrf
            <div class="card">
                <div id="create_recurring_expenses">
                    <div class="card-body">
                        <div class="form-row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="status" id="status" value="active" />
                                </div>

                                <div class="form-group">
                                    <label for="name" class="field-required">Name</label>
                                    <input name="name" id="name" type="text" class="form-control"
                                       required="required"  />
                                </div>

                                <div class="form-group">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <label for="frequecy" class="field-required">
                                                Frequency
                                            </label>
                                        </div>
                                    </div>
                                    <select name="frequency" id="frequency" class="form-control" required="required">
                                        <option selected="selected" value="monthly">Monthly</option>
                                        <option value="yearly" >Yearly</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="initial_due_date" class="field-required">Next Due Date</label>
                                    <input type="date" class="form-control" name="initial_due_date" id="initial_due_date"
                                      required="required"   value="{{ now()->format('Y-m-d') }}">
                                </div>

                                <div class="form-group">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <label for="currency" class="field-required">
                                                Currency
                                            </label>
                                        </div>
                                    </div>
                                    <select name="currency" id="currency" class="form-control" required="required">
                                        @foreach ($countries ?? [] as $country)
                                            <option value="{{ $country->currency }}">{{ $country->currency }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="amount" class="field-required">Amount</label>
                                    <input name="amount" id="amount" type="number" class="form-control" required="required">
         />
                                </div>

                                <div class="form-group">
                                    <label for="description" class="">Description</label>
                                    <textarea name="description" id="description" rows="5" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
